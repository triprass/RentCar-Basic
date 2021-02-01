<?php
session_start();
?>
<canvas id="transaksi_per_bulan" width="100%" height="60"></canvas>
<?php
    include '../../config/database.php';

    if (isset($_POST['tahun'])) {
        $tahun=$_POST['tahun'];
    }else {
        $tahun=date('Y');
    }

    $label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

    for($bulan = 1;$bulan <= 12;$bulan++)
    {
      //Jika level user adalah Admin maka transaksi yang ditampilkan hanya transaksi yang dilakukan admin tersebut
      if ($_SESSION["level"]=="Admin"){
        //Mengambil id_pengguna dalam variabel session
        $id_pengguna=$_SESSION["id_pengguna"];

        $sql="select SUM(total_biaya+denda) as total
        from transaksi t 
        inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi 
        where MONTH(tanggal_transaksi)='$bulan' and YEAR(tanggal_transaksi)='$tahun' and t.id_pengguna=$id_pengguna";
      }else {
        $sql="select SUM(total_biaya+denda) as total
        from transaksi t 
        inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi 
        where MONTH(tanggal_transaksi)='$bulan' and YEAR(tanggal_transaksi)='$tahun'";
      }

        $hasil=mysqli_query($kon,$sql);
        $data=mysqli_fetch_array($hasil);
        $total[] = $data['total'];
    }
?>
<script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart
var ctx = document.getElementById("transaksi_per_bulan");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($label); ?>,
    datasets: [{
      label: "Revenue",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data:  <?php echo json_encode($total); ?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 16
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 12
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>