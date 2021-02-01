<script>
    $('title').text('Detail Transaksi');
</script>


<main>
    <div class="container-fluid">
        <h2 class="mt-4">Detail Transaksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Detail Transaksi</li>
        </ol>
        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user mengubah status penyewaan
            if (isset($_GET['status'])) {
                if ($_GET['status']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Status penyewaan telah ditetapkan!</div>";
                }else if ($_GET['status']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Status penyewaan gagal ditetapkan!</div>";
                }    
            }
            //Validasi untuk menampilkan pesan pemberitahuan saat user mengubah data penyewa
            if (isset($_GET['edit-penyewa'])) {
                if ($_GET['edit-penyewa']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Penyewa telah diupdate</div>";
                }else if ($_GET['edit-penyewa']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Penyewa gagal diupdate</div>";
                }    
            }

        ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary" id="judul_grafik" >Informasi Transaksi</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table">
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        $id_transaksi=$_GET['id_transaksi'];
                                        $query = mysqli_query($kon, "SELECT * from transaksi where id_transaksi='$id_transaksi'");    
                                        $ambil = mysqli_fetch_array($query);
                                    ?>
                                    <tr>
                                        <td>Kode Transaksi</td>
                                        <td>: <?php echo $ambil['kode_transaksi'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Transaksi</td>
                                        <td>: <?php echo date('d/m/Y', strtotime($ambil["tanggal_transaksi"]));?></td>
                                    </tr>
                                    <tr>
                                        <td>Dilayani Oleh</td>
                                        <td>: <?php echo date('d/m/Y', strtotime($ambil["tanggal_transaksi"]));?></td>
                                    </tr>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary" id="judul_grafik" >Informasi Penyewa</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table">
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        $id_transaksi=$_GET['id_transaksi'];
                                        $query = mysqli_query($kon, "SELECT * from transaksi where id_transaksi='$id_transaksi'");    
                                        $ambil = mysqli_fetch_array($query);
                                    ?>
                                    <tr>
                                        <td>Nama Penyewa</td>
                                        <td>: <?php echo $ambil['nama_penyewa'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Identitas Penyewa</td>
                                        <td>: <?php echo $ambil['identitas']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>No Telp</td>
                                        <td>: <?php echo $ambil['no_telp'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: <?php echo  $ambil['alamat'];?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="btn btn-warning btn-circle" id="tombol_edit_penyewa" id_transaksi="<?php echo $_GET['id_transaksi'];?>" ><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-primary btn-circle" id="tombol_lihat_foto_identitas" id_transaksi="<?php echo $_GET['id_transaksi'];?>" ><i class="fas fa-id-card"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary" id="judul_grafik" >Informasi Pembayaran</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table">
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        include 'detail-transaksi/pembayaran.php';
                                        $id_transaksi=$_GET['id_transaksi'];
                                        $query = mysqli_query($kon, "SELECT * from transaksi where id_transaksi='$id_transaksi'");    
                                        $ambil = mysqli_fetch_array($query);
                                        $kode_transaksi =$ambil['kode_transaksi'];
                                    ?>
                                    <tr>
                                        <td>Status</td>
                                        <td>:<?php echo status_pembayaran($ambil['kode_transaksi']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Biaya</td>
                                        <td>: Rp. <?php echo number_format(total_biaya($ambil['kode_transaksi']),0,',','.'); ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Sudah Dibayar</td>
                                        <td>: Rp. <?php echo number_format(total_pembayaran($ambil['kode_transaksi']),0,',','.'); ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Selisih Pembayaran</td>
                                        <td>: <span id="tampil_selisih"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="btn btn-primary btn-circle" id="tombol_edit_pembayaran" id_transaksi="<?php echo $_GET['id_transaksi'];?>" kode_transaksi="<?php echo $ambil['kode_transaksi'];?>" ><i class="fas fa-cash-register"></i></button>
                                            <button class="btn btn-danger btn-circle" id="tombol_hapus_pembayaran" id_transaksi="<?php echo $_GET['id_transaksi'];?>" ><i class="fas fa-trash"></i></button> 
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="bagian_penyewaan">
                    <div class="col-sm-12">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <button class="btn btn-success btn-circle" id="tombol_tambah_penyewaan" id_transaksi="<?php echo $_GET['id_transaksi'];?>" kode_transaksi="<?php echo $ambil['kode_transaksi'];?>" ><i class="fas fa-cart-plus"></i> Tambah Penyewaan</button>
                            </div>
                            <div class="card-body" >
                                <?php
                                    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah penyewaan baru
                                    if (isset($_GET['tambah-penyewaan'])) {
                                        if ($_GET['tambah-penyewaan']=='berhasil'){
                                            echo"<div class='alert alert-success'><strong>Berhasil!</strong> Penyewaan baru telah ditambahkan</div>";
                                        } else if ($_GET['status']=='gagal'){
                                            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Penyewaan baru gagal ditambahkan</div>";
                                        }   
                                    }
                                    //Validasi untuk menampilkan pesan pemberitahuan saat user menghapus penyewaan
                                    if (isset($_GET['hapus-penyewaan'])) {
                                        if ($_GET['hapus-penyewaan']=='berhasil'){
                                            echo"<div class='alert alert-success'><strong>Berhasil!</strong> Penyewaan telah dihapus</div>";
                                        } else if ($_GET['status']=='gagal'){
                                            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Penyewaan gagal dihapus</div>";
                                        }    
                                    }
                                ?>
            
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Mobil</th>
                                        <th rowspan="2">Lama Sewa</th>
                                        <th colspan="3"  class="text-center">Waktu Penyewaan</th>
                                        <th rowspan="2">Fasilitas</th>
                                        <th rowspan="2">Biaya Sewa</th>
                                        <th rowspan="2">Denda</th>
                                        <th rowspan="2">Status Penyewaan</th>
                                        <th rowspan="2">Konfirmasi</th>
                                    </tr>
                                    <tr>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Jam</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        $id_transaksi=$_GET['id_transaksi'];
                                        // Menampilkan detail penyewaan
                                        $sql1="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi where transaksi.id_transaksi='$id_transaksi'";
                                        $result=mysqli_query($kon,$sql1);
                                        $no=0;
                                        $tot_harus_bayar=0;
                                        $status='';
                                        //Menampilkan data dengan perulangan while
                                        while ($ambil = mysqli_fetch_array($result)):
                                        $no++; 
                                        if ($ambil['status_penyewaan']==0){
                                            $status="<span class='badge badge-secondary'>Belum ditentukan</span>";
                                            
                                        }else if ($ambil['status_penyewaan']==1){
                                            $status="<span class='badge badge-warning'>Sedang disewa</span>";
                                        }else {
                                            $status="<span class='badge badge-success'>Telah Selesai</span>";
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $ambil['nama_mobil']; ?></td>
                                        <td><?php echo $ambil['lama_sewa']; ?> jam</td>
                                        <td class="text-center"><?php echo date("d/m/Y",strtotime($ambil['mulai_sewa'])); ?></td>
                                        <td class="text-center"><?php echo date("d/m/Y",strtotime($ambil['akhir_sewa'])); ?></td>
                                        <td class="text-center"><?php echo date("H:i",strtotime($ambil['akhir_sewa'])); ?> WIB</td>
                                        <td><?php if ($ambil['supir'] == 1 ) echo "<span class='badge badge-info'>Supir</span>"; ?> <?php if ($ambil['bbm'] == 1 ) echo "<span class='badge badge-info'>BBM</span>"; ?></td>
                                        <td>Rp. <?php echo number_format($ambil['total_biaya'],0,',','.'); ?></td>
                                        <td>Rp. <?php echo number_format($ambil['denda'],0,',','.'); ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                            <button class="tombol_edit_status_penyewaan btn btn-primary btn-circle" id_detail_transaksi="<?php echo $ambil['id_detail_transaksi']; ?>" id_transaksi="<?php echo $ambil['id_transaksi']; ?>" id_mobil="<?php  echo $ambil['id_mobil'];?>"   status_penyewaan="<?php  echo $ambil['status_penyewaan'];?>" denda="<?php  echo $ambil['denda'];?>"  ><i class="fas fa-edit"></i></button>
                                            <button class="tombol_hapus_penyewaan btn btn-danger btn-circle"  id_detail_transaksi="<?php echo  $ambil['id_detail_transaksi'];?>" id_transaksi="<?php echo  $_GET['id_transaksi'];?>" ><i class="fas fa-trash"></i></button> 
                                        </td>
                                    </tr>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                                <a href="transaksi/cetak/cetak-detail-transaksi.php?id_transaksi=<?php echo $id_transaksi;?>" target='blank' class="btn btn-primary btn-icon-split"><span class="text"><i class="fas fa-print"></i> Cetak Invoice</span></a>
                                <a href="transaksi/cetak/detail-transaksi-pdf.php?id_transaksi=<?php echo $id_transaksi;?>" target='blank' class="btn btn-danger btn-icon-pdf"><span class="text"><i class="fas fa-file-pdf"></i> Export PDF</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Bagian header -->
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Bagian body -->
      <div class="modal-body">
        
        <div id="tampil_data">
          <!-- Data akan ditampilkan disini dengan AJAX -->                   
        </div>
            
      </div>
      <!-- Bagian footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<input name="total_biaya" id="total_biaya" value="<?php echo total_biaya($kode_transaksi); ?>" type="hidden"  class="form-control">                            
<input name="total_pembayaran" id="total_pembayaran" value="<?php echo total_pembayaran($kode_transaksi); ?>" type="hidden"  class="form-control"> 


<script>

<?php
    if ($_SESSION["level"]=="Manajer"){
    echo "$('#tombol_edit_pembayaran').hide();";
    echo "$('#tombol_hapus_pembayaran').hide();";
    echo "$('#tombol_edit_penyewa').hide();";
    echo "$('#tombol_lihat_foto_identitas').hide();";
    echo "$('#tombol_tambah_penyewaan').hide();";
    echo "$('.tombol_hapus_penyewaan').hide();";
    echo "$('.tombol_edit_status_penyewaan').hide();";
    }
      
?>
  // edit pembayaran
    $('#tombol_edit_pembayaran').on('click',function(){
        var id_transaksi = $(this).attr("id_transaksi");
        var kode_transaksi = $(this).attr("kode_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/pembayaran-edit.php',
            method: 'post',
            data: {id_transaksi:id_transaksi,kode_transaksi:kode_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Pembayaran';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // hapus pembayaran
    $('#tombol_hapus_pembayaran').on('click',function(){
        var id_transaksi = $(this).attr("id_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/pembayaran-hapus.php',
            method: 'post',
            data: {id_transaksi:id_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Hapus Pembayaran';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });



    // edit penyewa
    $('#tombol_edit_penyewa').on('click',function(){
        var id_transaksi = $(this).attr("id_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/penyewa-edit.php',
            method: 'post',
            data: {id_transaksi:id_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Penyewa';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // lihat foto identitas
    $('#tombol_lihat_foto_identitas').on('click',function(){
        var id_transaksi = $(this).attr("id_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/lihat-identitas.php',
            method: 'post',
            data: {id_transaksi:id_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Foto Identitas';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // tambah penyewaaan
    $('#tombol_tambah_penyewaan').on('click',function(){
        var kode_transaksi = $(this).attr("kode_transaksi");
        var id_transaksi = $(this).attr("id_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/penyewaan-pilih-mobil.php',
            method: 'post',
            data: {id_transaksi:id_transaksi,kode_transaksi:kode_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Penyewaan';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // hapus penyewaaan
    $('.tombol_hapus_penyewaan').on('click',function(){
      
        var id_detail_transaksi = $(this).attr("id_detail_transaksi");
        var id_transaksi = $(this).attr("id_transaksi");
        $.ajax({
            url: 'transaksi/detail-transaksi/penyewaan-hapus.php',
            method: 'post',
            data: {id_detail_transaksi:id_detail_transaksi,id_transaksi:id_transaksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Hapus Penyewaan';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });



    // Edit status penyewaan
    $('.tombol_edit_status_penyewaan').on('click',function(){
        
        var id_detail_transaksi = $(this).attr("id_detail_transaksi");
        var id_transaksi = $(this).attr("id_transaksi");
        var id_mobil = $(this).attr("id_mobil");
        var status_penyewaan =$(this).attr("status_penyewaan");
        var denda =$(this).attr("denda");
        $.ajax({
            url: 'transaksi/detail-transaksi/status-penyewaan-edit.php',
            method: 'post',
            data: {id_detail_transaksi:id_detail_transaksi,id_transaksi:id_transaksi,id_mobil:id_mobil,status_penyewaan:status_penyewaan,denda:denda},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Status Penyewaan';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });    

    //Format rupiah
    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }

    //Menampilkan total bayar
    var total_biaya =$("#total_biaya").val();
    $("#tampil_total_biaya").text('Rp. '+format_rupiah(total_biaya));


    //Menampilkan selisih pembayaran
    var total_biaya =$("#total_biaya").val();
    var total_pembayaran =$("#total_pembayaran").val();
    var selisih = total_biaya-total_pembayaran;
    $("#tampil_selisih").text('Rp. '+format_rupiah(selisih));

    if (selisih>0){
        $("#tampil_selisih").css("color", "red");
    }else {
        $("#tampil_selisih").css("color", "green");
     
        
    }

</script>