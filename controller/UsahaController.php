<?php
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/model/UsahaModel.php';
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/model/WisataModel.php';
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/fpdf/fpdf.php';

class UsahaController
{
    public function __construct()
    {
        $this->usaha = new UsahaModel();
		$this->wisata = new WisataModel();
    }

    public function get_all_wisata()
    {
        $wisata = $this->usaha->get_all_by_category('wisata');
        return $wisata;
    }
    
    public function get_all_umkm()
    {
        $umkm = $this->usaha->get_all_by_category('umkm');
        return $umkm;
    }

    public function store($request)
    {
        $dataUsaha = [
            "user_id" => $request['user_id'],
            "kategori" => $request['kategori'],
            "nama_perusahaan" => $request['nama_perusahaan'],
            "nama_produk" => $request['nama_produk'],
            "deskripsi" => $request['deskripsi'],
            "kecamatan_id" => $request['kecamatan'],
            "kelurahan_id" => $request['kelurahan'],
            "latitude" => $request['latitude'],
            "longitude" => $request['longitude'],
            "alamat" => $request['alamat'],
            "nomor_telepon" => $request['nomor_telepon'],
        ];

        // input ke database dan akan return id
        $usaha = $this->usaha->create($dataUsaha);

        // jika kategori yang dimaksud adalah tempat wisata
        if ($request['kategori'] == "wisata") {
            $dataWisata = [
                "usaha_id" => $usaha,
                "harga_weekday_anak" => $request['harga_weekday_anak'],
                "harga_weekend_anak" => $request['harga_weekend_anak'],
                "harga_weekday_dewasa" => $request['harga_weekday_dewasa'],
                "harga_weekend_dewasa" => $request['harga_weekend_dewasa'],
                "jam_buka_weekday" => $request['jam_buka_hari_biasa'],
                "jam_tutup_weekday" => $request['jam_tutup_hari_biasa'],
                "jam_buka_weekend" => $request['jam_buka_hari_weekend'],
                "jam_tutup_weekend" => $request['jam_tutup_hari_weekend'],
            ];
            $wisata = $this->wisata->create($dataWisata);
        }

        header("Location: ". $request['kategori'] ."_home.php");
    }
    
    public function update($id, $request)
    {
        $dataUsaha = [
            "kategori" => $request['kategori'],
            "nama_perusahaan" => $request['nama_perusahaan'],
            "nama_produk" => $request['nama_produk'],
            "deskripsi" => $request['deskripsi'],
            "kecamatan_id" => $request['kecamatan'],
            "kelurahan_id" => $request['kelurahan'],
            "latitude" => $request['latitude'],
            "longitude" => $request['longitude'],
            "alamat" => $request['alamat'],
            "nomor_telepon" => $request['nomor_telepon'],
        ];

        // update
        $usaha = $this->usaha->update($id, $dataUsaha);

        // jika kategori yang dimaksud adalah tempat wisata
        if ($request['kategori'] == "wisata") {
            $dataWisata = [
                "harga_weekday_anak" => $request['harga_weekday_anak'],
                "harga_weekend_anak" => $request['harga_weekend_anak'],
                "harga_weekday_dewasa" => $request['harga_weekday_dewasa'],
                "harga_weekend_dewasa" => $request['harga_weekend_dewasa'],
                "jam_buka_weekday" => $request['jam_buka_hari_biasa'],
                "jam_tutup_weekday" => $request['jam_tutup_hari_biasa'],
                "jam_buka_weekend" => $request['jam_buka_hari_weekend'],
                "jam_tutup_weekend" => $request['jam_tutup_hari_weekend'],
            ];
            $wisata = $this->wisata->update($id, $dataWisata);
        }

        header("Location: ". $request['kategori'] ."_home.php");
    }

    public function generatePdf($request)
    {
        $kecamatanId = $request['pdf_kecamatan_id'];
        $kelurahanId = $request['pdf_kelurahan_id'];
        $jenisUsaha = $request['pdf_jenis_usaha'];
        
        $condition = array();
        if ($kecamatanId != 0) {
            $condition['kecamatan_id'] = $kecamatanId;
        }

        if ($kelurahanId != 0) {
            $condition['kelurahan_id'] = $kelurahanId;
        }

        if ($jenisUsaha != 'semua') {
            $condition['kategori'] = $jenisUsaha;
        }

        if (sizeof($condition) != 0) {
            $usahaRows = $this->usaha->get_all_row_by_condition($condition);
        } else {
            $usahaRows = $this->usaha->get_all();
        }

        $pdf = new FPDF();
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 12);
        //foreach($header as $heading) {
        //$pdf->Cell(40,12,$display_heading[$heading['Field']],1);
        //}
        foreach ($usahaRows as $row) {
            $pdf->Ln();
            foreach ($row as $row=>$column) {
                $pdf->Cell(40, 12, $column, 1);
            }
		}
		
        $pdf->Output();
    }
}
