<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ArsipKartografis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KartografiController extends Controller
{
    public function index($kategoriId)
    {
        $kategori     = Kategori::findOrFail($kategoriId);
        $totalDokumen = ArsipKartografis::where('id_kategori', $kategoriId)->count();
        $totalSize    = ArsipKartografis::where('id_kategori', $kategoriId)->sum('size');
        $userRole     = Auth::user()->role->name ?? 'user';

        return view('admin.kartografi', compact('kategori', 'totalDokumen', 'totalSize', 'userRole'));
    }

    public function getKartografi($kategoriId)
    {
        $kartografi = ArsipKartografis::where('id_kategori', $kategoriId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id'             => $item->id,
                    'name'           => $item->name,
                    'desc'           => $item->desc,
                    'date'           => $item->date,
                    'date_formatted' => $item->date ? $item->date->format('d M Y') : '-',
                    'size'           => $item->size,
                    'size_formatted' => $item->size_formatted,
                    'original_name'  => $item->original_name,
                    'created_at'     => $item->created_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $kartografi
        ]);
    }

    public function getStats($kategoriId)
    {
        $totalDokumen = ArsipKartografis::where('id_kategori', $kategoriId)->count();
        $totalSize    = ArsipKartografis::where('id_kategori', $kategoriId)->sum('size');
        $latest       = ArsipKartografis::where('id_kategori', $kategoriId)
                            ->orderBy('created_at', 'desc')->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'total_dokumen' => $totalDokumen,
                'total_size'    => $this->formatSize($totalSize),
                'latest_upload' => $latest ? $latest->created_at->format('d M Y') : '-',
            ]
        ]);
    }

    public function store(Request $request, $kategoriId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'date' => 'required|date',
            'file' => 'required|file|max:51200',
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

            $file     = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Upload file ke Google Drive (folder 'kartografi')
            $path = Storage::disk('google')->putFileAs('kartografi', $file, $fileName);

            // Ambil Google Drive file ID
            $fileId = Storage::disk('google')->getAdapter()->getMetadata('kartografi/' . $fileName)['extraMetadata']['id']
                      ?? null;

            ArsipKartografis::create([
                'id_kategori'    => $kategoriId,
                'name'           => $request->name,
                'desc'           => $request->desc,
                'date'           => $request->date,
                'size'           => $file->getSize(),
                'file_path'      => $path,
                'google_file_id' => $fileId,
                'original_name'  => $file->getClientOriginalName(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen kartografi berhasil diupload',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload dokumen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function edit($kategoriId, $kartografiId)
    {
        $item = ArsipKartografis::where('id_kategori', $kategoriId)->findOrFail($kartografiId);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'   => $item->id,
                'name' => $item->name,
                'desc' => $item->desc,
                'date' => $item->date->format('Y-m-d'),
            ]
        ]);
    }

    public function update(Request $request, $kategoriId, $kartografiId)
    {
        $item = ArsipKartografis::where('id_kategori', $kategoriId)->findOrFail($kartografiId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
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
                'desc' => $request->desc,
                'date' => $request->date,
            ];

            if ($request->hasFile('file')) {
                // Hapus file lama dari Google Drive
                if ($item->file_path && Storage::disk('google')->exists($item->file_path)) {
                    Storage::disk('google')->delete($item->file_path);
                }

                $file     = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path     = Storage::disk('google')->putFileAs('kartografi', $file, $fileName);

                $fileId = Storage::disk('google')->getAdapter()->getMetadata('kartografi/' . $fileName)['extraMetadata']['id']
                          ?? null;

                $updateData['file_path']      = $path;
                $updateData['size']           = $file->getSize();
                $updateData['original_name']  = $file->getClientOriginalName();
                $updateData['google_file_id'] = $fileId;
            }

            $item->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui dokumen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($kategoriId, $kartografiId)
    {
        $item = ArsipKartografis::where('id_kategori', $kategoriId)->findOrFail($kartografiId);

        try {
            DB::beginTransaction();

            // Hapus file dari Google Drive
            if ($item->file_path && Storage::disk('google')->exists($item->file_path)) {
                Storage::disk('google')->delete($item->file_path);
            }

            $item->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus dokumen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function download($kategoriId, $kartografiId)
    {
        $item = ArsipKartografis::where('id_kategori', $kategoriId)->findOrFail($kartografiId);

        if (!$item->file_path || !Storage::disk('google')->exists($item->file_path)) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 404);
        }

        $fileContent = Storage::disk('google')->get($item->file_path);
        $mimeType    = Storage::disk('google')->mimeType($item->file_path);
        $fileName    = $item->original_name ?? $item->name;

        return response($fileContent, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}