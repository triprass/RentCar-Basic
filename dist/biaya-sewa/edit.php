<?php
 if (isset($_POST['update_biaya_sewa'])) {
    session_start();
    include '../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id_biaya_sewa=$_POST["id_biaya_sewa"];
    $biaya_sewa=input($_POST["biaya_sewa"]);
    $biaya_supir=input($_POST["biaya_supir"]);
    $biaya_bbm=input($_POST["biaya_bbm"]);

    $sql="update biaya_sewa set
    biaya_sewa='$biaya_sewa',
    biaya_supir='$biaya_supir',
    biaya_bbm='$biaya_bbm'
    where id_biaya_sewa=$id_biaya_sewa";

    //Mengeksekusi atau menjalankan query diatas
    $edit_biaya_sewa=mysqli_query($kon,$sql);

    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Edit Biaya Sewa ID #$id_biaya_sewa ";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");
   
    if ($edit_biaya_sewa && $simpan_aktivitas) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=biaya-sewa&edit=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=biaya-sewa&edit=gagal");
    }
 }

?>

<?php
    $id_biaya_sewa=$_POST["id_biaya_sewa"];
    // mengambil data barang dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM biaya_sewa where id_biaya_sewa=$id_biaya_sewa");
    $data = mysqli_fetch_array($query); 

    $biaya_sewa=$data['biaya_sewa'];
    $biaya_supir=$data['biaya_supir'];
    $biaya_bbm=$data['biaya_bbm'];
  
?>
<form action="biaya-sewa/edit.php" method="post">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Biaya Sewa Per Jam:</label>
                <input name="biaya_sewa" id="biaya_sewa" type="number" value="<?php echo $biaya_sewa; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <div id="info_biaya_sewa" class='font-weight-bold'></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Biaya Supir Per Jam:</label>
                <input name="biaya_supir" id="biaya_supir" type="number" value="<?php echo $biaya_supir; ?>" class="form-control">
            </div>
            <div class="form-group">
                <div id="info_biaya_supir" class='font-weight-bold'></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Biaya BBM:</label>
                <input name="biaya_bbm" id="biaya_bbm" type="number" value="<?php echo $biaya_bbm; ?>" class="form-control">
            </div>
            <div class="form-group">
                <div id="info_biaya_bbm" class='font-weight-bold'></div>
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

    <input name="id_biaya_sewa"  type="hidden"  value="<?php echo $id_biaya_sewa; ?>" class="form-control">
    <button type="submit" name="update_biaya_sewa" class="btn btn-warning">Update Biaya</button>    
</form>
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