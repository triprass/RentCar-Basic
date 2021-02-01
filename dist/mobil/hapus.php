<?php
      if (isset($_POST['simpan_hapus'])) {
        session_start();
        include '../../config/database.php';

        mysqli_query($kon,"START TRANSACTION");

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_mobil=input($_POST["id_mobil"]);
        $kode_mobil=input($_POST["kode_mobil"]);
        $gambar_mobil=$_POST["gambar_mobil"];

        $sql="delete from mobil where id_mobil=$id_mobil";
        $hapus_mobil=mysqli_query($kon,$sql);

        $id_pengguna=$_SESSION["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Hapus mobil #$kode_mobil ";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

        //Menghapus file foto jika foto selain gambar default
        if ($foto!='gambar_default.png'){
            unlink("gambar/".$gambar_mobil);
        }

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query-query diatas
        if ($hapus_mobil and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../dist/index.php?page=mobil&hapus=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../dist/index.php?page=mobil&hapus=gagal");

        }
    }
?>
<form action="mobil/hapus.php" method="post">
        <!-- rows -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                     <h5>Apakah anda yakin ingin menghapus data mobil ini?</h5>
                </div>
            </div>
        </div>
        <input type="hidden" name="id_mobil" value="<?php echo $_POST["id_mobil"]; ?>" />
        <input type="hidden" name="kode_mobil" value="<?php echo $_POST["kode_mobil"]; ?>" />
        <input type="hidden" name="gambar_mobil" value="<?php echo $_POST["gambar_mobil"]; ?>" />
        <button type="submit" name="simpan_hapus" class="btn btn-danger">Hapus</button>
</form>

