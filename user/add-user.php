<?php

require "../config/config.php";
require "../module/model-user.php";

$title = "Tambah User - sistemkasir";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_POST['simpan'])) {
  if (insert($_POST) > 0) {
    echo "<script>
      alert('User baru berhasil diregistrasi...');
      window.location.href = '$main_url/user/data-user.php';
    </script>";
  } else {
    echo "<script>alert('User gagal ditambahkan!');</script>";
  }
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=$main_url?>dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=$main_url?>user/data-user.php">User</a></li>
              <li class="breadcrumb-item active"><a href="<?=$main_url?>dashboard.php">Dashboard</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-find">
        <div class="card">
          <form action="" method="post" enctype="multipart/form-data">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus fa-sm"></i> Add user</h3>
            <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times"></i> Reset </button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8 mb-3">
                <div class="form-group">
                  <label for="username"> Username</label>               
                  <input type="text" name="username" class="form-control" id="username" placeholder="masukan username" autofocus autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="fullname"> Fullname</label>               
                  <input type="text" name="fullname" class="form-control" id="masukan nama lengkap" placeholder="masukan nama lengkap" required>
                </div>
                <div class="form-group">
                  <label for="password"> Password</label>               
                  <input type="text" name="password" class="form-control" id="password" placeholder="masukan password" required>
                </div>
                <div class="form-group">
                  <label for="password2"> Konfirmasi Password</label>               
                  <input type="text" name="password2" class="form-control" id="password2" placeholder="masukan kembali password" required>
                </div>
                <div class="form-group">
                  <label for="level"> Level</label>
                  <select name="level" id="level" class="form-control">
                    <option value="">-- Level User --</option>
                    <option value="1">Administrator</option>
                    <option value="2">Owner</option>
                    <option value="3">Gudang</option>
                    <option value="4">Operator</option>
                  </select>  
                </div>               
              </div>               
            </div>
          </form>
          </div>
        </div>
      </div>

    </section>

<?php

require "../template/footer.php";

?>