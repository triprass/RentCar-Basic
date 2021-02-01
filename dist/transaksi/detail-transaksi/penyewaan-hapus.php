<?php
session_start();
      if (isset($_POST['hapus_penyewaan'])) {

        include '../../../config/database.php';
        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        $id_detail_transaksi=$_POST["id_detail_transaksi"];
        $id_transaksi=$_POST["id_transaksi"];

        //Mengeksekusi atau menjalankan query 
        $hapus_penyewaan=mysqli_query($kon,"delete from detail_transaksi where id_detail_transaksi=$id_detail_transaksi");

        //Menyimpan aktivitas
        $id_pengguna=$_SESSION["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Hapus Penyewaan ID #$id_detail_transaksi";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");


        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hapus_penyewaan and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&hapus-penyewaan=berhasil&#bagian_penyewaan");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&hapus-penyewaan=gagal&#bagian_penyewaan");
        }

    }
?>
<form action="transaksi/detail-transaksi/penyewaan-hapus.php" method="post">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                    <h5>Yakin ingin menghapus penyewaan ini?</h5>
            </div>
        </div>
    </div>
    <input type="hidden" name="id_detail_transaksi" value="<?php echo $_POST["id_detail_transaksi"]; ?>" />
    <input type="hidden" name="id_transaksi" value="<?php echo $_POST["id_transaksi"]; ?>" />
    <button type="submit" name="hapus_penyewaan" class="btn btn-primary">Hapus</button>
</form>

