<script>
    $('title').text('Dashboard');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Dashboard</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
             <?php 
                include '../config/database.php';
                $hari_ini=date('Y-m-d');
                // perintah sql untuk menampilkan pendapatan hari ini, jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                if ($_SESSION["level"]=="Admin"){
                    $id_pengguna=$_SESSION["id_pengguna"];
                    $sql="select SUM(total_biaya+denda) as transaksi_hari_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where date(tanggal_transaksi)='$hari_ini' and t.id_pengguna=$id_pengguna";

                }else {
                    $sql="select SUM(total_biaya+denda) as transaksi_hari_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where date(tanggal_transaksi)='$hari_ini'";
                }

                $hasil=mysqli_query($kon,$sql);
                $data = mysqli_fetch_array($hasil);       
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-dark text-uppercase mb-1">Pendapatan Hari ini</div>
                        <div class="h5 mb-0 font-weight-bold text-dark-800">Rp. <?php echo number_format($data['transaksi_hari_ini'],0,',','.');?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-dark-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php 
                $bulan_ini=date('m');
                $tahun_ini=date('Y');
                // perintah sql untuk menampilkan pendapatan bulan ini, jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                if ($_SESSION["level"]=="Admin"){
                    $id_pengguna=$_SESSION["id_pengguna"];
                    $sql="select SUM(total_biaya+denda) as transaksi_bulan_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where MONTH(tanggal_transaksi)='$bulan_ini' and YEAR(tanggal_transaksi)='$tahun_ini' and t.id_pengguna=$id_pengguna ";
                }else {
                    $sql="select SUM(total_biaya+denda) as transaksi_bulan_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where MONTH(tanggal_transaksi)='$bulan_ini' and YEAR(tanggal_transaksi)='$tahun_ini' ";
                }
                $hasil=mysqli_query($kon,$sql);
                $data = mysqli_fetch_array($hasil);       
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-dark text-uppercase mb-1">Pendapatan Bulan ini</div>
                        <div class="h5 mb-0 font-weight-bold text-dark-800">Rp. <?php echo number_format($data['transaksi_bulan_ini'],0,',','.');?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-dark-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php 
              
                $tahun_ini=date('Y');
                // perintah sql untuk menampilkan pendapatan tahun ini, jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                if ($_SESSION["level"]=="Admin"){
                    $id_pengguna=$_SESSION["id_pengguna"];
                    $sql="select SUM(total_biaya+denda) as transaksi_tahun_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where YEAR(tanggal_transaksi)='$tahun_ini' and t.id_pengguna=$id_pengguna ";
                }else {
                    $sql="select SUM(total_biaya+denda) as transaksi_tahun_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi where YEAR(tanggal_transaksi)='$tahun_ini' ";
                }
                $hasil=mysqli_query($kon,$sql);
                $data = mysqli_fetch_array($hasil);       
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-dark text-uppercase mb-1">Pendapatan Tahun ini</div>
                        <div class="h5 mb-0 font-weight-bold text-dark-800">Rp. <?php echo number_format($data['transaksi_tahun_ini'],0,',','.');?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-dark-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php 
                // perintah sql untuk menampilkan pendapatan selama ini, jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
                if ($_SESSION["level"]=="Admin"){
                    $id_pengguna=$_SESSION["id_pengguna"];
                    $sql="select SUM(total_biaya+denda) as transaksi_selama_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi and t.id_pengguna=$id_pengguna";
                }else {
                    $sql="select SUM(total_biaya+denda) as transaksi_selama_ini from transaksi t inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi";
                }
                $hasil=mysqli_query($kon,$sql);
                $data = mysqli_fetch_array($hasil);       
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs text-dark text-uppercase mb-1">Pendapatan Selama ini</div>
                        <div class="h5 mb-0 font-weight-bold text-dark-800">Rp. <?php echo number_format($data['transaksi_selama_ini'],0,',','.');?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-dark-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <select class="form-control form-control-sm" id="tahun">
                                    <option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
                                    <?php
                                    
                                        include '../config/database.php';
                                        $hasil=mysqli_query($kon,"select YEAR(tanggal_transaksi) as tahun from transaksi group by tahun order by tahun desc");
                                        while ($rows = mysqli_fetch_array($hasil)):
                                            if (date('Y')==$rows['tahun']) {
                                            continue;
                                            }else {
                                                echo "<option  value='".$rows['tahun']."'>".$rows['tahun']."</option>";
                                            }
                                        endwhile; 
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm" id="bulan">
                                    <?php
                                        $nama_bulan="";
                                        for($bulan = 1;$bulan <= 12;$bulan++){
                                            switch($bulan){
                                                case 1 : $nama_bulan='Januari';
                                                break;
                                                case 2 : $nama_bulan='Februari';
                                                break;
                                                case 3 : $nama_bulan='Maret';
                                                break;
                                                case 4 : $nama_bulan='April';
                                                break;
                                                case 5 : $nama_bulan='Mei';
                                                break;
                                                case 6 : $nama_bulan='Juni';
                                                break;
                                                case 7 : $nama_bulan='Juli';
                                                break;
                                                case 8 : $nama_bulan='Agustus';
                                                break;
                                                case 9 : $nama_bulan='September';
                                                break;
                                                case 10 : $nama_bulan='Oktober';
                                                break;
                                                case 11 : $nama_bulan='November';
                                                break;
                                                case 12 : $nama_bulan='Desember';
                                                break;
                                            }
                                            ?>
                                            <option  <?php if (date('m')==$bulan) echo "selected"; ?>  value="<?php echo $bulan; ?>" ><?php echo $nama_bulan; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tampil_grafik_transaksi_per_bulan">
                            <!-- Garfik transaksi per bulan di load menggunakan AJAX-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Jumlah Transaksi Berdasarkan Penyewaan Mobil
                    </div>
                    <div class="card-body">
                        <div id="tampil_grafik_transaksi_per_mobil">
                            <!-- Garfik transaksi berdasarkan mobil di load menggunakan AJAX-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
   
            </div>
            <div class="card-body">
                <div id="tampil_grafik_transaksi_per_hari">
                 <!-- Garfik transaksi per hari di load menggunakan AJAX-->
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    //Menampilkan transaksi per periode
    $(document).ready(function(){
        transaksi_per_bulan();
        transaksi_per_hari();
        transaksi_per_mobil();
    });

    //Menampilkan grafik transaksi per hari
    function transaksi_per_hari(tahun,bulan) {
        $.ajax({
            url: 'dashboard/transaksi_per_hari.php',
            method: 'POST',
            data:{tahun:tahun,bulan:bulan},
            success:function(data){
                $('#tampil_grafik_transaksi_per_hari').html(data);
            
            }
        }); 
    }
    //Menampilkan grafik transaksi per bulan
    function transaksi_per_bulan(tahun) {
        $.ajax({
            url: 'dashboard/transaksi_per_bulan.php',
            method: 'POST',
            data:{tahun:tahun},
            success:function(data){
                $('#tampil_grafik_transaksi_per_bulan').html(data);
              
            }
        }); 
    }

    //Menampilkan grafik transaksi berdasarkan mobil yang disewa
    function transaksi_per_mobil(tahun,bulan) {
        $.ajax({
            url: 'dashboard/transaksi_per_mobil.php',
            method: 'POST',
            data:{tahun:tahun,bulan:bulan},
            success:function(data){
                $('#tampil_grafik_transaksi_per_mobil').html(data);
            
            }
        }); 
    }

    //Event yang dijalankan saat tahun dipilih oleh user
    $('#tahun').on('change',function(){    
        var tahun=$("#tahun").val();
        var bulan=$("#bulan").val();
        transaksi_per_bulan(tahun);
        transaksi_per_hari(tahun,bulan);
        transaksi_per_mobil(tahun,bulan);
    });


    //Event yang dijalankan saat bulan dipilih oleh user
    $('#bulan').on('change',function(){  

        var tahun=$("#tahun").val();
        var bulan=$("#bulan").val();

        transaksi_per_hari(tahun,bulan);
        transaksi_per_mobil(tahun,bulan);
    });

</script>


