<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Berkas;
use App\Models\ArsipInput;
use App\Models\ArsipKartografis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
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
        $userRole = Auth::user()->role->name ?? 'user';

        return view('admin.dashboard', compact(
            'kategoris', 'totalBerkas', 'totalSize', 'totalSizeGB', 'totalUsers', 'userRole'
        ));
    }

    public function index()
    {
        $kategoris = Kategori::with([
            'kategoriDetails.tahunKategoriDetails.berkas',
            'kategoriDetails.tahunKategoriDetails.arsipInputs',
            'arsipKartografis',
        ])
        ->withCount(['kategoriDetails as kategori_details_count'])
        ->get()
        ->map(function ($kategori) {
            if ($kategori->isDirect()) {
                // Kartografi: hitung langsung dari arsip_kartografis
                $kategori->total_documents = $kategori->arsipKartografis->count();
            } elseif ($kategori->isUpload()) {
                // Upload: hitung dari berkas
                $total = 0;
                foreach ($kategori->kategoriDetails as $detail) {
                    foreach ($detail->tahunKategoriDetails as $tahun) {
                        $total += $tahun->berkas->count();
                    }
                }
                $kategori->total_documents = $total;
            } elseif ($kategori->isInput()) {
                // Input: hitung dari arsip_inputs
                $total = 0;
                foreach ($kategori->kategoriDetails as $detail) {
                    foreach ($detail->tahunKategoriDetails as $tahun) {
                        $total += $tahun->arsipInputs->count();
                    }
                }
                $kategori->total_documents = $total;
            } else {
                $kategori->total_documents = 0;
            }

            return $kategori;
        });

        return response()->json([
            'success' => true,
            'kategoris' => $kategoris
        ]);
    }

    public function getStats()
    {
        $totalKategori = Kategori::count();
        $totalBerkas   = Berkas::count();
        $totalInput    = ArsipInput::count();
        $totalKarto    = ArsipKartografis::count();
        $totalDokumen  = $totalBerkas + $totalInput + $totalKarto;
        $totalSize     = Berkas::sum('size');
        $totalUsers    = User::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_kategori' => $totalKategori,
                'total_dokumen'  => $totalDokumen,
                'total_size'     => $this->formatSize($totalSize),
                'total_users'    => $totalUsers,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:kategoris,name',
            'desc' => 'required|string',
            'icon' => 'required|string|max:255',
            'type' => 'required|in:upload,input,direct',
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

            $kategori = Kategori::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
                'type' => $request->type,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data'    => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Arahkan ke halaman yang sesuai berdasarkan type
        if ($kategori->isDirect()) {
            return redirect()->route('kategori.kartografi.index', $kategori->id);
        }

        return redirect()->route('kategori.detail.index', $kategori->id);
    }

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
            'data'    => $kategori
        ]);
    }

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
            'type' => 'required|in:upload,input,direct',
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

            $kategori->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'icon' => $request->icon,
                'type' => $request->type,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui',
                'data'    => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

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
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}