<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\ArsipInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class ArsipImportController extends Controller
{
    private const NAMA_MUSNAH     = 'Daftar Arsip Usul Musnah';
    private const NAMA_PERSURATAN = 'Arsip Inaktif Persuratan';

    // =========================================================
    // Mapping kolom Excel → field DB per template
    //
    // MUSNAH (13 kolom, data mulai baris 7):
    //   A=No.(skip) B=Kode Klas. C=Uraian D=Kurun Waktu E=Tingkat
    //   F=Jumlah G=No.Box H=Media I=Kondisi J=Nomor Folder
    //   K=Jangka+Nasib L=Ket M=Lbr
    //
    // VITAL/PERMANEN (16 kolom, data mulai baris 8):
    //   A=No.(skip) B=Jenis Arsip C=No Box D=No Berkas E=No.Perjanjian
    //   F=Pihak I G=Pihak II H=Tingkat I=Tgl Berlaku J=Tgl Berakhir
    //   K=Media L=Jumlah M=Jangka Simpan N=Lokasi O=Metode P=Ket
    //
    // PERSURATAN (13 kolom, data mulai baris 8):
    //   A=No.Berkas B=Unit Kerja C=Nomor Item D=Kode Klas. E=Uraian
    //   F=Tgl G=Tingkat H=Jumlah(lbr) I=No.FC J=No.Laci K=No.Folder
    //   L=Klas.Keamanan M=Ket
    // =========================================================

    public function import(Request $request, $kategoriId, $detailId, $tahunId)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $kategori       = Kategori::findOrFail($kategoriId);
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);
        $tahunDetail    = TahunKategoriDetail::where('id_kategori_detail', $detailId)->findOrFail($tahunId);

        try {
            $spreadsheet = IOFactory::load($request->file('file')->getPathname());
            $ws          = $spreadsheet->getActiveSheet();
            $rows        = $ws->toArray(null, true, true, false); // 0-indexed array

            if ($kategori->name === self::NAMA_MUSNAH) {
                $result = $this->importMusnah($rows, $tahunId);
            } elseif ($kategori->name === self::NAMA_PERSURATAN) {
                $result = $this->importPersuratan($rows, $tahunId);
            } else {
                $result = $this->importVitalPermanen($rows, $tahunId);
            }

            $imported = $result['imported'];
            $skipped  = $result['skipped'];

            $message = "Berhasil mengimport {$imported} baris data.";
            if (count($skipped) > 0) {
                $message .= ' ' . count($skipped) . ' baris dilewati karena uraian informasi sudah ada.';
            }

            return response()->json([
                'success'       => true,
                'message'       => $message,
                'imported'      => $imported,
                'skipped_count' => count($skipped),
                'skipped_items' => $skipped,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal import: ' . $e->getMessage(),
            ], 500);
        }
    }

    // =========================================================
    // IMPORT: USUL MUSNAH
    // Header baris 5-6, nomor urut baris 6, data mulai baris 7 (index 6)
    // =========================================================
    private function importMusnah(array $rows, $tahunId): array
    {
        $dataStart    = $this->detectDataStart($rows, 6);
        $count        = 0;
        $skippedItems = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $i => $row) {
                if ($i < $dataStart) continue;

                $filled = array_filter($row, fn($v) => $v !== null && $v !== '');
                if (empty($filled)) continue;

                if ($this->isNoteRow($row)) continue;

                $inti = array_filter(array_slice($row, 1, 5), fn($v) => $v !== null && $v !== '');
                if (empty($inti)) continue;

                $uraian = $this->val($row, 2);

                // Cek duplikat berdasarkan uraian_informasi di tahun yang sama
                if ($uraian && ArsipInput::where('id_tahun_kategori_detail', $tahunId)
                        ->where('uraian_informasi', $uraian)
                        ->exists()) {
                    $skippedItems[] = $uraian;
                    continue;
                }

                $jangkaNasib  = $this->val($row, 10);
                $jangkaSimpan = null;
                $nasibAkhir   = null;
                if ($jangkaNasib) {
                    if (str_contains($jangkaNasib, ' / ')) {
                        [$jangkaSimpan, $nasibAkhir] = explode(' / ', $jangkaNasib, 2);
                    } else {
                        $jangkaSimpan = $jangkaNasib;
                    }
                }

                ArsipInput::create([
                    'id_tahun_kategori_detail' => $tahunId,
                    'kode_klasifikasi'         => $this->val($row, 1),
                    'uraian_informasi'         => $uraian,
                    'kurun_waktu'              => $this->val($row, 3),
                    'tingkat_perkembangan'     => $this->val($row, 4),
                    'jumlah'                   => $this->val($row, 5),
                    'no_box'                   => $this->val($row, 6),
                    'media_simpan'             => $this->val($row, 7),
                    'kondisi_fisik'            => $this->val($row, 8),
                    'nomor_folder'             => $this->val($row, 9),
                    'jangka_simpan'            => trim($jangkaSimpan ?? '') ?: null,
                    'nasib_akhir_arsip'        => trim($nasibAkhir ?? '') ?: null,
                    'keterangan'               => $this->val($row, 11),
                    'lembar'                   => $this->intVal($row, 12),
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return ['imported' => $count, 'skipped' => $skippedItems];
    }

    // =========================================================
    // IMPORT: VITAL & PERMANEN
    // Header baris 6, nomor urut baris 7, data mulai baris 8 (index 7)
    // =========================================================
    private function importVitalPermanen(array $rows, $tahunId): array
    {
        $dataStart    = $this->detectDataStart($rows, 7);
        $count        = 0;
        $skippedItems = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $i => $row) {
                if ($i < $dataStart) continue;

                $filled = array_filter($row, fn($v) => $v !== null && $v !== '');
                if (empty($filled)) continue;

                if ($this->isNoteRow($row)) continue;

                $inti = array_filter(array_slice($row, 1, 4), fn($v) => $v !== null && $v !== '');
                if (empty($inti)) continue;

                $uraian = $this->val($row, 1); // jenis_arsip sebagai identitas utama

                // Cek duplikat berdasarkan jenis_arsip + no_berkas di tahun yang sama
                $noBerkas = $this->val($row, 3);
                if ($uraian && ArsipInput::where('id_tahun_kategori_detail', $tahunId)
                        ->where('jenis_arsip', $uraian)
                        ->where('no_berkas', $noBerkas)
                        ->exists()) {
                    $label = $uraian . ($noBerkas ? " ({$noBerkas})" : '');
                    $skippedItems[] = $label;
                    continue;
                }

                ArsipInput::create([
                    'id_tahun_kategori_detail' => $tahunId,
                    'jenis_arsip'              => $uraian,
                    'no_box'                   => $this->val($row, 2),
                    'no_berkas'                => $noBerkas,
                    'no_perjanjian_kerjasama'  => $this->val($row, 4),
                    'pihak_i'                  => $this->val($row, 5),
                    'pihak_ii'                 => $this->val($row, 6),
                    'tingkat_perkembangan'     => $this->val($row, 7),
                    'tanggal_berlaku'          => $this->dateVal($row, 8),
                    'tanggal_berakhir'         => $this->dateVal($row, 9),
                    'media'                    => $this->val($row, 10),
                    'jumlah'                   => $this->val($row, 11),
                    'jangka_simpan'            => $this->val($row, 12),
                    'lokasi_simpan'            => $this->val($row, 13),
                    'metode_perlindungan'      => $this->val($row, 14),
                    'keterangan'               => $this->val($row, 15),
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return ['imported' => $count, 'skipped' => $skippedItems];
    }

    // =========================================================
    // IMPORT: ARSIP INAKTIF PERSURATAN
    // Header baris 5-6, nomor urut baris 7, data mulai baris 8 (index 7)
    // =========================================================
    private function importPersuratan(array $rows, $tahunId): array
    {
        $dataStart    = $this->detectDataStart($rows, 7);
        $count        = 0;
        $skippedItems = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $i => $row) {
                if ($i < $dataStart) continue;

                $filled = array_filter($row, fn($v) => $v !== null && $v !== '');
                if (empty($filled)) continue;

                if ($this->isNoteRow($row)) continue;

                $inti = array_filter([$row[3] ?? null, $row[4] ?? null], fn($v) => $v !== null && $v !== '');
                if (empty($inti)) continue;

                $uraian = $this->val($row, 4);

                // Cek duplikat berdasarkan uraian_informasi_persuratan di tahun yang sama
                if ($uraian && ArsipInput::where('id_tahun_kategori_detail', $tahunId)
                        ->where('uraian_informasi_persuratan', $uraian)
                        ->exists()) {
                    $skippedItems[] = $uraian;
                    continue;
                }

                ArsipInput::create([
                    'id_tahun_kategori_detail'        => $tahunId,
                    'no_berkas_persuratan'            => $this->val($row, 0),
                    'unit_kerja'                      => $this->val($row, 1),
                    'nomor_item_arsip'                => $this->val($row, 2),
                    'kode_klasifikasi_persuratan'     => $this->val($row, 3),
                    'uraian_informasi_persuratan'     => $uraian,
                    'tgl'                             => $this->dateVal($row, 5),
                    'tingkat_perkembangan_persuratan' => $this->val($row, 6),
                    'jumlah_lembar'                   => $this->val($row, 7),
                    'no_filling_cabinet'              => $this->val($row, 8),
                    'no_laci'                         => $this->val($row, 9),
                    'no_folder_persuratan'            => $this->val($row, 10),
                    'klasifikasi_keamanan'            => $this->val($row, 11),
                    'keterangan_persuratan'           => $this->val($row, 12),
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return ['imported' => $count, 'skipped' => $skippedItems];
    }

    // =========================================================
    // Helpers
    // =========================================================

    /**
     * Deteksi baris data sesungguhnya:
     * cari baris pertama setelah $minIndex yang bukan header/nomor urut
     */
    private function detectDataStart(array $rows, int $minIndex): int
    {
        foreach ($rows as $i => $row) {
            if ($i < $minIndex) continue;
            $nonNull = array_values(array_filter($row, fn($v) => $v !== null && $v !== ''));
            if (empty($nonNull)) continue;
            // Skip baris nomor urut kolom (semua nilai integer berurutan)
            $allInt = array_reduce($nonNull, fn($c, $v) => $c && is_numeric($v) && (int)$v == $v, true);
            if ($allInt && count($nonNull) >= 3) continue;
            return $i;
        }
        return $minIndex;
    }

    /**
     * Cek apakah baris adalah baris catatan/petunjuk (bukan data)
     * — baris yang hanya punya 1 sel terisi dan isinya panjang atau diawali ⚠️
     */
    private function isNoteRow(array $row): bool
    {
        $nonNull = array_filter($row, fn($v) => $v !== null && $v !== '');
        if (empty($nonNull)) return false;

        // Baris petunjuk: hanya 1-2 sel terisi dan isinya sangat panjang / diawali simbol peringatan
        if (count($nonNull) <= 2) {
            $firstVal = (string) reset($nonNull);
            if (str_starts_with($firstVal, '⚠') || mb_strlen($firstVal) > 80) {
                return true;
            }
        }
        return false;
    }

    private function val(array $row, int $col): ?string
    {
        $v = $row[$col] ?? null;
        if ($v === null || $v === '') return null;
        return trim((string) $v);
    }

    private function intVal(array $row, int $col): ?int
    {
        $v = $row[$col] ?? null;
        if ($v === null || $v === '') return null;
        return is_numeric($v) ? (int) $v : null;
    }

    private function dateVal(array $row, int $col): ?string
    {
        $v = $row[$col] ?? null;
        if ($v === null || $v === '') return null;

        try {
            // Excel numeric date
            if (is_numeric($v)) {
                return ExcelDate::excelToDateTimeObject($v)->format('Y-m-d');
            }
            // String date
            return Carbon::parse($v)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}