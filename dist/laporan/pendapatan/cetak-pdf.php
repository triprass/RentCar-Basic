<?php
session_start();
    require('../../../src/plugin/fpdf/fpdf.php');
    $pdf = new FPDF('P', 'mm','Letter');

    //Membuat Koneksi ke database akademik
    include '../../../config/database.php';

    $query = mysqli_query($kon, "select * from profil_aplikasi order by nama_aplikasi desc limit 1");    
    $row = mysqli_fetch_array($query);

    $pdf->AddPage();
    $pdf->Image('../../aplikasi/logo/'.$row['logo'],15,5,30,30);
    $pdf->SetFont('Arial','B',21);
    $pdf->Cell(0,7,strtoupper($row['nama_aplikasi']),0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,7,$row['alamat'].', Telp '.$row['no_telp'],0,1,'C');
    $pdf->Cell(0,7,$row['website'],0,1,'C');
    $pdf->Cell(10,7,'',0,1);

    $tanggal='';
    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])){
        $tanggal=date("d/m/Y",strtotime($_GET["dari_tanggal"]));
    }
    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])){
        $tanggal=date("d/m/Y",strtotime($_GET["dari_tanggal"]))." - ".date("d/m/Y",strtotime($_GET["sampai_tanggal"]));
    }

    $pdf->SetFont('Arial','',11);
    $pdf->Cell(50,6,'Laporan Penjualan Tanggal: ',0,0);
    $pdf->Cell(30,6,$tanggal,0,1);

    $pdf->Cell(10,2,'',0,1);
 
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(8,6,'No',1,0,'C');
    $pdf->Cell(22,6,'Tanggal',1,0,'C');
    $pdf->Cell(38,6,'Mobil',1,0,'C');
    $pdf->Cell(25,6,'Biaya',1,0,'C');
    $pdf->Cell(25,6,'Supir',1,0,'C');
    $pdf->Cell(25,6,'BBM',1,0,'C');
    $pdf->Cell(25,6,'Denda',1,0,'C');
    $pdf->Cell(28,6,'Total',1,1,'C');

    $no=1;
    $sub_total=0;
    $total=0;
    $status='';
    $kondisi="";

    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi)='".$_GET['dari_tanggal']."' ";
    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) $kondisi= "where date(tanggal_transaksi) between '".$_GET['dari_tanggal']."' and '".$_GET['sampai_tanggal']."'";
    
    // perintah sql untuk menampilkan laporan pendapatan jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
    if ($_SESSION["level"]=="Admin"){
        $id_pengguna=$_SESSION["id_pengguna"];
        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN biaya_sewa on mobil.id_mobil=biaya_sewa.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi and transaksi.id_pengguna=$id_pengguna order by tanggal_transaksi asc";
    }else {
        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN biaya_sewa on mobil.id_mobil=biaya_sewa.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi order by tanggal_transaksi asc";
    }
   
    $hasil=mysqli_query($kon,$sql);
    $no=1;
    $total=0;
    $pdf->SetFont('Arial','',10);
    //Menampilkan data dengan perulangan while
    while ($data = mysqli_fetch_array($hasil)):

        $biaya_sewa=$data['biaya_sewa']*$data['lama_sewa'];

        if ($data['supir']==1){
            $biaya_supir=$data['biaya_supir']*$data['lama_sewa'];
        }else {
            $biaya_supir=0;
        }
        if ($data['bbm']==1){
            $biaya_bbm=$data['biaya_bbm'];
        }else {
            $biaya_bbm=0;
        }

        $denda=$data['denda'];
        $sub_total=$biaya_sewa+$denda+$biaya_supir+$biaya_bbm;
        $total+= $sub_total;

        $pdf->Cell(8,6,$no,1,0);
        $pdf->Cell(22,6,date("d/m/Y",strtotime($data['tanggal_transaksi'])),1,0);
        $pdf->Cell(38,6,$data['nama_mobil'],1,0);
        $pdf->Cell(25,6,'Rp. '.number_format($biaya_sewa,0,',','.'),1,0);
        $pdf->Cell(25,6,'Rp. '.number_format($biaya_supir,0,',','.'),1,0);
        $pdf->Cell(25,6,'Rp. '.number_format($biaya_bbm,0,',','.'),1,0);
        $pdf->Cell(25,6,'Rp. '.number_format($denda,0,',','.'),1,0);
        $pdf->Cell(28,6,'Rp. '.number_format($sub_total,0,',','.'),1,1);
        $no++;
    endwhile;

    $pdf->Cell(10,7,'',0,1);
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(0,7,'Total Pendapatan : '.'Rp. '.number_format($total,0,',','.'),0,1,'R');
     
    $pdf->Output();
?>