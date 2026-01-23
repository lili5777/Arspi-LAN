<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\Berkas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display dashboard view
     */
    public function dashboard()
    {
        $kategoris = Kategori::withCount(['kategoriDetails as kategori_details_count'])
            ->with(['kategoriDetails' => function ($query) {
                $query->withCount(['tahunKategoriDetails as tahun_kategori_details_count']);
            }])
            ->get();

        $totalBerkas = Berkas::count();
        $totalSize = Berkas::sum('size');
        $totalSizeGB = $totalSize > 0 ? number_format($totalSize / (1024 * 1024 * 1024), 2) : 0;
        $totalUsers = 8;

        return view('admin.dashboard', compact('kategoris', 'totalBerkas', 'totalSize', 'totalSizeGB', 'totalUsers'));
    }

    /**
     * Get all categories (API endpoint)
     */
    public function index()
    {
        $kategoris = Kategori::withCount(['kategoriDetails as kategori_details_count'])
            ->with(['kategoriDetails' => function ($query) {
                $query->withCount(['tahunKategoriDetails as tahun_kategori_details_count']);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'kategoris' => $kategoris
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function getStats()
    {
        $totalKategori = Kategori::count();
        $totalDokumen = Berkas::count();
        $totalSize = Berkas::sum('size');
        $totalUsers = User::count();

        $stats = [
            'total_kategori' => $totalKategori,
            'total_dokumen' => $totalDokumen,
            'total_size' => $this->formatSize($totalSize),
            'total_users' => $totalUsers,
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:kategoris,name',
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

            $kategori = Kategori::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Redirect ke halaman kategori detail
        return redirect()->route('kategori.detail.index', $kategori->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:kategoris,name,' . $kategori->id,
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

            $kategori->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $kategori->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori',
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
