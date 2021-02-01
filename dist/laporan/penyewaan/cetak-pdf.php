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
    $pdf->Cell(40,6,'Penyewa',1,0,'C');
    $pdf->Cell(40,6,'Mobil',1,0,'C');
    $pdf->Cell(25,6,'Mulai',1,0,'C');
    $pdf->Cell(25,6,'Selesai',1,0,'C');
    $pdf->Cell(23,6,'Jam',1,0,'C');
    $pdf->Cell(35,6,'Status',1,1,'C');

    $pdf->SetFont('Arial','',10);
    $kondisi="";

    if (!empty($_GET["dari_tanggal"]) && empty($_GET["sampai_tanggal"])) $kondisi= "where date(mulai_sewa)='".$_GET['dari_tanggal']."' ";
    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) $kondisi= "where date(mulai_sewa) between '".$_GET['dari_tanggal']."' and '".$_GET['sampai_tanggal']."'";
    
    // perintah sql untuk menampilkan laporan penyewaan jika level admin maka sistem hanya akan menampilkan transaksi yang dilakukan admin tersebut
    if ($_SESSION["level"]=="Admin"){
        $id_pengguna=$_SESSION["id_pengguna"];
        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi  and transaksi.id_pengguna=$id_pengguna order by mulai_sewa asc";
    }else {
        $sql="select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi $kondisi order by mulai_sewa asc";
    }

    $hasil=mysqli_query($kon,$sql);
    $no=1;
    $status='';
    //Menampilkan data dengan perulangan while
    while ($data = mysqli_fetch_array($hasil)):

        if ($data['status_penyewaan']==2){
            $status="Telah Selesai";
        }else if ($data['status_penyewaan']==1){
            $status="Sedang disewa";
        }else {
            $status="Belum ditentukan";
        }

        $pdf->Cell(8,6,$no,1,0);
        $pdf->Cell(40,6,$data['nama_penyewa'],1,0);
        $pdf->Cell(40,6,$data['nama_mobil'],1,0);
        $pdf->Cell(25,6,date("d/m/Y",strtotime($data['mulai_sewa'])),1,0);
        $pdf->Cell(25,6,date("d/m/Y",strtotime($data['akhir_sewa'])),1,0);
        $pdf->Cell(23,6, date("H:i",strtotime($data['akhir_sewa'])).' WIB',1,0);
        $pdf->Cell(35,6, $status,1,1);
        $no++;
    endwhile;
     
    $pdf->Output();
?>