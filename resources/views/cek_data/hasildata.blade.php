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

                    <div class="row w-100">
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <h2 style="text-align: center;">PORTAL DATA - KEMENAG KOTA BATU</h2>
                        </div>
                        <div class="col-lg-6 mx-auto">
                            <div class="auto-form-wrapper">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="" class="col-md control-label">Tahun Data</label>
                                    <div class="col-md">
                                        <select class="form-control" name="" required="">
                                            <option value="">-- Pilih Tahun Data --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="" class="col-md control-label">Data Utama</label>
                                    <div class="col-md">
                                        <select class="form-control" name="" required="">
                                            <option value="">-- Pilih Data Utama --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="" class="col-md control-label">Jenis Data</label>
                                    <div class="col-md">
                                        <select class="form-control" name="" required="">
                                            <option value="">-- Pilih Jenis Data --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="" class="col-md control-label">Kategori Data</label>
                                    <div class="col-md">
                                        <select class="form-control" name="" required="">
                                            <option value="">-- Pilih Kategori Data --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary submit-btn btn-block" type="submit">Cek Data</button>
                                </div>
                            </div>
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
</body>

</html>