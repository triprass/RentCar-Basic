<?php
session_start();

    if (isset($_POST['kode_mobil'])) {
        $kode_mobil=$_POST['kode_mobil'];
    }else {
        $kode_mobil="";
    }

    if (isset($_POST["aksi"])) {
        $aksi=$_POST["aksi"];
    }else {
        $aksi="";
    }
    if (isset($_POST['tanggal'])) {
        $tanggal=$_POST['tanggal'];
    }else {
        $tanggal=0;
    }
    if (isset($_POST['jam'])) {
        $jam=$_POST['jam'];
    }else {
        $jam=0;
    }

    if (isset($_POST['lama_sewa'])) {
        $lama_sewa=$_POST['lama_sewa'];
    }else {
        $lama_sewa=0;
    }

    if (isset($_POST['total_biaya'])) {
        $total_biaya=$_POST['total_biaya'];
    }else {
        $total_biaya=0;
    }
    if (isset($_POST['bbm'])) {
        $bbm=$_POST['bbm'];
    }else {
        $bbm=0;
    }

    if (isset($_POST['supir'])) {
        $supir=$_POST['supir'];
    }else {
        $supir=0;
    }

    //Set tanggal mulai sewa dan akhir sewa
    $tgl=$tanggal.$jam;
    $mulai_sewa = date("d-m-Y H:i",strtotime($tgl));
    $akhir_sewa=date("d-m-Y H:i",strtotime("+$lama_sewa hour",strtotime($tgl)));

    //Mengambil data mobil dan biaya sewa
    include '../../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM mobil m inner join biaya_sewa b on m.id_mobil=b.id_mobil  where m.kode_mobil='$kode_mobil'");
    $mobilByCode = mysqli_fetch_array($query);
 
    if (isset($_POST["aksi"])) {
    //Memasukan data ke dalam array
    $itemArray = array($mobilByCode['kode_mobil']=>array('mulai_sewa'=>$mulai_sewa,'akhir_sewa'=>$akhir_sewa,'lama_sewa'=>$lama_sewa,'id_mobil'=>$mobilByCode['id_mobil'],'kode_mobil'=>$mobilByCode['kode_mobil'],'nama_mobil'=>$mobilByCode['nama_mobil'],'supir'=>$supir,'bbm'=>$bbm,'biaya_sewa'=>$mobilByCode['biaya_sewa'],'total_biaya'=>$total_biaya));
    }
    switch($aksi) {	
        //Fungsi untuk menambah penyewaan kedalam cart
        case "tambah_sewa":
        if(!empty($_SESSION["cart_item"])) {
            if(in_array($mobilByCode['kode_mobil'],array_keys($_SESSION["cart_item"]))) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($mobilByCode['kode_mobil'] == $k) {
                            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                        }
                }
            } else {
                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
            }
        } else {
            $_SESSION["cart_item"] = $itemArray;
        }
        break;
        //Fungsi untuk menghapus penyewaan dari cart
        case "hapus_mobil":
    		if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_POST["kode_mobil"] == $k)
                            unset($_SESSION["cart_item"][$k]);
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
    }
?>
 <div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th rowspan="2">Mobil</th>
                    <th colspan="3"  class="text-center">Waktu Penyewaan</th>
                    <th rowspan="2">Fasilitas</th>
                    <th rowspan="2">Total Biaya</th>
                    <th rowspan="2">Aksi</th>
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
                        <td><button type="button" kode_mobil="<?php echo $item["kode_mobil"]; ?>"  class="hapus_mobil btn btn-danger btn-circle"  ><i class="fas fa-trash"></i></button></td>
                    </tr>
                <?php 
                    endforeach;
                    endif;
                ?>
                    <tr>
                        <td colspan="4" style="text-align:right"><h4>Total Bayar</h4></td>
                        <td colspan="2" ><h4>Rp. <?php  echo number_format($total_bayar,0,',','.'); ?></h4></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <a href="index.php?page=checkout" class="btn btn-primary" id="btn_selanjutnya">Selanjutnya</a>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="total_bayar" value="<?php echo $total_bayar;?>"/>

<script>
    //Cart pemesanan ditampilkan
    $('#tampil_data_pemesan').show();

    //Fungsi untuk menghapus penyewaan mobil dari cart (keranjang belanja)
    $('.hapus_mobil').on('click',function(){
        var kode_mobil = $(this).attr("kode_mobil");
        var aksi ='hapus_mobil';
        $.ajax({
            url: 'transaksi/transaksi-baru/cart.php',
            method: 'POST',
            data:{kode_mobil:kode_mobil,aksi:aksi},
            success:function(data){
                $('#tampil_cart').html(data);
            }
        }); 
    });

    //Fungsi untuk menampilkan pemberitahuan caart masih kosong saat pengguna mengklik tombol selanjutnya
    $('#btn_selanjutnya').on('click',function(){
        var total_bayar=$("#total_bayar").val();
        if(total_bayar<=0) {
            alert('Cart masih kosong');
            return false;
        }
    });
</script>