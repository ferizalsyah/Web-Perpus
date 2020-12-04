<?php
tcpdf();
$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = " Perpustakaan SMP N 2 Pajangan";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData("pdf.jpg", PDF_HEADER_LOGO_WIDTH, $title, "Laporan Pengembalian Buku");
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
                <th width="5%"><b>No</b></th>
                <th><b>ID Anggota</b></th>
                <th width="15%"><b>Nama Peminjam</b></th>
                <th width="5%"><b>Kelas</b></th>
                <th width="20%"><b>Judul Buku</b></th>
                <th width="4%"><b>No Buku</b> </th>
                <th ><b>Tanggal Pinjam</b></th>
                <th ><b>Tanggal Kembali</b></th>
                <th ><b>Tanggal Dikembalikan</b></th>
                <th width="5%"><b>Telat</b></th>
                <th ><b>Denda</b></th>        
                </tr>
    </thead>
         <?php
  $no = 1;
foreach($data_pinjam->result_array() as $op)
    {
      if ($op['status']==1) {
       
      $idp=$op['id_pinjam'];
    ?>
            <tr>
            <td width="5%" align="center"><?php echo $no++ ;?></td>
                <td><?php $op['id_pinjam'];
                    foreach ($data_pinjam->result_array() as $op3) {
                      if ($op3['id_pinjam']==$op['id_pinjam']) {
                        echo $op3['id_anggota'];
                      }
                    }?>
                    </td>                
                 <?php foreach ($data_pinjam->result_array()  as $op3) {
                  if ($op3['id_pinjam']==$idp) {
                    $buku=$op3['id_anggota'];
                  }
                  }?>
                        <td width="15%"><?php 
                           foreach ($data_anggota->result_array() as $key => $op4) {
                             if ($op4['id_anggota']==$buku) {
                              echo $op4['nama'];
                              $idk=$op4['id_kelas'];
                             }
                           }
                            ?>
                        </td> 
                        <td align="center" width="5%"><?php //$buku=$op7['id_kelas'];
                            foreach ($data_kelas ->result_array()  as $op6) {
                              if($op6['id_kelas']==$idk){
                                  echo $op6['kelas'];
                              }
                            }?>
                        </td>        
                        
                <td width="20%"><?php $j=0;
                 foreach ($data_detail_pinjam->result_array()  as $op3){
                  if ($op3['id_pinjam']==$idp) {
                    if ($j>2) {
                      echo ",";
                    }
                    $dbk=$op3['id_buku'];
                    foreach ($data_buku->result_array() as $key => $value) {
                     if ($value['id_buku']==$dbk) {
                       echo $value['judul'];
                       echo ", ";
                     }
                  }
                } 
                };
                ?>
                </td>
                <td align="center" width="4%"><?php $op['id_pinjam'];
                    foreach ($data_detail_pinjam->result_array() as $op3) {
                      if ($op3['id_pinjam']==$op['id_pinjam']) {
                        echo $op3['no_buku'];
                        echo ",";                      
                      }
                    }?>
                    </td>
                <td align="center"><?php $pinjam=$op['id_pinjam'];
                    foreach ($data_pinjam ->result_array()  as $op2) {
                      if($op2['id_pinjam']==$pinjam){
                          echo $op2['tgl_pinjam'];
                      }
                    }?></td>
                 <td align="center"><?php $pinjam=$op['id_pinjam'];
                    foreach ($data_pinjam->result_array()  as $op2) {
                      if($op2['id_pinjam']==$pinjam){
                          echo $op2['tgl_kembali'];
                      }
                    }?></td>
              <?php $idp2=$op['id_pinjam'];
               foreach ($data_kembali->result_array() as $key => $op5) {
               if ($op5['id_pinjam']==$idp2) {
                ?><td align="center"><?php
              echo $op5['tgl_dikembalikan'];
        ?>
              </td>
                <td align="center" width="5%"><?php echo $op5['terlambat'];?></td>
              <td align="rigth" >Rp. <?php echo $op5['denda'];?></td>
               <?php }
              }
              ?>
            
                
                

                        
               
                </tr>
<?php
}
    }
  ?>            
    </table>
    <?php
       $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('output.pdf', 'I');?>
      
  