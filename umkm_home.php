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

    if(isset($_POST['_method'])){
        $usahaModel = new UsahaModel();
        $deleteUsaha = $usahaModel->delete($_POST['id']);
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
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Kabupaten Bandung </div>
            <div class="list-group list-group-flush">
                <a href="/skripsi/admin_home.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="/skripsi/umkm_home.php"
                    class="list-group-item list-group-item-action bg-dark text-white">UMKM</a>
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <span class="row">
                                    <span class="col-sm-6">
                                        <h3 class="float-left">UMKM</h3>
                                    </span>
                                    <span class="col-sm-6">
                                        <a href="create_umkm.php" class="btn btn-success float-right">Tambahkan Data
                                            UMKM</a>
                                    </span>
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="dtBasicExample" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Produk</th>
                                            <th class="th-sm">Kecamatan</th>
                                            <th class="th-sm">Kelurahan</th>
                                            <th class="th-sm">Alamat</th>
                                            <th class="th-sm">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $usaha = new UsahaController();
                                            $usaha_rows = $usaha->get_all_umkm();
                                            foreach ($usaha_rows as $row) {
                                                ?>
                                        <tr>
                                            <td><?php echo $row['nama_produk']; ?></td>
                                            <td><?php echo ucfirst($row['nama_kecamatan']); ?></td>
                                            <td><?php echo ucfirst($row['nama_kelurahan']); ?></td>
                                            <td><?php echo $row['alamat']; ?></td>
                                            <td class="text-center">
                                                <a href="umkm_edit.php?id=<?php echo $row['id'] ?>"
                                                    class="btn btn-info">Edit</a>
                                                <form action="#" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                    <button class="btn btn-danger" type="button" data-toggle="modal"
                                                        data-target="#myModal">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal body -->
                <div class="modal-body">
                    Yakin untuk menghapus data ini ?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-target="#confirm-delete">Ya</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="public/js/jquery-3.2.1.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $(function() {
        $('#dtBasicExample').DataTable();
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        if ($("#toggle-icon").hasClass("fa-arrow-left")) {
            $("#toggle-icon").removeClass('fa-arrow-left').addClass('fa-arrow-right');
        } else {
            $("#toggle-icon").removeClass('fa-arrow-right').addClass('fa-arrow-left');
        }
    });
    </script>

</body>

</html>