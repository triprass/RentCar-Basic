<?php
session_start();
    if (isset($_POST['simpan_tambah'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
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
            $nama_mobil=input($_POST["nama_mobil"]);
            $warna=input($_POST["warna"]);
            $merek=input($_POST["merek"]);
            $jumlah_kursi=input($_POST["jumlah_kursi"]);
            $tahun_produksi=input($_POST["tahun_produksi"]);
            $nomor_polisi=input($_POST["nomor_polisi"]);
            $tanggal=date("Y-m-d");

            $ekstensi_diperbolehkan	= array('png','jpg');
            $gambar_mobil = $_FILES['gambar_mobil']['name'];
            $x = explode('.', $gambar_mobil);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambar_mobil']['size'];
            $file_tmp = $_FILES['gambar_mobil']['tmp_name'];	

            if (!empty($gambar_mobil)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){

                    if($ukuran < 1044070){	
                        //Mengupload gambar
                        move_uploaded_file($file_tmp, 'gambar/'.$gambar_mobil);
                    }
                }
            }else {
                $gambar_mobil="gambar_default.png";
            }

            $sql="insert into mobil (kode_mobil,nama_mobil,id_merek,warna,jumlah_kursi,tahun_produksi,nomor_polisi,gambar_mobil) values
            ('$kode','$nama_mobil','$merek','$warna','$jumlah_kursi','$tahun_produksi','$nomor_polisi','$gambar_mobil')";
            //Mengeksekusi/menjalankan query 
            $simpan_mobil=mysqli_query($kon,$sql);

            $id_pengguna=$_SESSION["id_pengguna"];
            $waktu=date("Y-m-d h:i:s");
            $log_aktivitas="Tambah Mobil #$kode ";
            $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");
    
            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_mobil and $simpan_aktivitas) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../dist/index.php?page=mobil&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../dist/index.php?page=mobil&add=gagal");
            }
        }
    }
      // mengambil data mobil dengan kode paling besar
      include '../../config/database.php';
      $query = mysqli_query($kon, "SELECT max(id_mobil) as kodeTerbesar FROM mobil");
      $data = mysqli_fetch_array($query);
      $id_mobil = $data['kodeTerbesar'];
      $id_mobil++;
      $huruf = "M";
      $kodeMobil = $huruf . sprintf("%04s", $id_mobil);

?>
<form action="mobil/tambah.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Nama Mobil:</label>
                <input name="nama_mobil" type="text" class="form-control" placeholder="Masukan nama" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kodeMobil; ?></h3>
                <input name="kode" value="<?php echo $kodeMobil; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>

    <!-- rows -->
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Warna:</label>
                <select name="warna" class="form-control">
                <?php
                   $warna=array("Hitam", "Merah", "Putih", "Abu-abu","Hijau","Kuning","Biru","Orange");
                   $jumlah = count($warna);
                   for($i = 0; $i < $jumlah ; $i++) {
                       echo "<option value='".$warna[$i]."'>".$warna[$i]."</option>";
                      
                   }
                ?>
                </select>
            </div>
        </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Merek Mobil:</label>
            <select name="merek" class="form-control">
            <?php
                 
                 $sql="select * from merek_mobil order by id_merek asc";
                 $hasil=mysqli_query($kon,$sql);
                 while ($data = mysqli_fetch_array($hasil)):
             ?>
                 <option value="<?php echo $data['id_merek']; ?>"><?php echo $data['merek']; ?></option>
                 <?php endwhile; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Jumlah Kursi:</label>
            <input name="jumlah_kursi" type="number" class="form-control" placeholder="Masukan jumlah stok" required>
        </div>
    </div>
    </div>
    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tahun Produksi:</label>
                <select name="tahun_produksi" class="form-control">
                <?php
                    $thn=date('Y', strtotime('-20 years'));
                    for ($i=date('Y');$i>=$thn;$i--):
                        echo "<option value='$i'>$i</option>";

                    endfor;
                ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nomor Polisi:</label>
                <input name="nomor_polisi" type="text" class="form-control" placeholder="Masukan harga jual" required>
            </div>
        </div>
    </div>
    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Logo Bank:</label>
                <input type="file" name="gambar_mobil" class="file" >
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

    <!-- rows -->   
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
             <button type="submit" name="simpan_tambah" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </div>

       
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
