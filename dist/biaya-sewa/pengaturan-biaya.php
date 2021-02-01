<script>
    $('title').text('Pengatuan Biaya Sewa');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Pengaturan Biaya Sewa</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengaturan Biaya Sewa</li>
        </ol>
        <?php
            if (isset($_GET['edit'])) {
            //Mengecek nilai variabel edit 
            if ($_GET['edit']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Biaya sewa telah diedit!</div>";
            }else if ($_GET['edit']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Biaya sewa gagal diedit!</div>";
            }    
            }
            if (isset($_GET['hapus'])) {
            //Mengecek notifikasi hapus
            if ($_GET['hapus']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Biaya sewa berhasil dihapus!</div>";
            }else if ($_GET['hapus']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Biaya sewa gagal dihapus!</div>";
            }    
            }
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <!-- rows -->
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div>
                                <?php
                                    include '../config/database.php';
                                    $kode_mobil=str_replace(' ', '',$_GET['kode_mobil']);
                                    $query = mysqli_query($kon, "SELECT * FROM mobil where kode_mobil='$kode_mobil' or nomor_polisi='$kode_mobil' limit 1");
                                    $data = mysqli_fetch_array($query);
                                    
                                    $id_mobil=$data['id_mobil'];
                                    $nama_mobil=$data['nama_mobil'];
                                    $warna=$data['warna'];
                                    $tahun=$data['tahun_produksi'];
                                    $gambar_mobil=$data['gambar_mobil'];
                                    $jumlah = mysqli_num_rows($query);

                                    //Mengecek apakah kode yang dimasukan apakah sudah benar
                                    if ($jumlah<1){
                                        echo "<script> $('#info').show(); </script>";
                                        echo "<div class='alert alert-danger'><strong>Berhasil!</strong> Tidak Tersedia</div>";
                                        
                                    }else {
                                        $query = mysqli_query($kon, "SELECT * FROM biaya_sewa where id_mobil='$id_mobil'");
                                        $cek = mysqli_num_rows($query);

                                        //Mengecek apakah biaya sewa sewa mobil sudah ditambahkan atau belum
                                        if ($cek<1){
                                            echo "<p class='text'><strong>$nama_mobil, $warna tahun $tahun </strong></p>";

                                        ?>
                                        <img src="../dist/mobil/gambar/<?php echo $gambar_mobil;?>" class="rounded" width="100%" alt="Cinque Terre">

                                        <?php 
                                        }else {
                                            echo "<script> document.getElementById('simpan_pengaturan_sewa').disabled = true; </script>";
                                       
                                            echo "<div class='alert alert-warning'><strong>Berhasil!</strong> Biaya sewa telah diatur</div>";
                                        }
                                    }    
                                ?>
                            </div>
                        </div>                 
                    </div>
                    <div class="col-sm-9">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Form Pengaturan</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <form method="post" action="biaya-sewa/simpan.php">
                                    <div class="row">
                        
                                        <div class="form-group">
                                            <input name="id_mobil" value="<?php echo $id_mobil; ?>" type="hidden"  class="form-control">
                                        </div>
                   
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Biaya Sewa Per Jam:</label>
                                                <input name="biaya_sewa" id="biaya_sewa" type="number" placeholder="Masukan biaya sewa per jam" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <div id="info_biaya_sewa" class='font-weight-bold'></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Biaya Supir Per Jam:</label>
                                                <input name="biaya_supir" id="biaya_supir" type="number" placeholder="Masukan biaya supir per jam" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <div id="info_biaya_supir" class='font-weight-bold'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Biaya BBM (Sekali jalan):</label>
                                                <input name="biaya_bbm" id="biaya_bbm" type="number" placeholder="Masukan biaya BBM" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <div id="info_biaya_bbm" class='font-weight-bold'></div>
                                            </div>
                                            <div class="form-group">
                                                <button  type="submit" name="simpan_pengaturan_sewa" id="simpan_pengaturan_sewa"   class="btn btn-success"><span class="text"><i class="fas fa fa-cogs fa-sm"></i> Simpan Pengaturan</span></button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <table class="table table-dark">
                                                <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center">Estimasi Biaya Per Hari</td>
                                                </tr>
                                                <tr>
                                                    <td>Biaya Sewa Mobil</td>
                                                    <td><span id="biaya_sewa_harian"> </span></td>
                                            
                                                </tr>
                                                <tr>
                                                    <td>Biaya Supir</td>
                                                    <td><span id="biaya_supir_harian"> </span></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
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
<script>

function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }

    $('#biaya_sewa').bind('keyup', function () {
        biaya_sewa();

    }); 

    $('#biaya_supir').bind('keyup', function () {
        biaya_supir();
    }); 
    $('#biaya_bbm').bind('keyup', function () {
        biaya_bbm();
    });


    function biaya_sewa(){
        var biaya_sewa=$("#biaya_sewa").val();
        var biaya_sewa_harian=biaya_sewa*24;

        $("#info_biaya_sewa").text('Rp.'+format_rupiah(biaya_sewa)); 
        $("#biaya_sewa_harian").text('Rp.'+format_rupiah(biaya_sewa_harian)); 
    }

    function biaya_supir(){
        var biaya_supir=$("#biaya_supir").val();
        var biaya_supir_harian=biaya_supir*24;

        $("#info_biaya_supir").text('Rp.'+format_rupiah(biaya_supir)); 
        $("#biaya_supir_harian").text('Rp.'+format_rupiah(biaya_supir_harian));    
    }

    function biaya_bbm(){
        var biaya_bbm=$("#biaya_bbm").val();
        $("#info_biaya_bbm").text('Rp.'+format_rupiah(biaya_bbm));   
    }
</script>