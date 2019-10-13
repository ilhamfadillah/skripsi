<!DOCTYPE html>
<html>

<head>
    <title>Kabupaten Bandung</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/select2/css/select2.css">
    <link rel="stylesheet" href="public/select2-bootstrap4-theme/select2-bootstrap4.css">
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
            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control select2" name="kategori">
                                <option>Semua</option>
                                <option>UMKM</option>
                                <option>Wisata</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control select2" name="kecamatan">
                                <option>Semua</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2" name="kelurahan">
                                <option>Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urutkan Berdasarkan</label>
                            <select class="form-control" name="urutkan">
                                <option>Nama A-Z</option>
                                <option>Nama Z-A</option>
                                <option>Lokasi Terdekat</option>
                                <option>Lokasi Terjauh</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary float-right">Jalankan</button>
            </form>
        </div>
        <!-- Page Heading -->
        <div class="row my-5">
            <?php for ($i=0; $i<10; $i++) { ?>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="#">Project One</a>
                        </h4>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam
                            aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt,
                            dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="template/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="public/select2/js/select2.min.js"></script>
    <script type="text/javascript">
    $(function() {
        $('.select2').select2({
            theme: "bootstrap4"
        });
    });
    </script>
</body>

</html>