<?php
session_start();
if (isset($_POST['simpan_pengaturan_sewa'])) {
    //Include file koneksi ke database
    include '../../config/database.php';

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id_mobil=input($_POST["id_mobil"]);
    $biaya_sewa=input($_POST["biaya_sewa"]);
    $biaya_supir=input($_POST["biaya_supir"]);
    $biaya_bbm=input($_POST["biaya_bbm"]);

    $biaya="insert into biaya_sewa (id_mobil,biaya_sewa,biaya_supir,biaya_bbm) values
    ('$id_mobil','$biaya_sewa','$biaya_supir','$biaya_bbm')";

    $simpan_biaya_sewa=mysqli_query($kon,$biaya);

    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Simpan Biaya Sewa ID Mobil #$id_mobil ";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");
   
    if ($simpan_biaya_sewa && $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=biaya-sewa&add=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=biaya-sewa&add=gagal");
    }
}
?>