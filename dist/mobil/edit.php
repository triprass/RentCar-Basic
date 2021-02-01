<?php
session_start();
if (isset($_POST['simpan_edit'])) {

    include '../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_mobil=input($_POST["id_mobil"]);
    $kode_mobil=input($_POST["kode_mobil"]);
    $nama_mobil=input($_POST["nama_mobil"]);
    $warna=input($_POST["warna"]);
    $merek=input($_POST["merek"]);
    $jumlah_kursi=input($_POST["jumlah_kursi"]);
    $tahun_produksi=input($_POST["tahun_produksi"]);
    $nomor_polisi=input($_POST["nomor_polisi"]);

    $gambar_lama=$_POST['gambar_lama'];
 
    $gambar_baru = $_FILES['gambar_baru']['name'];
    $ekstensi_diperbolehkan	= array('png','jpg');
    $x = explode('.', $gambar_baru);
    $ekstensi = strtolower(end($x));
    $ukuran	= $_FILES['gambar_baru']['size'];
    $file_tmp = $_FILES['gambar_baru']['tmp_name'];

    
    if (!empty($gambar_baru)){
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if ($ukuran < 2044070){

                //Mengupload logo baru
                move_uploaded_file($file_tmp, 'gambar/'.$gambar_baru);
                //menghapus logo lama
                unlink("gambar/".$gambar_lama);

                $sql="update mobil set
                nama_mobil='$nama_mobil',
                id_merek='$merek',
                warna='$warna',
                jumlah_kursi='$jumlah_kursi',
                tahun_produksi='$tahun_produksi',
                nomor_polisi='$nomor_polisi',
                gambar_mobil='$gambar_baru'
                where id_mobil=$id_mobil";
            }
        }
    }else {
        $sql="update mobil set
        nama_mobil='$nama_mobil',
        id_merek='$merek',
        warna='$warna',
        jumlah_kursi='$jumlah_kursi',
        tahun_produksi='$tahun_produksi',
        nomor_polisi='$nomor_polisi'
        where id_mobil=$id_mobil";
    }

    //Mengeksekusi atau menjalankan query diatas
    $edit_mobil=mysqli_query($kon,$sql);

    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Edit mobil #$kode_mobil ";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");


    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($edit_mobil and $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=mobil&edit=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=mobil&edit=gagal");

    }

}

    $id_mobil=$_POST["id_mobil"];
    // mengambil data mobil dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM mobil where id_mobil=$id_mobil");
    $data = mysqli_fetch_array($query); 

    $kode_mobil=$data['kode_mobil'];
    $nama_mobil=$data['nama_mobil'];
    $warna=$data['warna'];
    $id_merek=$data['id_merek'];
    $jumlah_kursi=$data['jumlah_kursi'];
    $tahun_produksi=$data['tahun_produksi'];
    $nomor_polisi=$data['nomor_polisi'];
    $gambar_mobil=$data['gambar_mobil'];

?>
<form action="mobil/edit.php"  method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Nama Mobil:</label>
                <input name="nama_mobil" value="<?php echo $nama_mobil; ?>" type="text" class="form-control" placeholder="Masukan nama mobil" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kode_mobil; ?></h3>
                <input name="kode_mobil" value="<?php echo $kode_mobil; ?>" type="hidden" class="form-control">
                <input name="id_mobil" value="<?php echo $id_mobil; ?>" type="hidden" class="form-control">
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
                   $list_warna=array("Hitam", "Merah", "Putih", "Abu-abu","Hijau","Kuning","Biru","Orange");
                   $jumlah = count($list_warna);
                   for($i = 0; $i < $jumlah ; $i++) {
                       ?>
                      <option <?php if ($warna==$list_warna[$i]) echo "selected";?> value="<?php echo $list_warna[$i];?>"><?php echo $list_warna[$i];?></option>
                      <?php
                   }
                ?>
                </select>
            </div>
        </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Merek Mobil:</label>
            <select name="merek" class="form-control">
            <!-- Menampilkan daftar merek_mobil di dalam select list -->
            <?php
                
                $sql="select * from merek_mobil order by id_merek asc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                if ($id_merek==0) echo "<option value='0'>-</option>";
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
                <option  <?php if ($id_merek==$data['id_merek']) echo "selected"; ?> value="<?php echo $data['id_merek']; ?>"><?php echo $data['merek']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Jumlah Kursi:</label>
            <input name="jumlah_kursi" value="<?php echo $jumlah_kursi; ?>" type="number" class="form-control" placeholder="Masukan jumlah kursi" required>
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
                        if ($tahun_produksi==$i){
                            echo "<option value='$i' selected >$i</option>";
                        }else {
                            echo "<option value='$i'>$i</option>";
                        }
                    endfor;
                ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nomor Polisi:</label>
                <input name="nomor_polisi" value="<?php echo $nomor_polisi; ?>" type="text" class="form-control" placeholder="Masukan nomor polisi" required>
            </div>
        </div>
    </div>

    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
        <label>Gambar Lama:</label>
            <img src="../dist/mobil/gambar/<?php echo $gambar_mobil;?>" class="rounded" width="70%" alt="Cinque Terre">
            <input type="hidden" name="gambar_lama" value="<?php echo $gambar_mobil;?>" class="form-control" />
        </div>
        <div class="col-sm-6">
            <div id="msg"></div>
            <label>Gambar Baru:</label>
            <input type="file" name="gambar_baru" class="file" >
                <div class="input-group my-3">
                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                    <div class="input-group-append">
                            <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                    </div>
                </div>
            <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">
        </div>
    </div>
    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="simpan_edit" class="btn btn-warning">Update</button>
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
