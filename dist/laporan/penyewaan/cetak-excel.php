<?php
session_start();
    //Koneksi database
    include '../../../config/database.php';
    //Mengambil nama aplikasi
    $query = mysqli_query($kon, "select nama_aplikasi from profil_aplikasi order by nama_aplikasi desc limit 1");    
    $row = mysqli_fetch_array($query);
    //Mengambil tanggal
    $tanggal='';
    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])) $tanggal=date("d/m/Y",strtotime($_GET["dari_tanggal"]));
    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) $tanggal= "".date("d/m/Y",strtotime($_GET["dari_tanggal"]))." - ".date("d/m/Y",strtotime($_GET["sampai_tanggal"]))."";
    
    //Membuat file format excel
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=LAPORAN PENYEWAAN ".strtoupper($row['nama_aplikasi'])." ".$tanggal.".xls");
?>  
<h2><center>LAPORAN PENYEWAAN <?php echo strtoupper($row['nama_aplikasi']);?></center></h2>
<h4>Tanggal : <?php echo $tanggal; ?></h4>
<table border="1">
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
            $status="<span class='badge badge-success'>Telah Selesai</span>";
        }else if ($data['status_penyewaan']==1){
            $status="<span class='badge badge-warning'>Sedang disewa</span>";
        }else {
            $status="<span class='badge badge-secondary'>Belum ditentukan</span>";
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