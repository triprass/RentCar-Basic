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
                                        <th>No</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Mobil</th>
                                        <th>Biaya Penyewaan</th>
                                        <th>Supir</th>
                                        <th>BBM</th>
                                        <th>Denda</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                    // include database
                                    include '../../../config/database.php';
                                    $kondisi="";

                                    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi)='".$_GET['dari_tanggal']."' ";
                                    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi) between '".$_GET['dari_tanggal']."' and '".$_GET['sampai_tanggal']."'";
                                    
                                    // perintah sql untuk menampilkan laporan pendapatan jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                                    if ($_SESSION["level"]=="Admin"){
                                        $id_pengguna=$_SESSION["id_pengguna"];
                                        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN biaya_sewa on mobil.id_mobil=biaya_sewa.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi and transaksi.id_pengguna=$id_pengguna order by tanggal_transaksi asc";
                                    }else {
                                        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN biaya_sewa on mobil.id_mobil=biaya_sewa.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi order by tanggal_transaksi asc";
                                    }
                                  
                                    $hasil=mysqli_query($kon,$sql);
                                    $no=0;
                                    $total=0;
                                    //Menampilkan data dengan perulangan while
                                    while ($data = mysqli_fetch_array($hasil)):
                                    $no++;
                                    $biaya_sewa=$data['biaya_sewa']*$data['lama_sewa'];

                                    if ($data['supir']==1){
                                        $biaya_supir=$data['biaya_supir']*$data['lama_sewa'];
                                    }else {
                                        $biaya_supir=0;
                                    }
                                    if ($data['bbm']==1){
                                        $biaya_bbm=$data['biaya_bbm'];
                                    }else {
                                        $biaya_bbm=0;
                                    }
                                
                                    $denda=$data['denda'];
                                    $sub_total=$biaya_sewa+$denda+$biaya_supir+$biaya_bbm;
                                    $total+= $sub_total;
                            
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo date("d/m/Y",strtotime($data['tanggal_transaksi'])); ?></td>
                                    <td><?php echo $data['nama_mobil']; ?> </td>
                                    <td>Rp. <?php echo number_format($biaya_sewa,0,',','.'); ?></td>
                                    <td>Rp. <?php echo number_format($biaya_supir,0,',','.'); ?></td>
                                    <td>Rp. <?php echo number_format($biaya_bbm,0,',','.'); ?></td>
                                    <td>Rp. <?php echo number_format($denda,0,',','.'); ?></td>
                                    <td>Rp. <?php echo number_format($sub_total,0,',','.'); ?></td>
                                </tr>
                                <!-- bagian akhir (penutup) while -->
                                <?php endwhile; ?>
                                <tr><td colspan="7"><strong>Total</strong></td><td><strong>Rp. <?php echo number_format($total,0,',','.'); ?></strong></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>