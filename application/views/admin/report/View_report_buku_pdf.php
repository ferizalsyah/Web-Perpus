<?php
tcpdf();
$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "SMP N 2 Pajangan";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData("pdf.jpg", PDF_HEADER_LOGO_WIDTH, $title, "Laporan Data Buku SMP N 2 Pajangan");
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
ob_start();
?>
   <table border="1">
   <thead align="center">
            <tr align="center">
                <td width ="5%" align="center"> <b> No</b></td>
                <th ><b> ID Buku </b></th>
                <th> <b>ISBN</b></th>
                <th width ="15%"><b>Judul Buku</b></th>
                <th width ="15%"><b>Kategori</b></th>
                <th ><b>Penerbit</b></th>
                <th ><b>Pengarang</b></th>
                <th><b>No. Rak</b></th>
                <th width ="5%"><b>Tahun Terbit</b></th>
                <th width ="5%"><b>Stok</b></th>
                <th><b>Keterangan</b></th>
            </tr>
    </thead>
         <?php
  $no = 1;
    foreach($data_buku->result_array() as $op)
    {
    ?>
            <tr >
                <td align="center" width ="5%"><?php echo $no++ ;?></td>
                <td><?php echo $op['id_buku'];?></td>
                <td><?php echo $op['ISBN'];?></td>
                <td width ="15%"><?php echo $op['judul'];?></td>
                <td width ="15%"><?php $kategori=$op['id_kategori'];
                    foreach ($data_kategori ->result_array()  as $op2) {
                      if($op2['id_kategori']==$kategori){
                          echo $op2['kategori'];
                      }
                    }?></td>
                <td><?php $penerbit=$op['id_penerbit'];
                    foreach ($data_penerbit ->result_array()  as $op2) {
                      if($op2['id_penerbit']==$penerbit){
                          echo $op2['nama_penerbit'];
                      }
                    }?></td>
                <td><?php $pengarang=$op['id_pengarang'];
                    foreach ($data_pengarang->result_array()  as $op2) {
                      if($op2['id_pengarang']==$pengarang){
                          echo $op2['nama_pengarang'];
                      }
                    }?></td>
                <td align="center"><?php $no_rak=$op['no_rak'];
                    foreach ($data_rak->result_array()  as $op2) {
                      if($op2['no_rak']==$no_rak){
                          echo $op2['nama_rak'];
                      }
                    }?></td>
                <td align="center" width ="5%"><?php echo $op['thn_terbit'];?></td>
                <td align="center" width ="5%"><?php echo $op['stok'];?></td>
                <td><?php echo $op['ket'];?></td>
                </tr>
<?php
    }
  ?>            
    </table>
    <?php
       $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('output.pdf', 'I');?>
      
  