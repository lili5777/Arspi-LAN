<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BerkasController extends Controller
{
    /**
     * Buat path folder Google Drive berdasarkan nama:
     * kategoriName/kategoriDetailName/tahunName
     *
     * Membutuhkan relasi: kategoriDetail.kategori sudah di-load
     */
    private function buildFolderPath(TahunKategoriDetail $tahunDetail): string
    {
        $kategoriName = $tahunDetail->kategoriDetail->kategori->name ?? 'kategori';
        $detailName   = $tahunDetail->kategoriDetail->name ?? 'detail';
        $tahunName    = $tahunDetail->name ?? 'tahun';

        // Sanitasi nama agar aman sebagai path folder (spasi → underscore, huruf kecil)
        $sanitize = fn(string $name): string => Str::slug($name, '_');

        return implode('/', [
            $sanitize($kategoriName),
            $sanitize($detailName),
            $sanitize($tahunName),
        ]);
    }

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
        $totalSize   = $tahunDetail->berkas->sum('size');
        $userRole    = Auth::user()->role->name ?? 'user';

        return view('admin.berkas', compact(
            'kategori',
            'kategoriDetail',
            'tahunDetail',
            'totalBerkas',
            'totalSize',
            'userRole'
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
                    'id'             => $item->id,
                    'name'           => $item->name,
                    'date'           => $item->date,
                    'date_formatted' => $item->date ? $item->date->format('d M Y') : '-',
                    'size'           => $item->size,
                    'size_formatted' => $item->size_formatted,
                    'created_at'     => $item->created_at->format('d M Y H:i'),
                    'updated_at'     => $item->updated_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $berkas
        ]);
    }

    /**
     * Get statistics for berkas
     */
    public function getStats($kategoriId, $detailId, $tahunId)
    {
        $totalBerkas  = Berkas::where('id_tahun_kategori_detail', $tahunId)->count();
        $totalSize    = Berkas::where('id_tahun_kategori_detail', $tahunId)->sum('size');
        $latestBerkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->orderBy('created_at', 'desc')->first();
        $oldestBerkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->orderBy('date', 'asc')->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'total_berkas'  => $totalBerkas,
                'total_size'    => $this->formatSize($totalSize),
                'latest_upload' => $latestBerkas ? $latestBerkas->created_at->format('d M Y') : '-',
                'oldest_date'   => $oldestBerkas && $oldestBerkas->date ? $oldestBerkas->date->format('d M Y') : '-',
            ]
        ]);
    }

    /**
     * Store berkas ke Google Drive
     * Struktur folder: kategoriName/kategoriDetailName/tahunName/filename
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
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Load relasi yang dibutuhkan untuk membangun path folder
            $tahunDetail = TahunKategoriDetail::with('kategoriDetail.kategori')
                ->findOrFail($tahunId);

            $folderPath = $this->buildFolderPath($tahunDetail);
            // Contoh hasil: "arsip_statis/surat_masuk/2024"

            $file     = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Upload ke Google Drive
            $path = Storage::disk('google')->putFileAs($folderPath, $file, $fileName);

            $berkas = Berkas::create([
                'id_tahun_kategori_detail' => $tahunId,
                'name'          => $request->name,
                'date'          => $request->date,
                'size'          => $file->getSize(),
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diupload',
                'data'    => [
                    'id'             => $berkas->id,
                    'name'           => $berkas->name,
                    'date'           => $berkas->date,
                    'date_formatted' => $berkas->date->format('d M Y'),
                    'size'           => $berkas->size,
                    'size_formatted' => $berkas->size_formatted,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload berkas',
                'error'   => $e->getMessage()
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
            'data'    => [
                'id'             => $berkas->id,
                'name'           => $berkas->name,
                'date'           => $berkas->date,
                'date_formatted' => $berkas->date->format('d M Y'),
                'size'           => $berkas->size,
                'size_formatted' => $berkas->size_formatted,
                'file_path'      => $berkas->file_path,
                'original_name'  => $berkas->original_name,
                'created_at'     => $berkas->created_at->format('d M Y H:i'),
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
            'data'    => [
                'id'             => $berkas->id,
                'name'           => $berkas->name,
                'date'           => $berkas->date->format('Y-m-d'),
                'size'           => $berkas->size,
                'size_formatted' => $berkas->size_formatted,
            ]
        ]);
    }

    /**
     * Update berkas di Google Drive
     * Jika file baru diupload: hapus file lama, upload ke folder yang sama
     */
    public function update(Request $request, $kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'file' => 'nullable|file|max:51200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'date' => $request->date,
            ];

            if ($request->hasFile('file')) {
                // Hapus file lama dari Google Drive
                if ($berkas->file_path && Storage::disk('google')->exists($berkas->file_path)) {
                    Storage::disk('google')->delete($berkas->file_path);
                }

                // Load relasi untuk path folder
                $tahunDetail = TahunKategoriDetail::with('kategoriDetail.kategori')
                    ->findOrFail($tahunId);

                $folderPath = $this->buildFolderPath($tahunDetail);

                $file     = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path     = Storage::disk('google')->putFileAs($folderPath, $file, $fileName);

                $updateData['file_path']     = $path;
                $updateData['size']          = $file->getSize();
                $updateData['original_name'] = $file->getClientOriginalName();
            }

            $berkas->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diperbarui',
                'data'    => [
                    'id'             => $berkas->id,
                    'name'           => $berkas->name,
                    'date'           => $berkas->date,
                    'date_formatted' => $berkas->date->format('d M Y'),
                    'size'           => $berkas->size,
                    'size_formatted' => $berkas->size_formatted,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui berkas',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus berkas dari Google Drive
     */
    public function destroy($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        try {
            DB::beginTransaction();

            if ($berkas->file_path && Storage::disk('google')->exists($berkas->file_path)) {
                Storage::disk('google')->delete($berkas->file_path);
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
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download berkas dari Google Drive
     */
    public function download($kategoriId, $detailId, $tahunId, $berkasId)
    {
        $berkas = Berkas::where('id_tahun_kategori_detail', $tahunId)->findOrFail($berkasId);

        if (!$berkas->file_path || !Storage::disk('google')->exists($berkas->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        $fileContent = Storage::disk('google')->get($berkas->file_path);
        $mimeType    = Storage::disk('google')->mimeType($berkas->file_path);
        $fileName    = $berkas->original_name ?? $berkas->name;

        return response($fileContent, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Format size in bytes to readable format
     */
    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}