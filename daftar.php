<?php
require_once "./config.php";
$sql = "SELECT id, nama FROM kecamatan_tables ORDER BY nama";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Daftar</title>
		<link rel="stylesheet" href="public/css/bootstrap.min.css">
		<link rel="stylesheet" href="public/select2/css/select2.min.css">
		<link rel="stylesheet" href="public/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	</head>
	<body>
		<?php 
			require_once "template/navbar.php";
		?>
		<div class="container my-4">
			<div class="card">
				<form method="post" action="controller/controller_daftar.php">
					<div class="card-header">
						<h4 class="text-center">Daftar Baru</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>
							<div class="form-group">
								<label for="nama">Nama Lengkap</label>
								<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
							</div>
						</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="jenis_kelamin">Jenis Kelamin</label>
									<select class="form-control" id="janis_kelamin" name="jenis_kelamin">
										<option value="pria">Pria</option>
										<option value="wanita">Wanita</option>
									</select>
								</div>
								<div class="form-group">
									<label for="telpon">Nomor Telepon</label>
									<input type="text" class="form-control numeric" id="nomor_telepon" name="telepon" placeholder="08xxxxxxxxxx">
								</div>
								<div class="form-group">
									<label>Alamat Lengkap</label>
									<textarea class="form-control" rows="5" name="alamat" id="alamat"></textarea>
								</div>
							</div>
						</div>
						<button type="submit" name="button-daftar" class="btn btn-primary float-right my-3">Daftar</button>
					</div>
				</form>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="public/select2/js/select2.full.min.js"></script>
		<script type="text/javascript">
		$(document).on("input", ".numeric", function() {
			this.value = this.value.replace(/\D/g,'');
		});
		</script>
	</body>
</html>