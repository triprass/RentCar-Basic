<?php
session_start();
    if (isset($_POST['tambah_merek'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            mysqli_query($kon,"START TRANSACTION");

            $kode=input($_POST["kode"]);
            $merek=input($_POST["merek"]);
            $keterangan=input($_POST["keterangan"]);
            $tanggal=date("Y-m-d");

            $ekstensi_diperbolehkan	= array('png','jpg');
            $gambar_merek = $_FILES['gambar_merek']['name'];
            $x = explode('.', $gambar_merek);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambar_merek']['size'];
            $file_tmp = $_FILES['gambar_merek']['tmp_name'];	

            if (!empty($gambar_merek)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    if($ukuran < 1044070){	
                        //Mengupload gambar
                        move_uploaded_file($file_tmp, 'gambar/'.$gambar_merek);

                        $sql="insert into merek_mobil (kode_merek,merek,gambar_merek,keterangan) values
                        ('$kode','$merek','$gambar_merek','$keterangan')";
                    }
                }else {
                    header("Location:../../../dist/index.php?page=mobil&add=format_gambar_tidak_sesuai");
                }
            }else {
                $gambar_merek="gambar_default.png";
                $sql="insert into merek_mobil (kode_merek,merek,gambar_merek,keterangan) values
                ('$kode','$merek','$gambar_merek','$keterangan')";
            }

            //Mengeksekusi/menjalankan query 
            $simpan_merek=mysqli_query($kon,$sql);

            $id_pengguna=$_SESSION["id_pengguna"];
            $waktu=date("Y-m-d h:i:s");
            $log_aktivitas="Tambah Merek Mobil #$kode";
            $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");
    
    
            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_merek and $simpan_aktivitas) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../../dist/index.php?page=mobil&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../../dist/index.php?page=mobil&add=gagal");
            }

            
        }

    }
      // mengambil data produk dengan kode paling besar
      include '../../../config/database.php';
      $query = mysqli_query($kon, "SELECT max(id_merek) as kodeTerbesar FROM merek_mobil");
      $data = mysqli_fetch_array($query);
      $id_merek_mobil = $data['kodeTerbesar'];
      $id_merek_mobil++;
      $huruf = "A";
      $kodeMerek = $huruf . sprintf("%04s", $id_merek_mobil);

?>
<form action="mobil/merek/tambah.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Merek:</label>
                <input name="merek" type="text" class="form-control" placeholder="Masukan Merek Mobil" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kodeMerek; ?></h3>
                <input name="kode" value="<?php echo $kodeMerek; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>

    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Logo/Gambar:</label>
                <input type="file" name="gambar_merek" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                        <div class="input-group-append">
                                <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                        </div>
                    </div>
                <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
            </div>
        </div>
    </div>

    <!-- rows -->   
    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" class="form-control" rows="4" ></textarea>
        </div>
    </div>
    </div>

        <button type="submit" name="tambah_merek" class="btn btn-success">Tambah</button>
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>
    $(document).on("click", "#pilih_gambar", function() {
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
