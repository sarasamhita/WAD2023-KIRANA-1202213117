<?php

require 'connect.php';

// (1) Mulai session
session_start();
//

// (2) Ambil nilai input dari form registrasi

    // a. Ambil nilai input email
    $email = $_POST['email'];
    // b. Ambil nilai input name
    $name = $_POST['name'];
    // c. Ambil nilai input username
    $usn = $_POST['username'];
    // d. Ambil nilai input password
    $pass = $_POST['password'];
    // e. Ubah nilai input password menjadi hash menggunakan fungsi password_hash()
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

//

// (3) Buat dan lakukan query untuk mencari data dengan email yang sama dari nilai input email
    $cek = "SELECT * FROM users WHERE email = '$email'";
    $hasil = mysqli_query($db, $cek);
//

// (4) Buatlah perkondisian ketika tidak ada data email yang sama ( gunakan mysqli_num_rows == 0 )
    if(mysqli_num_rows($hasil) == 0) {

    // a. Buatlah query untuk melakukan insert data ke dalam database
        $masuk = "INSERT INTO users (name, username, email, password) VALUES ('$name', '$usn', '$email', '$pass')";
        $insert = mysqli_query($db, $masuk);
    // b. Buat lagi perkondisian atau percabangan ketika query insert berhasil dilakukan
    //    Buat di dalamnya variabel session dengan key message untuk menampilkan pesan penadftaran berhasil
        if($insert) {
            $_SESSION['message'] = 'Pendaftaran Berhasil, Silahkan Login';
            $_SESSION['color'] = 'success';
            header('Location: ../views/login.php');
        }else{
            $_SESSION['message'] = "Registrasi gagal";
        }
    }
// 

// (5) Buat juga kondisi else
//     Buat di dalamnya variabel session dengan key message untuk menampilkan pesan error karena data email sudah terdaftar
    else{
        $_SESSION['message'] = 'Email sudah terdaftar';
        header('Location: ../register.php');
    }
//

?>