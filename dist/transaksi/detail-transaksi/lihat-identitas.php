<?php
    //Mengambil nilai id_transaksi
    $id_transaksi=$_POST["id_transaksi"];
    //Koneksi database
    include '../../../config/database.php';
    // mengambil data transaksi dengan kode paling besar
    $query = mysqli_query($kon, "SELECT foto_identitas FROM transaksi where id_transaksi=$id_transaksi");
    $data = mysqli_fetch_array($query); 

    $foto_identitas=$data['foto_identitas'];

?>
<!-- rows -->
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
        <center><img src="transaksi/foto/<?php echo $foto_identitas;?>" width="100%" class="rounded"></center>
        </div>
    </div>
</div>

 