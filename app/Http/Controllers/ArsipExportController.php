<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\TahunKategoriDetail;
use App\Models\ArsipInput;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ArsipExportController extends Controller
{
    // Ubah sesuai instansi
    private const TTD_KOTA    = 'Makassar';
    private const TTD_JABATAN = 'Kepala Bagian Umum';
    private const TTD_NAMA    = 'Zulchaidir, S.Sos.,MPA';
    private const TTD_NIP     = 'NIP. 19830115 200912 1 003';

    // Nama kategori – sesuaikan jika beda di database
    private const NAMA_MUSNAH     = 'Daftar Arsip Usul Musnah';
    private const NAMA_PERSURATAN = 'Arsip Inaktif Persuratan';

    public function export($kategoriId, $detailId, $tahunId)
    {
        $kategori       = Kategori::findOrFail($kategoriId);
        $kategoriDetail = KategoriDetail::where('id_kategori', $kategoriId)->findOrFail($detailId);
        $tahunDetail    = TahunKategoriDetail::where('id_kategori_detail', $detailId)->findOrFail($tahunId);

        $inputs = ArsipInput::where('id_tahun_kategori_detail', $tahunId)
            ->orderBy('no', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($kategori->name === self::NAMA_MUSNAH) {
            return $this->exportMusnah($inputs, $kategoriDetail, $tahunDetail);
        }

        if ($kategori->name === self::NAMA_PERSURATAN) {
            return $this->exportPersuratan($inputs, $kategoriDetail, $tahunDetail);
        }

        return $this->exportVitalPermanen($inputs, $kategori, $kategoriDetail, $tahunDetail);
    }

    // =========================================================
    // EXPORT: DAFTAR ARSIP USUL MUSNAH
    // Header baris 5-6 (abu-abu), data mulai baris 7
    // TTD di kolom K, 5 baris setelah data terakhir
    // =========================================================
    private function exportMusnah($inputs, $kategoriDetail, $tahunDetail)
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Usul Musnah');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        foreach ([
            'A' => 6.41,  'B' => 16.7,  'C' => 59.56,
            'D' => 11.28, 'E' => 17.56, 'F' => 10.85, 'G' => 8.7,
            'H' => 10.85, 'I' => 13.14, 'J' => 12.14, 'K' => 15.41,
            'L' => 8.7,   'M' => 8.7,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        $ws->mergeCells('A1:M1');
        $ws->setCellValue('A1', 'DAFTAR ARSIP INAKTIF USUL MUSNAH');
        $ws->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(1)->setRowHeight(18.95);

        $ws->mergeCells('A2:M2');
        $ws->setCellValue('A2', 'TAHUN ' . $tahunDetail->name);
        $ws->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(2)->setRowHeight(18.95);

        $ws->mergeCells('A3:D3');
        $ws->setCellValue('A3', 'Pencipta Arsip : Puslatbang KMP LAN');
        $ws->getStyle('A3')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $ws->getRowDimension(3)->setRowHeight(21.75);
        $ws->getRowDimension(4)->setRowHeight(7.5);

        $headers = [
            'A' => 'No.',
            'B' => 'Kode Klasifikasi',
            'C' => 'Uraian Informasi',
            'D' => 'Kurun Waktu',
            'E' => 'Tingkat Perkembangan',
            'F' => 'Jumlah',
            'G' => 'No. Box',
            'H' => 'Media Simpan',
            'I' => 'Kondisi Fisik',
            'J' => 'Nomor Folder',
            'K' => 'Jangka Simpan dan Nasib Akhir Arsip',
            'L' => 'Ket',
            'M' => 'Lbr',
        ];

        foreach (array_keys($headers) as $col) {
            $ws->mergeCells("{$col}5:{$col}6");
        }

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach ($headers as $col => $label) {
            $ws->setCellValue("{$col}5", $label);
            $ws->getStyle("{$col}5:{$col}6")->applyFromArray($hStyle);
        }
        $ws->getRowDimension(5)->setRowHeight(26.25);
        $ws->getRowDimension(6)->setRowHeight(30);

        $dStyle = [
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'font'      => ['size' => 11],
        ];

        $row = 7;
        foreach ($inputs as $i => $item) {
            $jangkaNasib = trim(
                ($item->jangka_simpan ?? '') .
                ($item->nasib_akhir_arsip ? ' / ' . $item->nasib_akhir_arsip : '')
            );

            $ws->setCellValue("A{$row}", $i + 1);
            $ws->setCellValue("B{$row}", $item->kode_klasifikasi ?? '');
            $ws->setCellValue("C{$row}", $item->uraian_informasi ?? '');
            $ws->setCellValue("D{$row}", $item->kurun_waktu ?? '');
            $ws->setCellValue("E{$row}", $item->tingkat_perkembangan ?? '');
            $ws->setCellValue("F{$row}", $item->jumlah ?? '');
            $ws->setCellValue("G{$row}", $item->no_box ?? '');
            $ws->setCellValue("H{$row}", $item->media_simpan ?? '');
            $ws->setCellValue("I{$row}", $item->kondisi_fisik ?? '');
            $ws->setCellValue("J{$row}", $item->nomor_folder ?? '');
            $ws->setCellValue("K{$row}", $jangkaNasib);
            $ws->setCellValue("L{$row}", $item->keterangan ?? '');
            $ws->setCellValue("M{$row}", $item->lembar ?? '');

            $ws->getStyle("A{$row}:M{$row}")->applyFromArray($dStyle);
            $ws->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("G{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("M{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $lines = max(1, ceil(mb_strlen($item->uraian_informasi ?? '') / 60));
            $ws->getRowDimension($row)->setRowHeight(max(20, $lines * 15));
            $row++;
        }

        $tanggal = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
        $ws->setCellValue("K" . ($row + 5),  self::TTD_KOTA . ',  ' . $tanggal);
        $ws->setCellValue("K" . ($row + 6),  self::TTD_JABATAN);
        $ws->setCellValue("K" . ($row + 11), self::TTD_NAMA);
        $ws->setCellValue("K" . ($row + 12), self::TTD_NIP);

        foreach ([$row + 5, $row + 6, $row + 11, $row + 12] as $r) {
            $ws->getStyle("K{$r}")->applyFromArray([
                'font'      => ['size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ]);
        }

        $ws->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)->setFitToHeight(0);
        $ws->getPageMargins()->setTop(0.75)->setBottom(0.75)->setLeft(0.5)->setRight(0.5);

        $filename = 'Daftar_Arsip_Usul_Musnah_' . str_replace(' ', '_', $tahunDetail->name) . '.xlsx';
        return $this->streamExcel($spreadsheet, $filename);
    }

    // =========================================================
    // EXPORT: DAFTAR ARSIP VITAL / PERMANEN
    // Header baris 6 (abu-abu), nomor urut baris 7 (abu-abu), data mulai baris 8
    // TTD di kolom N, 5 baris setelah data terakhir
    // =========================================================
    private function exportVitalPermanen($inputs, $kategori, $kategoriDetail, $tahunDetail)
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Arsip Vital');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        foreach ([
            'A' => 5.57,  'B' => 42.14, 'C' => 6.86,  'D' => 9.0,
            'E' => 16.86, 'F' => 14.0,  'G' => 13.86, 'H' => 17.29,
            'I' => 15.43, 'J' => 14.57, 'K' => 8.43,  'L' => 10.71,
            'M' => 12.43, 'N' => 12.14, 'O' => 16.0,  'P' => 10.71,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        $ws->mergeCells('A1:P1');
        $ws->setCellValue('A1', strtoupper($kategori->name));
        $ws->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(1)->setRowHeight(18);

        $ws->mergeCells('A2:P2');
        $ws->setCellValue('A2', 'TAHUN PENCIPTAAN ' . $tahunDetail->name);
        $ws->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(2)->setRowHeight(18);

        $ws->mergeCells('A3:P3');
        $ws->getRowDimension(3)->setRowHeight(18);

        $ws->setCellValue('A4', 'Unit Kerja : Pusjar SKMP LAN');
        $ws->getStyle('A4')->applyFromArray([
            'font'      => ['size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $ws->getRowDimension(4)->setRowHeight(16.5);
        $ws->getRowDimension(5)->setRowHeight(5);

        $headers = [
            'A' => 'No.',
            'B' => 'Jenis Arsip',
            'C' => 'No Box',
            'D' => 'No Berkas',
            'E' => 'No. Perjanjian Kerjasama',
            'F' => 'Pihak I',
            'G' => 'Pihak II',
            'H' => 'Tingkat Perkembangan',
            'I' => 'Tanggal Berlaku',
            'J' => 'Tanggal Berakhir',
            'K' => 'Media',
            'L' => 'Jumlah',
            'M' => 'Jangka Simpan',
            'N' => 'Lokasi Simpan',
            'O' => 'Metode Perlindungan',
            'P' => 'Ket',
        ];

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach ($headers as $col => $label) {
            $ws->setCellValue("{$col}6", $label);
            $ws->getStyle("{$col}6")->applyFromArray($hStyle);
        }
        $ws->getRowDimension(6)->setRowHeight(36.75);

        $nStyle = [
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach (array_keys($headers) as $idx => $col) {
            $ws->setCellValue("{$col}7", $idx + 1);
            $ws->getStyle("{$col}7")->applyFromArray($nStyle);
        }
        $ws->getRowDimension(7)->setRowHeight(20.25);

        $dStyle = [
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'font'      => ['size' => 11],
        ];

        $row = 8;
        foreach ($inputs as $i => $item) {
            $ws->setCellValue("A{$row}", $i + 1);
            $ws->setCellValue("B{$row}", $item->jenis_arsip ?? '');
            $ws->setCellValue("C{$row}", $item->no_box ?? '');
            $ws->setCellValue("D{$row}", $item->no_berkas ?? '');
            $ws->setCellValue("E{$row}", $item->no_perjanjian_kerjasama ?? '');
            $ws->setCellValue("F{$row}", $item->pihak_i ?? '');
            $ws->setCellValue("G{$row}", $item->pihak_ii ?? '');
            $ws->setCellValue("H{$row}", $item->tingkat_perkembangan ?? '');
            $ws->setCellValue("I{$row}", $item->tanggal_berlaku
                ? Carbon::parse($item->tanggal_berlaku)->format('d-m-Y') : '');
            $ws->setCellValue("J{$row}", $item->tanggal_berakhir
                ? Carbon::parse($item->tanggal_berakhir)->format('d-m-Y') : '');
            $ws->setCellValue("K{$row}", $item->media ?? '');
            $ws->setCellValue("L{$row}", $item->jumlah ?? '');
            $ws->setCellValue("M{$row}", $item->jangka_simpan ?? '');
            $ws->setCellValue("N{$row}", $item->lokasi_simpan ?? '');
            $ws->setCellValue("O{$row}", $item->metode_perlindungan ?? '');
            $ws->setCellValue("P{$row}", $item->keterangan ?? '');

            $ws->getStyle("A{$row}:P{$row}")->applyFromArray($dStyle);
            $ws->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("L{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $lines = max(1, ceil(mb_strlen($item->jenis_arsip ?? '') / 30));
            $ws->getRowDimension($row)->setRowHeight(max(20, $lines * 15));
            $row++;
        }

        $tanggal = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
        $ws->setCellValue("N" . ($row + 5),  self::TTD_KOTA . ', ' . $tanggal);
        $ws->setCellValue("N" . ($row + 6),  self::TTD_JABATAN);
        $ws->setCellValue("N" . ($row + 11), self::TTD_NAMA);
        $ws->setCellValue("N" . ($row + 12), self::TTD_NIP);

        foreach ([$row + 5, $row + 6, $row + 11, $row + 12] as $r) {
            $ws->getStyle("N{$r}")->applyFromArray([
                'font'      => ['size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ]);
        }

        $ws->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(5) // Legal
            ->setFitToWidth(1)->setFitToHeight(0);
        $ws->getPageMargins()->setTop(0.75)->setBottom(0.75)->setLeft(0.5)->setRight(0.5);

        $safeKategori = str_replace(' ', '_', $kategori->name);
        $filename     = "{$safeKategori}_{$tahunDetail->name}.xlsx";
        return $this->streamExcel($spreadsheet, $filename);
    }

    // =========================================================
    // EXPORT: ARSIP INAKTIF PERSURATAN
    // Struktur mengikuti file Surat_Masuk_Tahun_2018.xlsx
    // Sheet "Daftar Isi Berkas Fix":
    //   Baris 1: Judul   Baris 2: Tahun   Baris 3: Pencipta Arsip
    //   Baris 4: kosong  Baris 5: Header row 1  Baris 6: Header row 2
    //   Baris 7: Nomor urut kolom  Data mulai baris 8
    //
    // Kolom: No.Berkas | Unit Kerja | No.Item | Kode Klas. | Uraian Informasi |
    //        Tgl | Tingkat Perkembangan | Jumlah (lbr) |
    //        Lokasi (No.Filling Cabinet | No.Laci | No.Folder) |
    //        Klas. Keamanan | Ket
    // TTD di kolom K, 5 baris setelah data terakhir
    // =========================================================
    private function exportPersuratan($inputs, $kategoriDetail, $tahunDetail)
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Arsip Persuratan');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        // Lebar kolom
        // A=No.Berkas B=Unit Kerja C=No.Item D=Kode E=Uraian F=Tgl
        // G=Tingkat H=Jumlah I=No.FC J=No.Laci K=No.Folder L=Klas.Keamanan M=Ket
        foreach ([
            'A' => 9.0,   'B' => 14.0,  'C' => 9.0,   'D' => 14.0,
            'E' => 55.0,  'F' => 11.0,  'G' => 17.0,  'H' => 10.0,
            'I' => 12.0,  'J' => 9.0,   'K' => 10.0,  'L' => 16.0,
            'M' => 14.0,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        // Baris 1: Judul
        $ws->mergeCells('A1:M1');
        $ws->setCellValue('A1', 'DAFTAR ISI BERKAS ARSIP PERSURATAN');
        $ws->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(1)->setRowHeight(18.95);

        // Baris 2: Tahun
        $ws->mergeCells('A2:M2');
        $ws->setCellValue('A2', 'TAHUN ' . $tahunDetail->name);
        $ws->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $ws->getRowDimension(2)->setRowHeight(18.95);

        // Baris 3: Pencipta Arsip
        $ws->mergeCells('A3:D3');
        $ws->setCellValue('A3', 'Pencipta Arsip : Puslatbang KMP LAN');
        $ws->getStyle('A3')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $ws->getRowDimension(3)->setRowHeight(21.75);
        $ws->getRowDimension(4)->setRowHeight(7.5);

        // ---- Header baris 5 & 6 ----
        // Kolom I,J,K perlu merge baris 5 untuk label "Lokasi"
        // Semua kolom lain merge baris 5-6

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        // Kolom single (merge baris 5-6)
        $singleCols = [
            'A' => 'No. Berkas',
            'B' => 'Unit Kerja',
            'C' => 'Nomor Item Arsip',
            'D' => 'Kode Klasifikasi',
            'E' => 'Uraian Informasi Isi Arsip',
            'F' => 'Tgl',
            'G' => 'Tingkat Perkembangan',
            'H' => 'Jumlah (lbr)',
            'L' => 'Klasifikasi Keamanan dan Akses Arsip (Terbuka, Terbatas, Rahasia)',
            'M' => 'Ket',
        ];

        foreach ($singleCols as $col => $label) {
            $ws->mergeCells("{$col}5:{$col}6");
            $ws->setCellValue("{$col}5", $label);
            $ws->getStyle("{$col}5:{$col}6")->applyFromArray($hStyle);
        }

        // Kolom I-K: baris 5 = "Lokasi" (merge I5:K5), baris 6 = sub-header
        $ws->mergeCells('I5:K5');
        $ws->setCellValue('I5', 'Lokasi');
        $ws->getStyle('I5:K5')->applyFromArray($hStyle);

        foreach (['I' => 'No. Filling Cabinet', 'J' => 'No. Laci', 'K' => 'No. Folder'] as $col => $label) {
            $ws->setCellValue("{$col}6", $label);
            $ws->getStyle("{$col}6")->applyFromArray($hStyle);
        }

        $ws->getRowDimension(5)->setRowHeight(36.75);
        $ws->getRowDimension(6)->setRowHeight(30);

        // Baris 7: Nomor urut kolom
        $nStyle = [
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach (range('A', 'M') as $idx => $col) {
            $ws->setCellValue("{$col}7", $idx + 1);
            $ws->getStyle("{$col}7")->applyFromArray($nStyle);
        }
        $ws->getRowDimension(7)->setRowHeight(20.25);

        // Data baris 8+
        $dStyle = [
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'font'      => ['size' => 11],
        ];

        $row = 8;
        foreach ($inputs as $i => $item) {
            $ws->setCellValue("A{$row}", $item->no_berkas_persuratan ?? ($i + 1));
            $ws->setCellValue("B{$row}", $item->unit_kerja ?? '');
            $ws->setCellValue("C{$row}", $item->nomor_item_arsip ?? '');
            $ws->setCellValue("D{$row}", $item->kode_klasifikasi_persuratan ?? '');
            $ws->setCellValue("E{$row}", $item->uraian_informasi_persuratan ?? '');
            $ws->setCellValue("F{$row}", $item->tgl
                ? Carbon::parse($item->tgl)->format('d-m-Y') : '');
            $ws->setCellValue("G{$row}", $item->tingkat_perkembangan_persuratan ?? '');
            $ws->setCellValue("H{$row}", $item->jumlah_lembar ?? '');
            $ws->setCellValue("I{$row}", $item->no_filling_cabinet ?? '');
            $ws->setCellValue("J{$row}", $item->no_laci ?? '');
            $ws->setCellValue("K{$row}", $item->no_folder_persuratan ?? '');
            $ws->setCellValue("L{$row}", $item->klasifikasi_keamanan ?? '');
            $ws->setCellValue("M{$row}", $item->keterangan_persuratan ?? '');

            $ws->getStyle("A{$row}:M{$row}")->applyFromArray($dStyle);
            $ws->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("J{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ws->getStyle("K{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $lines = max(1, ceil(mb_strlen($item->uraian_informasi_persuratan ?? '') / 60));
            $ws->getRowDimension($row)->setRowHeight(max(20, $lines * 15));
            $row++;
        }

        // TTD: kolom K, 5 baris setelah data terakhir
        $tanggal = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
        $ws->setCellValue("K" . ($row + 5),  self::TTD_KOTA . ',  ' . $tanggal);
        $ws->setCellValue("K" . ($row + 6),  self::TTD_JABATAN);
        $ws->setCellValue("K" . ($row + 11), self::TTD_NAMA);
        $ws->setCellValue("K" . ($row + 12), self::TTD_NIP);

        foreach ([$row + 5, $row + 6, $row + 11, $row + 12] as $r) {
            $ws->getStyle("K{$r}")->applyFromArray([
                'font'      => ['size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ]);
        }

        $ws->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)->setFitToHeight(0);
        $ws->getPageMargins()->setTop(0.75)->setBottom(0.75)->setLeft(0.5)->setRight(0.5);

        $filename = 'Arsip_Inaktif_Persuratan_' . str_replace(' ', '_', $tahunDetail->name) . '.xlsx';
        return $this->streamExcel($spreadsheet, $filename);
    }


    // =========================================================
    // DOWNLOAD TEMPLATE IMPORT
    // Menghasilkan file Excel kosong sesuai format tiap template
    // =========================================================
    public function downloadTemplate($kategoriId, $detailId, $tahunId)
    {
        $kategori = Kategori::findOrFail($kategoriId);

        if ($kategori->name === self::NAMA_MUSNAH) {
            return $this->templateMusnah();
        }

        if ($kategori->name === self::NAMA_PERSURATAN) {
            return $this->templatePersuratan();
        }

        return $this->templateVitalPermanen($kategori);
    }

    // ─── Template: Usul Musnah ───────────────────────────────
    private function templateMusnah()
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Usul Musnah');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        foreach ([
            'A' => 6.41,  'B' => 16.7,  'C' => 59.56,
            'D' => 11.28, 'E' => 17.56, 'F' => 10.85, 'G' => 8.7,
            'H' => 10.85, 'I' => 13.14, 'J' => 12.14, 'K' => 15.41,
            'L' => 8.7,   'M' => 8.7,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        // Baris 1-4: Info (biarkan kosong, user isi sendiri)
        $ws->mergeCells('A1:M1');
        $ws->setCellValue('A1', 'DAFTAR ARSIP INAKTIF USUL MUSNAH');
        $ws->getStyle('A1')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A2:M2');
        $ws->setCellValue('A2', 'TAHUN [ISI TAHUN]');
        $ws->getStyle('A2')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A3:D3');
        $ws->setCellValue('A3', 'Pencipta Arsip : [ISI INSTANSI]');
        $ws->getStyle('A3')->applyFromArray(['font' => ['bold' => true]]);

        $ws->getRowDimension(4)->setRowHeight(7.5);

        // Header baris 5-6
        $headers = [
            'A' => 'No.',
            'B' => 'Kode Klasifikasi',
            'C' => 'Uraian Informasi',
            'D' => 'Kurun Waktu',
            'E' => 'Tingkat Perkembangan',
            'F' => 'Jumlah',
            'G' => 'No. Box',
            'H' => 'Media Simpan',
            'I' => 'Kondisi Fisik',
            'J' => 'Nomor Folder',
            'K' => 'Jangka Simpan dan Nasib Akhir Arsip',
            'L' => 'Ket',
            'M' => 'Lbr',
        ];

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        foreach (array_keys($headers) as $col) {
            $ws->mergeCells("{$col}5:{$col}6");
        }
        foreach ($headers as $col => $label) {
            $ws->setCellValue("{$col}5", $label);
            $ws->getStyle("{$col}5:{$col}6")->applyFromArray($hStyle);
        }
        $ws->getRowDimension(5)->setRowHeight(26.25);
        $ws->getRowDimension(6)->setRowHeight(30);

        // Baris nomor urut kolom (baris 7) — abu-abu
        $nStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach (array_keys($headers) as $idx => $col) {
            $ws->setCellValue("{$col}7", $idx + 1);
            $ws->getStyle("{$col}7")->applyFromArray($nStyle);
        }
        $ws->getRowDimension(7)->setRowHeight(18);

        // Baris 8-9: contoh data nyata, baris 10+: kosong
        $dStyle = [
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'font'      => ['size' => 11],
        ];
        $cStyle = array_merge($dStyle, [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2CC']],
        ]);

        $contoh = [
            8 => [
                'A' => '1',
                'B' => 'PDP.07.1',
                'C' => 'Kertas Kerja Perorangan (KKP) : Rencana Kerja Peningkatan Pengkajian Kelembagaan dan Sumber Daya Aparatur pada Pusat Kajian dan Diklat Aparatur II LAN oleh Muhammad Idris Diklat Struktural Staf dan Pimpinan Administrasi Tingkat Pertama (SPAMA) Angkatan XXVII',
                'D' => '2001',
                'E' => 'Fotokopi',
                'F' => '1 Folder',
                'G' => '-',
                'H' => 'Kertas',
                'I' => 'Baik',
                'J' => '-',
                'K' => '5 Tahun / Dinilai Kembali',
                'L' => '-',
                'M' => '',
            ],
            9 => [
                'A' => '2',
                'B' => 'PDP.07.1',
                'C' => 'Kertas Kerja Perorangan (KKP) : Peningkatan Kompetensi Aparatur Badan Kepegawaian Daerah melalui Penyelenggaraan Diklat Aparatur untuk mewujudkan Good Governance dalam rangka memantapkan pelaksanaan Otonomi Daerah di Kabupaten Bogor oleh Drs. Alimuddin Ralla Diklatpim II Angkatan IV Kelas F PKP2A II LAN',
                'D' => '2002',
                'E' => 'Fotokopi',
                'F' => '1 Folder',
                'G' => '-',
                'H' => 'Kertas',
                'I' => 'Baik',
                'J' => '-',
                'K' => '5 Tahun / Musnah',
                'L' => '-',
                'M' => '',
            ],
        ];

        foreach ($contoh as $r => $rowData) {
            foreach ($rowData as $col => $val) {
                $ws->setCellValue("{$col}{$r}", $val);
                $ws->getStyle("{$col}{$r}")->applyFromArray($cStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(60);
        }

        // Baris kosong setelahnya
        for ($r = 10; $r <= 14; $r++) {
            foreach (array_keys($headers) as $col) {
                $ws->setCellValue("{$col}{$r}", '');
                $ws->getStyle("{$col}{$r}")->applyFromArray($dStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(20);
        }

        // Catatan pengisian di bawah
        $noteRow = 16;
        $ws->mergeCells("A{$noteRow}:M{$noteRow}");
        $ws->setCellValue("A{$noteRow}", '⚠️  PETUNJUK: Isi data mulai baris 8. Baris kuning adalah CONTOH — ubah atau hapus sebelum import. Kolom K format: "5 Tahun / Musnah" (Jangka Simpan / Nasib Akhir). Pilihan Nasib Akhir: Musnah / Permanen / Dinilai Kembali. Jangan ubah baris 1-7.');
        $ws->getStyle("A{$noteRow}")->applyFromArray([
            'font'      => ['size' => 10, 'color' => ['rgb' => 'C00000'], 'italic' => true],
            'alignment' => ['wrapText' => true],
        ]);
        $ws->getRowDimension($noteRow)->setRowHeight(28);

        $ws->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        return $this->streamExcel($spreadsheet, 'Template_Import_Usul_Musnah.xlsx');
    }

    // ─── Template: Vital & Permanen ──────────────────────────
    private function templateVitalPermanen(Kategori $kategori)
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Arsip Vital');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        foreach ([
            'A' => 5.57,  'B' => 42.14, 'C' => 6.86,  'D' => 9.0,
            'E' => 16.86, 'F' => 14.0,  'G' => 13.86, 'H' => 17.29,
            'I' => 15.43, 'J' => 14.57, 'K' => 8.43,  'L' => 10.71,
            'M' => 12.43, 'N' => 12.14, 'O' => 16.0,  'P' => 10.71,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        $ws->mergeCells('A1:P1');
        $ws->setCellValue('A1', strtoupper($kategori->name));
        $ws->getStyle('A1')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A2:P2');
        $ws->setCellValue('A2', 'TAHUN PENCIPTAAN [ISI TAHUN]');
        $ws->getStyle('A2')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A3:P3');
        $ws->getRowDimension(3)->setRowHeight(18);

        $ws->setCellValue('A4', 'Unit Kerja : [ISI UNIT KERJA]');
        $ws->getRowDimension(5)->setRowHeight(5);

        $headers = [
            'A' => 'No.',               'B' => 'Jenis Arsip',
            'C' => 'No Box',            'D' => 'No Berkas',
            'E' => 'No. Perjanjian Kerjasama',
            'F' => 'Pihak I',           'G' => 'Pihak II',
            'H' => 'Tingkat Perkembangan',
            'I' => 'Tanggal Berlaku',   'J' => 'Tanggal Berakhir',
            'K' => 'Media',             'L' => 'Jumlah',
            'M' => 'Jangka Simpan',     'N' => 'Lokasi Simpan',
            'O' => 'Metode Perlindungan', 'P' => 'Ket',
        ];

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach ($headers as $col => $label) {
            $ws->setCellValue("{$col}6", $label);
            $ws->getStyle("{$col}6")->applyFromArray($hStyle);
        }
        $ws->getRowDimension(6)->setRowHeight(36.75);

        $nStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach (array_keys($headers) as $idx => $col) {
            $ws->setCellValue("{$col}7", $idx + 1);
            $ws->getStyle("{$col}7")->applyFromArray($nStyle);
        }
        $ws->getRowDimension(7)->setRowHeight(20.25);

        $dStyle = [
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'font'      => ['size' => 11],
        ];
        $cStyle = array_merge($dStyle, [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2CC']],
        ]);

        $contoh = [
            8 => [
                'A' => '1',
                'B' => 'Perjanjian Kerjasama',
                'C' => 'B-001',
                'D' => 'BRK-001',
                'E' => 'PKS-001/2020',
                'F' => 'Puslatbang KMP LAN',
                'G' => 'Pemerintah Kota Makassar',
                'H' => 'Asli',
                'I' => '01-01-2020',
                'J' => '31-12-2024',
                'K' => 'Kertas',
                'L' => '1 Berkas',
                'M' => '10 Tahun',
                'N' => 'Ruang Arsip Lantai 2',
                'O' => 'Brankas',
                'P' => '',
            ],
            9 => [
                'A' => '2',
                'B' => 'MOU',
                'C' => 'B-002',
                'D' => 'BRK-002',
                'E' => 'MOU-002/2021',
                'F' => 'Puslatbang KMP LAN',
                'G' => 'Universitas Hasanuddin',
                'H' => 'Fotokopi',
                'I' => '15-03-2021',
                'J' => '14-03-2026',
                'K' => 'Digital',
                'L' => '2 Berkas',
                'M' => '10 Tahun',
                'N' => 'Ruang Arsip Lantai 2',
                'O' => 'Digital Backup',
                'P' => '',
            ],
        ];

        foreach ($contoh as $r => $rowData) {
            foreach ($rowData as $col => $val) {
                $ws->setCellValue("{$col}{$r}", $val);
                $ws->getStyle("{$col}{$r}")->applyFromArray($cStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(30);
        }

        for ($r = 10; $r <= 14; $r++) {
            foreach (array_keys($headers) as $col) {
                $ws->setCellValue("{$col}{$r}", '');
                $ws->getStyle("{$col}{$r}")->applyFromArray($dStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(20);
        }

        $noteRow = 16;
        $ws->mergeCells("A{$noteRow}:P{$noteRow}");
        $ws->setCellValue("A{$noteRow}", '⚠️  PETUNJUK: Isi data mulai baris 8. Baris kuning adalah CONTOH — ubah atau hapus sebelum import. Kolom Tanggal format: DD-MM-YYYY. Jangan ubah baris 1-7.');
        $ws->getStyle("A{$noteRow}")->applyFromArray([
            'font'      => ['size' => 10, 'color' => ['rgb' => 'C00000'], 'italic' => true],
            'alignment' => ['wrapText' => true],
        ]);
        $ws->getRowDimension($noteRow)->setRowHeight(28);

        $ws->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(5);

        $safe = str_replace(' ', '_', $kategori->name);
        return $this->streamExcel($spreadsheet, "Template_Import_{$safe}.xlsx");
    }

    // ─── Template: Arsip Inaktif Persuratan ──────────────────
    private function templatePersuratan()
    {
        $spreadsheet = new Spreadsheet();
        $ws          = $spreadsheet->getActiveSheet();
        $ws->setTitle('Arsip Persuratan');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        foreach ([
            'A' => 9.0,   'B' => 14.0,  'C' => 9.0,   'D' => 14.0,
            'E' => 55.0,  'F' => 11.0,  'G' => 17.0,  'H' => 10.0,
            'I' => 12.0,  'J' => 9.0,   'K' => 10.0,  'L' => 16.0,
            'M' => 14.0,
        ] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        $ws->mergeCells('A1:M1');
        $ws->setCellValue('A1', 'DAFTAR ISI BERKAS ARSIP PERSURATAN');
        $ws->getStyle('A1')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A2:M2');
        $ws->setCellValue('A2', 'TAHUN [ISI TAHUN]');
        $ws->getStyle('A2')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $ws->mergeCells('A3:D3');
        $ws->setCellValue('A3', 'Pencipta Arsip : [ISI INSTANSI]');
        $ws->getStyle('A3')->applyFromArray(['font' => ['bold' => true]]);
        $ws->getRowDimension(4)->setRowHeight(7.5);

        $hStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '969696']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        $singleCols = [
            'A' => 'No. Berkas',
            'B' => 'Unit Kerja',
            'C' => 'Nomor Item Arsip',
            'D' => 'Kode Klasifikasi',
            'E' => 'Uraian Informasi Isi Arsip',
            'F' => 'Tgl',
            'G' => 'Tingkat Perkembangan',
            'H' => 'Jumlah (lbr)',
            'L' => 'Klasifikasi Keamanan dan Akses Arsip (Terbuka, Terbatas, Rahasia)',
            'M' => 'Ket',
        ];
        foreach ($singleCols as $col => $label) {
            $ws->mergeCells("{$col}5:{$col}6");
            $ws->setCellValue("{$col}5", $label);
            $ws->getStyle("{$col}5:{$col}6")->applyFromArray($hStyle);
        }

        $ws->mergeCells('I5:K5');
        $ws->setCellValue('I5', 'Lokasi');
        $ws->getStyle('I5:K5')->applyFromArray($hStyle);

        foreach (['I' => 'No. Filling Cabinet', 'J' => 'No. Laci', 'K' => 'No. Folder'] as $col => $label) {
            $ws->setCellValue("{$col}6", $label);
            $ws->getStyle("{$col}6")->applyFromArray($hStyle);
        }

        $ws->getRowDimension(5)->setRowHeight(36.75);
        $ws->getRowDimension(6)->setRowHeight(30);

        $nStyle = [
            'font'      => ['bold' => true, 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        foreach (range('A', 'M') as $idx => $col) {
            $ws->setCellValue("{$col}7", $idx + 1);
            $ws->getStyle("{$col}7")->applyFromArray($nStyle);
        }
        $ws->getRowDimension(7)->setRowHeight(20);

        $dStyle = [
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            'font'      => ['size' => 11],
        ];
        $cStyle = array_merge($dStyle, [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2CC']],
        ]);

        $contoh = [
            8 => [
                'A' => '1',
                'B' => 'Bagian Umum',
                'C' => '1',
                'D' => 'HKM.02.1',
                'E' => 'Disposisi dan Surat Nota Dinas dari Sekretaris Utama LAN Perihal contoh surat Dinas LAN No 01/S.1/HKM.02.1',
                'F' => '02-01-2018',
                'G' => 'Disposisi',
                'H' => '19',
                'I' => '',
                'J' => '',
                'K' => '',
                'L' => 'Terbuka',
                'M' => '',
            ],
            9 => [
                'A' => '1',
                'B' => 'Bagian Umum',
                'C' => '2',
                'D' => 'HMI.05',
                'E' => 'Disposisi dan Surat Masuk dari Sekretaris Utama LAN Perihal Paparan Pengembangan Layanan Berbasis TIK di Lingkungan LAN No.06/S.1/HMI.05',
                'F' => '03-01-2018',
                'G' => 'Disposisi',
                'H' => '7',
                'I' => '',
                'J' => '',
                'K' => '',
                'L' => 'Terbuka',
                'M' => '',
            ],
        ];

        foreach ($contoh as $r => $rowData) {
            foreach ($rowData as $col => $val) {
                $ws->setCellValue("{$col}{$r}", $val);
                $ws->getStyle("{$col}{$r}")->applyFromArray($cStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(50);
        }

        for ($r = 10; $r <= 14; $r++) {
            foreach (range('A', 'M') as $col) {
                $ws->setCellValue("{$col}{$r}", '');
                $ws->getStyle("{$col}{$r}")->applyFromArray($dStyle);
            }
            $ws->getRowDimension($r)->setRowHeight(20);
        }

        $noteRow = 16;
        $ws->mergeCells("A{$noteRow}:M{$noteRow}");
        $ws->setCellValue("A{$noteRow}", '⚠️  PETUNJUK: Isi data mulai baris 8. Baris kuning adalah CONTOH — ubah atau hapus sebelum import. Kolom Tgl format: DD-MM-YYYY. Kolom Klasifikasi Keamanan: Terbuka / Terbatas / Rahasia. Jangan ubah baris 1-7.');
        $ws->getStyle("A{$noteRow}")->applyFromArray([
            'font'      => ['size' => 10, 'color' => ['rgb' => 'C00000'], 'italic' => true],
            'alignment' => ['wrapText' => true],
        ]);
        $ws->getRowDimension($noteRow)->setRowHeight(28);

        $ws->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        return $this->streamExcel($spreadsheet, 'Template_Import_Arsip_Persuratan.xlsx');
    }

    private function streamExcel(Spreadsheet $spreadsheet, string $filename)
    {
        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}