<?php
session_start();
    //Koneksi database
    include '../../config/database.php';
    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    $kode_transaksi=$_GET['kode_transaksi'];

    //Menghapus data transaksi dan detail transaksi
    $hapus_transaksi=mysqli_query($kon,"delete from transaksi where kode_transaksi='$kode_transaksi'");
    $hapus_detail_transaksi=mysqli_query($kon,"delete from detail_transaksi where kode_transaksi='$kode_transaksi'");

    $waktu=date("Y-m-d H:i");
    $log_aktivitas="Hapus transaksi Kode #$kode_transaksi";
    $id_pengguna= $_SESSION["id_pengguna"];

    //Menyimpan aktivitas
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($hapus_transaksi && $hapus_detail_transaksi && $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=transaksi&hapus=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=transaksi&hapus=berhasil");

    }

?>