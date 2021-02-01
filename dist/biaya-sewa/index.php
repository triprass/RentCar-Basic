<script>
    $('title').text('Daftar Biaya Sewa');
</script>
<?php
    if ($_SESSION["level"]!="Super Admin"):
        echo"<div class='alert alert-danger'>Anda tidak punya hak akses</div>";
        exit;
    endif;
?>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Daftar Biaya Sewa</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Biaya Sewa</li>
        </ol>
        <?php
            if (isset($_GET['add'])) {
                //Mengecek nilai variabel add 
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Biaya sewa telah ditambahkan</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Biaya sewa gagal ditambahkan</div>";
                }    
            }
            if (isset($_GET['edit'])) {
                //Mengecek nilai variabel edit 
                if ($_GET['edit']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Biaya sewa telah diedit</div>";
                }else if ($_GET['edit']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Biaya sewa gagal diedit</div>";
                }    
            }
            if (isset($_GET['hapus'])) {
                //Mengecek notifikasi hapus
                if ($_GET['hapus']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Biaya sewa berhasil dihapus</div>";
                }else if ($_GET['hapus']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Biaya sewa gagal dihapus</div>";
                }    
            }
        ?>

        <div id="pemberitahuan">
            <!-- pemberitahuan menggunakan ajax -->
        </div>
        <div class="card mb-4">
            <div class="card-body">
                
                    <!-- rows -->
                    <div class="row">
                            <div class="col-sm-3">
                                <form action="#" method="get">
                                <input name="page"  type="hidden" class="form-control" value="pengaturan-biaya">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input name="kode_mobil" id="kode_mobil" type="text" class="form-control" placeholder="Masukan kode mobil">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <button  type="submit" name="cari_mobil" class="btn btn-primary btn-block">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-group">
                                    <div id="tampil_mobil">
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                </div>
                                <div id="info">
                                    <?php
                                        include '../config/database.php';
                                        $query = "select id_mobil from mobil where id_mobil not in (select id_mobil from biaya_sewa)";
                                        $hasil = mysqli_query ($kon,$query);
                                        $jumlah = mysqli_num_rows($hasil);

                                        if ($jumlah<=0){
                                    ?>
                                    <div class="alert alert-primary">
                                        Semua mobil telah diatur biayanya.
                                    </div>
                                    <?php
                                    }else {
                                    ?>
                                    <div class="alert alert-info">
                                        Masih ada <?php echo $jumlah;?> mobil yang perlu diatur biaya sewanya.
                                    </div>
                                    <ul class="list-group">
                                        <?php
                                        $sql="select * from mobil where id_mobil not in (select id_mobil from biaya_sewa) order by id_mobil desc";
                                        $hasil=mysqli_query($kon,$sql);
                                        $no=0;
                                        //Menampilkan data dengan perulangan while
                                        while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <li class="list-group-item"><?php echo $data['kode_mobil'];?></li>
                                        <?php endwhile; ?>
                                    </ul>
                                    <?php } ?>
                                </div>                  
                            </div>
                            <div class="col-sm-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th width="17%">Gambar</th>
                                                <th>Nama Mobil</th>
                                                <th>Biaya Sewa</th>
                                                <th>Biaya Supir</th>
                                                <th>Biaya BBM</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            // include database
                                            include '../config/database.php';
                                            // perintah sql untuk menampilkan daftar mobil yang berelasi dengan tabel kategori mobil
                                            $sql="select * from mobil m inner join biaya_sewa p on m.id_mobil=p.id_mobil order by id_biaya_sewa desc";
                                            $hasil=mysqli_query($kon,$sql);
                                            $no=0;
                                            //Menampilkan data dengan perulangan while
                                            while ($data = mysqli_fetch_array($hasil)):
                                            $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $data['kode_mobil']; ?></td>
                                            <td><img src="../dist/mobil/gambar/<?php echo $data['gambar_mobil'];?>" class="rounded" width="100%" alt="Cinque Terre"></td>
                                            <td><?php echo $data['nama_mobil']; ?></td>
                                            <td>Rp. <?php echo number_format($data['biaya_sewa'],0,',','.'); ?></td>
                                            <td>Rp. <?php echo number_format($data['biaya_supir'],0,',','.'); ?></td>
                                            <td>Rp. <?php echo number_format($data['biaya_bbm'],0,',','.'); ?></td>
                                            <td>
                                                <button type="button" class="btn-edit btn btn-warning btn-circle"  id_biaya_sewa="<?php echo $data['id_biaya_sewa']; ?>" data-toggle="tooltip" title="Edit mobil" data-placement="top"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn-hapus btn btn-danger btn-circle"  id_mobil="<?php echo $data['id_mobil']; ?>"  data-toggle="tooltip" title="Hapus mobil" data-placement="top"><i class="fas fa-trash"></i></button>
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
        </div>
    </div>
</main>



<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

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
  $(document).ready(function(){

    $('.btn-edit').on('click',function(){
    
        var id_biaya_sewa = $(this).attr("id_biaya_sewa");
        $.ajax({
            url: 'biaya-sewa/edit.php',
            method: 'post',
            data: {id_biaya_sewa:id_biaya_sewa},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Biaya Sewa #'+id_biaya_sewa;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


            // fungsi edit mobil
    $('.btn-hapus').on('click',function(){

        var id_mobil = $(this).attr("id_mobil");

        $.ajax({
            url: 'biaya-sewa/hapus.php',
            method: 'post',
            data: {id_mobil:id_mobil},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Hapus Biaya Sewa mobil #'+id_mobil;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
});


</script>