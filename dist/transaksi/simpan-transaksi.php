<?php
session_start();

if (isset($_POST['buat_transaksi'])) {

    include '../../config/database.php';

    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $date = date("ymd");
    $query = mysqli_query($kon, "SELECT max(id_transaksi) as id_transaksi_terbesar FROM transaksi WHERE kode_transaksi like'%$date%'");
    $data = mysqli_fetch_array($query);
    $id_transaksi = $data['id_transaksi_terbesar'];
    $id_transaksi++;
    //Membuat kode transaksi
    $kode_transaksi = $date . sprintf("%02s", $id_transaksi);
    $id_pengguna=$_SESSION["id_pengguna"];
    $nama_penyewa=input($_POST['nama_penyewa']);
    $no_telp=input($_POST['no_telp']);
    $alamat=input($_POST['alamat']);
    $tanggal_transaksi=date("Y-m-d h:i:s");
    $identitas=input($_POST['identitas']);
    $pembayaran=input($_POST['pembayaran']);

        //Jika pake uang muka
    if ($pembayaran==1){
        $total_bayar=input($_POST['uang_muka']);
        //Jika lunas
    } else if ($pembayaran==2){
        $total_bayar=input($_POST['total_bayar']);
        //Jika belum bayar
    }else {
        $total_bayar=0;
    }
   
    $foto_identitas = $_FILES['foto_identitas']['name'];
    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $x = explode('.', $foto_identitas);
    $ekstensi = strtolower(end($x));
    $ukuran	= $_FILES['foto_identitas']['size'];
    $file_tmp = $_FILES['foto_identitas']['tmp_name'];	

    if (!empty($foto_identitas)){
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            //Mengupload foto
            move_uploaded_file($file_tmp, 'foto/'.$foto_identitas);
            //Sql jika admin memasukan foto identitas
            $simpan_transaksi=mysqli_query($kon,"insert into transaksi (kode_transaksi,id_pengguna,tanggal_transaksi,nama_penyewa,no_telp,alamat,identitas,foto_identitas,total_bayar) values ('$kode_transaksi',$id_pengguna,'$tanggal_transaksi','$nama_penyewa','$no_telp','$alamat','$identitas','$foto_identitas','$total_bayar')");
        }
    }else {
        //Sql jika admin tidak memasukan foto identitas, maka akan menggunakan gambar default
        $simpan_transaksi=mysqli_query($kon,"insert into transaksi (kode_transaksi,id_pengguna,tanggal_transaksi,nama_penyewa,no_telp,alamat,identitas,total_bayar) values ('$kode_transaksi',$id_pengguna,'$tanggal_transaksi','$nama_penyewa','$no_telp','$alamat','$identitas','$total_bayar')");
    
    }
    
    //Simpan detail transaksi
    if(!empty($_SESSION["cart_item"])):
        foreach ($_SESSION["cart_item"] as $item):
            $id_mobil=$item["id_mobil"];
            $mulai_sewa=date("Y-m-d H:i",strtotime($item["mulai_sewa"]));
            $akhir_sewa=date("Y-m-d H:i",strtotime($item["akhir_sewa"]));
            $lama_sewa=$item["lama_sewa"];
            $supir=$item["supir"];
            $bbm=$item["bbm"];
            $total_biaya=$item["total_biaya"];

            $simpan_detail_transaksi=mysqli_query($kon,"insert into detail_transaksi (kode_transaksi,id_mobil,mulai_sewa,akhir_sewa,lama_sewa,supir,bbm,total_biaya) values ('$kode_transaksi','$id_mobil','$mulai_sewa','$akhir_sewa','$lama_sewa','$supir','$bbm','$total_biaya')");
        endforeach;
    endif;

    $waktu=date("Y-m-d H:i");
    $log_aktivitas="Input transaksi Kode #$kode_transaksi";
    $id_pengguna= $_SESSION["id_pengguna"];

    //Menyimpan aktivitas
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

    //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
    if ($simpan_transaksi and $simpan_detail_transaksi and $simpan_aktivitas) {

        //Jika semua query berhasil, lakukan commit
        mysqli_query($kon,"COMMIT");

        //Kosongkan keranjang belanja
        unset($_SESSION["cart_item"]);
        //Alihkan ke halaman awal
        header("Location:../../dist/index.php?page=transaksi&add=berhasil");
    }
    else {
        //Jika ada query yang gagal, lakukan rollback
        mysqli_query($kon,"ROLLBACK");
        //Kosongkan keranjang belanja
        unset($_SESSION["cart_item"]);
        header("Location:../../dist/index.php?page=transaksi&add=gagal");
    }
  

}   
?>