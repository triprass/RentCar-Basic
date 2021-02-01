<?php
session_start();
?>
<div class="card mb-4">
    <div class="card-body">
            <div class="table-responsive">
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

                        if (!empty($_POST["dari_tanggal"]) && empty($_POST["sampai_tanggal"])) $kondisi= "where date(mulai_sewa)='".$_POST['dari_tanggal']."' ";
                        if (!empty($_POST["dari_tanggal"]) && !empty($_POST["sampai_tanggal"])) $kondisi= "where date(mulai_sewa) between '".$_POST['dari_tanggal']."' and '".$_POST['sampai_tanggal']."'";
                       
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
            <a href="laporan/penyewaan/cetak-laporan.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-primary btn-icon-split"><span class="text"><i class="fas fa-print fa-sm"></i> Cetak Invoice</span></a>
            <a href="laporan/penyewaan/cetak-pdf.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-danger btn-icon-pdf"><span class="text"><i class="fas fa-file-pdf fa-sm"></i> Export PDF</span></a>
	        <a href="laporan/penyewaan/cetak-excel.php?dari_tanggal=<?php if (!empty($_POST["dari_tanggal"])) echo $_POST["dari_tanggal"]; ?>&sampai_tanggal=<?php if (!empty($_POST["sampai_tanggal"])) echo $_POST["sampai_tanggal"]; ?>" target='blank' class="btn btn-success btn-icon-pdf"><span class="text"><i class="fas fa-file-excel fa-sm"></i> Export Excel</span></a>
        </div>
    </div>
</div>