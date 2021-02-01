<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th width="10%">Gambar</th>
                <th>Nama Mobil</th>
                <th>Merk</th>
                <th>Warna</th>
                <th>Jumlah Kursi</th>
                <th>Tahun Produksi</th>
                <th>Nomor Polisi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
            // include database
            include '../../config/database.php';
            $id_merek=$_POST['id_merek'];
            // perintah sql untuk menampilkan daftar mobil yang berelasi dengan tabel kategori mobil
            $sql="select * from mobil m inner join merek_mobil mk on m.id_merek=mk.id_merek where m.id_merek=$id_merek order by id_mobil desc";
            $hasil=mysqli_query($kon,$sql);
            $no=0;
            //Menampilkan data dengan perulangan while
            while ($data = mysqli_fetch_array($hasil)):
            $no++;
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data['kode_mobil']; ?></td>
            <td><img src="../dist/mobil/gambar/<?php echo $data['gambar_mobil'];?>" class="rounded" width="100%" alt="Cinque Terre"></td>
            <td><?php echo $data['nama_mobil']; ?></td>
            <td><?php echo $data['merek']; ?></td>
            <td><?php echo $data['warna']; ?></td>
            <td><?php echo $data['jumlah_kursi']; ?></td>
            <td><?php echo $data['tahun_produksi']; ?></td>
            <td><?php echo $data['nomor_polisi']; ?></td>

            <td>   <button class="btn-edit-mobil btn btn-warning btn-circle" id_mobil="<?php echo $data['id_mobil']; ?>"  kode_mobil="<?php echo $data['kode_mobil']; ?>" data-toggle="tooltip" title="Edit mobil" data-placement="top"><i class="fas fa-edit"></i></button>
                <button class="btn-hapus-mobil btn btn-danger btn-circle"  gambar_mobil="<?php echo $data['gambar_mobil']; ?>"  id_mobil="<?php echo $data['id_mobil']; ?>"  kode_mobil="<?php echo $data['kode_mobil']; ?>"  data-toggle="tooltip" title="Hapus mobil" data-placement="top"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        <!-- bagian akhir (penutup) while -->
        <?php endwhile; ?>

        </tbody>
    </table>
</div>
<script>
    // fungsi edit mobil
    $('.btn-edit-mobil').on('click',function(){
        
        var id_mobil = $(this).attr("id_mobil");
        var kode_mobil = $(this).attr("kode_mobil");
        $.ajax({
            url: 'mobil/edit.php',
            method: 'post',
            data: {id_mobil:id_mobil},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit mobil #'+kode_mobil;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus mobil
    $('.btn-hapus-mobil').on('click',function(){

        var id_mobil = $(this).attr("id_mobil");
        var kode_mobil = $(this).attr("kode_mobil");
        var gambar_mobil = $(this).attr("gambar_mobil");
        $.ajax({
            url: 'mobil/hapus.php',
            method: 'post',
            data: {id_mobil:id_mobil,kode_mobil:kode_mobil,gambar_mobil:gambar_mobil},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Hapus Mobil #'+kode_mobil;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>