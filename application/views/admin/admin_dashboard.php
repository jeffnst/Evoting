<div class="box box-default">

<div class="box-header with-border">
<i class="fa fa-bullhorn"> </i>
<h3 class="box-title"> Hasil Pemilihan Ketua Osis </h3>
</div>
<div class="box-body">
<div class="col-md-3 col-sm-6 col-xs-12">
          
          <div class="info-box with-border" style="box-shadow: 3px 3px 3px #333;">
            <div class="info-box-icon bg-aqua" style="font-size: 45px; line-height: 55px">  
                <span class="inner" ><?php echo $pemilih_kandidat1 ;?></span> 
                <span class="inner"> <h5> Suara </h5> </span>
            </div>
            <div class="info-box-content" style="padding: 10px 10px 3px 2px;">
              
            <?php 
            if($box1){
              echo $box1;
            }
            ;?>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->  


<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box with-border" style="box-shadow: 3px 3px 3px #333;">
            <div class="info-box-icon bg-green" style="font-size: 45px; line-height: 55px">  
            <span class="inner" ><?php echo $pemilih_kandidat2 ;?></span> 
            <span class="inner"> <h5> Suara </h5> </span>
            </div>
            <div class="info-box-content" style="padding: 10px 10px 3px 2px;">
            <?php 
            if($box2){
              echo $box2;
            }
            ;?>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->  

<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box with-border" style="box-shadow: 3px 3px 3px #333;">
            <div class="info-box-icon bg-yellow" style="font-size: 45px; line-height: 55px">  
            <span class="inner" ><?php echo $pemilih_kandidat3 ;?></span> 
            <span class="inner"> <h5> Suara </h5> </span>
            </div>

            <div class="info-box-content" style="padding: 10px 10px 3px 2px;">
             <?php 
            if($box3){
              echo $box3;
            }
            ;?>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->  

<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box with-border" style="box-shadow: 3px 3px 3px #333;">
            <div class="info-box-icon bg-red" style="font-size: 55px; line-height: 90px">  
            <span class="inner" ><i class="fa fa-star-o"></i></span> 
            <span class="inner">  </span>
            </div>
            <div class="info-box-content">
              <span class="info-box-text">Jumlah Suara :</span>
              <span class="info-box-number"><?php echo $total_pemilih ;?></span>
              <span class="info-box-text">Suara</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->  
</div>
</div>


<div class="row">
  


<!-- BAR CHART -->
      <div class="col-xs-6">  
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Hasil Pemilihan</h3>

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
            </div>
            <!-- /.box-body -->
          </div>
      </div>



<!-- /.row -->
<!-- Main row -->

  <!-- Left col -->
  <section class="">
    <!-- Custom tabs (Charts with tabs)-->
    
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-6k2t{background-color:#D2E4FC;vertical-align:top}
</style>

<div class="col-xs-6">
<div class="box printcontent">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Tabel Hasil Pemilihan</b></h3>
    <div class="btn btn-info pull-right printbtn"id="printbtn"> <b> <i class="fa fa-print"> Print</i></b></div>
  </div>
      <div class="box-body">  
        <table class="tg table">
          <tr>
            <th class="tg-yw4l">No Urut</th>
            <th class="tg-yw4l">Nama Pasangan Calon<br></th>
            <th class="tg-yw4l">Jumlah Suara<br></th>
          </tr>
          <tr>
            <td class="tg-6k2t">1</td>
            <td class="tg-6k2t"><?php echo $paslon1;?></td>
            <td class="tg-6k2t"><?php echo $pemilih_kandidat1 ;?></td>
          </tr>
          <tr>
            <td class="tg-yw4l">2</td>
            <td class="tg-yw4l"><?php echo $paslon2;?></td>
            <td class="tg-yw4l"><?php echo $pemilih_kandidat2 ;?></td>
          </tr>
          <tr>
            <td class="tg-6k2t">3</td>
            <td class="tg-6k2t"><?php echo $paslon3;?></td>
            <td class="tg-6k2t"><?php echo $pemilih_kandidat3 ;?></td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Total Suara</td>
            <td class="tg-yw4l"><?php $total =  $pemilih_kandidat1+$pemilih_kandidat2+$pemilih_kandidat3;
            echo $total?></td>
          </tr>
          <tr>
            <td class="tg-6k2t" colspan="2">Total DPT</td>
            <td class="tg-6k2t"><?php echo $total_dpt ; ?></td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Selisih</td>
            <td class="tg-yw4l"><?php $selisih=$total_dpt-$total;
            echo $selisih; ?></td>
          </tr>
        </table>
        </div>  <!-- /.box body -->
        </div>  <!-- /.box -->
</div>

  </section>
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->

  <!-- right col -->
</div>
<!-- /.row (main row) -->
<!-- page script -->
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url() ?>aset/plugins/chartjs/Chart.min.js"></script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    
    var ChartDataSet = {
      labels: ["Pasangan 1", "Pasangan 2", "Pasangan 3"],
      datasets: [
        {
          label: "Jumlah Suara",
          backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
               
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1,
            data: <?php echo json_encode($grafik); ?>,
        }
    ]
         
        };
        
      

    
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = ChartDataSet;
     barChartData.datasets[0].fillColor = ['#00c0ef','#00a65a','#f39c12'];
   // barChartData.datasets[0].strokeColor = "#00a65a";
   // barChartData.datasets[0].pointColor = "#00a65a";
    

    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 10,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 10,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = true;
    barChart.Bar(barChartData, barChartOptions);
  });
</script>
<script type="text/javascript">
$('.printbtn').printPreview ({
obj2print:'.printcontent',
width:'800',
height:screen.height,
scrollbars:'no',
title:'Print Preview'

});

</script>