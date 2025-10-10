@extends('layouts.master')
@section('judul','Visualisasi Rata-rata Persepsi, Harapan dan Gap per Indikator')

@section('content')

  
    
      <div class="row">
      <div class="col-lg-12 mt-2">
        <figure class="highcharts-figure">
          <div id="keandalan"></div>
        </figure>
      <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
        <tr>
          <td></td>
          <td>R1</td>
          <td>R2</td>
          <td>R3</td>
          <td>R4</td>
          <td>R5</td>
          <td>R6</td>
          <td>R7</td>
        </tr>
        <tr>
          <td>Rata-rata persepsi</td>
          <td>{{ number_format($r1_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r2_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r3_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r4_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r5_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r6_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($r7_ratapersepsi_rata,2)  }}</td>
        </tr>
        <tr>
          <td>Rata-rata harapan</td>
          <td>{{ number_format($r1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r5_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r6_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r7_ratakepentingan_rata,2)  }}</td>
        </tr>
        <tr>
          <td>Gap</td>
          <td>{{ number_format($r1_ratapersepsi_rata-$r1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r2_ratapersepsi_rata-$r2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r3_ratapersepsi_rata-$r3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r4_ratapersepsi_rata-$r4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r5_ratapersepsi_rata-$r5_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r6_ratapersepsi_rata-$r6_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($r7_ratapersepsi_rata-$r7_ratakepentingan_rata,2)  }}</td>
        </tr>
      </table>
    </div>
    <div class="col-lg-12 mt-2">
      <figure class="highcharts-figure">
        <div id="bukti_fisik"></div>
      </figure>
      <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
        <tr>
          <td></td>
          <td>T1</td>
          <td>T2</td>
          <td>T3</td>
          <td>T4</td>
          <td>T5</td>
          <td>T6</td>
        </tr>
        <tr>
          <td>Rata-rata persepsi</td>
          <td>{{ number_format($t1_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($t2_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($t3_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($t4_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($t5_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($t6_ratapersepsi_rata,2)  }}</td>
        </tr>
        <tr>
          <td>Rata-rata harapan</td>
          <td>{{ number_format($t1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t5_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t6_ratakepentingan_rata,2)  }}</td>
        </tr>
        <tr>
          <td>Gap</td>
          <td>{{ number_format($t1_ratapersepsi_rata-$t1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t2_ratapersepsi_rata-$t2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t3_ratapersepsi_rata-$t3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t4_ratapersepsi_rata-$t4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t5_ratapersepsi_rata-$t5_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($t6_ratapersepsi_rata-$t6_ratakepentingan_rata,2)  }}</td>
        </tr>
      </table>
    </div>
    <div class="col-lg-12 mt-2">
      <figure class="highcharts-figure">
      <div id="daya_tanggap"></div>
      </figure>
      <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
        <tr>
          <td></td>
          <td>RS1</td>
          <td>RS2</td>
          
          
        </tr>
        <tr>
          <td>Rata-rata persepsi</td>
          <td>{{ number_format($rs1_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($rs2_ratapersepsi_rata,2)  }}</td>
        
          
        </tr>
        <tr>
          <td>Rata-rata harapan</td>
          <td>{{ number_format($rs1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($rs2_ratakepentingan_rata,2)  }}</td>
        
          
        </tr>
        <tr>
          <td>Gap</td>
          <td>{{ number_format($rs1_ratapersepsi_rata-$rs1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($rs2_ratapersepsi_rata-$rs2_ratakepentingan_rata,2)  }}</td>
        
        
        </tr>
      </table>
    
    </div>
    <div class="col-lg-12 mt-2">
      <figure class="highcharts-figure">
      <div id="jaminan"></div>
      </figure>
      <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
        <tr>
          <td></td>
          <td>A1</td>
          <td>A2</td>
          <td>A3</td>
          <td>A4</td>
        </tr>
        <tr>
          <td>Rata-rata persepsi</td>
          <td>{{ number_format($a1_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($a2_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($a3_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($a4_ratapersepsi_rata,2)  }}</td>
          
        </tr>
        <tr>
          <td>Rata-rata harapan</td>
          <td>{{ number_format($a1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a4_ratakepentingan_rata,2)  }}</td>
          
        </tr>
        <tr>
          <td>Gap</td>
          <td>{{ number_format($a1_ratapersepsi_rata-$a1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a2_ratapersepsi_rata-$a2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a3_ratapersepsi_rata-$a3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($a4_ratapersepsi_rata-$a4_ratakepentingan_rata,2)  }}</td>
          
        </tr>
      </table>
    </div>
    
  
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="empati"></div>
    </figure>
      <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
        <tr>
          <td></td>
          <td>E1</td>
          <td>E2</td>
          <td>E3</td>
          <td>E4</td>
          <td>E5</td>
        
        </tr>
        <tr>
          <td>Rata-rata persepsi</td>
          <td>{{ number_format($e1_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($e2_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($e3_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($e4_ratapersepsi_rata,2)  }}</td>
          <td>{{ number_format($e5_ratapersepsi_rata,2)  }}</td>
        
        </tr>
        <tr>
          <td>Rata-rata harapan</td>
          <td>{{ number_format($e1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e5_ratakepentingan_rata,2)  }}</td>
        
        </tr>
        <tr>
          <td>Gap</td>
          <td>{{ number_format($e1_ratapersepsi_rata-$e1_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e2_ratapersepsi_rata-$e2_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e3_ratapersepsi_rata-$e3_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e4_ratapersepsi_rata-$e4_ratakepentingan_rata,2)  }}</td>
          <td>{{ number_format($e5_ratapersepsi_rata-$e5_ratakepentingan_rata,2)  }}</td>
        
        </tr>
      </table>
    
  </div>
  
  
  <div class="col-lg-12 mt-2">
    <figure class="highcharts-figure">
      <div id="relevansi"></div>
    </figure>
    <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap" style="background-color: powderblue">
      <tr>
        <td></td>
        <td>AP1</td>
        <td>AP2</td>
        
        
      </tr>
      <tr>
        <td>Rata-rata persepsi</td>
        <td>{{ number_format($ap1_ratapersepsi_rata,2)  }}</td>
        <td>{{ number_format($ap2_ratapersepsi_rata,2)  }}</td>
        
      </tr>
      <tr>
        <td>Rata-rata harapan</td>
        <td>{{ number_format($ap1_ratakepentingan_rata,2)  }}</td>
        <td>{{ number_format($ap2_ratakepentingan_rata,2)  }}</td>
        
      </tr>
      <tr>
        <td>Gap</td>
        <td>{{ number_format($ap1_ratapersepsi_rata-$ap1_ratakepentingan_rata,2)  }}</td>
        <td>{{ number_format($ap2_ratapersepsi_rata-$ap2_ratakepentingan_rata,2)  }}</td>
      
      </tr>
    </table>
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
Highcharts.chart('keandalan', {
    chart: {
        type: 'column',
        height: 600
        
    },
    title: {
        text: 'Dimensi Reliability'
    },
    xAxis: {
        categories: ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7']
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($r1_ratapersepsi_rata,3)  }}, {{ number_format($r2_ratapersepsi_rata,3)  }}, {{ number_format($r3_ratapersepsi_rata,3)  }}, {{ number_format($r4_ratapersepsi_rata,3)  }}, {{ number_format($r5_ratapersepsi_rata,3)  }}, {{ number_format($r6_ratapersepsi_rata,3)  }}, {{ number_format($r7_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($r1_ratakepentingan_rata,3)  }}, {{ number_format($r2_ratakepentingan_rata,3)  }}, {{ number_format($r3_ratakepentingan_rata,3)  }}, {{ number_format($r4_ratakepentingan_rata,3)  }}, {{ number_format($r5_ratakepentingan_rata,3)  }}, {{ number_format($r6_ratakepentingan_rata,3)  }}, {{ number_format($r7_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($r1_ratapersepsi_rata-$r1_ratakepentingan_rata,3)  }}, {{ number_format($r2_ratapersepsi_rata-$r2_ratakepentingan_rata,3)  }}, {{ number_format($r3_ratapersepsi_rata-$r3_ratakepentingan_rata,3)  }}, {{ number_format($r4_ratapersepsi_rata-$r4_ratakepentingan_rata,3)  }}, {{ number_format($r5_ratapersepsi_rata-$r5_ratakepentingan_rata,3)  }}, {{ number_format($r6_ratapersepsi_rata-$r6_ratakepentingan_rata,3)  }}, {{ number_format($r7_ratapersepsi_rata-$r7_ratakepentingan_rata,3)  }}]
    }]
});

Highcharts.chart('jaminan', {
    chart: {
        type: 'column',
        height: 600
    },
    title: {
        text: 'Dimensi Assurance'
    },
    xAxis: {
        categories: ['A1', 'A2', 'A3', 'A4']
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($a1_ratapersepsi_rata,3)  }}, {{ number_format($a2_ratapersepsi_rata,3)  }}, {{ number_format($a3_ratapersepsi_rata,3)  }}, {{ number_format($a4_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($a1_ratakepentingan_rata,3)  }}, {{ number_format($a2_ratakepentingan_rata,3)  }}, {{ number_format($a3_ratakepentingan_rata,3)  }}, {{ number_format($a4_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($a1_ratapersepsi_rata-$a1_ratakepentingan_rata,3)  }}, {{ number_format($a2_ratapersepsi_rata-$a2_ratakepentingan_rata,3)  }}, {{ number_format($a3_ratapersepsi_rata-$a3_ratakepentingan_rata,3)  }}, {{ number_format($a4_ratapersepsi_rata-$a4_ratakepentingan_rata,3)  }}]
    }]
});

Highcharts.chart('bukti_fisik', {
    chart: {
        type: 'column',
        height: 600
    },
    title: {
        text: 'Dimensi Tangible'
    },
    xAxis: {
        categories: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6']
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($t1_ratapersepsi_rata,3)  }}, {{ number_format($t2_ratapersepsi_rata,3)  }}, {{ number_format($t3_ratapersepsi_rata,3)  }}, {{ number_format($t4_ratapersepsi_rata,3)  }}, {{ number_format($t5_ratapersepsi_rata,3)  }}, {{ number_format($t6_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($t1_ratakepentingan_rata,3)  }}, {{ number_format($t2_ratakepentingan_rata,3)  }}, {{ number_format($t3_ratakepentingan_rata,3)  }}, {{ number_format($t4_ratakepentingan_rata,3)  }}, {{ number_format($t5_ratakepentingan_rata,3)  }}, {{ number_format($t6_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($t1_ratapersepsi_rata-$t1_ratakepentingan_rata,3)  }}, {{ number_format($t2_ratapersepsi_rata-$t2_ratakepentingan_rata,3)  }}, {{ number_format($t3_ratapersepsi_rata-$t3_ratakepentingan_rata,3)  }}, {{ number_format($t4_ratapersepsi_rata-$t4_ratakepentingan_rata,3)  }}, {{ number_format($t5_ratapersepsi_rata-$t5_ratakepentingan_rata,3)  }}, {{ number_format($t6_ratapersepsi_rata-$t6_ratakepentingan_rata,3)  }}]
    }]
});

Highcharts.chart('empati', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Dimensi Empathy'
    },
    xAxis: {
        categories: ['E1', 'E2', 'E3', 'E4', 'E5']
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($e1_ratapersepsi_rata,3)  }}, {{ number_format($e2_ratapersepsi_rata,3)  }}, {{ number_format($e3_ratapersepsi_rata,3)  }}, {{ number_format($e4_ratapersepsi_rata,3)  }}, {{ number_format($e5_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($e1_ratakepentingan_rata,3)  }}, {{ number_format($e2_ratakepentingan_rata,3)  }}, {{ number_format($e3_ratakepentingan_rata,3)  }}, {{ number_format($e4_ratakepentingan_rata,3)  }}, {{ number_format($e5_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($e1_ratapersepsi_rata-$e1_ratakepentingan_rata,3)  }}, {{ number_format($e2_ratapersepsi_rata-$e2_ratakepentingan_rata,3)  }}, {{ number_format($e3_ratapersepsi_rata-$e3_ratakepentingan_rata,3)  }}, {{ number_format($e4_ratapersepsi_rata-$e4_ratakepentingan_rata,3)  }}, {{ number_format($e5_ratapersepsi_rata-$e5_ratakepentingan_rata,3)  }}]
    }]
});


Highcharts.chart('daya_tanggap', {
    chart: {
        type: 'column',
        height: 600
    },
    title: {
        text: 'Dimensi Responsiveness'
    },
    xAxis: {
        categories: ['RS1', 'RS2']
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($rs1_ratapersepsi_rata,3)  }}, {{ number_format($rs2_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($rs1_ratakepentingan_rata,3)  }}, {{ number_format($rs2_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($rs1_ratapersepsi_rata-$rs1_ratakepentingan_rata,3)  }}, {{ number_format($rs2_ratapersepsi_rata-$rs2_ratakepentingan_rata,3)  }}]
    }]
});


Highcharts.chart('relevansi', {
    chart: {
        type: 'column',
        height: 600
    },
    title: {
        text: 'Dimensi Applicability'
    },
    xAxis: {
        categories: ['AP1', 'AP2'],
        
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
        name: 'Rata-rata persepsi',
        color: '#0000FF',
        data: [{{ number_format($ap1_ratapersepsi_rata,3)  }}, {{ number_format($ap2_ratapersepsi_rata,3)  }}]
    }, {
        name: 'Rata-rata harapan',
        color: '#D2691E',
        data: [{{ number_format($ap1_ratakepentingan_rata,3)  }}, {{ number_format($ap2_ratakepentingan_rata,3)  }}]
    }, {
        name: 'Gap',
        color: '#2F4F4F',
        data: [{{ number_format($ap1_ratapersepsi_rata-$ap1_ratakepentingan_rata,3)  }}, {{ number_format($ap2_ratapersepsi_rata-$ap2_ratakepentingan_rata,3)  }}]
    }]
});



</script>
@endsection