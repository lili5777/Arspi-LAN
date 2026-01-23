<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TahunKategoriDetailController extends Controller
{
    /**
     * Display tahun kategori detail view
     */
    public function index($kategoriId, $detailId)
    {
        $kategori = Kategori::findOrFail($kategoriId);
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)
            ->with(['tahunKategoriDetails.berkas'])
            ->findOrFail($detailId);

        $totalTahun = $kategoriDetail->tahunKategoriDetails->count();
        $totalBerkas = $kategoriDetail->tahunKategoriDetails->sum(function ($tahun) {
            return $tahun->berkas->count();
        });
        $totalSize = $kategoriDetail->tahunKategoriDetails->sum(function ($tahun) {
            return $tahun->berkas->sum('size');
        });

        return view('admin.tahun-kategori-detail', compact(
            'kategori',
            'kategoriDetail',
            'totalTahun',
            'totalBerkas',
            'totalSize'
        ));
    }

    /**
     * Get all tahun kategori details for specific kategori detail (API endpoint)
     */
    public function getTahunDetails($kategoriId, $detailId)
    {
        $tahunDetails = TahunKategoriDetail::where('id_kategori_detail', $detailId)
            ->withCount('berkas')
            ->with(['berkas' => function ($query) {
                $query->select('id', 'id_tahun_kategori_detail', 'name', 'date', 'size')
                    ->orderBy('date', 'desc');
            }])
            ->orderBy('name', 'desc')
            ->get();

        // Add total size for each tahun
        $tahunDetails->each(function ($tahun) {
            $tahun->total_size = $tahun->berkas->sum('size');
            $tahun->total_size_formatted = $this->formatSize($tahun->total_size);
        });

        return response()->json([
            'success' => true,
            'data' => $tahunDetails
        ]);
    }

    /**
     * Get statistics for tahun kategori detail
     */
    public function getStats($kategoriId, $detailId)
    {
        $totalTahun = TahunKategoriDetail::where('id_kategori_detail', $detailId)->count();

        $totalBerkas = Berkas::whereHas('tahunKategoriDetail', function ($query) use ($detailId) {
            $query->where('id_kategori_detail', $detailId);
        })->count();

        $totalSize = Berkas::whereHas('tahunKategoriDetail', function ($query) use ($detailId) {
            $query->where('id_kategori_detail', $detailId);
        })->sum('size');

        // Get latest berkas
        $latestBerkas = Berkas::whereHas('tahunKategoriDetail', function ($query) use ($detailId) {
            $query->where('id_kategori_detail', $detailId);
        })
            ->orderBy('created_at', 'desc')
            ->first();

        $stats = [
            'total_tahun' => $totalTahun,
            'total_berkas' => $totalBerkas,
            'total_size' => $this->formatSize($totalSize),
            'latest_upload' => $latestBerkas ? $latestBerkas->created_at->format('d M Y') : '-',
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Store a newly created tahun kategori detail
     */
    public function store(Request $request, $kategoriId, $detailId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $tahunDetail = TahunKategoriDetail::create([
                'id_kategori_detail' => $detailId,
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tahun berhasil ditambahkan',
                'data' => $tahunDetail
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tahun',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified tahun kategori detail
     */
    public function show($kategoriId, $detailId, $tahunId)
    {
        $tahunDetail = TahunKategoriDetail::with(['kategoriDetail.kategori', 'berkas'])
            ->where('id_kategori_detail', $detailId)
            ->findOrFail($tahunId);

        return response()->json([
            'success' => true,
            'data' => $tahunDetail
        ]);
    }

    /**
     * Get tahun kategori detail for editing
     */
    public function edit($kategoriId, $detailId, $tahunId)
    {
        $tahunDetail = TahunKategoriDetail::where('id_kategori_detail', $detailId)
            ->findOrFail($tahunId);

        return response()->json([
            'success' => true,
            'data' => $tahunDetail
        ]);
    }

    /**
     * Update the specified tahun kategori detail
     */
    public function update(Request $request, $kategoriId, $detailId, $tahunId)
    {
        $tahunDetail = TahunKategoriDetail::where('id_kategori_detail', $detailId)
            ->findOrFail($tahunId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $tahunDetail->update([
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tahun berhasil diperbarui',
                'data' => $tahunDetail
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tahun',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified tahun kategori detail
     */
    public function destroy($kategoriId, $detailId, $tahunId)
    {
        $tahunDetail = TahunKategoriDetail::where('id_kategori_detail', $detailId)
            ->findOrFail($tahunId);

        try {
            DB::beginTransaction();

            $tahunDetail->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tahun berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tahun',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format size in bytes to readable format
     */
    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
