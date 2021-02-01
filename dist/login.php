<?php
    $pesan="";

        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();

    include "../config/database.php";

    $username = input($_POST["username"]);
    $password = input(md5($_POST["password"]));

        $cek_pengguna = "select * from pengguna where username='".$username."' and password='".$password."' limit 1";
    $hasil_cek = mysqli_query ($kon,$cek_pengguna);
    $jumlah = mysqli_num_rows($hasil_cek);
    $row = mysqli_fetch_assoc($hasil_cek); 

    if ($jumlah>0){
    if ($row["status"]==1){
        $_SESSION["id_pengguna"]=$row["id_pengguna"];
        $_SESSION["kode_pengguna"]=$row["kode_pengguna"];
        $_SESSION["nama_pengguna"]=$row["nama_pengguna"];
        $_SESSION["username"]=$row["username"];
        $_SESSION["level"]=$row["level"];

        $id_pengguna=$row["id_pengguna"];
        $waktu=date("Y-m-d h:i:s");
        $log_aktifitas="Login";

        mysqli_query($kon,"insert into log_aktifitas (waktu,aktifitas,id_pengguna) values ('$waktu','$log_aktifitas',$id_pengguna)");

        header("Location:index.php?page=dashboard");

    }else {
        $pesan="<div class='alert alert-warning'><strong>Gagal!</strong> Status pengguna tidak aktif.</div>";
    }

        }else {
            $pesan="<div class='alert alert-danger'><strong>Error!</strong> Username dan password salah.</div>";
        }
    }
?>
<!DOCTYPE html>
<?php 
    include '../config/database.php';
    $hasil=mysqli_query($kon,"select * from profil_aplikasi order by nama_aplikasi desc limit 1");
    $data = mysqli_fetch_array($hasil); 
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $data['nama_aplikasi'];?></title>
        <link href="../src/templates/css/styles.css" rel="stylesheet" />
        <script src="../src/js/font-awesome/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">

                                     <div class="card-body">
                                        <center><img src="aplikasi/logo/<?php echo $data['logo'];?>" id="preview" width="35%"></center>
                                        <h3 class="text-center font-weight-bold my-4"><?php echo ucwords($data['nama_aplikasi']);?></h3>
                                    <?php 	if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
                                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" >Username</label>
                                                <input class="form-control py-4"  name="username" type="text" placeholder="Masukan Username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" >Password</label>
                                                <input class="form-control py-4" name="password" type="password" placeholder="Masukan Password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; <?php echo $data['nama_aplikasi'];?> <?php echo date('Y');?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="../src/js/jquery/jquery-3.5.1.min.js"></script>
        <script src="../src/plugin/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../src/js/scripts.js"></script>
    </body>
</html>
