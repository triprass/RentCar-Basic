<script>
    $('title').text('Transaksi Baru');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Transaksi Baru</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transaksi Baru</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control" id="mobil">
                                <option value="">Pilih Mobil</option>
                                <?php
                                    include '../config/database.php';
                                    $sql="SELECT m.* FROM mobil m inner join biaya_sewa b on m.id_mobil=b.id_mobil order by m.id_mobil asc";
                                    $hasil=mysqli_query($kon,$sql);
                                    while ($data = mysqli_fetch_array($hasil)):
                                ?>
                                <option value="<?php echo $data['kode_mobil']; ?>"><?php echo $data['nama_mobil']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div id="tampil_form"></div>
                    </div>
                    <div class="col-sm-8">
                        <div id="tampil_cart"></div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Bagian header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judul"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Bagian body -->
            <div class="modal-body">
                <div id="tampil_data">

                </div>  
            </div>
            <!-- Bagian footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    //Fungsi untuk membuat format rupiah
    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
             ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }

    //Menambilkan form penyewaan saat pengguna memilih mobil
    $('#mobil').on('change',function(){
       
        var kode_mobil=$("#mobil").val();

        if (kode_mobil==''){
            document.getElementById("tambah").disabled = true;
           
        }else {
            $.ajax({
                url: 'transaksi/transaksi-baru/form-penyewaan.php',
                method: 'POST',
                data:{kode_mobil:kode_mobil},
                success:function(data){
                    $('#tampil_form').html(data);
                    $("#tampil_biaya_sewa").html(format_rupiah(biaya_sewa()));
                    $("#tampil_biaya_supir").html(format_rupiah(biaya_supir()));
                    $("#tampil_biaya_bbm").html(format_rupiah(biaya_bbm()));
                    $("#tampil_total_biaya").html(format_rupiah(total_biaya()));
                    $("#tot_biaya").val(total_biaya());
                    document.getElementById("tanggal").disabled = false;
                }
            }); 
        }
    });

    //Menampilkan form penyewaan
    $(document).ready(function(){
        
        $.ajax({
            type	: 'POST',
            url: 'transaksi/transaksi-baru/form-penyewaan.php',
            data	: '',
            cache	: false,
            success	: function(data){
                $("#tampil_form").html(data);
            }
        });
    });

    //Menampilkan cart atau kerangjang belanja
    $(document).ready(function(){
        $.ajax({
            type	: 'POST',
            url: 'transaksi/transaksi-baru/cart.php',
            data	: '',
            cache	: false,
            success	: function(data){
                $("#tampil_cart").html(data);
            }
        });
    });

</script>