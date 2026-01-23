<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriDetailController extends Controller
{
    /**
     * Display kategori detail view
     */
    public function index($kategoriId)
    {
        $kategori = Kategori::with(['kategoriDetails.tahunKategoriDetails.berkas'])->findOrFail($kategoriId);

        $totalDetails = $kategori->kategoriDetails->count();
        $totalTahun = $kategori->kategoriDetails->sum(function ($detail) {
            return $detail->tahunKategoriDetails->count();
        });
        $totalBerkas = $kategori->kategoriDetails->sum(function ($detail) {
            return $detail->tahunKategoriDetails->sum(function ($tahun) {
                return $tahun->berkas->count();
            });
        });

        $userRole = Auth::user()->role->name ?? 'user';

        return view('admin.kategori-detail', compact('kategori', 'totalDetails', 'totalTahun', 'totalBerkas','userRole'));
    }

    /**
     * Get all kategori details for specific kategori (API endpoint)
     */
    public function getDetails($kategoriId)
    {
        $kategoriDetails = KategoriDetail::where('id_kategori', $kategoriId)
            ->with([
                'tahunKategoriDetails' => function ($query) {
                    $query->withCount('berkas');
                }
            ])
            ->withCount([
                // total seluruh berkas dari semua tahun
                'tahunKategoriDetails as berkas_count' => function ($query) {
                    $query->join(
                        'berkas',
                        'berkas.id_tahun_kategori_detail',
                        '=',
                        'tahun_kategori_details.id'
                    );
                }
            ])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kategoriDetails
        ]);
    }

    /**
     * Get statistics for kategori detail
     */
    public function getStats($kategoriId)
    {
        $kategori = Kategori::findOrFail($kategoriId);

        $totalDetails = KategoriDetail::where('id_kategori', $kategoriId)->count();

        $totalTahun = TahunKategoriDetail::whereHas('kategoriDetail', function ($query) use ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        })->count();

        $totalBerkas = Berkas::whereHas('tahunKategoriDetail.kategoriDetail', function ($query) use ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        })->count();

        $totalSize = Berkas::whereHas('tahunKategoriDetail.kategoriDetail', function ($query) use ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        })->sum('size');

        $stats = [
            'total_details' => $totalDetails,
            'total_tahun' => $totalTahun,
            'total_berkas' => $totalBerkas,
            'total_size' => $this->formatSize($totalSize),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Store a newly created kategori detail
     */
    public function store(Request $request, $kategoriId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'icon' => 'required|string|max:255',
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

            $kategoriDetail = KategoriDetail::create([
                'id_kategori' => $kategoriId,
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori detail berhasil ditambahkan',
                'data' => $kategoriDetail
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified kategori detail
     */
    public function show($kategoriId, $detailId)
    {
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);

        // Redirect ke halaman tahun kategori detail
        return redirect()->route('kategori.detail.tahun.index', [
            'kategori' => $kategoriId,
            'detail' => $detailId
        ]);
    }

    /**
     * Get kategori detail for editing
     */
    public function edit($kategoriId, $detailId)
    {
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);

        return response()->json([
            'success' => true,
            'data' => $kategoriDetail
        ]);
    }

    /**
     * Update the specified kategori detail
     */
    public function update(Request $request, $kategoriId, $detailId)
    {
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'icon' => 'required|string|max:255',
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

            $kategoriDetail->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori detail berhasil diperbarui',
                'data' => $kategoriDetail
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified kategori detail
     */
    public function destroy($kategoriId, $detailId)
    {
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);

        try {
            DB::beginTransaction();

            $kategoriDetail->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori detail berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori detail',
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
