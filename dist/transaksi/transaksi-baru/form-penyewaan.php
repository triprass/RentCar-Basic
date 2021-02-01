<?php 
    include '../../../config/database.php';
    if (isset($_POST['kode_mobil'])) {
        $kode_mobil=$_POST['kode_mobil'];
    }else {
        $kode_mobil="";
    }
    $query = mysqli_query($kon, "SELECT * FROM mobil m inner join biaya_sewa b on m.id_mobil=b.id_mobil  where m.kode_mobil='$kode_mobil'");
    $data = mysqli_fetch_array($query);
?>
 <div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Tanggal:</label>
                    <input type="date" class="form-control" id="tanggal" disabled>
                </div>
                <div id="pemberitahuan_ketersediaan_tanggal"></div>
            </div>
        
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Jam:</label>
                    <input type="time" class="form-control" id="jam" disabled>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Lama Sewa:</label>
                    <select class="form-control" id="lama_sewa" disabled>
                        <option value="24">24 Jam</option>
                        <option value="48">48 Jam</option>
                        <option value="72">72 Jam</option>
                        <option value="96">96 Jam</option>
                        <option value="120">120 Jam</option>
                    </select>
                </div>
                <div id="pemberitahuan_ketersediaan_lama_sewa"></div>
            </div>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>  
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="biaya_sewaa" class="custom-control-input" id="biaya_sewaa" checked disabled>
                            <label class="custom-control-label" for="biaya_sewaa">Biaya Sewa</label>
                        </div>
                    </td> 
                    <td>Rp. <span id="tampil_biaya_sewa">0</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="supir" class="custom-control-input" id="supir">
                            <label class="custom-control-label" for="supir">Menggunakan Supir</label>
                        </div>
                    </td>
                    <td>Rp. <span id="tampil_biaya_supir">0</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="bbm" class="custom-control-input" id="bbm">
                            <label class="custom-control-label" for="bbm">Menggunakan BBM</label>
                        </div>
                    </td>
                    <td>Rp. <span id="tampil_biaya_bbm">0</span></td>
                </tr>
                </tr>
                <tr>
                    <td>Total Biaya</td>
                    <td>
                        Rp. <span id="tampil_total_biaya">0</span>
                    </td>
                </tr>
                </tbody>
            </table>
            <button type="submit" name="tambah" id="tambah" aksi="tambah_sewa" class="btn btn-primary btn-block" disabled>Tambah</button>
        </div>
    </div>
</div>


<input type="hidden"id="biaya_sewa" value="<?php echo $data['biaya_sewa']; ?>" />
<input type="hidden"id="biaya_supir" value="<?php echo $data['biaya_supir']; ?>" />
<input type="hidden"id="biaya_bbm" value="<?php echo $data['biaya_bbm']; ?>" />
<input type="hidden"id="tot_biaya" value="" />

<script>
    //Fungsi untuk mengambil nilai biaya sewa
    function biaya_sewa(){
        var lama_sewa=$("#lama_sewa").val();
        var biaya_sewa=$("#biaya_sewa").val();
        var hasil=0;
        return hasil=lama_sewa*biaya_sewa;
    }

    //Fungsi untuk mengambil nilai biaya supir
    function biaya_supir(){
        var lama_sewa=$("#lama_sewa").val();
        var biaya_supir=$("#biaya_supir").val();
        var tot_biaya_supir=0;

        if ($('#supir').prop("checked") == true){
            return tot_biaya_supir=biaya_supir*lama_sewa;
        }else {
            return tot_biaya_supir;
        }

    }

    //Fungsi untuk mengambil nilai biaya bbm
    function biaya_bbm(){
        var biaya_bbm=$("#biaya_bbm").val();
    
        if ($('#bbm').prop("checked") == true){
            return parseInt(biaya_bbm);
        }else {
            return 0;
        }
    }

    //Fungsi untuk menghitung total biaya
    function total_biaya(){
        return biaya_sewa()+biaya_supir()+biaya_bbm();

    }

    //Fungsi format rupiah
    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
             ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }

     //Untuk menampilkan biaya sewa mobil, biaya supir dan total biaya
    $('#lama_sewa').bind('change', function () {
        $("#tampil_biaya_sewa").html(format_rupiah(biaya_sewa()));
        $("#tampil_biaya_supir").html(format_rupiah(biaya_supir()));
        $("#tampil_total_biaya").html(format_rupiah(total_biaya()));
        $("#tot_biaya").val(total_biaya());
    });

    
    //Saat suir diaktifkan maka akan menampilkan biaya supir dan total biaya
    $('#supir').bind('change', function () {
        $("#tampil_biaya_supir").html(format_rupiah(biaya_supir()));
        $("#tampil_total_biaya").html(format_rupiah(total_biaya()));
        $("#tot_biaya").val(total_biaya());
    });

    //Saat bbm diaktifkan maka akan menampilkan biaya bbm dan total biaya
    $('#bbm').bind('change', function () {
        $("#tampil_biaya_bbm").html(format_rupiah(biaya_bbm()));
        $("#tampil_total_biaya").html(format_rupiah(total_biaya()));
        $("#tot_biaya").val(total_biaya());
    });

    //Untuk mengecek ketersediaan mobil saat pengguna memilih tanggal sewa
    $('#tanggal').bind('change', function () {
        document.getElementById("jam").disabled = false;
        document.getElementById("lama_sewa").disabled = false;
        $("#tot_biaya").val(total_biaya());   
        var kode_mobil=$("#mobil").val();
        var tanggal=$("#tanggal").val();
        var jam=$("#jam").val();
        var lama_sewa=$("#lama_sewa").val();
     
        $.ajax({
            url: 'transaksi/transaksi-baru/cek-ketersediaan-mobil.php',
            method: 'POST',
            data:{kode_mobil:kode_mobil,tanggal:tanggal,jam:jam,lama_sewa:lama_sewa},
            success:function(data){
                $('#pemberitahuan_ketersediaan_lama_sewa').html(data);
                
            }
        });  
    });

    //Untuk mengecek ketersediaan mobil saat pengguna memilih lama sewa
    $('#lama_sewa').bind('change', function () {
        var kode_mobil=$("#mobil").val();
        var tanggal=$("#tanggal").val();
        var jam=$("#jam").val();
        var lama_sewa=$("#lama_sewa").val();
        
        $.ajax({
            url: 'transaksi/transaksi-baru/cek-ketersediaan-mobil.php',
            method: 'POST',
            data:{kode_mobil:kode_mobil,tanggal:tanggal,jam:jam,lama_sewa:lama_sewa},
            success:function(data){
                $('#pemberitahuan_ketersediaan_lama_sewa').html(data);    
                
            }
        }); 
    }); 


    //Saat pengguna mengklik tombol tambah penyewaan maka sistem akan menyimpan ke database menggunakan teknik AJAX
    $('#tambah').on('click',function(){
        if( $('#tanggal').val()=='') {
                alert('Tanggal belum dipilih');
                return false;
            }
        var aksi = $(this).attr("aksi");
        var kode_mobil=$("#mobil").val();
        var tanggal=$("#tanggal").val();
        var jam=$("#jam").val();
        var lama_sewa=$("#lama_sewa").val();

        var total_biaya=$("#tot_biaya").val();
        var supir=0;
        var bbm=0;

        if ($('#supir').prop("checked") == true){
                supir=1;
            }
        if ($('#bbm').prop("checked") == true){
                bbm=1;
            }
        
        var id_transaksi=$("#id_transaksi").val();
   
            $.ajax({
            url: 'transaksi/transaksi-baru/cart.php',
            method: 'POST',
            data:{kode_mobil:kode_mobil,lama_sewa:lama_sewa,tanggal:tanggal,jam:jam,supir:supir,bbm:bbm,total_biaya:total_biaya,aksi:aksi},
            success:function(data){
                $('#tampil_cart').html(data);
            }
        }); 

    });


</script>