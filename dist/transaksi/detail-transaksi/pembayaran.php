<?php


function status_pembayaran($kode_transaksi){
    include '../config/database.php';

    $tot = mysqli_fetch_array(mysqli_query($kon, "SELECT total_bayar from transaksi where kode_transaksi='$kode_transaksi'"));
    $total_bayar=$tot['total_bayar'];
    $total_biaya=0;

    $result=mysqli_query($kon,"SELECT total_biaya,denda from detail_transaksi where kode_transaksi='$kode_transaksi'");

    while ($ambil = mysqli_fetch_array($result)):
        $total_biaya+=$ambil['total_biaya']+$ambil['denda'];
    endwhile;


    if ($total_bayar==0 && $total_biaya==0 ){
        return "<span class='badge badge-secondary'>Tidak ada transaksi</span>";
    }else if ($total_bayar==0 &&  $total_biaya!=0){
        return "<span class='badge badge-danger'>Belum Bayar</span>";
    }else if ($total_bayar<$total_biaya){
        return "<span class='badge badge-warning'>Belum Lunas</span>";
    }else if ($total_bayar==$total_biaya){
        return "<span class='badge badge-success'>Sudah Lunas</span>";
    }else {
        return "<span class='badge badge-info'>Kelebihan</span>";
    }

}




function total_biaya($kode_transaksi){
        
    include '../config/database.php';

    $total_biaya=0;
    $result=mysqli_query($kon,"SELECT total_biaya,denda from detail_transaksi where kode_transaksi='$kode_transaksi'");

    while ($ambil = mysqli_fetch_array($result)):
        $total_biaya+=$ambil['total_biaya']+$ambil['denda'];
    endwhile;

    return $total_biaya;

}


function total_pembayaran($kode_transaksi){
        
    include '../config/database.php';

    $data = mysqli_fetch_array(mysqli_query($kon, "SELECT total_bayar from transaksi where kode_transaksi='$kode_transaksi'"));
    $total_bayar=$data['total_bayar'];

    return $total_bayar;

}

?>