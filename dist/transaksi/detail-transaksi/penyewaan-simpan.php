<?php
    session_start();
    include '../../../config/database.php';
    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    $tanggal=$_POST["tanggal"];
    $jam=$_POST["jam"];
    $lama_sewa=$_POST["lama_sewa"];

    $tgl=$tanggal.$jam;
    $mulai_sewa = date("Y-m-d H:i",strtotime($tgl));
    $akhir_sewa=date("Y-m-d H:i",strtotime("+$lama_sewa hour",strtotime($tgl)));

    $kode_transaksi=$_POST["kode_transaksi"];
    $id_mobil=$_POST["id_mobil"];
   
    $supir=$_POST["supir"];
    $bbm=$_POST["bbm"];
    $total_biaya=$_POST["total_biaya"];
    $tambah_penyewaan=mysqli_query($kon,"insert into detail_transaksi (kode_transaksi,id_mobil,mulai_sewa,akhir_sewa,lama_sewa,supir,bbm,total_biaya) values ('$kode_transaksi','$id_mobil','$mulai_sewa','$akhir_sewa','$lama_sewa','$supir','$bbm','$total_biaya')");

    //Menyimpan aktivitas
    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Tambah Penyewaan Kode #$kode_transaksi";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

    if ($tambah_penyewaan and $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
    }

?>