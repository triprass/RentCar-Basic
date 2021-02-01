
<?php
session_start();
?>
<canvas id="transaksi_mobil" width="100%" height="60"></canvas>
<?php

    if (isset($_POST['tahun'])) {
        $tahun=$_POST['tahun'];
    }else {
        $tahun=date('Y');
    }

    if (isset($_POST['bulan'])) {
        $bulan=$_POST['bulan'];
    }else {
        $bulan=date('m');
    }

    include '../../config/database.php';

    //Jika level user adalah Admin maka transaksi yang ditampilkan hanya transaksi yang dilakukan admin tersebut
    if ($_SESSION["level"]=="Admin"){
      //Mengambil id_pengguna dalam variabel session
      $id_pengguna=$_SESSION["id_pengguna"];
    
      $sql="select m.nama_mobil,count(*) as total
      from mobil m
      inner join detail_transaksi d on d.id_mobil=m.id_mobil
      inner join transaksi t on t.kode_transaksi=d.kode_transaksi
      where MONTH(tanggal_transaksi)='$bulan' and  YEAR(tanggal_transaksi)='$tahun' and t.id_pengguna=$id_pengguna
      group by m.nama_mobil ";
    }else {
      $sql="select m.nama_mobil,count(*) as total
      from mobil m
      inner join detail_transaksi d on d.id_mobil=m.id_mobil
      inner join transaksi t on t.kode_transaksi=d.kode_transaksi
      where MONTH(tanggal_transaksi)='$bulan' and  YEAR(tanggal_transaksi)='$tahun'
      group by m.nama_mobil ";
    }

    $hasil=mysqli_query($kon,$sql);
    while ($data = mysqli_fetch_array($hasil)) {
    $nama_mobil[]=$data['nama_mobil'];
    $total[]=$data['total'];
    }
?>

<script>
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Pie Chart
  var ctx = document.getElementById("transaksi_mobil");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels:  <?php echo json_encode($nama_mobil); ?>,
      datasets: [{
        data:  <?php echo json_encode($total); ?>,
        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745','#53ff1a','#ff9900','#7300e6','#75a3a3','#99994d','#ac3939','#66b3ff','#ac7339','#ff00ff'],
      }],
    },
  });
</script>