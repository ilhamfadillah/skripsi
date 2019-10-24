<?php
include "config.php";

// session_start();
// if (isset($_SESSION["admin"])) {
//     header("Location: admin_home.php");
// }

$usaha_controller = new UsahaController();
$usaha_model = new UsahaModel();
$galeri_model = new GaleriModel();
$wisata_model = new WisataModel();
$kecamatan_rows = $usaha_model->get_all_kecamatan();
$usaha_rows = $usaha_model->get_all();

if (isset($_POST['kecamatan_id'])) {
    $kelurahan_rows = $usaha_model->get_all_kelurahan_by_kecamatan($_POST['kecamatan_id']);
    echo json_encode($kelurahan_rows);
    die();
}


if (isset($_GET['filter'])) {
    $usaha_rows = $usaha_controller->filter($_GET);
    echo json_encode($usaha_rows);
    die();
}

if (isset($_GET['usaha_id'])) {
    $data = [];
    
    // Usaha
    $condition = [
        'id' => $_GET['usaha_id']
    ];
    $usaha_row_by_condition = $usaha_model->get_row_by_condition($condition);
    $data['usaha'] = $usaha_row_by_condition;
    
    // Galeri
    $galeri_condition = [
        'usaha_id' => $_GET['usaha_id']
    ];
    $galeri_rows = $galeri_model->get_all_row_by_condition($galeri_condition);
    if (sizeof($galeri_rows) != 0) {
        $data['galeri'] = $galeri_rows;
    }
    // Wisata
    if ($usaha_row_by_condition['kategori'] == 'wisata') {
        $wisata_condition = [
            'usaha_id' => $_GET['usaha_id']
        ];
        $wisata = $wisata_model->get_row($wisata_condition);
        $temp = [
            'harga_weekday_anak' => $wisata['harga_weekday_anak'] ?? "tidak diketahui",
            'harga_weekend_anak' => $wisata['harga_weekend_anak'] ?? "tidak diketahui",
            'harga_weekday_dewasa' => $wisata['harga_weekday_dewasa'] ?? "tidak diketahui",
            'harga_weekend_dewasa' => $wisata['harga_weekend_dewasa'] ?? "tidak diketahui",
            'jam_buka_weekday' => $wisata['jam_buka_weekday'] ?? "tidak diketahui",
            'jam_tutup_weekday' => $wisata['jam_tutup_weekday'] ?? "tidak diketahui",
            'jam_buka_weekend' => $wisata['jam_buka_weekend'] ?? "tidak diketahui",
            'jam_tutup_weekend' => $wisata['jam_tutup_weekend'] ?? "tidak diketahui",
        ];
        $data['wisata'] = $temp;
    }
    
    echo json_encode($data);
    die();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Kabupaten Bandung</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/select2/css/select2.css">
    <link rel="stylesheet" href="public/select2-bootstrap4-theme/select2-bootstrap4.css">
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet' />
    <style>
    .select2 {
        background-color: white;
    }
    </style>
</head>

<body>
    <?php include 'template/navbar.php' ?>
    <div class="container">
        <!-- <?php //include 'template/content.php'?> -->
        <div class="jumbotron mt-2">
            <h2 class="page-header">Filter</h2>
            <form action="#" method="GET">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control kategori" name="kategori">
                                <option value="0">semua</option>
                                <option value="umkm">UMKM</option>
                                <option value="wisata">Wisata</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control select2 kecamatan" name="kecamatan">
                                <option value="0">Semua</option>
                                <?php foreach ($kecamatan_rows as $row) { ?>
                                <option nama_kecamatan="<?php echo ucfirst($row['nama']) ?>"
                                    value="<?php echo $row['id'] ?>">
                                    <?php echo ucfirst($row['nama']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 kelurahan" name="kelurahan">
                                <option value="0">Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urutkan Berdasarkan</label>
                            <select class="form-control urutkan" name="urutkan">
                                <option value="asc_nama">Nama A-Z</option>
                                <option value="desc_nama">Nama Z-A</option>
                                <option value="terdekat">Lokasi Terdekat</option>
                                <option value="terjauh">Lokasi Terjauh</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="latitude" class="latitude" value="">
                <input type="hidden" name="longitude" class="longitude" value="">
                <button type="button" name="jalankan" class="btn btn-primary float-right jalankan">Jalankan</button>
            </form>
        </div>
        <!-- Page Heading -->
        <div class="row my-5 set-data" id="parent-card">
            <?php foreach ($usaha_rows as $row) { ?>
            <div class="col-lg-4 col-sm-6 mb-4 my-card" id="usaha-<?php echo $row['id'] ?>">
                <div class="card h-100">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                        $galeri_row = $galeri_model->get_all_row_by_usaha_id($row['id']);
                        if (sizeof($galeri_row) > 0) {
                            $i = 0;
                            foreach ($galeri_row as $foto) {
                                $i++;
                                if($i == 1){
                            ?>
                                <div class="carousel-item active">
                                    <img class="card-img-top" src="./image/<?php echo $foto['nama']; ?>" alt="" />
                                </div>
                            <?php }else{ ?>
                                <div class="carousel-item">
                                    <img class="card-img-top" src="./image/<?php echo $foto['nama']; ?>" alt="">
                                </div>
                            <?php
                                }
                            }     
                        } else { ?>
                            <img class="card-img-top" src="http://placehold.it/700x400" alt="">
                        <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo ucfirst($row['nama_produk']) ?></h4>
                        <div class="card-text">
                            <p><?php echo $row['alamat'] ?></p>
                            <p class="text-justify"><?php echo $row['deskripsi'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">

    </div>

    <script src="public/js/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="public/select2/js/select2.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <script type="text/javascript">
    $(function() {
        $('.select2').select2({
            theme: "bootstrap4"
        });

        var location = "";
        navigator.geolocation.getCurrentPosition(function(position) {
            $(".latitude").val(position.coords.latitude);
            $(".longitude").val(position.coords.longitude);
        });

    });

    function jsUcFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $('.kecamatan').on('change', function(e) {
        var id = $(this).find(':selected')[0].value;
        $.ajax({
            type: 'POST',
            data: {
                kecamatan_id: id,
            },
            dataType: 'json',
            success: function(data) {
                $('.kelurahan').empty();
                var kelurahan = '';
                kelurahan += "<option value='0'>Semua</option>";
                for (var i = 0; i < data.length; i++) {
                    kelurahan += "<option value='" + data[i].id + "' nama_kelurahan='" + data[i]
                        .nama +
                        "'>" + jsUcFirst(data[i].nama) +
                        "</option>";
                }
                $('.kelurahan').append(kelurahan);
            }
        });
    });

    function jsUcFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $('.jalankan').on('click', function() {
        $('.set-data').empty();
        var kategori = $('.kategori').val();
        var kecamatan = $('.kecamatan').val();
        var kelurahan = $('.kelurahan').val();
        var urutkan = $('.urutkan').val();
        var latitude = $('.latitude').val() == 0 ? '-7.025126' : $('.latitude').val();
        var longitude = $('.longitude').val() == 0 ? '107.527228' : $('.longitude').val();
        $.ajax({
            type: 'GET',
            data: {
                filter: true,
                filter_kategori: kategori,
                filter_kecamatan: kecamatan,
                filter_kelurahan: kelurahan,
                filter_urutkan: urutkan,
                latitude: latitude,
                longitude: longitude,
            },
            dataType: 'json',
            success: function(data) {
                var set = "";
                for (var i = 0; i < data.length; i++) {
                    set += '<div class="col-lg-4 col-sm-6 mb-4 my-card" id="usaha-' + data[i].id +
                        '">' +
                        '<div class="card h-100">' +
                        '<img class="card-img-top" src="http://placehold.it/700x400" alt="">' +
                        '<div class="card-body">' +
                        '<span class="float-right">' + parseFloat(data[i].distance).toFixed(2) +
                        ' Km</span>' +
                        '<h4 class="card-title">' + jsUcFirst(data[i].nama_produk) + '</h4>' +
                        '<div class="card-text">' +
                        '<p>' + data[i].alamat + '</p>' +
                        '<p class="text-justify">' + data[i].deskripsi + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                $('.set-data').append(set);
            }
        });
    });

    $('#parent-card').on('click', '.my-card', function() {
        var id = $(this).attr('id').split('-')[1];
        $.ajax({
            type: 'GET',
            data: {
                usaha_id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#myModal').empty();
                var html = "";
                if (data.usaha.kategori == 'wisata') {
                    html = '<div class="modal-dialog modal-lg">' +
                        '<div class="modal-content">' +
                        '<!-- Modal Header -->' +
                        '<div class="modal-header">' +
                        '<h4 class="modal-title">' + data.usaha.nama_produk + '</h4>' +
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                        '</div>' +
                        '<!-- Modal body -->' +
                        '<div class="modal-body">' +
                        '<ul>' +
                        '<li>Alamat : ' + data.usaha.alamat + '</li>' +
                        '<li>Pengelola : ' + data.usaha.nama_perusahan + '</li>' +
                        '<li>Kategori : ' + data.usaha.kategori + '</li>' +
                        '<li>Telepon : ' + data.usaha.nomor_telepon + '</li>' +
                        '<li>Harga Tiket Anak (senin - jumat) : ' + data.wisata.harga_weekday_anak +
                        '</li>' +
                        '<li>Harga Tiket Anak (sabtu - minggu) : ' + data.wisata
                        .harga_weekend_anak + '</li>' +
                        '<li>Harga Tiket Dewasa (senin - jumat) : ' + data.wisata
                        .harga_weekday_dewasa + '</li>' +
                        '<li>Harga Tiket Dewasa (sabtu - minggu) : ' + data.wisata
                        .harga_weekend_dewasa + '</li>' +
                        '<li>Jam operasional (senin - jumat) : ' + data.wisata.jam_buka_weekday +
                        ' - ' + data.wisata.jam_tutup_weekday + '</li>' +
                        '<li>Jam operasional (sabtu - minggu) : ' + data.wisata.jam_buka_weekend +
                        ' - ' + data.wisata.jam_tutup_weekend + '</li>' +
                        '</ul>' +
                        '<p>' + data.usaha.deskripsi + '</p>' +
                        '<center><div id="map" style="height:400px"></div></center>' +
                        '</div>' +
                        '<!-- Modal footer -->' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>' +
                        '</div>';
                } else {
                    html = '<div class="modal-dialog modal-lg">' +
                        '<div class="modal-content">' +
                        '<!-- Modal Header -->' +
                        '<div class="modal-header">' +
                        '<h4 class="modal-title">' + data.usaha.nama_produk + '</h4>' +
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                        '</div>' +
                        '<!-- Modal body -->' +
                        '<div class="modal-body">' +
                        '<ul>' +
                        '<li>Alamat : ' + data.usaha.alamat + '</li>' +
                        '<li>Pengelola : ' + data.usaha.nama_perusahan + '</li>' +
                        '<li>Kategori : ' + data.usaha.kategori + '</li>' +
                        '<li>Telepon : ' + data.usaha.nomor_telepon + '</li>' +
                        '</ul>' +
                        '<p>' + data.usaha.deskripsi + '</p>' +
                        '<center><div id="map" style="height:400px"></div></center>' +
                        '</div>' +
                        '<!-- Modal footer -->' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>' +
                        '</div>';
                }
                $('#myModal').html(html);
                $('#myModal').modal('show');

                mapboxgl.accessToken =
                    'pk.eyJ1IjoiaWxoYW1mYWRpbGxhaCIsImEiOiJjanp6aG85MTYxbW53M2hwZmRremRlOHU2In0.meZDrwl--MXNhmK8D9Q3ZQ';

                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/outdoors-v11',
                    center: [data.usaha.longitude, data.usaha.latitude],
                    zoom: 9,
                });

                new mapboxgl.Marker().setLngLat([data.usaha.longitude, data.usaha.latitude]).addTo(
                    map);
            }
        });
    });
    </script>
</body>

</html>