
<?php
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


    $id_transaksi=$_GET['id_transaksi'];
    $query = mysqli_query($kon, "select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi where transaksi.id_transaksi='$id_transaksi'");    
   $data = mysqli_fetch_array($query);

    $id_transaksi=$data['id_transaksi'];

    $pdf->Cell(10,7,'',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50,6,'Kode Transaksi',0,0);
    $pdf->Cell(20,6,': '.$data['kode_transaksi'],0,1);

    $pdf->Cell(50,6,'Tanggal Transaksi',0,0);
    $pdf->Cell(20,6,': '.date("d/m/Y",strtotime($data['tanggal_transaksi'])),0,1);

    $pdf->Cell(50,6,'Penyewa',0,0);
    $pdf->Cell(20,6,': '.$data['nama_penyewa'],0,1);

    $pdf->Cell(50,6,'Identitas',0,0);
    $pdf->Cell(20,6,': '.$data['identitas'],0,1);



    $pdf->Cell(10,7,'',0,1);

    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(8,6,'No',1,0,'C');
    $pdf->Cell(50,6,'Mobil',1,0,'C');
    $pdf->Cell(23,6,'Lama Sewa',1,0,'C');
    $pdf->Cell(30,6,'Status',1,0,'C');
    $pdf->Cell(28,6,'Biaya Sewa',1,0,'C');
    $pdf->Cell(28,6,'Denda',1,0,'C');
    $pdf->Cell(28,6,'Sub Total',1,1,'C');
    $pdf->SetFont('Arial','',10);
    $no=1;
    $sub_total=0;
    $total=0;
    $status='';
    $kode_transaksi=$data['kode_transaksi'];
    //Query untuk mengambil data mahasiswa pada tabel mahasiswa
    $hasil = mysqli_query($kon, "select * from detail_transaksi inner join mobil on mobil.id_mobil=detail_transaksi.id_mobil INNER JOIN transaksi on transaksi.kode_transaksi=detail_transaksi.kode_transaksi where detail_transaksi.kode_transaksi='$kode_transaksi'");
    while ($data = mysqli_fetch_array($hasil)){
        $sub_total=$data['total_biaya']+$data['denda'];
        $total+=$sub_total;

        if ($data['status_penyewaan']==2){
            $status='Telah Selesai';
        }else if ($data['status_penyewaan']==1){
            $status='Sedang disewa';
        }else {
            $status='Belum ditentukan';
        }

        $pdf->Cell(8,6,$no,1,0);
        $pdf->Cell(50,6,$data['nama_mobil'],1,0);
        $pdf->Cell(23,6,$data['lama_sewa'].' jam',1,0);
        $pdf->Cell(30,6,$status,1,0);
        $pdf->Cell(28,6,'Rp. '.number_format($data['total_biaya'],0,',','.'),1,0);
        $pdf->Cell(28,6,'Rp. '.number_format($data['denda'],0,',','.'),1,0);
        $pdf->Cell(28,6,'Rp. '.number_format($sub_total,0,',','.'),1,1);

        $no++;
    }

    $pdf->Cell(10,7,'',0,1);
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(0,7,'Total Bayar : '.'Rp. '.number_format($total,0,',','.'),0,1,'R');
     
    $pdf->Output();
?>
