<?php
session_start();
    if (isset($_POST['simpan_profil'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        session_start();
        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_pengguna=$_POST["id_pengguna"];
        $nama=input($_POST["nama"]);
        $username=input($_POST["username_baru"]);
        $no_telp=input($_POST["no_telp"]);
        $email=input($_POST["email"]);
        $foto_saat_ini=$_POST['foto_saat_ini'];
        $foto_baru = $_FILES['foto_baru']['name'];
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
        $x = explode('.', $foto_baru);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['foto_baru']['size'];
        $file_tmp = $_FILES['foto_baru']['tmp_name'];

        $ambil_password=mysqli_query($kon,"select password from pengguna where id_pengguna=$id_pengguna limit 1");
        $data = mysqli_fetch_array($ambil_password);


        if ($data['password']==$_POST["password"]){
            $password=input($_POST["password"]);
        }else {
            $password=md5(input($_POST["password"]));
        }

        if (!empty($foto_baru)){
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                //Mengupload foto baru
                move_uploaded_file($file_tmp,'../pengguna/foto/'.$foto_baru);

                //Langsung mengganti nama dan foto yang telah disimpan di dalam session
                unset($_SESSION['nama_pengguna']);
                unset($_SESSION['foto']);
                $_SESSION["nama_pengguna"]=$nama;
                $_SESSION["foto"]=$foto_baru;

                //Menghapus foto lama, foto yang dihapus selain foto default
                if ($foto_saat_ini!='pengguna_default.png'){
                    unlink("../pengguna/foto/".$foto_saat_ini);
                }
                
                $sql="update pengguna set
                nama_pengguna='$nama',
                email='$email',
                no_telp='$no_telp',
                username='$username',
                password='$password',
                foto='$foto_baru'
                where id_pengguna=$id_pengguna";
            }
        }else {
            $sql="update pengguna set
            nama_pengguna='$nama',
            email='$email',
            no_telp='$no_telp',
            username='$username',
            password='$password'
            where id_pengguna=$id_pengguna";
        }

        //Mengeksekusi query 
        $update_pengguna=mysqli_query($kon,$sql);

        $id=$_SESSION['id_pengguna'];
        $waktu=date("Y-m-d h:i:s");
        $log_aktivitas="Edit Profil Pribadi";
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas','$id')");

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($update_pengguna and $simpan_aktivitas) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../dist/index.php?page=profil&add=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../dist/index.php?page=profil&add=gagal");
        }
        
    }
?>

