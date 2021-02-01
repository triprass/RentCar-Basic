<?php
session_start();
?>
<div class="card mb-4">
    <div class="card-body">
            <div class="table-responsive">
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

                    if (!empty($_POST["dari_tanggal"]) && empty($_POST["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi)='".$_POST['dari_tanggal']."' ";
                    if (!empty($_POST["dari_tanggal"]) && !empty($_POST["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi) between '".$_POST['dari_tanggal']."' and '".$_POST['sampai_tanggal']."'";
                    
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
            <a href="laporan/pendapatan/cetak-laporan.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-primary btn-icon-split"><span class="text"><i class="fas fa-print fa-sm"></i> Cetak Invoice</span></a>
            <a href="laporan/pendapatan/cetak-pdf.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-danger btn-icon-pdf"><span class="text"><i class="fas fa-file-pdf fa-sm"></i> Export PDF</span></a>
	         <a href="laporan/pendapatan/cetak-excel.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-success btn-icon-pdf"><span class="text"><i class="fas fa-file-excel fa-sm"></i> Export Excel</span></a>
        </div>
    </div>
</div>