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
            ->orderBy('no_urut', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $inputs
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

        $rules = $this->getValidationRules($kategori);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            ArsipInput::create([
                'id_tahun_kategori_detail' => $tahunId,
                'no_urut'                 => $request->no_urut,
                'kode_klasifikasi'        => $request->kode_klasifikasi,
                'uraian_informasi'        => $request->uraian_informasi,
                'kurun_waktu'             => $request->kurun_waktu,
                'jumlah'                  => $request->jumlah,
                'tingkat_perkembangan'    => $request->tingkat_perkembangan,
                'media_simpan'            => $request->media_simpan,
                'kondisi'                 => $request->kondisi,
                // Usul Musnah
                'jangka_simpan'           => $request->jangka_simpan,
                'nasib_akhir'             => $request->nasib_akhir,
                'tanggal_habis_retensi'   => $request->tanggal_habis_retensi,
                // Vital & Permanen
                'lokasi_simpan'           => $request->lokasi_simpan,
                'nomor_boks'              => $request->nomor_boks,
                'keterangan'              => $request->keterangan,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data',
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
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $input->update([
                'no_urut'               => $request->no_urut,
                'kode_klasifikasi'      => $request->kode_klasifikasi,
                'uraian_informasi'      => $request->uraian_informasi,
                'kurun_waktu'           => $request->kurun_waktu,
                'jumlah'                => $request->jumlah,
                'tingkat_perkembangan'  => $request->tingkat_perkembangan,
                'media_simpan'          => $request->media_simpan,
                'kondisi'               => $request->kondisi,
                'jangka_simpan'         => $request->jangka_simpan,
                'nasib_akhir'           => $request->nasib_akhir,
                'tanggal_habis_retensi' => $request->tanggal_habis_retensi,
                'lokasi_simpan'         => $request->lokasi_simpan,
                'nomor_boks'            => $request->nomor_boks,
                'keterangan'            => $request->keterangan,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data',
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

    // Validasi berbeda per type kategori
    private function getValidationRules(Kategori $kategori): array
    {
        $base = [
            'no_urut'              => 'required|integer',
            'kode_klasifikasi'     => 'required|string|max:100',
            'uraian_informasi'     => 'required|string',
            'kurun_waktu'          => 'required|string|max:100',
            'jumlah'               => 'required|string|max:100',
            'tingkat_perkembangan' => 'nullable|string|max:100',
            'media_simpan'         => 'nullable|string|max:100',
            'kondisi'              => 'nullable|string|max:100',
            'keterangan'           => 'nullable|string',
        ];

        if ($kategori->name === 'Daftar Arsip Usul Musnah') {
            $base['jangka_simpan']         = 'required|string|max:100';
            $base['nasib_akhir']           = 'required|string|max:100';
            $base['tanggal_habis_retensi'] = 'nullable|date';
        } else {
            // Vital & Permanen
            $base['lokasi_simpan'] = 'nullable|string|max:255';
            $base['nomor_boks']    = 'nullable|string|max:100';
        }

        return $base;
    }
}