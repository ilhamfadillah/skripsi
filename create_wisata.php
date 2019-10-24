<?php
    include "config.php";

    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
    }
    if (isset($_GET['logout'])) {
        $controller = new UserController();
        $redirect = $controller->logout($_GET);
    }

    if (isset($_POST['submit'])) {
        if($_FILES['foto']['name'][0] != ""){
            $_POST['foto'] = $_FILES['foto'];
        }
        $controller = new UsahaController();
        $usaha = $controller->store($_POST);
    }

    $usaha_model = new UsahaModel();
    $kecamatan_rows = $usaha_model->get_all_kecamatan();

    if (isset($_POST['kecamatan_id'])) {
        $kelurahan_rows = $usaha_model->get_all_kelurahan_by_kecamatan($_POST['kecamatan_id']);
        echo json_encode($kelurahan_rows);
        die();
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
    <link rel="stylesheet" type="text/css" href="template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="public/select2/css/select2.css">
    <link rel="stylesheet" href="public/select2-bootstrap4-theme/select2-bootstrap4.css">

    <!-- mapbox -->
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

    <!-- timepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <style>
    #map {
        height: 400px;
    }
    </style>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Kabupaten Bandung </div>
            <div class="list-group list-group-flush">
                <a href="/skripsi/admin_home.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="/skripsi/umkm_home.php" class="list-group-item list-group-item-action bg-light">UMKM</a>
                <a href="/skripsi/wisata_home.php"
                    class="list-group-item list-group-item-action bg-dark text-white">Wisata</a>
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <span class="row">
                                    <span class="col-sm-6">
                                        <h3 class="float-left">Wisata</h3>
                                    </span>
                                </span>
                            </div>
                            <div class="alert alert-danger" role="alert" style="display:none"></div>
                            <div class="card-body">
                                <form action="#" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                    <input type="hidden" name="kategori" value="wisata">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['admin']['id']; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email">Nama Pengelola</label>
                                                <input type="text" class="form-control" id="nama_perusahaan"
                                                    placeholder="Nama Pengelola" name="nama_perusahaan">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_tempat">Nama Tempat</label>
                                                <input type="text" class="form-control" id="nama_produk"
                                                    placeholder="Nama Tempat" name="nama_produk">
                                            </div>
                                            <div class="form-group">
                                                <label for="nomor_telepon">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="nomor_telepon"
                                                    placeholder="Nama Tempat" name="nomor_telepon">
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control"
                                                    placeholder="Deskripsi"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="kecamatan">Kecamatan</label>
                                                <select name="kecamatan" id="kecamatan"
                                                    class="form-control select2 kecamatan">
                                                    <?php foreach ($kecamatan_rows as $row) { ?>
                                                    <option nama_kecamatan="<?php echo ucfirst($row['nama']) ?>"
                                                        value="<?php echo $row['id'] ?>">
                                                        <?php echo ucfirst($row['nama']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="kelurahan">Kelurahan</label>
                                                <select name="kelurahan" id="kelurahan"
                                                    class="form-control select2 kelurahan">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Lokasi</label>
                                                <div class="form-control">
                                                    <div id='map'></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <span class="col-sm-6">
                                                        <label for="alamat">Latitude</label>
                                                        <input type="text" class="form-control latitude" name="latitude"
                                                            readonly>
                                                    </span>
                                                    <span class="col-sm-6">
                                                        <label for="alamat">Longitude</label>
                                                        <input type="text" class="form-control longitude"
                                                            name="longitude" readonly>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="foto">Foto <small>(Max 3 Foto)</small></label>
                                                <input type="file" class="form-control" id="foto" name="foto[]" multiple>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea class="form-control" name="alamat" id="alamat"
                                                    rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Harga Tiket Anak Hari Biasa</label>
                                                <input type="text" class="form-control numeric"
                                                    id="harga_tiket_anak_hari_biasa" name="harga_weekday_anak"
                                                    placeholder="10000">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Harga Tiket Anak Akhir Pekan (sabtu-minggu)</label>
                                                <input type="text" class="form-control numeric"
                                                    id="harga_tiket_anak_hari_biasa" name="harga_weekend_anak"
                                                    placeholder="10000">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Harga Tiket Dewasa Hari Biasa</label>
                                                <input type="text" class="form-control numeric"
                                                    id="harga_tiket_anak_hari_biasa" name="harga_weekday_dewasa"
                                                    placeholder="10000">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Harga Tiket Dewasa Akhir Pekan
                                                    (sabtu-minggu)</label>
                                                <input type="text" class="form-control numeric"
                                                    id="harga_tiket_dewasa_akhir_pekan" name="harga_weekend_dewasa"
                                                    placeholder="10000">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Jam Buka Hari Biasa</label>
                                                <input type="text" class="form-control timepicker"
                                                    id="jam_buka_hari_biasa" name="jam_buka_hari_biasa" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Jam Tutup Hari Biasa</label>
                                                <input type="text" class="form-control timepicker"
                                                    id="jam_tutup_hari_biasa" name="jam_tutup_hari_biasa" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Jam Buka Akhir Pekan (sabtu-minggu)</label>
                                                <input type="text" class="form-control timepicker"
                                                    id="jam_buka_hari_weekend" name="jam_buka_hari_weekend" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Jam Tutup Akhir Pekan (sabtu-minggu)</label>
                                                <input type="text" class="form-control timepicker"
                                                    id="jam_tutup_hari_weekend" name="jam_tutup_hari_weekend" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <button type="submit" name="submit"
                                            class="btn btn-primary float-right">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="public/select2/js/select2.min.js"></script>

    <!-- mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.min.js'>
    </script>
    <link rel='stylesheet'
        href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.css'
        type='text/css' />
    <!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
    $(function() {
        $('.select2').select2({
            theme: "bootstrap4",
            width: '100%'
        });

        $('.kecamatan').trigger('change');

        $('.timepicker').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 30,
            defaultTime: '07',
            startTime: '05:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });
    });

    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g, '');
    });


    function jsUcFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    var accessToken =
        'pk.eyJ1IjoiaWxoYW1mYWRpbGxhaCIsImEiOiJjanp6aG85MTYxbW53M2hwZmRremRlOHU2In0.meZDrwl--MXNhmK8D9Q3ZQ';

    $('.kecamatan').on('change', function() {
        var id = $(this).find(':selected')[0].value;
        var nama_kecamatan = $(this).find(':selected')[0].attributes[0].nodeValue;
        ajaxGetKelurahan(id);
        runMap(nama_kecamatan);
    });

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
                for (var i = 0; i < data.length; i++) {
                    kelurahan += "<option value='" + data[i].id + "' nama_kelurahan='" + data[i].nama +
                        "'>" + jsUcFirst(data[i].nama) +
                        "</option>";
                }
                $('.kelurahan').append(kelurahan);
            }
        });
    }

    var coordinate = [];

    function runMap(nama_kecamatan) {
        $.ajax({
            type: 'GET',
            url: 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + nama_kecamatan +
                '.json?country=id&access_token=' +
                accessToken,
            success: function(data) {
                coordinate = [data.features[0].bbox[0], data.features[0].bbox[1]];
                $('.latitude').val(data.features[0].bbox[1]);
                $('.longitude').val(data.features[0].bbox[0]);
                myMap(coordinate);
            }
        });
    }

    function myMap(coordinate) {
        mapboxgl.accessToken = accessToken;
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: coordinate,
            zoom: 13
        });

        map.on('load', function() {

            map.addLayer({
                'id': 'maine',
                'type': 'fill',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                    <?php
                                        include "arrayPolygon.php";
                                        echo $polygonCoordinate;
                                    ?>
                            ]
                        }
                    }
                },
                'layout': {},
                'paint': {
                    'fill-color': '#088',
                    'fill-opacity': 0.3
                }
            });
        });

        var marker = new mapboxgl.Marker();
        var latitude = 0;
        var longitude = 0;
        map.on('click', function(e) {
            latitude = e.lngLat.lat;
            longitude = e.lngLat.lng;
            marker.setLngLat([longitude, latitude]).addTo(map);
            $('.latitude').val(latitude);
            $('.longitude').val(longitude);
        });

        var mapControl = map.addControl(new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker: false,
        }));
    }

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        if ($("#toggle-icon").hasClass("fa-arrow-left")) {
            $("#toggle-icon").removeClass('fa-arrow-left').addClass('fa-arrow-right');
        } else {
            $("#toggle-icon").removeClass('fa-arrow-right').addClass('fa-arrow-left');
        }
    });

    function validateForm() {
        var nama_pengelola = $('#nama_perusahaan').val();
        var nama_tempat = $('#nama_produk').val();
        var alamat = $('#alamat').val();
        var message = "";

        if(nama_pengelola == ""){
            message += "<li>Nama Pengelola Wajib Diisi</li>"
        }
        if(nama_tempat == ""){
            message += "<li>Nama Tempat Wajib Diisi</li>"
        }
        if(alamat == ""){
            message += "<li>Alamat Wajib Diisi</li>"
        }

        if($('#foto').val() !== undefined){
            var foto = $('#foto').get(0).files;
            if(foto.length > 3){
                message += "<li>Maksimal 3 Foto</li>";
            }
            var ukuran_foto = "";
            var format_foto = "";
            for(var i=0; i<foto.length; i++){
                if(foto[i].size/1024 > 2048){
                    ukuran_foto += "true"; 
                }
                var ext = foto[i].type.split('/').pop().toLowerCase();
                if($.inArray(ext,['jpg','jpeg','gif', 'png']) === -1){
                    format_foto += "true";
                }
            }

            if(ukuran_foto != ''){
                message += "<li>Ukuran File Foto Harus Dibawah 2MB</li>"
            }

            if(format_foto != ''){
                message += "<li>Format File Foto Tidak Sesuai</li>";
            }
        }
        
        if(message != ""){            
            $('.alert').empty();
            $('.alert').append("<ul>"+message+"</ul>");
            $('.alert').show();
            return false;
        }else{
            return true;
        }
    }
    </script>

</body>

</html>