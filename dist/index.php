<?php 
  session_start();
  if (!$_SESSION["id_pengguna"]){
        header("Location:login.php");
  }else {

    include '../config/database.php';
    $id_pengguna=$_SESSION["id_pengguna"];
    $username=$_SESSION["username"];

    $hasil=mysqli_query($kon,"select username from pengguna where id_pengguna=$id_pengguna");
    $data = mysqli_fetch_array($hasil); 
    $username_db=$data['username'];

    if ($username!=$username_db){
        session_unset();
        session_destroy();
        header("Location:login.php");
    }
  }

?>

<?php
  include '../config/database.php';
  $hasil=mysqli_query($kon,"select * from profil_aplikasi order by nama_aplikasi desc limit 1");
  $data = mysqli_fetch_array($hasil); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $data['nama_aplikasi'];?></title>
        <link href="../src/templates/css/styles.css" rel="stylesheet" />
        <link href="../src/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="../src/plugin/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="../src/js/font-awesome/all.min.js" crossorigin="anonymous"></script>
        <script src="../src/js/jquery/jquery-3.5.1.min.js"></script>
        <script src="../src/plugin/chart/Chart.js"></script>
      
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><?php  echo $data['nama_aplikasi'];?></a>
           
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="index.php?page=profil">Profil</a>
                        <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#logoutModal" >Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php?page=dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <?php if ($_SESSION["level"]=="Super Admin"): ?>
                            <a class="nav-link" href="index.php?page=mobil">
                                <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                                Data Mobil
                            </a>
                            <a class="nav-link" href="index.php?page=biaya-sewa">
                                <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
                                Biaya Sewa
                            </a>
                            <?php endif; ?>
                            
                            <a class="nav-link" href="index.php?page=transaksi">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                Laporan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page=laporan-penyewaan"><i class="fas fa-receipt"></i>  &nbsp; Penyewaan</a>
                                    <a class="nav-link" href="index.php?page=laporan-pendapatan"><i class="fas fa-hand-holding-usd"></i>  &nbsp; Pendapatan</a>
                                </nav>
                            </div>
                            <?php if ($_SESSION["level"]=="Super Admin"): ?>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaturan" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Pengaturan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePengaturan" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page=aplikasi"><i class="fas fa-bars"></i>  &nbsp; Aplikasi</a>
                                    <a class="nav-link" href="index.php?page=pengguna"><i class="fas fa-user"></i> &nbsp; Pengguna</a>
                                </nav>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Login Sebagai:</div>
                        <?php echo $_SESSION["nama_pengguna"]; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <?php 
          if(isset($_GET['page'])){
            $page = $_GET['page'];
        
            switch ($page) {
                case 'dashboard':
                    include "dashboard/index.php";
                    break;
                case 'mobil':
                    include "mobil/index.php";
                    break;
                case 'biaya-sewa':
                    include "biaya-sewa/index.php";
                    break;
                case 'pengaturan-biaya':
                    include "biaya-sewa/pengaturan-biaya.php";
                    break;
                case 'transaksi':
                    include "transaksi/index.php";
                    break;
                case 'tambah-transaksi':
                    include "transaksi/tambah-transaksi.php";
                    break;
                case 'checkout':
                    include "transaksi/transaksi-baru/checkout.php";
                    break;
                case 'detail-transaksi':
                    include "transaksi/detail-transaksi.php";
                    break;
                case 'laporan-penyewaan':
                    include "laporan/penyewaan/laporan-penyewaan.php";
                    break;
                case 'laporan-pendapatan':
                    include "laporan/pendapatan/laporan-pendapatan.php";
                    break;
                case 'pengguna':
                        include "pengguna/index.php";
                    break;
                case 'profil':
                    include "profil/index.php";
                break;
                case 'aplikasi':
                    include "aplikasi/index.php";
                break;
              default:
                echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                break;
            }
          }
      ?>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                        <?php 
                            include '../config/database.php';
                            $hasil=mysqli_query($kon,"select nama_aplikasi from profil_aplikasi order by nama_aplikasi desc limit 1");
                            $data = mysqli_fetch_array($hasil); 
                        ?>
                        <div class="text-muted">Copyright &copy; <?php echo $data['nama_aplikasi'];?> <?php echo date('Y');?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
       
        <script src="../src/plugin/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
          <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keluar Aplikasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin keluar?</div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
            </div>
        </div>
 
    </body>
</html>
