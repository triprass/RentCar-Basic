<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <!-- Custom styles for this template -->
  <link href="../../../src/templates/css/styles.css" rel="stylesheet">
  <link href="../../../src/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
    <body onload="window.print();">
        <?php
        include '../../../config/database.php';
   
        $query = mysqli_query($kon, "select * from profil_aplikasi order by nama_aplikasi desc limit 1");    
        $row = mysqli_fetch_array($query);
        ?>
        <div class="container-fluid">
            <div class="card">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-sm-2 float-left">
                    <img src="../../aplikasi/logo/<?php echo $row['logo']; ?>" width="95px" alt="brand"/>
                    </div>
                    <div class="col-sm-10 float-left">
                        <h3><?php echo strtoupper($row['nama_aplikasi']);?></h3>
                        <h6><?php echo $row['alamat'].', Telp '.$row['no_telp'];?></h6>
                        <h6><?php echo $row['website'];?></h6>
                    </div>
                </div>
            </div>
                <div class="card-body">
                    <!--rows -->
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Penyewa</th>
                                        <th rowspan="2">Mobil</th>
                                        <th colspan="3">Waktu Penyewaan</th>
                                        <th rowspan="2">Status</th>
                                    </tr>
                                    <tr>
                                        <th>Mulai</th>
                                        <th>Akhir</th>
                                        <th>Jam</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                    // include database
                                    include '../../../config/database.php';
                                    $kondisi="";

                                    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])) $kondisi= "where date(mulai_sewa)='".$_GET['dari_tanggal']."' ";
                                    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) $kondisi= "where date(mulai_sewa) between '".$_GET['dari_tanggal']."' and '".$_GET['sampai_tanggal']."'";
                                    
                                    // perintah sql untuk menampilkan laporan penyewaan jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                                    if ($_SESSION["level"]=="Admin"){
                                        $id_pengguna=$_SESSION["id_pengguna"];
                                        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi  and transaksi.id_pengguna=$id_pengguna order by mulai_sewa asc";
                                    }else {
                                        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi order by mulai_sewa asc";
                                    } 
                                    
                                    $hasil=mysqli_query($kon,$sql);
                                    $no=0;
                                    $status='';
                                    //Menampilkan data dengan perulangan while
                                    while ($data = mysqli_fetch_array($hasil)):
                                    $no++;
                                    if ($data['status_penyewaan']==2){
                                        $status="Telah Selesai";
                                    }else if ($data['status_penyewaan']==1){
                                        $status="Sedang disewa";
                                    }else {
                                        $status="Belum ditentukan";
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['nama_penyewa']; ?> </td>
                                    <td><?php echo $data['nama_mobil']; ?> </td>
                                    <td class="text-center"><?php echo date("d/m/Y",strtotime($data['mulai_sewa'])); ?></td>
                                    <td class="text-center"><?php echo date("d/m/Y",strtotime($data['akhir_sewa'])); ?></td>
                                    <td class="text-center"><?php echo date("H:i",strtotime($data['akhir_sewa'])); ?> WIB</td>
                                    <td><?php echo  $status; ?></td>
                                    
                                </tr>
                                <!-- bagian akhir (penutup) while -->
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>