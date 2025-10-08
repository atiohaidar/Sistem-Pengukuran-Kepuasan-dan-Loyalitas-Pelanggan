@extends('layouts.master')
@section('judul','Visualisasi Indikator Kepuasan')

@section('content')
<div class="row">
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="grafik1"></div>
     
    </figure>
    
  </div>

  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="grafik2"></div>
      <?php
      $persentase_1 = ($k1_rata_count_1/$k1_count)*100;
      $persentase_2 = ($k1_rata_count_2/$k1_count)*100;
      $persentase_3 = ($k1_rata_count_3/$k1_count)*100;
      $persentase_4 = ($k1_rata_count_4/$k1_count)*100;
      $persentase_5 = ($k1_rata_count_5/$k1_count)*100;

      $probabilitas_1 = 0.00;
      $probabilitas_2 = 0.25;
      $probabilitas_3 = 0.50;
      $probabilitas_4 = 0.75;
      $probabilitas_5 = 1.00;

      $persentase_propabilitas_1 = $persentase_1*$probabilitas_1;
      $persentase_propabilitas_2 = $persentase_2*$probabilitas_2;
      $persentase_propabilitas_3 = $persentase_3*$probabilitas_3;
      $persentase_propabilitas_4 = $persentase_4*$probabilitas_4;
      $persentase_propabilitas_5 = $persentase_5*$probabilitas_5;

      $frekuensi_probabilitas_1 = $k1_rata_count_1*$probabilitas_1;
      $frekuensi_probabilitas_2 = $k1_rata_count_2*$probabilitas_2;
      $frekuensi_probabilitas_3 = $k1_rata_count_3*$probabilitas_3;
      $frekuensi_probabilitas_4 = $k1_rata_count_4*$probabilitas_4;
      $frekuensi_probabilitas_5 = $k1_rata_count_5*$probabilitas_5;

      $total = $frekuensi_probabilitas_1+$frekuensi_probabilitas_2+$frekuensi_probabilitas_3+$frekuensi_probabilitas_4+$frekuensi_probabilitas_5;

    
      ?>

      <center>Dari {{ $k1_count }} orang, maka jumlah pelanggan yang berpotensi untuk menjadi loyal adalah sebanyak {{ number_format($total,0) }}  orang</center>
    </figure>
    
  </div>
  
</div>


@endsection

@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
Highcharts.chart('grafik1', {
    chart: {
        type: 'bar',
        height : 300
    },
    
    title: {
        text: 'Gap antara layanan yang ideal dan yang diharapkan'
    },
    xAxis: {
        categories: ['Gap', 'Menurut saya, layanan pelatihan ini telah sesuai dengan layanan pelatihan yang ideal', 'Menurut saya, kinerja pelatihan ini telah sesuai dengan harapan saya'],
        title: {
            text: null
        }
    },
    
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: "Total",
        data: [{{ number_format($gap,2) }}, {{ number_format($total_rata_k3,2) }} ,{{ number_format($total_rata_k2,2) }}]
    }]
});
          


// Create the chart
Highcharts.chart('grafik2', {
  chart: {
    type: 'column',
    height : 500
  },
  title: {
    text: 'Secara keseluruhan, saya merasa puas pada layanan pelatihan ini'
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Total'
    }

  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y:.0f}'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> <br/>'
  },

  series: [
    {
      name: "Total",
      colorByPoint: true,
      data: [
        {
          name: "Sangat tidak setuju",
          y: {{ number_format($k1_rata_count_1,2)  }}
        },
        {
          name: "Tidak setuju",
          y: {{ number_format($k1_rata_count_2,2)  }}
        },
        {
          name: "Netral",
          y: {{ number_format($k1_rata_count_3,2)  }}
        }
        ,
        {
          name: "Setuju",
          y: {{ number_format($k1_rata_count_4,2)  }}
        }
        ,
        {
          name: "Sangat setuju",
          y: {{ number_format($k1_rata_count_5,2)  }}
        }
      ]
    }
  ]
});


</script>
@endsection