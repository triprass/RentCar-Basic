<?php
session_start();
if (isset($_POST['edit_penyewa'])) {
    //Include file koneksi, untuk koneksikan ke database
    include '../../../config/database.php';

    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");
    
    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_transaksi=input($_POST["id_transaksi"]);
    $nama_penyewa=input($_POST["nama_penyewa"]);
    $no_telp=input($_POST["no_telp"]);
    $alamat=input($_POST["alamat"]);
    $identitas=input($_POST["identitas"]);

    $foto_saat_ini=$_POST['foto_saat_ini'];
    $foto_baru = $_FILES['foto_baru']['name'];
    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $x = explode('.', $foto_baru);
    $ekstensi = strtolower(end($x));
    $ukuran	= $_FILES['foto_baru']['size'];
    $file_tmp = $_FILES['foto_baru']['tmp_name'];



    if (!empty($foto_baru)){
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            //Mengupload foto baru
            move_uploaded_file($file_tmp, '../foto/'.$foto_baru);

            //Menghapus foto lama, foto yang dihapus selain foto default
            if ($foto_saat_ini!='foto_default.png'){
                unlink("foto/".$foto_saat_ini);
            }
            
            $sql="update transaksi set
            nama_penyewa='$nama_penyewa',
            no_telp='$no_telp',
            alamat='$alamat',
            identitas='$identitas',
            foto_identitas='$foto_baru'
            where id_transaksi=$id_transaksi";
        }
    }else {
        $sql="update transaksi set
        nama_penyewa='$nama_penyewa',
        no_telp='$no_telp',
        alamat='$alamat',
        identitas='$identitas'
        where id_transaksi=$id_transaksi";
    }

    //Mengeksekusi atau menjalankan query 
    $edit_penyewa=mysqli_query($kon,$sql);

    //Menyimpan aktivitas
    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Edit Data Penyewa - ID Transaksi #$id_transaksi ";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");

    
    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($edit_penyewa and $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&edit-penyewa=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../../dist/index.php?page=detail-transaksi&id_transaksi=$id_transaksi&edit-penyewa=gagal");

    }
    
}
?>

<?php
    //Mengambil  id_transaksi
    $id_transaksi=$_POST["id_transaksi"];
    //Koneksi database
    include '../../../config/database.php';
    // mengambil data transaksi dengan kode paling besar
    $query = mysqli_query($kon, "SELECT * FROM transaksi where id_transaksi=$id_transaksi");
    $data = mysqli_fetch_array($query); 



?>
<form action="transaksi/detail-transaksi/penyewa-edit.php" method="post" enctype="multipart/form-data">
<div class="form-group">
        <input name="id_transaksi" value="<?php echo  $data['id_transaksi']; ?>" type="hidden" class="form-control">
    </div>
<div class="form-group">
    <label>Nama Penyewa:</label>
    <input type="text" class="form-control" value="<?php echo $data['nama_penyewa'];?>" name="nama_penyewa" required>
</div>
<div class="form-group">
    <label>No Telp:</label>
    <input type="text" class="form-control" value="<?php echo $data['no_telp'];?>"  name="no_telp" required>
</div>
<div class="form-group">
    <label for="comment">Alamat:</label>
    <textarea class="form-control" rows="2" name="alamat"><?php echo $data['alamat'];?></textarea>
</div>
<div class="form-group">
    <label for="Identitas">Identitas:</label>
    <select name="identitas" id="Identitas" class="form-control">
    <?php
        $daftar_identitas = array("KTP","SIM A", "Lainnya");
        for ($i=0;$i<3;$i++):
    ?>
        <option <?php if ($daftar_identitas[$i]==$data['identitas']) echo "selected"; ?> value="<?php echo $daftar_identitas[$i];?>"><?php echo $daftar_identitas[$i];?></option>
    <?php endfor; ?>
    </select>
</div>

<div class="form-group">
    <label>Foto Identitas: (Abaikan jika tidak ingin mengganti)</label><br>
  
    <input type="hidden" name="foto_saat_ini" value="<?php echo $data['foto_identitas'];?>" class="form-control" />
</div>

<div class="form-group">
    <div id="msg"></div>
    <input type="file" name="foto_baru" class="file" >
        <div class="input-group my-3">
            <input type="text" class="form-control" disabled placeholder="Upload Identitas" id="file">
            <div class="input-group-append">
                    <button type="button" id="pilih_identitas" class="browse btn btn-dark">Pilih</button>
            </div>
        </div>
    <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
</div>

<button type="submit" name="edit_penyewa" class="btn btn-dark" >Update Penyewa</button>
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>

<script>
    $(document).on("click", "#pilih_identitas", function() {
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

