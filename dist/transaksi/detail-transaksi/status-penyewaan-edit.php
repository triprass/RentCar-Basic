
<?php
session_start();
if (isset($_POST['edit_status_penyewaan'])) {

    include '../../../config/database.php';
    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    $id_mobil=$_POST["id_mobil"];
    $id_transaksi=$_POST["id_transaksi"];
    $id_detail_transaksi=$_POST["id_detail_transaksi"];
    $status_penyewaan=$_POST["status_penyewaan"];

    //Jika stats penyewaan dipilih sedang sewa (nilainya 1) maka denda akan di set 0
    $denda=$_POST["denda"];
    if ($status_penyewaan==1){
        $denda=0;
    }
    
    //Update status penyewaan dan denda
    $update_status_penyewaan=mysqli_query($kon,"update detail_transaksi set status_penyewaan='$status_penyewaan' where id_detail_transaksi='".$id_detail_transaksi."'");
    $update_denda=mysqli_query($kon,"update detail_transaksi set denda='$denda' where id_detail_transaksi='".$id_detail_transaksi."'");
    
    $waktu=date("Y-m-d H:i");
    $log_aktivitas="Update Status Penyewaan ID Detail Transaksi #$id_detail_transaksi";
    $id_pengguna= $_SESSION["id_pengguna"];
    //Menyimpan aktivitas
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");


    if ($update_status_penyewaan and $update_denda and $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=gagal");
    }
}
?>
<form method="post" action="transaksi/detail-transaksi/status-penyewaan-edit.php">
    <div class="form-group">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="sedang_sewa" name="status_penyewaan" value="1" <?php echo $_POST['status_penyewaan'] == 1 ? 'checked' : ''; ?> />
            <label class="custom-control-label" for="sedang_sewa">Sedang Disewa</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="telah_selesai" name="status_penyewaan" value="2" <?php echo $_POST['status_penyewaan'] == 2 ? 'checked' : ''; ?> />
            <label class="custom-control-label" for="telah_selesai">Telah Selesai</label>
        </div>
    </div>
    <div class="alert alert-info" id="info">
        <span id='pesan'></span>
    </div>
    <div class="form-group">
        <input type="number" class="form-control" id="denda"  min="0" name="denda" placeholder="Masukan Denda" value="<?php echo $_POST['denda'];?>">
    </div>
    <div class="form-group">
        <div id="info_nominal" class='font-weight-bold'></div>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="id_mobil" value="<?php echo $_POST['id_mobil'];?>">
        <input type="hidden" class="form-control" name="id_transaksi" value="<?php echo $_POST['id_transaksi'];?>">
        <input type="hidden" class="form-control" name="id_detail_transaksi" value="<?php echo $_POST['id_detail_transaksi'];?>">
    </div>
    <button type="submit" name="edit_status_penyewaan" id="tombol_edit" class="btn btn-primary">Submit</button>
</form>
<script>
    //Format rupiah
    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }
    //Selector denda dan info disembunyikan terlebih dahulu, tombol edit juga di disabled
    $('#denda').hide();
    $('#info').hide();
    $( "#tombol_edit" ).prop( "disabled", true );

    //Event saat penguna mengklik radio button sedang sewa
    $('#sedang_sewa').on('click',function(){
        $('#denda').hide(200);
        $('#info_nominal').hide(200);
        $('#info').show(200); 
        $('#pesan').text("Status mobil akan berubah menjadi 'Sedang Disewa'"); 
        $( "#tombol_edit" ).prop( "disabled", false );
    });

     //Event saat penguna mengklik radio telah selesai
    $('#telah_selesai').on('click',function(){
        $('#denda').show(200);
        $('#info').show(200);
        $('#info_nominal').show(200);
        $('#pesan').text("Kosongkan isian jika penyewaan tidak dikenakan denda"); 
        $( "#tombol_edit" ).prop( "disabled", false );
    });

    //Event saat pengguna menginput denda
    $('#denda').bind('keyup', function () {
        var denda=$("#denda").val();
        $("#info_nominal").text('Rp.'+format_rupiah(denda));     
    }); 

</script>