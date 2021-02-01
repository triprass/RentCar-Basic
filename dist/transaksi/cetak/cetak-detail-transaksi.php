<script>
    $('title').text('Cetak Transaksi Penyewaan');
</script>
<!DOCTYPE html>
<html>
<head>
  <!-- Custom styles for this template -->
  <link href="../../../src/templates/css/styles.css" rel="stylesheet" />
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
                    <div class="col-sm-2 text-left">
                    <img src="../../aplikasi/logo/<?php echo $row['logo']; ?>" width="95px" alt="brand"/>
                    </div>
                    <div class="col-sm-10 text-left">
                        <h3><?php echo strtoupper($row['nama_aplikasi']);?></h3>
                        <h6><?php echo $row['alamat'].', Telp '.$row['no_telp'];?></h6>
                        <h6><?php echo $row['website'];?></h6>
                    </div>
                </div>
            </div>
            <?php
                  
                  $id_transaksi=$_GET['id_transaksi'];
                  $query = mysqli_query($kon, "SELECT * from transaksi where id_transaksi='$id_transaksi'");    
                  $ambil = mysqli_fetch_array($query);
              ?>
            
            <div class="card-body">
                <!--rows -->   
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <table class="table">
                                    <tbody>
                    
                                    <tr>
                                        <td>Kode Transaksi</td>
                                        <td>: <?php echo $ambil['kode_transaksi'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Transaksi</td>
                                        <td>: <?php echo date('d/m/Y', strtotime($ambil["tanggal_transaksi"]));?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Penyewa</td>
                                        <td>: <?php echo $ambil['nama_penyewa'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Identitas Penyewa</td>
                                        <td><?php echo $ambil['identitas']; ?></td>
                                    </tr>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                        <div class="col-sm-8">
                        
                        </div>
                    </div>
                    <!--rows -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mobil</th>
                                        <th>Lama Sewa</th>
                                        <th>Status Penyewaan</th>
                                        <th>Biaya Sewa</th>
                                        <th>Denda</th>
                                        <th>Sub Total</th>
                                    </tr>
                
                                    </thead>
                                    <tbody>
                                    <?php
                                        include '../../../config/database.php';
                                        $id_transaksi=$_GET['id_transaksi'];
                                        // perintah sql untuk menampilkan daftar transaksi yang berelasi dengan tabel kategori transaksi
                                        $sql1="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi where transaksi.id_transaksi='$id_transaksi'";
                                        $result=mysqli_query($kon,$sql1);
                                        $no=0;
                                        $status='';
                                        $sub_total=0;
                                        $total=0;
                                        //Menampilkan data dengan perulangan while
                                        while ($ambil = mysqli_fetch_array($result)):
                                        $no++; 
                                        $sub_total=$ambil['total_biaya']+$ambil['denda'];
                                        $total+=$sub_total;


                                        if ($ambil['status_penyewaan']==2){
                                            $status="Telah Selesai";
                                        }else if ($ambil['status_penyewaan']==1){
                                            $status="Sedang disewa";
                                        }else {
                                            $status="Belum ditentukan";
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $ambil['nama_mobil']; ?></td>
                                        <td><?php echo $ambil['lama_sewa']; ?> jam</td>
                                        <td><?php echo $status; ?></td>
                                        <td>Rp. <?php echo number_format($ambil['total_biaya'],0,',','.'); ?></td>
                                        <td>Rp. <?php echo number_format($ambil['denda'],0,',','.'); ?></td>
                                        <td>Rp. <?php echo number_format($sub_total,0,',','.'); ?></td>
                                    </tr>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                                <br>
                                <h3 class='text-right'>Total Biaya : Rp. <?php echo number_format($total,0,',','.'); ?></h3>
                            </div>
                        </div>
                 
                </div>
            </div>
        </div>
    </body>
</html>