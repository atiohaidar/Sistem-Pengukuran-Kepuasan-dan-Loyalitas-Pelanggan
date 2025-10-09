@extends('layouts.master')
@section('judul','Visualisasi Profil Responden')

@section('content')
<div class="row">
    <div class="col-lg-6 mt-2">
        <figure class="highcharts-figure">
        <div id="container1"></div>
        </figure>
    </div>

    <div class="col-lg-6 mt-2">
        <figure class="highcharts-figure">
        <div id="container2"></div>
        </figure>
    </div>

    <div class="col-lg-6 mt-2">
        <figure class="highcharts-figure">
        <div id="container3"></div>
        </figure>
    </div>

    <div class="col-lg-6 mt-2">
        <figure class="highcharts-figure">
        <div id="container4"></div>
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
//usia responden
Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Jenis Kelamin Berdasarkan Usia Responden'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}%'
            }
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}%</b> of total<br/>'
    },
    xAxis: {
        categories: ['<25 tahun', '25-34 tahun', '35-44 tahun', '45-54 tahun', '55-64 tahun', '>64 tahun']
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Laki-laki',
        data: [{{ number_format($persentase_usia25_lk,0)  }}, {{ number_format($persentase_usia25_34_lk,0)  }}, {{ number_format($persentase_usia35_44_lk,0)  }}, {{ number_format($persentase_usia45_54_lk,0)  }}, {{ number_format($persentase_usia55_64_lk,0)  }}, {{ number_format($persentase_usia64_lk,0)  }}]
    }, {
        name: 'Perempuan',
        data: [{{ number_format($persentase_usia25_pr,0)  }}, {{ number_format($persentase_usia25_34_pr,0)  }}, {{ number_format($persentase_usia35_44_pr,0)  }}, {{ number_format($persentase_usia45_54_pr,0)  }}, {{ number_format($persentase_usia55_64_pr,0)  }}, {{ number_format($persentase_usia64_pr,0)  }}]
    }]
});


//total usia responden
// Create the chart
Highcharts.chart('container2', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Usia Responden'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.2f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Total",
            colorByPoint: true,
            data: [
                {
                    name: "Umur <25",
                    y: {{ $total_usia25  }}
                   
                },
                {
                    name: "Umur 25-34",
                    y: {{ $total_usia25_34  }}
                   
                },
                {
                    name: "Umur 35-44",
                    y: {{ $total_usia35_44  }}
                   
                },
                {
                    name: "Umur 45-54",
                    y: {{ $total_usia45_54  }}
                   
                },
                {
                    name: "Umur 55-64",
                    y: {{ $total_usia55_64  }}
                   
                },
                {
                    name: "Umur >64",
                    y: {{ $total_usia64  }}
                    
                }
            ]
        }
    ]
            
});


//pekerjaan
// Create the chart
Highcharts.chart('container3', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Pekerjaan Responden'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.2f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Total",
            colorByPoint: true,
            data: [
                {
                    name: "Karyawan swasta",
                    y: {{ $total_swasta  }}
                   
                },
                {
                    name: "Wiraswasta",
                    y: {{ $total_wiraswasta  }}
                   
                },
                {
                    name: "PNS",
                    y: {{ $total_pns  }}
                   
                },
                {
                    name: "Pelajar/Mahasiswa",
                    y: {{ $total_pelajar  }}
                   
                },
                {
                    name: "Lain-lain",
                    y: {{ $total_lain  }}
                   
                }
            ]
        }
    ]
            
     
});


//domisili
// Create the chart
Highcharts.chart('container4', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Domisili Responden'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },

    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.2f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Total",
            colorByPoint: true,
            data: [
                {
                    name: "Jawa",
                    y: {{ $total_jawa  }}
                   
                },
                {
                    name: "Sumatera",
                    y: {{ $total_sumatera  }}
                   
                },
                {
                    name: "Kalimantan",
                    y: {{ $total_kalimantan  }}
                   
                },
                {
                    name: "Bali",
                    y: {{ $total_bali  }}
                   
                },
                {
                    name: "Sulawesi",
                    y: {{ $total_sulawesi  }}
                   
                }
                ,
                {
                    name: "Papua",
                    y: {{ $total_papua  }}
                   
                },
                {
                    name: "NTB/NTT",
                    y: {{ $total_ntb  }}
                   
                },
                {
                    name: "Maluku",
                    y: {{ $total_maluku  }}
                   
                }
            ]
        }
    ]
            
     
});
</script>
@endsection