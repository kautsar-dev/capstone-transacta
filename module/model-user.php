<?php

function insert($data){
    global $koneksi;

    $username  = strtolower(mysqli_real_escape_string($koneksi, $data ['username']));
    $fullname  = mysqli_real_escape_string($koneksi, $data ['fullname']);
    $password  = mysqli_real_escape_string($koneksi, $data ['password']);
    $password2  = mysqli_real_escape_string($koneksi, $data ['password']);
    $level  = mysqli_real_escape_string($koneksi, $data ['level']);
    
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai, user baru gagal diregistrasi !);
            </script>";
        return false;
    }

    $passwordHash   = password_hash($password, PASSWORD_DEFAULT);

    $cekUsername    = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
                alert('username sudah terpakai, user baru gagal diregistrasi !');
            </script>";
        return false;
    }

    $sqlUser    ="INSERT INTO user VALUE (null, '$username', '$fullname', '$passwordHash', '$level')";
    mysqli_query($koneksi, $sqlUser);

    return mysqli_affected_rows($koneksi);
}
?>