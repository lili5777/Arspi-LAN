<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\ArsipInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArsipInputController extends Controller
{
    // Sesuaikan jika nama kategori di DB berbeda
    private const NAMA_MUSNAH     = 'Daftar Arsip Usul Musnah';
    private const NAMA_PERSURATAN = 'Arsip Inaktif Persuratan';

    public function index($kategoriId, $detailId, $tahunId)
    {
        $kategori       = Kategori::findOrFail($kategoriId);
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);
        $tahunDetail    = TahunKategoriDetail::where('id_kategori_detail', $detailId)->findOrFail($tahunId);
        $totalInput     = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->count();
        $userRole       = Auth::user()->role->name ?? 'user';

        return view('admin.arsip-input', compact(
            'kategori', 'kategoriDetail', 'tahunDetail', 'totalInput', 'userRole'
        ));
    }

    public function getInputs($kategoriId, $detailId, $tahunId)
    {
        $inputs = ArsipInput::where('id_tahun_kategori_detail', $tahunId)
            ->orderByRaw('ISNULL(kurun_waktu) ASC')
            ->orderBy('kurun_waktu', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $inputs,
        ]);
    }

    public function getStats($kategoriId, $detailId, $tahunId)
    {
        $total  = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->count();
        $latest = ArsipInput::where('id_tahun_kategori_detail', $tahunId)
                    ->orderBy('created_at', 'desc')->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'total_input'   => $total,
                'latest_update' => $latest ? $latest->updated_at->format('d M Y') : '-',
            ],
        ]);
    }

    public function store(Request $request, $kategoriId, $detailId, $tahunId)
    {
        $kategori  = Kategori::findOrFail($kategoriId);
        $rules     = $this->getValidationRules($kategori);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $this->buildData($request, $kategori);
            $data['id_tahun_kategori_detail'] = $tahunId;

            ArsipInput::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($kategoriId, $detailId, $tahunId, $inputId)
    {
        $input = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->findOrFail($inputId);

        return response()->json([
            'success' => true,
            'data'    => $input,
        ]);
    }

    public function update(Request $request, $kategoriId, $detailId, $tahunId, $inputId)
    {
        $input    = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->findOrFail($inputId);
        $kategori = Kategori::findOrFail($kategoriId);
        $rules    = $this->getValidationRules($kategori);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $this->buildData($request, $kategori);
            $input->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($kategoriId, $detailId, $tahunId, $inputId)
    {
        $input = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->findOrFail($inputId);

        try {
            DB::beginTransaction();
            $input->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // =========================================================
    // Build data array sesuai template kategori
    // =========================================================
    private function buildData(Request $request, Kategori $kategori): array
    {
        if ($kategori->name === self::NAMA_MUSNAH) {
            return [
                'kode_klasifikasi'     => $request->kode_klasifikasi,
                'uraian_informasi'     => $request->uraian_informasi,
                'kurun_waktu'          => $request->kurun_waktu,
                'tingkat_perkembangan' => $request->tingkat_perkembangan,
                'jumlah'               => $request->jumlah,
                'no_box'               => $request->no_box,
                'media_simpan'         => $request->media_simpan,
                'kondisi_fisik'        => $request->kondisi_fisik,
                'nomor_folder'         => $request->nomor_folder,
                'jangka_simpan'        => $request->jangka_simpan,
                'nasib_akhir_arsip'    => $request->nasib_akhir_arsip,
                'lembar'               => $request->lembar,
                'keterangan'           => $request->keterangan,
            ];
        }

        if ($kategori->name === self::NAMA_PERSURATAN) {
            return [
                'no_berkas_persuratan'           => $request->no_berkas_persuratan,
                'unit_kerja'                     => $request->unit_kerja,
                'nomor_item_arsip'               => $request->nomor_item_arsip,
                'kode_klasifikasi_persuratan'    => $request->kode_klasifikasi_persuratan,
                'uraian_informasi_persuratan'    => $request->uraian_informasi_persuratan,
                'tgl'                            => $request->tgl ?: null,
                'tingkat_perkembangan_persuratan'=> $request->tingkat_perkembangan_persuratan,
                'jumlah_lembar'                  => $request->jumlah_lembar,
                'no_filling_cabinet'             => $request->no_filling_cabinet,
                'no_laci'                        => $request->no_laci,
                'no_folder_persuratan'           => $request->no_folder_persuratan,
                'klasifikasi_keamanan'           => $request->klasifikasi_keamanan,
                'keterangan_persuratan'          => $request->keterangan_persuratan,
            ];
        }

        // Default: Vital & Permanen
        return [
            'jenis_arsip'             => $request->jenis_arsip,
            'no_box'                  => $request->no_box,
            'no_berkas'               => $request->no_berkas,
            'no_perjanjian_kerjasama' => $request->no_perjanjian_kerjasama,
            'pihak_i'                 => $request->pihak_i,
            'pihak_ii'                => $request->pihak_ii,
            'tingkat_perkembangan'    => $request->tingkat_perkembangan,
            'tanggal_berlaku'         => $request->tanggal_berlaku ?: null,
            'tanggal_berakhir'        => $request->tanggal_berakhir ?: null,
            'media'                   => $request->media,
            'jumlah'                  => $request->jumlah,
            'jangka_simpan'           => $request->jangka_simpan,
            'lokasi_simpan'           => $request->lokasi_simpan,
            'metode_perlindungan'     => $request->metode_perlindungan,
            'keterangan'              => $request->keterangan,
        ];
    }

    // =========================================================
    // Validation rules sesuai template kategori
    // =========================================================
    private function getValidationRules(Kategori $kategori): array
    {
        if ($kategori->name === self::NAMA_MUSNAH) {
            return [
                'kode_klasifikasi'     => 'nullable|string|max:255',
                'uraian_informasi'     => 'nullable|string',
                'kurun_waktu'          => 'nullable|string|max:255',
                'tingkat_perkembangan' => 'nullable|string|max:255',
                'jumlah'               => 'nullable|string|max:255',
                'no_box'               => 'nullable|string|max:255',
                'media_simpan'         => 'nullable|string|max:255',
                'kondisi_fisik'        => 'nullable|string|max:255',
                'nomor_folder'         => 'nullable|string|max:255',
                'jangka_simpan'        => 'nullable|string|max:255',
                'nasib_akhir_arsip'    => 'nullable|string|max:255',
                'lembar'               => 'nullable|integer',
                'keterangan'           => 'nullable|string',
            ];
        }

        if ($kategori->name === self::NAMA_PERSURATAN) {
            return [
                'no_berkas_persuratan'            => 'nullable|string|max:255',
                'unit_kerja'                      => 'nullable|string|max:255',
                'nomor_item_arsip'                => 'nullable|string|max:255',
                'kode_klasifikasi_persuratan'     => 'nullable|string|max:255',
                'uraian_informasi_persuratan'     => 'nullable|string',
                'tgl'                             => 'nullable|date',
                'tingkat_perkembangan_persuratan' => 'nullable|string|max:255',
                'jumlah_lembar'                   => 'nullable|string|max:255',
                'no_filling_cabinet'              => 'nullable|string|max:255',
                'no_laci'                         => 'nullable|string|max:255',
                'no_folder_persuratan'            => 'nullable|string|max:255',
                'klasifikasi_keamanan'            => 'nullable|string|max:255',
                'keterangan_persuratan'           => 'nullable|string',
            ];
        }

        // Default: Vital & Permanen
        return [
            'jenis_arsip'             => 'nullable|string|max:255',
            'no_box'                  => 'nullable|string|max:255',
            'no_berkas'               => 'nullable|string|max:255',
            'no_perjanjian_kerjasama' => 'nullable|string|max:255',
            'pihak_i'                 => 'nullable|string|max:255',
            'pihak_ii'                => 'nullable|string|max:255',
            'tingkat_perkembangan'    => 'nullable|string|max:255',
            'tanggal_berlaku'         => 'nullable|date',
            'tanggal_berakhir'        => 'nullable|date',
            'media'                   => 'nullable|string|max:255',
            'jumlah'                  => 'nullable|string|max:255',
            'jangka_simpan'           => 'nullable|string|max:255',
            'lokasi_simpan'           => 'nullable|string|max:255',
            'metode_perlindungan'     => 'nullable|string|max:255',
            'keterangan'              => 'nullable|string',
        ];
    }
}