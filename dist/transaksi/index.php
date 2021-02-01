<script>
    $('title').text('Data Transaksi');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Transaksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Transaksi</li>
        </ol>
        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah transaksi
            if (isset($_GET['add'])) {
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data transaksi telah disimpan</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data transaksi gagal disimpan</div>";
                }    
            }

            //Validasi untuk menampilkan pesan pemberitahuan saat user menghapus transaksi
            if (isset($_GET['hapus'])) {
                if ($_GET['hapus']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data transaksi telah dihapus</div>";
                }else if ($_GET['hapus']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data transaksi gagal dihapus</div>";
                }    
            }
        ?>

        <div class="card mb-4">
            <div class="card-header">
            <?php if ($_SESSION["level"]!="Manajer"): ?>
            <a href="index.php?page=tambah-transaksi" class="btn btn-primary" role="button">Input Transaksi</a>
            <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Kode</th>
                                <th>Nama Penyewa</th>
                                <th>Identitas</th>
                                <th>Total Biaya</th>
                                <th>Total Pembayaran</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
        
                        <tbody>
                        <?php
                            // include database
                            include '../config/database.php';
                            include 'detail-transaksi/pembayaran.php';
                            // perintah sql untuk menampilkan daftar transaksi jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                            if ($_SESSION["level"]=="Admin"){
                                $id_pengguna=$_SESSION["id_pengguna"];
                                $sql="select * from transaksi where id_pengguna=$id_pengguna order by id_transaksi desc";
                              }else {
                                $sql="select * from transaksi order by id_transaksi desc";
                              }

                      
                            
                            $hasil=mysqli_query($kon,$sql);
                            $no=0;
                            //Menampilkan data dengan perulangan while
                            while ($data = mysqli_fetch_array($hasil)):
                            $no++;
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($data["tanggal_transaksi"])); ?></td>
                            <td><?php echo $data['kode_transaksi']; ?></td>
                            <td><?php echo $data['nama_penyewa']; ?></td>
                            <td><?php echo $data['identitas']; ?></td>
                            <td>Rp.  <?php echo number_format(total_biaya($data['kode_transaksi']),0,',','.'); ?></td>
                            <td>Rp. <?php echo number_format(total_pembayaran($data['kode_transaksi']),0,',','.'); ?></td>
                            <td><?php echo status_pembayaran($data['kode_transaksi']); ?></td>
                            <td>
                                <a href="index.php?page=detail-transaksi&id_transaksi=<?php echo $data['id_transaksi']; ?>" class="btn btn-success btn-circle"><i class="fas fa-mouse-pointer"></i></a>
                                <?php if ($_SESSION["level"]=="Super Admin"): ?>
                                <a href="transaksi/hapus-transaksi.php?kode_transaksi=<?php echo $data['kode_transaksi']; ?>" class="btn-hapus-transaksi btn btn-danger btn-circle" ><i class="fas fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <!-- bagian akhir (penutup) while -->
                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-sm">
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

<script>

   // fungsi hapus transaksi
   $('.btn-hapus-transaksi').on('click',function(){
        konfirmasi=confirm("Yakin ingin data transaksi ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>