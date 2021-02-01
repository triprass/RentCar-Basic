<script>
    $('title').text('Checkout');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Checkout</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="transaksi/simpan-transaksi.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Penyewa</h6>
                                </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Penyewa:</label>
                                            <input type="text" class="form-control"  name="nama_penyewa" required>
                                        </div>
                                        <div class="form-group">
                                            <label>No Telp:</label>
                                            <input type="text" class="form-control"  name="no_telp" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Alamat:</label>
                                            <textarea class="form-control" rows="2" name="alamat"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="Identitas">Identitas:</label>
                                            <select class="form-control" name="identitas" id="Identitas">
                                                <option value="KTP">KTP</option>
                                                <option value="SIM A">SIM A</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div id="msg"></div>
                                            <input type="file" name="foto_identitas" class="file" >
                                                <div class="input-group my-3">
                                                    <input type="text" class="form-control" disabled placeholder="Upload Identitas" id="file">
                                                    <div class="input-group-append">
                                                            <button type="button" id="pilih_identitas" class="browse btn btn-dark">Pilih</button>
                                                    </div>
                                                </div>
                                            <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">Data Penyewaan</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th rowspan="2">Mobil</th>
                                                        <th colspan="3"  class="text-center">Waktu Penyewaan</th>
                                                        <th rowspan="2">Fasilitas</th>
                                                        <th rowspan="2">Total Biaya</th>
                                                
                                                    </tr>
                                                    <tr>
                                                        <th>Mulai</th>
                                                        <th>Selesai</th>
                                                        <th>Jam</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $total_bayar=0;	
                                                        if(!empty($_SESSION["cart_item"])):
                                                        foreach ($_SESSION["cart_item"] as $item):
                                                            $sub_tot=$item["total_biaya"];
                                                            $total_bayar+=$sub_tot;
                                                    ?> 
                                                        <tr>
                                                            <td><?php echo $item["nama_mobil"]; ?></td>
                                                
                                                            <td class="text-center"><?php echo date("d/m/Y",strtotime($item["mulai_sewa"])); ?></td>
                                                            <td class="text-center"><?php echo date("d/m/Y",strtotime($item["akhir_sewa"])); ?></td>
                                                            <td class="text-center"><?php echo date("H:i",strtotime($item['akhir_sewa'])); ?> WIB</td>
                                                            <td><?php if ($item['supir'] == 1 ) echo "<span class='badge badge-info'>Supir</span>"; ?> <?php if ($item['bbm'] == 1 ) echo "<span class='badge badge-warning'>BBM</span>"; ?></td>
                                                            <td>Rp. <?php echo number_format($item['total_biaya'],0,',','.'); ?></td>
                                                        
                                                        </tr>
                                                    <?php 
                                                        endforeach;
                                                        endif;
                                                    ?>
                                                        <tr>
                                                            <td colspan="4" style="text-align:right"><h4>Total Bayar</h4></td>
                                                            <td colspan="2" ><h4>Rp. <?php  echo number_format($total_bayar,0,',','.'); ?></h4></td>
                                                            <input type="hidden" name="total_bayar" value="<?php echo $total_bayar;?>"/>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="belum_bayar" name="pembayaran" value="0">
                                                    <label class="custom-control-label" for="belum_bayar">Belum Bayar</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="uang_muka" name="pembayaran" value="1">
                                                    <label class="custom-control-label" for="uang_muka">Uang Muka</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="lunas" name="pembayaran" value="2">
                                                    <label class="custom-control-label" for="lunas">Lunas</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" id="jumlah_uang_muka"  min="0" name="uang_muka" placeholder="Masukan Uang Muka">
                                            </div>
                                            <div class="form-group">
                                                <div id="info_nominal" class='font-weight-bold'></div>
                                            </div>
                                            <div class="alert alert-info" id="info_lunas">
                                                Pembayaran belum termasuk denda yang akan dihitung setelah mobil dikembalikan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="buat_transaksi" class="btn btn-success float-right">Buat Transaksi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>



<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>

<script>

    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }

    $('#jumlah_uang_muka').hide();
    $('#info_lunas').hide();

    $('#belum_bayar').on('click',function(){
        $('#jumlah_uang_muka').hide(200);
        $('#info_lunas').hide(200); 
    });
    $('#uang_muka').on('click',function(){
        $('#jumlah_uang_muka').show(200);
        $('#info_lunas').hide(200); 
    });

    $('#lunas').on('click',function(){
        $('#info_lunas').show(200); 
        $('#jumlah_uang_muka').hide(200); 
    });

    $('#jumlah_uang_muka').bind('keyup', function () {
        var jumlah_uang_muka=$("#jumlah_uang_muka").val();
        $("#info_nominal").text('Rp.'+format_rupiah(jumlah_uang_muka));     
    }); 


    $(document).on("click", "#pilih_identitas", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
    });

</script>