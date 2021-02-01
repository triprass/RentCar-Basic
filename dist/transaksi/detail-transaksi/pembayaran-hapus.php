<?php
session_start();
      if (isset($_POST['hapus_pembayaran'])) {

        include '../../../config/database.php';
        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        $id_transaksi=$_POST["id_transaksi"];

 
        $hapus_pembayaran=mysqli_query($kon,"update transaksi set total_bayar=0 where id_transaksi=$id_transaksi");

        $waktu=date("Y-m-d H:i");
        $log_aktivitas="Hapus Pembayaran ID #$id_transaksi";
        $id_pengguna= $_SESSION["id_pengguna"];
        //Menyimpan aktivitas
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hapus_pembayaran and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=berhasil");
        }

    }
?>
<form action="transaksi/detail-transaksi/pembayaran-hapus.php" method="post">
        <!-- rows -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                     <h5>Yakin ingin menghapus pembayaran ini?</h5>
                </div>
            </div>
        </div>
        <input type="hidden" name="id_transaksi" value="<?php echo $_POST["id_transaksi"]; ?>" />
  
        <button type="submit" name="hapus_pembayaran" class="btn btn-primary">Hapus</button>
</form>

