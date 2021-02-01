<script>
    $('title').text('Data Mobil');
</script>
<?php
    if ($_SESSION["level"]!="Super Admin"):
        echo"<div class='alert alert-danger'>Anda tidak punya hak akses</div>";
        exit;
    endif;
?>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Mobil</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Mobil</li>
        </ol>

        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah Mobil
            if (isset($_GET['add'])) {
                //Mengecek nilai variabel add yang telah di enskripsi dengan method md5()
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> data mobil telah ditambah!</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data mobil gagal ditambahkan!</div>";
                }else if  ($_GET['add']=='format_gambar_tidak_sesuai'){
                    echo"<div class='alert alert-warning'><strong>Gagal!</strong> Format gambar tidak sesuai!</div>";
                }   
            }

            if (isset($_GET['edit'])) {
            //Mengecek nilai variabel edit yang telah di enskripsi dengan method md5()
            if ($_GET['edit']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data mobil telah diupdate!</div>";
            }else if ($_GET['edit']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data mobil gagal diupdate!</div>";
            }    
            }
            if (isset($_GET['hapus'])) {
            //Mengecek notifikasi hapus
            if ($_GET['hapus']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data mobil telah dihapus!</div>";
            }else if ($_GET['hapus']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data mobil gagal dihapus!</div>";
            }    
            }
        ?>

        <div class="card mb-4">
            <div class="card-header">
                <button type="button" id="btn-tambah-mobil" class="btn-tambah-mobil btn btn-primary"><span class="text"><i class="fas fa-car fa-sm"></i> Tambah Mobil</span></button>
                <button type="button" id="btn-tambah-merek" class="btn-tambah-merek btn btn-primary"><span class="text"><i class="fas fa-car fa-sm"></i> Tambah Merek</span></button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-columns">
                            <?php         
                            // include database
                            include '../config/database.php';
                            // perintah sql untuk menampilkan daftar pengguna yang berelasi dengan tabel kategori pengguna
                            $sql="select * from merek_mobil";
                            $hasil=mysqli_query($kon,$sql);
                            $no=0;
                            //Menampilkan data dengan perulangan while
                            while ($data = mysqli_fetch_array($hasil)):
                            $no++;
                            ?>
                            <div class="card bg-basic"  style="width: 12rem;">
                            <a href="#" class="hapus_merek" id_merek="<?php echo $data['id_merek'];?>"  merek="<?php echo $data['merek'];?>" gambar="<?php echo $data['gambar_merek']; ?>"><h6 class="text-danger text-center"><small>Hapus</small></h6></a>
                            <img class="card-img-top" src="../dist/mobil/merek/gambar/<?php echo $data['gambar_merek'];?>"  alt="Card image cap">
                                <div class="card-body text-center">
                            
                                <button type="button" id_merek="<?php echo $data['id_merek'];?>" merek="<?php echo $data['merek'];?>"  class="merek btn btn-light"><?php echo $data['merek'];?></button>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="tampil_mobil">
                    <!-- Daftar mobil akan ditampilkan disini -->
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

    // tampil daftar mobil
    $('.merek').on('click',function(){

        var id_merek = $(this).attr("id_merek");
       
        $.ajax({
        url: 'mobil/tampil-mobil.php',
        method: 'post',
        data: {id_merek:id_merek},
        success:function(data){
            $('#tampil_mobil').html(data);  
        }
        });
    });

    $('#btn-tambah-mobil').on('click',function(){
        
        $.ajax({
            url: 'mobil/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Mobil';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


   // fungsi tambah merek
    $('#btn-tambah-merek').on('click',function(){
        
        $.ajax({
            url: 'mobil/merek/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Merek Mobil';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    $('.hapus_merek').on('click',function(){
        var id_merek = $(this).attr("id_merek");
        var merek = $(this).attr("merek");
        var gambar = $(this).attr("gambar");

        konfirmasi=confirm("Semua mobil dengan merek "+merek+" akan dihapus! Yakin ingin menghapus?")

        if (konfirmasi){
            $.ajax({
                url: 'mobil/merek/hapus.php',
                method: 'post',
                data: {id_merek:id_merek,gambar:gambar},
                success:function(data){
                    window.location.href = 'index.php?page=mobil&hapus=berhasil';
                }
            });
        }
    });

</script>