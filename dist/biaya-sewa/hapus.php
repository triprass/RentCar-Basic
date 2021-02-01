<form action="biaya-sewa/hapus.php" method="post">
        <!-- rows -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                     <h5>Apakah anda yakin ingin menghapus data biaya sewa ini?</h5>
                </div>
            </div>
        </div>
        <input type="hidden" name="id_mobil" value="<?php echo $_POST["id_mobil"]; ?>" />
        <input type="hidden" name="kode_mobil" value="<?php echo $_POST["kode_mobil"]; ?>" />
        <button type="submit" name="simpan_hapus" id="simpan_hapus" class="btn btn-primary">Hapus</button>
</form>

<script>
 $("#simpan_hapus").click(function(){
<?php
      if (isset($_POST['simpan_hapus'])) {
        //Memulai session
        session_start();
        include '../../config/database.php';
        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_mobil=input($_POST["id_mobil"]);


        $sql="delete from biaya_sewa where id_mobil=$id_mobil";
        $hapus_biaya=mysqli_query($kon,$sql);

        $id_pengguna=$_SESSION["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Hapus biaya sewa ID #$id_mobil ";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query-query diatas
        if ($hapus_biaya and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../dist/index.php?page=biaya-sewa&hapus=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../dist/index.php?page=biaya-sewa&hapus=gagal");

        }

    }
?>
 }
</script>