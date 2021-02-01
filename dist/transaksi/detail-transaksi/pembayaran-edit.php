<?php
session_start();
if (isset($_POST['bayar_sekarang'])) {

    include '../../../config/database.php';
    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id_transaksi=input($_POST["id_transaksi"]);
    $nominal_bayar=input($_POST["nominal_bayar"]);
    $tot_bayar_saat_ini=input($_POST["tot_bayar_saat_ini"]);

    $total_bayar=$tot_bayar_saat_ini+$nominal_bayar;
    //Update pembayaran
    $update_pembayaran=mysqli_query($kon,"update transaksi set total_bayar='$total_bayar' where id_transaksi='".$id_transaksi."'");

    $waktu=date("Y-m-d H:i");
    $log_aktivitas="Edit Pembayaran ID #$id_transaksi";
    $id_pengguna= $_SESSION["id_pengguna"];

    //Menyimpan aktivitas
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

    if ($update_pembayaran and $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&status=gagal");

    }
}
?>
<form method="post" action="transaksi/detail-transaksi/pembayaran-edit.php">
    <div class="form-group">
    <span id="tampil_biaya"></span>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="id_transaksi" value="<?php echo $_POST['id_transaksi'];?>">
        <input type="hidden" class="form-control" name="tot_bayar_saat_ini" id="tot_bayar_saat_ini" value="">
        <input type="text" class="form-control" name="nominal_bayar" id="nominal_bayar" placeholder="Masukan Nominal Bayar">
    </div>
    <div class="form-group">
        <span id="info_nominal"></span>
    </div>
    <button type="submit" class="btn btn-primary" id="bayar_sekarang" name="bayar_sekarang">Bayar Sekarang</button>
</form>

<script>

//Fungsi untuk membuat format rupiah
function format_rupiah(nominal){
    var  reverse = nominal.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        return ribuan	= ribuan.join('.').split('').reverse().join('');
}


 //Menampilkan selisih pembayaran
 var selisih = $("#total_biaya").val()-$("#total_pembayaran").val();
 $( "#tampil_biaya" ).html("<div class='alert alert-warning'>Biaya yang harus dibayar adalah Rp."+format_rupiah(selisih)+"</div>");

    //Kondisi untuk menampilkan info pembayaran
    if (selisih>0){
        $("#tampil_biaya").css("color", "red");
    }
    else if ($("#total_biaya").val()==0 && $("#total_pembayaran").val()==0){
        $( "#tampil_biaya" ).html("<div class='alert alert-secondary'>Tidak ada transaksi penyewaan</div>");
        $( "#nominal_bayar" ).hide();
        $( "#bayar_sekarang" ).hide();
        $( "#tombol_hapus_pembayaran" ).prop( "disabled", true );
    } else if ($("#total_biaya").val()==$("#total_pembayaran").val()){
        $( "#tampil_biaya" ).html("<div class='alert alert-success'>Biaya penyewaan telah lunas</div>");
        $( "#nominal_bayar" ).hide();
        $( "#bayar_sekarang" ).hide();
    } 
    else {
        $( "#nominal_bayar" ).hide();
        $( "#bayar_sekarang" ).hide();
        $( "#tampil_biaya" ).html("<div class='alert alert-info'>Terdapat kelebihan pembayaran sebanyak Rp."+format_rupiah(selisih)+"</div>");
    }

$("#tot_bayar_saat_ini").val(total_pembayaran);
$( "#bayar_sekarang" ).prop( "disabled", true );


//Menampilkan nominal bayar
$('#nominal_bayar').bind('keyup', function () {
    var nominal_bayar=$("#nominal_bayar").val();
    $("#info_nominal").text('Rp.'+format_rupiah(nominal_bayar));

    //Kondisi untuk disabled atau enable tombol bayar
    if (nominal_bayar>selisih){
        $( "#bayar_sekarang" ).prop( "disabled", true );
        
    }else {
        $( "#bayar_sekarang" ).prop( "disabled", false );
    
    }     
});  
</script>