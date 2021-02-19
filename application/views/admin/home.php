 <?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

 <!-- Main content -->
 <section class="container-fluid">
   <div class="row">
     <div class="col-lg-3 col-6">
       <div class="small-box bg-info" style="background-color: #17a2b8!important;">
         <div class="inner">
           <h3 style="color: white;"> <?= $count_pengguna ?></h3>
           <p style="color: white;">Data anggota</p>
         </div>
         <div class="icon">
           <i class="ion ion-person-add"></i>
         </div>
         <a href="http://localhost/App-perpus/admin/Anggota" class="small-box-footer">More info <i class="fa fa-arrow-circle-right  "></i></a>
       </div>
     </div>

     <div class="col-lg-3 col-6">
       <!-- small box -->
       <div class="small-box bg-success" style="background-color: green">
         <div class="inner">
           <h3 style="color: white;"><?= $count_buku; ?><sup style="font-size: 20px"></sup></h3>
           <p style="color: white;">Data Buku</p>
         </div>
         <div class="icon">
           <i class="fa fa-book"></i>
         </div>
         <a href="http://localhost/App-perpus/admin/Buku/buku" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>

     <div class="col-lg-3 col-6">
       <!-- small box -->
       <div class="small-box bg-warning" style="background-color: #ffc107!important;">
         <div class="inner">
           <h3><?= $count_pinjam; ?></h3>
           <p>Data Peminjaman</p>
         </div>
         <div class="icon">
           <i class="ion ion-pie-graph"></i>
         </div>
         <a href="http://localhost/App-perpus/admin/Pinjam" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>

     <div class="col-lg-3 col-6">
       <!-- small box -->
       <div class="small-box bg-danger" style="background-color: #dc3545!important;">
         <div class="inner">
           <h3 style="color: white;"><?= $count_kembali; ?></h3>
           <p style="color: white;">Report</p>
         </div>
         <div class="icon">
           <i class="ion ion-person-add"></i>
         </div>
         <a href="http://localhost/App-perpus/admin/Report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>

     <!-- AREA CHART -->


     <div class="row">
       <div class=" col-md-6">

       </div>
     </div>
     <!-- /.box -->

     <!-- DONUT CHART -->
     <!-- <div class="box box-danger">
         <div class="box-header with-border">
           <h3 class="box-title">Grafik 10 Kategori Dipinjam Terbanyak</h3>

           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
             </button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
           </div>
         </div>
         <div class="box-body">
           <canvas id="pieChart" style="height:250px"></canvas>
         </div> -->
     <!-- /.box-body -->
     <!-- </div> -->
     <!-- /.box -->

     <!-- </div> -->
     <!-- /.col (LEFT) -->
     <!-- <div class="col-md-6"> -->
     <!-- LINE CHART -->
     <!-- <div class="box box-info">
       <div class="box-header with-border">
         <h3 class="box-title">Grafik 10 Buku Terbanyak Dipinjam Terbanyak</h3>

         <div class="box-tools pull-right">
           <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
           </button>
           <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
         </div>
       </div>
       <div class="box-body">
         <div class="chart">
           <canvas id="lineChart" style="height:250px"></canvas>
         </div>
       </div> -->
     <!-- /.box-body -->
     <!-- </div> -->
     <!-- /.box -->

     <!-- BAR CHART -->
     <!-- <div class="box box-success">
     <div class="box-header with-border">
       <h3 class="box-title">Grafik 10 Kelas Peminjam Terbanyak</h3>

       <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
         </button>
         <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
       </div>
     </div>
     <div class="box-body">
       <div class="chart">
         <canvas id="barChart" style="height:230px"></canvas>
       </div>
     </div> -->
     <!-- /.box-body -->
     <!-- </div> -->
     <!-- /.box -->

     <!-- </div> -->
     <!-- /.col (RIGHT) -->
   </div>
   <!-- /.row -->

 </section>
 <!-- /.content -->