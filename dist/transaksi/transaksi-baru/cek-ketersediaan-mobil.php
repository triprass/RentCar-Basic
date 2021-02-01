<?php
include '../../../config/database.php';

     //Menerima data kiriman
    $kode_mobil=$_POST['kode_mobil'];
    $lama_sewa=$_POST["lama_sewa"];
    $tanggal=$_POST["tanggal"];

     //Set tanggal mulai dan akhir
    $tgl=$tanggal;
    $mulai_sewa=date("Y-m-d H:i",strtotime($tgl));
    $akhir_sewa=date("Y-m-d H:i",strtotime("+$lama_sewa hour",strtotime($tgl)));
     //Ambil id_mobil
    $ambil_id_mobil = mysqli_query ($kon,"select id_mobil from mobil where kode_mobil='".$kode_mobil."' limit 1");
    $data = mysqli_fetch_assoc($ambil_id_mobil);
    $id_mobil=$data['id_mobil'];

     //Cek ketersediaan mobil
  while (strtotime($mulai_sewa) <= strtotime($akhir_sewa)) {
    $query = mysqli_query($kon, "select * from detail_transaksi where '".$mulai_sewa."' between date(mulai_sewa) and date(akhir_sewa) and id_mobil='$id_mobil'");
    $mulai_sewa = date ("Y-m-d", strtotime("+1 day", strtotime($mulai_sewa)));
    $cek[] = mysqli_num_rows($query);
   }

   // Mengecek jika 1 artinya tanggal tersebut sudah ada penyewaa lain yang sedang menyewa mobil tersebut
   if (in_array('1', $cek)){
        echo "<div class='alert alert-danger'> Tidak Tersedia</div>";
        echo "<script> document.getElementById('tambah').disabled = true; </script>";
   }else {
        echo "<div class='alert alert-success'> Tersedia</div>";
        echo "<script> document.getElementById('tambah').disabled = false; </script>";
   }

?>
