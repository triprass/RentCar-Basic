<?php
session_start();
      if (isset($_POST['simpan_hapus'])) {

        include '../../config/database.php';

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_pengguna=input($_POST["id_pengguna"]);
        $level=input($_POST["level"]);
        $foto=input($_POST["foto"]);

        $sql="delete from pengguna where id_pengguna=$id_pengguna";

        //Mengeksekusi  query diatas
        $hapus_pengguna=mysqli_query($kon,$sql);

        //Menghapus file foto jika foto selain foto default
        if ($foto!='pengguna_default.png'){
            unlink("foto/".$foto);
        }

        //Menyimpan aktivitas
        $id_pengguna=$_SESSION["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Hapus pengguna ID #$id_pengguna";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");
    
        
        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hapus_pengguna and $simpan_aktivitas) {
            header("Location:../../dist/index.php?page=pengguna&hapus=berhasil");
        }
        else {
            header("Location:../../dist/index.php?page=pengguna&hapus=gagal");
        }
    }
?>
<form action="pengguna/hapus-pengguna.php" method="post">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                    <h5>Apakah anda yakin ingin menghapus pengguna ini?</h5>
            </div>
        </div>
    </div>
    <input type="hidden" name="id_pengguna" value="<?php echo $_POST["id_pengguna"]; ?>" />
    <input type="hidden" name="level" value="<?php echo $_POST["level"]; ?>" />
    <input type="hidden" name="foto" value="<?php echo $_POST["foto"]; ?>" />
    <button type="submit" name="simpan_hapus" class="btn btn-primary">Hapus</button>
</form>

