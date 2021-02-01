
<?php
session_start();
?>
<canvas id="transaksi_per_hari" width="100%" height="30"></canvas>
<?php
    if (isset($_POST['tahun'])) {
        $tahun=$_POST['tahun'];
    }else {
        $tahun=date('Y');
    }

    if (isset($_POST['bulan'])) {
        echo $bulan=$_POST['bulan'];
    }else {
        $bulan=date('m');
    }

    include '../../config/database.php';

    //Mendapatkan jumlah hari dalam bulan ini
    $jumHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    for($hari=1;$hari<=$jumHari;$hari++)
    {
      //Jika level user adalah Admin maka transaksi yang ditampilkan hanya transaksi yang dilakukan admin tersebut
      if ($_SESSION["level"]=="Admin"){
        //Mengambil id_pengguna dalam variabel session
        $id_pengguna=$_SESSION["id_pengguna"];

        $sql="select  day(tanggal_transaksi) as tanggal,SUM(total_biaya+denda) as total
        from transaksi t 
        inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi 
        where DAY(tanggal_transaksi)='$hari' and MONTH(tanggal_transaksi)='$bulan' and  YEAR(tanggal_transaksi)='$tahun' and t.id_pengguna=$id_pengguna";
      }else {
        $sql="select  day(tanggal_transaksi) as tanggal,SUM(total_biaya+denda) as total
        from transaksi t 
        inner join detail_transaksi d on d.kode_transaksi=t.kode_transaksi 
        where DAY(tanggal_transaksi)='$hari' and MONTH(tanggal_transaksi)='$bulan' and  YEAR(tanggal_transaksi)='$tahun' ";
      }

        $hasil=mysqli_query($kon,$sql);
        $data=mysqli_fetch_array($hasil);
        $pendapatan_harian[] = $data['total'];
        $tgl[] = $hari;
    }
?>
<script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart 
var ctx = document.getElementById("transaksi_per_hari");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($tgl); ?>,
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: <?php echo json_encode($pendapatan_harian); ?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 31
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>