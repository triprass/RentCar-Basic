
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <select class="form-control" id="mobil">
                        <option value="">Pilih Mobil</option>
                        <?php
                            include '../../../config/database.php';
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
    </div>
</div>

<input type='hidden' id="id_transaksi" value="<?php echo $_POST['id_transaksi'];?>" />
<input type='hidden' id="kode_transaksi" value="<?php echo $_POST['kode_transaksi'];?>" />
<div id="tampil_form_penyewaan"></div>

<script>
    //Menampilkan form penyewaan menggunakan AJAX saat pengguna memilih mobil
    $('#mobil').on('change',function(){          
        var kode_mobil=$("#mobil").val();
        var id_transaksi=$("#id_transaksi").val();
        var kode_transaksi=$("#kode_transaksi").val();

        $.ajax({
            url: 'transaksi/detail-transaksi/penyewaan-form-tambah.php',
            method: 'post',
            data: {kode_mobil:kode_mobil,id_transaksi:id_transaksi,kode_transaksi:kode_transaksi},
            success:function(data){
                $('#tampil_form_penyewaan').html(data);
                $("#tampil_biaya_sewa").html(format_rupiah(biaya_sewa()));
                $("#tampil_biaya_supir").html(format_rupiah(biaya_supir()));
                $("#tampil_total_biaya").html(format_rupiah(total_biaya()));
                document.getElementById("tanggal").disabled = false;  
            }
        });
    });

</script>