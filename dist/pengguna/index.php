<script>
    $('title').text('Data Pengguna');
</script>

<?php
    $id_pengguna= $_SESSION["id_pengguna"];

    if ($_SESSION["level"]!="Super Admin"):
        echo"<div class='alert alert-danger'>Anda tidak punya hak akses</div>";
        exit;
    endif;
?>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Pengguna</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Pengguna</li>
        </ol>

        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah pengguna
            if (isset($_GET['add'])) {
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> data pengguna telah ditambah!</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengguna gagal ditambahkan!</div>";
                }    
            }

            if (isset($_GET['edit'])) {
            if ($_GET['edit']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data pengguna telah diupdate!</div>";
            }else if ($_GET['edit']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengguna gagal diupdate!</div>";
            }    
            }
            if (isset($_GET['hapus'])) {
            if ($_GET['hapus']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data pengguna telah dihapus!</div>";
            }else if ($_GET['hapus']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengguna gagal dihapus!</div>";
            }    
            }
        ?>

        <div class="card mb-4">
          <div class="card-header py-3">
            <!-- Tombol tambah pengguna -->
            <button  class="btn-tambah btn btn-dark btn-icon-split"><span class="text">Tambah</span></button>
          </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode</th>
                          <th width="10%">Foto</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>No Telp</th>
                          <th>Level</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              // include database
                              include '../config/database.php';
                              // perintah sql untuk menampilkan daftar pengguna yang berelasi dengan tabel kategori pengguna
                              $sql="select * from pengguna order by id_pengguna desc";
                              $hasil=mysqli_query($kon,$sql);
                              $no=0;
                              //Menampilkan data dengan perulangan while
                              while ($data = mysqli_fetch_array($hasil)):
                              $no++;
                          ?>
                          <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo $data['kode_pengguna']; ?></td>
                              <td> <img src="pengguna/foto/<?php echo $data['foto'];?>" width="90%" class="img-thumbnail"></td>
                              <td><?php echo $data['nama_pengguna']; ?></td>
                              <td><?php echo $data['email']; ?></td>
                              <td><?php echo $data['no_telp']; ?></td>
                              <td><?php echo $data['level']; ?></td>
                              <td><?php echo $data['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                              <td>
                                  <button class="btn-edit btn btn-warning btn-circle" id_pengguna="<?php echo $data['id_pengguna']; ?>" kode_pengguna="<?php echo $data['kode_pengguna']; ?>" ><i class="fas fa-edit"></i></button>
                                  <button class="btn-hapus btn btn-danger btn-circle"  id_pengguna="<?php echo $data['id_pengguna']; ?>" kode_pengguna="<?php echo $data['kode_pengguna']; ?>" level="<?php echo $data['level']; ?>" foto="<?php echo $data['foto']; ?>" ><i class="fas fa-trash"></i></button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div id="tampil_data">
                 <!-- Data akan di load menggunakan AJAX -->                   
            </div>  
        </div>
  
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>

<script>

    // Tambah pengguna
    $('.btn-tambah').on('click',function(){
        var level = $(this).attr("level");
        $.ajax({
            url: 'pengguna/tambah-pengguna.php',
            method: 'post',
            data: {level:level},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah pengguna';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi edit pengguna
    $('.btn-edit').on('click',function(){

        var id_pengguna = $(this).attr("id_pengguna");
        var kode_pengguna = $(this).attr("kode_pengguna");
        $.ajax({
            url: 'pengguna/edit-pengguna.php',
            method: 'post',
            data: {id_pengguna:id_pengguna},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit pengguna #'+kode_pengguna;
            }
        });
            // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus pengguna
    $('.btn-hapus').on('click',function(){

        var id_pengguna = $(this).attr("id_pengguna");
        var kode_pengguna = $(this).attr("kode_pengguna");
        var level = $(this).attr("level");
        $.ajax({
            url: 'pengguna/hapus-pengguna.php',
            method: 'post',
            data: {id_pengguna:id_pengguna,kode_pengguna:kode_pengguna,level:level},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Hapus pengguna #'+kode_pengguna;
            }
        });
            // Membuka modal
        $('#modal').modal('show');
    });
</script>

