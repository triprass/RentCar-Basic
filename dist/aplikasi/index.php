<script>
    $('title').text('Pengaturan Aplikasi');
</script>
<?php
    if ($_SESSION["level"]!="Super Admin"):
        echo"<div class='alert alert-danger'>Anda tidak punya hak akses</div>";
        exit;
    endif;
?>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Pengaturan Aplikasi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengaturan Aplikasi</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Edit Profil Aplikasi</h6>
                            </div>
                            <?php 
                                include '../config/database.php';
                            
                                $hasil=mysqli_query($kon,"select * from profil_aplikasi order by nama_aplikasi desc limit 1");
                                $data = mysqli_fetch_array($hasil); 
                            ?>
                            <!-- Card Body -->
                            <div class="card-body">
                                <form action="aplikasi/edit.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" value="<?php echo $data['id'];?>" name="id">  
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Rental Mobil:</label>
                                        <input type="text" class="form-control" value="<?php echo $data['nama_aplikasi'];?>" name="nama" required>  
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat:</label>
                                        <input type="text" class="form-control" value="<?php echo $data['alamat'];?>" name="alamat">  
                                    </div>
                                    <div class="form-group">
                                        <label>No Telp:</label>
                                        <input type="text" class="form-control" value="<?php echo $data['no_telp'];?>" name="no_telp">  
                                    </div>
                                    <div class="form-group">
                                        <label>Website:</label>
                                        <input type="text" class="form-control" value="<?php echo $data['website'];?>" name="website">  
                                    </div>
                                    <div class="form-group">
                                        <div id="msg"></div>
                                        <label>Logo:</label>
                                        <input type="file" name="logo" class="file" >
                                            <div class="input-group my-3">
                                                <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                                                <div class="input-group-append">
                                                        <button type="button" id="pilih_logo" class="browse btn btn-dark">Pilih Logo</button>
                                                </div>
                                            </div>
                                        <img src="aplikasi/logo/<?php echo $data['logo'];?>" id="preview" width="70%" class="img-thumbnail">
                                        <input type="hidden" name="logo_sebelumnya" value="<?php echo $data['logo'];?>" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"name="ubah_aplikasi" >Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>

    $(document).on("click", "#pilih_logo", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });

</script>