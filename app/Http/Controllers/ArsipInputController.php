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
            ->orderBy('no', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $inputs
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
            ]
        ]);
    }

    public function store(Request $request, $kategoriId, $detailId, $tahunId)
    {
        $kategori = Kategori::findOrFail($kategoriId);
        $rules    = $this->getValidationRules($kategori);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            ArsipInput::create([
                'id_tahun_kategori_detail' => $tahunId,
                'no'                      => $request->no,

                // GAMBAR 1
                'kode_klasifikasi'        => $request->kode_klasifikasi,
                'uraian_informasi'        => $request->uraian_informasi,
                'kurun_waktu'             => $request->kurun_waktu,
                'tingkat_perkembangan'    => $request->tingkat_perkembangan,
                'jumlah'                  => $request->jumlah,
                'no_box'                  => $request->no_box,
                'media_simpan'            => $request->media_simpan,
                'kondisi_fisik'           => $request->kondisi_fisik,
                'nomor_folder'            => $request->nomor_folder,
                'jangka_simpan'           => $request->jangka_simpan,
                'nasib_akhir_arsip'       => $request->nasib_akhir_arsip,
                'lembar'                  => $request->lembar,
                'keterangan'              => $request->keterangan,

                // GAMBAR 2
                'jenis_arsip'             => $request->jenis_arsip,
                'no_berkas'               => $request->no_berkas,
                'no_perjanjian_kerjasama' => $request->no_perjanjian_kerjasama,
                'pihak_i'                 => $request->pihak_i,
                'pihak_ii'                => $request->pihak_ii,
                'tanggal_berlaku'         => $request->tanggal_berlaku,
                'tanggal_berakhir'        => $request->tanggal_berakhir,
                'media'                   => $request->media,
                'lokasi_simpan'           => $request->lokasi_simpan,
                'metode_perlindungan'     => $request->metode_perlindungan,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function edit($kategoriId, $detailId, $tahunId, $inputId)
    {
        $input = ArsipInput::where('id_tahun_kategori_detail', $tahunId)->findOrFail($inputId);

        return response()->json([
            'success' => true,
            'data'    => $input
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
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $input->update($request->only([
                'no',
                'kode_klasifikasi',
                'uraian_informasi',
                'kurun_waktu',
                'tingkat_perkembangan',
                'jumlah',
                'no_box',
                'media_simpan',
                'kondisi_fisik',
                'nomor_folder',
                'jangka_simpan',
                'nasib_akhir_arsip',
                'lembar',
                'keterangan',
                'jenis_arsip',
                'no_berkas',
                'no_perjanjian_kerjasama',
                'pihak_i',
                'pihak_ii',
                'tanggal_berlaku',
                'tanggal_berakhir',
                'media',
                'lokasi_simpan',
                'metode_perlindungan',
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
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
                'message' => 'Data arsip berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    private function getValidationRules(Kategori $kategori): array
    {
        if ($kategori->name === 'Daftar Arsip Usul Musnah') {
            return [
                'no'                   => 'required|integer',
                'kode_klasifikasi'     => 'nullable|string|max:100',
                'uraian_informasi'     => 'required|string',
                'kurun_waktu'          => 'nullable|string|max:100',
                'tingkat_perkembangan' => 'nullable|string|max:100',
                'jumlah'               => 'required|string|max:100',
                'no_box'               => 'nullable|string|max:100',
                'media_simpan'         => 'nullable|string|max:100',
                'kondisi_fisik'        => 'nullable|string|max:100',
                'nomor_folder'         => 'nullable|string|max:100',
                'jangka_simpan'        => 'required|string|max:100',
                'nasib_akhir_arsip'    => 'required|string|max:100',
                'lembar'               => 'nullable|integer',
                'keterangan'           => 'nullable|string',
            ];
        }

        // Vital & Permanen
        return [
            'no'                      => 'required|integer',
            'jenis_arsip'             => 'required|string|max:100',
            'no_box'                  => 'nullable|string|max:100',
            'no_berkas'               => 'nullable|string|max:100',
            'no_perjanjian_kerjasama' => 'nullable|string|max:100',
            'pihak_i'                 => 'nullable|string|max:255',
            'pihak_ii'                => 'nullable|string|max:255',
            'tingkat_perkembangan'    => 'nullable|string|max:100',
            'tanggal_berlaku'         => 'nullable|date',
            'tanggal_berakhir'        => 'nullable|date',
            'media'                   => 'nullable|string|max:100',
            'jumlah'                  => 'required|string|max:100',
            'jangka_simpan'           => 'nullable|string|max:100',
            'lokasi_simpan'           => 'nullable|string|max:255',
            'metode_perlindungan'     => 'nullable|string|max:255',
            'keterangan'              => 'nullable|string',
        ];
    }

}