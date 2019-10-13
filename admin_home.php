<?php
    include "config.php";

    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
    }

    if(isset($_GET['logout'])){
        $controller = new UserController();
        $redirect = $controller->logout($_GET);
    }

    $UsahaModel = new UsahaModel();
    $jumlahWisata = $UsahaModel->count_by_category("wisata");
    $jumlahUmkm = $UsahaModel->count_by_category("umkm");

    $usaha_model = new UsahaModel();
    $kecamatan_rows = $usaha_model->get_all_kecamatan();

    if (isset($_POST['kecamatan_id'])) {
        $kelurahan_rows = $usaha_model->get_all_kelurahan_by_kecamatan($_POST['kecamatan_id']);
        echo json_encode($kelurahan_rows);
        die();
    }

    if (isset($_POST['map_kecamatan_id'])) 
    {
        $condition = array();
        if($_POST['map_kecamatan_id'] != 0){
            $condition['kecamatan_id'] = $_POST['map_kecamatan_id']; 
        }

        if($_POST['map_kelurahan_id'] != 0){
            $condition['kelurahan_id'] = $_POST['map_kelurahan_id']; 
        }

        if($_POST['map_jenis_usaha'] != 'semua'){
            $condition['kategori'] = $_POST['map_jenis_usaha'];
        }

        if(sizeof($condition) != 0){
            $get_usaha = $usaha_model->get_all_row_by_condition($condition);
        }else{
            $get_usaha = $usaha_model->get_all();
        }

        echo json_encode($get_usaha);
        die();
    }

    if(isset($_POST['submit_pdf'])){
        $usaha = new UsahaController();
        $toPdf = $usaha->generatePdf($_POST);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="public/css/simple-sidebar.css" rel="stylesheet">
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/select2/css/select2.css">
    <link rel="stylesheet" href="public/select2-bootstrap4-theme/select2-bootstrap4.css">
    <style>
    .marker {
        background-image: url('mapbox-icon.png');
        background-size: cover;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Kabupaten Bandung </div>
            <div class="list-group list-group-flush">
                <a href="/skripsi/admin_home.php"
                    class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
                <a href="/skripsi/umkm_home.php" class="list-group-item list-group-item-action bg-light">UMKM</a>
                <a href="/skripsi/wisata_home.php" class="list-group-item list-group-item-action bg-light">Wisata</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-info border-bottom">
                <button class="btn btn-warning" id="menu-toggle"><span class="fa fa-arrow-left"
                        id="toggle-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link text-white" href="?logout"><b>Logout</b></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body bg-success">
                                <div class="card-title">
                                    <h4>Jumlah UMKM</h4>
                                </div>
                                <div class="card-text float-right mt-4">
                                    <h4><?php echo $jumlahUmkm ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="card-title">
                                    <h4>Jumlah Wisata</h4>
                                </div>
                                <div class="card-text float-right mt-4">
                                    <h4><?php echo $jumlahWisata ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body bg-warning">
                                <div class="card-title">
                                    <h4>Total</h4>
                                </div>
                                <div class="card-text float-right mt-4">
                                    <h4><?php echo $jumlahUmkm+$jumlahWisata ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end cards -->

                </div>
                <div class="row mt-5">
                    <span class="col-sm-3">
                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control select2 kecamatan">
                                <option value="0">Semua</option>
                                <?php foreach ($kecamatan_rows as $row) { ?>
                                <option nama_kecamatan="<?php echo ucfirst($row['nama']) ?>"
                                    value="<?php echo $row['id'] ?>">
                                    <?php echo ucfirst($row['nama']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </span>
                    <span class="col-sm-3">
                        <label for="">Kelurahan</label>
                        <div class="form-group">
                            <select name="kelurahan" id="kelurahan" class="form-control select2 kelurahan">
                                <option value="0">Semua</option>
                            </select>
                        </div>
                    </span>
                    <span class="col-sm-3">
                        <label for="">Jenis</label>
                        <div class="form-group">
                            <select name="jenis_usaha" id="jenis_usaha" class="form-control select2 jenis_usaha">
                                <option value="semua">Semua</option>
                                <option value="umkm">UMKM</option>
                                <option value="wisata">Wisata</option>
                            </select>
                        </div>
                    </span>
                    <span class="col-sm-3">
                        <label for="aksi">Aksi</label>
                        <span class="row">
                            <span class='col-sm-6'>
                                <button type="button" class="btn btn-primary btn-block cari">Cari</button>
                            </span>
                            <span class='col-sm-6'>
                                <button type="button" name="submit_pdf"
                                    class="btn btn-danger btn-block pdf">PDF</button>
                            </span>
                        </span>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <div id='map' class="mt-4" style='width: 100%; height: 600px;'></div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="public/js/jquery-3.2.1.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <script src="public/select2/js/select2.min.js"></script>


    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        if ($("#toggle-icon").hasClass("fa-arrow-left")) {
            $("#toggle-icon").removeClass('fa-arrow-left').addClass('fa-arrow-right');
        } else {
            $("#toggle-icon").removeClass('fa-arrow-right').addClass('fa-arrow-left');
        }
    });

    $(function() {
        $('.select2').select2({
            theme: "bootstrap4",
            width: '100%',
        });
        $('.cari').trigger('click');
    });

    $('.kecamatan').on('change', function() {
        var id = $(this).find(':selected')[0].value;
        var nama_kecamatan = $(this).find(':selected')[0].attributes[0].nodeValue;
        ajaxGetKelurahan(id);
    });

    function jsUcFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function ajaxGetKelurahan(id) {
        $.ajax({
            type: 'POST',
            data: {
                kecamatan_id: id,
            },
            dataType: 'json',
            success: function(data) {
                $('.kelurahan').empty();
                var kelurahan = '';
                kelurahan += '<option value=0>Semua</option>';
                for (var i = 0; i < data.length; i++) {
                    kelurahan += "<option value='" + data[i].id + "' nama_kelurahan='" + data[i].nama +
                        "'>" + jsUcFirst(data[i].nama) +
                        "</option>";
                }
                $('.kelurahan').append(kelurahan);
            }
        });
    }

    $('.cari').on('click', function() {
        var kecamatan_id = $('.kecamatan').val();
        var kelurahan_id = $('.kelurahan').val();
        var jenis_usaha = $('.jenis_usaha').val();
        $.ajax({
            type: 'POST',
            data: {
                map_kecamatan_id: kecamatan_id,
                map_kelurahan_id: kelurahan_id,
                map_jenis_usaha: jenis_usaha,
            },
            dataType: 'json',
            success: function(data) {
                runMap(data);
            }
        });
    });


    function runMap(data) {
        mapboxgl.accessToken =
            'pk.eyJ1IjoiaWxoYW1mYWRpbGxhaCIsImEiOiJjanp6aG85MTYxbW53M2hwZmRremRlOHU2In0.meZDrwl--MXNhmK8D9Q3ZQ';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/outdoors-v11',
            center: [107.527228, -7.025126],
            zoom: 11,
        });

        data.forEach(function(marker) {
            var longitude = marker.longitude;
            var latitude = marker.latitude;
            var coordinate = [longitude, latitude];
            // create a HTML element for each feature
            // var el = document.createElement('div');
            // el.className = 'marker';

            if (marker.kategori == 'umkm') {
                var html = "<h3>" + marker.nama_produk + "</h3>" +
                    "<img src='https://www.sahabat-ukm.com/wp-content/uploads/2016/05/icon-pasar.png' class='img-responsive' width='125px' height='125px'>" +
                    "<p>" + marker.deskripsi + "</p>";
            } else {
                var html = "<h3>" + marker.nama_produk + "</h3>" +
                    "<img src='https://apprecs.org/gp/images/app-icons/300/11/net.wisatalokal.jpg' class='img-responsive' width='125px' height='125px'>" +
                    "<p>" + marker.deskripsi + "</p>";
            }


            // make a marker for each feature and add to the map
            new mapboxgl.Marker()
                .setLngLat(coordinate)
                .setPopup(new mapboxgl.Popup({
                    offset: 50
                }).setHTML(html))
                .addTo(map);
        });
    }

    $('#wrapper').on('click', '.pdf', function(e) {
        e.preventDefault();
        var submit_pdf = true;
        var pdf_kecamatan_id = $('.kecamatan').val();
        var pdf_kelurahan_id = $('.kelurahan').val();
        var pdf_jenis_usaha = $('.jenis_usaha').val();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                submit_pdf: submit_pdf,
                pdf_kecamatan_id: pdf_kecamatan_id,
                pdf_kelurahan_id: pdf_kelurahan_id,
                pdf_jenis_usaha: pdf_jenis_usaha,
            },
            success: function(data) {}
        });
    })
    </script>

</body>

</html>