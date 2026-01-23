<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BerkasController extends Controller
{
    /**
     * Display berkas view
     */
    public function index($kategoriId, $detailId, $tahunId)
    {
        $kategori = Kategori::findOrFail($kategoriId);
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);
        $tahunDetail = TahunKategoriDetail::where('id_kategori_detail', $detailId)
            ->with(['berkas' => function ($query) {
                $query->orderBy('date', 'desc');
            }])
            ->findOrFail($tahunId);

        $totalBerkas = $tahunDetail->berkas->count();
        $totalSize = $tahunDetail->berkas->sum('size');

        return view('admin.berkas', compact(
            'kategori',
            'kategoriDetail',
            'tahunDetail',
            'totalBerkas',
            'totalSize'
        ));
    }

    /**
     * Get all berkas for specific tahun (API endpoint)
     */
    public function getBerkas($kategoriId, $detailId, $tahunId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'date' => $item->date,
                    'date_formatted' => $item->date ? $item->date->format('d M Y') : '-',
                    'size' => $item->size,
                    'size_formatted' => $item->size_formatted,
                    'created_at' => $item->created_at->format('d M Y H:i'),
                    'updated_at' => $item->updated_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $berkas
        ]);
    }

    /**
     * Get statistics for berkas
     */
    public function getStats($kategoriId, $detailId, $tahunId)
    {
        $totalBerkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->count();
        $totalSize = Berkas::where('id_tahun_kategori_detail', $tahunId)->sum('size');

        $latestBerkas = Berkas::where('id_tahun_kategori_detail', $tahunId)
            ->orderBy('created_at', 'desc')
            ->first();

        $oldestBerkas = Berkas::where('id_tahun_kategori_detail', $tahunId)
            ->orderBy('date', 'asc')
            ->first();

        $stats = [
            'total_berkas' => $totalBerkas,
            'total_size' => $this->formatSize($totalSize),
            'latest_upload' => $latestBerkas ? $latestBerkas->created_at->format('d M Y') : '-',
            'oldest_date' => $oldestBerkas && $oldestBerkas->date ? $oldestBerkas->date->format('d M Y') : '-',
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Store a newly created berkas (file upload)
     */
    public function store(Request $request, $kategoriId, $detailId, $tahunId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'file' => 'required|file|max:51200', // max 50MB
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

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store file in storage/app/public/berkas
            $path = $file->storeAs('berkas', $fileName, 'public');

            $berkas = Berkas::create([
                'id_tahun_kategori_detail' => $tahunId,
                'name' => $request->name,
                'date' => $request->date,
                'size' => $file->getSize(),
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diupload',
                'data' => [
                    'id' => $berkas->id,
                    'name' => $berkas->name,
                    'date' => $berkas->date,
                    'date_formatted' => $berkas->date->format('d M Y'),
                    'size' => $berkas->size,
                    'size_formatted' => $berkas->size_formatted,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload berkas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified berkas
     */
    public function show($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $berkas->id,
                'name' => $berkas->name,
                'date' => $berkas->date,
                'date_formatted' => $berkas->date->format('d M Y'),
                'size' => $berkas->size,
                'size_formatted' => $berkas->size_formatted,
                'file_path' => $berkas->file_path,
                'original_name' => $berkas->original_name,
                'created_at' => $berkas->created_at->format('d M Y H:i'),
            ]
        ]);
    }

    /**
     * Get berkas for editing
     */
    public function edit($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $berkas->id,
                'name' => $berkas->name,
                'date' => $berkas->date->format('Y-m-d'),
                'size' => $berkas->size,
                'size_formatted' => $berkas->size_formatted,
            ]
        ]);
    }

    /**
     * Update the specified berkas
     */
    public function update(Request $request, $kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'file' => 'nullable|file|max:51200', // max 50MB
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

            $updateData = [
                'name' => $request->name,
                'date' => $request->date,
            ];

            // If new file is uploaded, replace the old one
            if ($request->hasFile('file')) {
                // Delete old file
                if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
                    Storage::disk('public')->delete($berkas->file_path);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('berkas', $fileName, 'public');

                $updateData['file_path'] = $path;
                $updateData['size'] = $file->getSize();
                $updateData['original_name'] = $file->getClientOriginalName();
            }

            $berkas->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diperbarui',
                'data' => [
                    'id' => $berkas->id,
                    'name' => $berkas->name,
                    'date' => $berkas->date,
                    'date_formatted' => $berkas->date->format('d M Y'),
                    'size' => $berkas->size,
                    'size_formatted' => $berkas->size_formatted,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui berkas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified berkas
     */
    public function destroy($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        try {
            DB::beginTransaction();

            // Delete file from storage
            if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
                Storage::disk('public')->delete($berkas->file_path);
            }

            $berkas->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus berkas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download berkas file
     */
    public function download($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        if (!$berkas->file_path || !Storage::disk('public')->exists($berkas->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        return Storage::disk('public')->download($berkas->file_path, $berkas->original_name ?? $berkas->name);
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
