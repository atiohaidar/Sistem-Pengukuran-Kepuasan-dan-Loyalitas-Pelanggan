@extends('layouts.master')
@section('judul','Visualisasi')

@section('content')
<div class="row">
  <div class="col-lg-4 col-md-4">
    
    <!-- Widget: user widget style 2 -->
    <div class="card card-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-success">
        <h4 class="text-center">Indeks Kepuasan Pelanggan</h4>
      </div>
      <div class="card-footer p-0">
          
        <div class="page">
           
          <div class="clearfix">
              <div class="c100 p{{ number_format($totalikp,0) }} big green">
                  <span>{{ number_format($totalikp,2) }} %</span>
                  <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                  </div>
              </div>
          </div>
          
        </div>
        
        <table class="table table-bordered">
          <tr class="bg-success">
            <td>Indeks Kepuasan Pelanggan</td>
            <td>Keterangan</td>
          </tr>
          <tr>
            <td>0% - 34%</td>
            <td>Tidak puas</td>
          </tr>
          <tr>
            <td>35% - 50%</td>
            <td>Kurang puas</td>
          </tr>
          <tr>
            <td>51% - 65%</td>
            <td>Cukup puas</td>
          </tr>
          <tr>
            <td>66% - 80%</td>
            <td>Puas</td>
          </tr>
          <tr>
            <td>81% - 100%</td>
            <td>Sangat puas</td>
          </tr>
        </table>


      </div>
    </div>
    
  </div>

  <div class="col-lg-8 col-md-8">
    
    <figure class="highcharts-figure">
      <div id="grafik1"></div>
     <center>Rata-rata Gap terbesar antara persepsi dan harapan pelanggan ada pada dimensi realibility dan empathy</center>
    </figure>
<hr />
    <figure class="highcharts-figure">
      <div id="grafik2"></div>
     
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
        type: 'bar'
    },
    title: {
        text: 'Rata-Rata  Gap Antara Persepsi dan Harapan Per Dimensi'
    },
    xAxis: {
        categories: ['Reliability', 'Empathy', 'Assurance','Responsiveness','Tangible','Applicability'],
        title: {
            text: null
        },
        
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
        data: [{{ number_format($rata_gap_r,3) }},
                {{ number_format($rata_gap_e,3) }}, 
               {{ number_format($rata_gap_a,3) }},
               {{ number_format($rata_gap_rs,3) }}, 
               {{ number_format($rata_gap_t,3) }}, 
               {{ number_format($rata_gap_rl,3) }}]
    }]
});
        
          

// Create the chart
Highcharts.chart('grafik2', {
  chart: {
    type: 'column',
    height : 300
  },
  title: {
    text: 'Standar Deviasi'
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
        format: '{point.y:.2f}'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
  },

  series: [
    {
      name: "Total",
      colorByPoint: true,
      data: [
        {
          name: "Reliability",
          y: {{ number_format($deviasi_r,2)  }}
        },
        {
          name: "Empathy",
          y: {{ number_format($deviasi_e,2)  }}
        },
        {
          name: "Assurance",
          y: {{ number_format($deviasi_a,2)  }}
        }
        ,
        {
          name: "Responsiveness",
          y: {{ number_format($deviasi_rs,2)  }}
        }
        ,
        {
          name: "Tangible",
          y: {{ number_format($deviasi_t,2)  }}
        },
        {
          name: "Applicability",
          y: {{ number_format($deviasi_rl,2)  }}
        }
      ]
    }
  ]
});

</script>
@endsection