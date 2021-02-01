
<?php
      if (isset($_POST['id_merek'])) {
        session_start();
        include '../../../config/database.php';
        mysqli_query($kon,"START TRANSACTION");
        
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_merek=input($_POST["id_merek"]);
        $gambar_merek=$_POST["gambar_merek"];

        $sql1="delete from merek_mobil where id_merek=$id_merek";
        $hapus_merek=mysqli_query($kon,$sql1);

        $sql2="delete from mobil where id_merek=$id_merek";
        $hapus_mobil=mysqli_query($kon,$sql2);

        if ($gambar!='gambar_default.png'){
            unlink("gambar/".$gambar);
        }
        //Menghapus gambar merek
        unlink("gambar/".$gambar_merek);
        //Menghapus gambar mobil
        unlink("../gambar/".$gambar_mobil);

        $id_pengguna=$_SESSION["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Hapus Merek Mobil ID #$id_merek ";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");


        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query-query diatas
        if ($hapus_merek and $hapus_mobil and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../index.php?page=mobil&hapus=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../index.php?page=mobil&hapus=gagal");

        }

    }
?>