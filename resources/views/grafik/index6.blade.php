@extends('layouts.master')
@section('judul','Visualisasi Indikator Loyalitas')

@section('content')
<div class="row">
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="gfarik1"></div>
            <center>Dari {{ $l1_rata_count }} orang, maka jumlah pelanggan yang diprediksikan akan mengulangi menggunakan jasa pelatihan ini adalah sebanyak {{ number_format($l1_probability_data['total_probability'],0) }} orang</center>
    </figure>
    
  </div>
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="gfarik2"></div>
      <center>Dari {{ $l2_rata_count }} orang, maka jumlah pelanggan yang diprediksikan tidak akan berpindah ke pesaing adalah sebanyak {{ number_format($l2_probability_data['total_probability'],0) }} orang</center>
    </figure>
  </div>
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="gfarik3"></div>
      <center>Dari {{ $l3_rata_count }} orang, maka jumlah pelanggan yang diprediksikan akan merekomendasikan pelatihan ini kepada orang lain adalah sebanyak {{ number_format($l3_probability_data['total_probability'],0) }} orang</center>
    </figure>
  </div>
  <div class="col-lg-4 mt-2">
    <!-- Widget: user widget style 2 -->
    <div class="card card-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-primary">
        <h4 class="text-center">Index Loyalitas Pelanggan</h4>
        
      </div>
      <div class="card-footer p-0">
        <div class="page">
          <div class="clearfix">
              
              <div class="c100 p{{ number_format($total_l_rata,0) }} big">
                  <span>{{ number_format($total_l_rata,2) }} %</span>
                  <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                  </div>
              </div>
          </div>
        </div>
        <table class="table table-bordered">
          <tr class="bg-primary">
            <td>Index Loyalitas Pelanggan</td>
            <td>Keterangan</td>
          </tr>
          <tr>
            <td>0% - 25%</td>
            <td>Tidak loyal</td>
          </tr>
          <tr>
            <td>25.01% - 50%</td>
            <td>Kurang loyal</td>
          </tr>
          <tr>
            <td>50.01% - 70%</td>
            <td>Cukup loyal</td>
          </tr>
          <tr>
            <td>70.01% - 90%</td>
            <td>Loyal</td>
          </tr>
          <tr>
            <td>90.01% - 100%</td>
            <td>Sangat loyal</td>
          </tr>
        </table>

      </div>
    </div>
    
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
// Create the chart
Highcharts.chart('gfarik1', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Saya akan mengulangi menggunakan jasa pelatihan ini'
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
      name: "Info",
      colorByPoint: true,
      data: [
        {
          name: "Sangat tidak setuju",
          y: {{ number_format($l1_rata_count_1,2)  }}
        },
        {
          name: "Tidak setuju",
          y: {{ number_format($l1_rata_count_2,2)  }}
        },
        {
          name: "Netral",
          y: {{ number_format($l1_rata_count_3,2)  }}
        }
        ,
        {
          name: "Setuju",
          y: {{ number_format($l1_rata_count_4,2)  }}
        }
        ,
        {
          name: "Sangat setuju",
          y: {{ number_format($l1_rata_count_5,2)  }}
        }
      ]
    }
  ]
});

// Create the chart
Highcharts.chart('gfarik2', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Saya akan tetap memilih jasa pelatihan ini meskipun tersedia alternatif pelatihan lain'
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
      name: "Info",
      colorByPoint: true,
      data: [
        {
          name: "Sangat tidak setuju",
          y: {{ number_format($l2_rata_count_1,2)  }}
        },
        {
          name: "Tidak setuju",
          y: {{ number_format($l2_rata_count_2,2)  }}
        },
        {
          name: "Netral",
          y: {{ number_format($l2_rata_count_3,2)  }}
        }
        ,
        {
          name: "Setuju",
          y: {{ number_format($l2_rata_count_4,2)  }}
        }
        ,
        {
          name: "Sangat setuju",
          y: {{ number_format($l2_rata_count_5,2)  }}
        }
      ]
    }
  ]
});


// Create the chart
Highcharts.chart('gfarik3', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Saya akan merekomendasikan pelatihan ini kepada orang lain'
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
      name: "Info",
      colorByPoint: true,
      data: [
        {
          name: "Sangat tidak setuju",
          y: {{ number_format($l3_rata_count_1,2)  }}
        },
        {
          name: "Tidak setuju",
          y: {{ number_format($l3_rata_count_2,2)  }}
        },
        {
          name: "Netral",
          y: {{ number_format($l3_rata_count_3,2)  }}
        }
        ,
        {
          name: "Setuju",
          y: {{ number_format($l3_rata_count_4,2)  }}
        }
        ,
        {
          name: "Sangat setuju",
          y: {{ number_format($l3_rata_count_5,2)  }}
        }
      ]
    }
  ]
});



</script>
@endsection