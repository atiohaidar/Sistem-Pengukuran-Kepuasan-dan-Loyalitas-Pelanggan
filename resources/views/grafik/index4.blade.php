@extends('layouts.master')
@section('judul','Visualisasi Rata-rata Persepsi, Harapan dan Gap per Dimensi')

@section('content')
<figure class="highcharts-figure">
  <div id="keandalan"></div>
  <table class="table table-bordered" style="background-color: powderblue">
    <tr>
      <td></td>
      <td>Realibility</td>
      <td>Assurance</td>
      <td>Tangible</td>
      <td>Empanthy</td>
      <td>Responsiveness</td>
      <td>Applicability</td>
    </tr>
    <tr>
      <td>Rata-rata persepsi</td>
      <td>{{ number_format($total_rpersepsi,2)  }}</td>
      <td>{{ number_format($total_apersepsi,2)  }}</td>
      <td>{{ number_format($total_tpersepsi,2)  }}</td>
      <td>{{ number_format($total_epersepsi,2)  }}</td>
      <td>{{ number_format($total_rspersepsi,2)  }}</td>
      <td>{{ number_format($total_rlpersepsi,2)  }}</td>
    </tr>
    <tr>
      <td>Rata-rata harapan</td>
      <td>{{ number_format($total_rkepentingan,2)  }}</td>
      <td>{{ number_format($total_akepentingan,2)  }}</td>
      <td>{{ number_format($total_tkepentingan,2)  }}</td>
      <td>{{ number_format($total_ekepentingan,2)  }}</td>
      <td>{{ number_format($total_rskepentingan,2)  }}</td>
      <td>{{ number_format($total_rlkepentingan,2)  }}</td>
    </tr>
    <tr>
      <td>Gap</td>
      <td>{{ number_format($total_rgap,3)  }}</td>
      <td>{{ number_format($total_agap,3)  }}</td>
      <td>{{ number_format($total_tgap,3)  }}</td>
      <td>{{ number_format($total_egap,3)  }}</td>
      <td>{{ number_format($total_rsgap,3)  }}</td>
      <td>{{ number_format($total_rlgap,3)  }}</td>
    </tr>
  </table>
</figure>

@endsection

@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
Highcharts.chart('keandalan', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Rata-rata Persepsi , Harapan & Gap per dimensi'
    },
    xAxis: {
        categories: ['Realibility', 'Assurance', 'Tangible', 'Empathy', 'Responsiveness', 'Applicability']
    },
    credits: {
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
    series: [{
        name: 'Rata-rata persepsi dimensi',
        color: '#0000FF',
        data: [{{ number_format($total_rpersepsi,2)  }}, {{ number_format($total_apersepsi,2)  }}, {{ number_format($total_tpersepsi,2)  }}, {{ number_format($total_epersepsi,2)  }}, {{ number_format($total_rspersepsi,2)  }}, {{ number_format($total_rlpersepsi,2)  }}]
    }, {
        name: 'Rata-rata harapan dimensi',
        color: '#D2691E',
        data: [{{ number_format($total_rkepentingan,2)  }}, {{ number_format($total_akepentingan,2)  }}, {{ number_format($total_tkepentingan,2)  }}, {{ number_format($total_ekepentingan,2)  }}, {{ number_format($total_rskepentingan,2)  }}, {{ number_format($total_rlkepentingan,2)  }}]
    }, {
        name: 'Gap dimensi',
        color: '#2F4F4F',
        data: [{{ number_format($total_rgap,3)  }}, {{ number_format($total_agap,3)  }}, {{ number_format($total_tgap,3)  }}, {{ number_format($total_egap,3)  }}, {{ number_format($total_rsgap,3)  }}, {{ number_format($total_rlgap,3)  }}]
    }]
});
</script>
@endsection