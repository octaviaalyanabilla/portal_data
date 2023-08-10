<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PORTAL DATA</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/puse-icons-feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
</head>

<body>
    <form method="POST" action="">
        {{ csrf_field() }}
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
                <div class="content-wrapper d-flex align-items-center auth theme-one">

                    <div class="row col-md-12">
                        <div class="col-md-6" style="padding:8%;">
                            <h2 style="text-align: center;">Total Data {{$dataUtama->nama_data}} Berdasarkan {{$dataJenis->nama_jenis_data}} Tahun {{$dataTahun->tahun_data}} Sebanyak :  <b>{{$total}}</b>
                            <br>
                            <br>
                            <a href="{{url('/')}}" class="btn btn-sm btn-primary">Kembali Ke halaman Awal</a>
                            </h2>
                        </div>
                        <div class="col-md-6">
                           <div id="chartContainer" style="height: 100%; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends Herziwp@gmail.com -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </form>
    <script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('vendors/js/vendor.bundle.addons.js')}}"></script>
    <script>
        window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "{{$dataUtama->nama_data}} Berdasarkan {{$dataJenis->nama_jenis_data}} Tahun {{$dataTahun->tahun_data}}"
            },
            axisY: {
                title: "Tota Data"
            },
            data: [{        
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "red",
                legendText: "Kategori Data",
                dataPoints: <?php echo json_encode($chart, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        }
    </script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>