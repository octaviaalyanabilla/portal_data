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
    <form action="{{url('/')}}">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
                <div class="content-wrapper d-flex align-items-center auth theme-one">

                    <div class="row w-100">
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <h2 style="text-align: center;">PORTAL DATA - KEMENAG KOTA BATU</h2>
                            @if($message != null)
                            <p align="center" style="color:red;">{{$message}}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 mx-auto">
                            <div class="auto-form-wrapper">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="" class="col-md control-label">Tahun Data</label>
                                    <div class="col-md">
                                        <select class="form-control" name="web_tahun_data_id" required="">
                                            <option value="">-- Pilih Tahun Data --</option>
                                            @foreach ($tahun_data as $t)
                                            <option value="{{$t->id}}" {{$request->web_tahun_data_id == $t->id ? 'selected':''}}>
                                                {{ $t->tahun_data }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="web_data_utama_id" class="col-md control-label">Data Utama</label>
                                    <div class="col-md">
                                        <select class="form-control" name="web_data_utama_id" required=""
                                            onchange="getJenis(this.value)">
                                            <option value="">-- Pilih Data Utama --</option>
                                            @foreach ($data_utama as $d)
                                            <option value="{{$d->id}}" {{$request->web_data_utama_id == $d->id ? 'selected':''}}>
                                                {{ $d->nama_data }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="web_jenis_data_id" class="col-md control-label">Jenis Data</label>
                                    <div class="col-md">
                                        <select class="form-control" name="web_jenis_data_id" required=""
                                        id="jenis_data_id" onchange="getKategori(this.value)">
                                            <option value="">-- Pilih Jenis Data --</option>
                                            @foreach ($jenis_data as $j)
                                            <option value="{{$j->id}}" {{$request->web_jenis_data_id == $j->id ? 'selected':''}}>
                                                {{ $j->nama_jenis_data }}
                                            </option>
                                            @endforeach
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
    <script src="{{asset('js/off-canvas.js')}}"></script>
    <script src="{{asset('js/misc.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/sweetalert2.all.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});

function getJenis(web_jenis_data_id) {
    $.get("{{ url('getJenisCekData') }}" + "/" + web_jenis_data_id, function(data) {
        var temp = [];
        $.each(data, function(key, value) {
            temp.push({
                v: value,
                k: key
            });
        });
        var x = document.getElementById("jenis_data_id");
        $('#jenis_data_id').empty();
        var opt_head = document.createElement('option');
        opt_head.text = '-- Pilih Jenis Data --';
        opt_head.value = '0';
        opt_head.disabled = true;
        opt_head.selected = true;
        x.appendChild(opt_head);
        console.log(temp[0].v);
        for (var i = 0; i < temp.length; i++) {
            var opt = document.createElement('option');
            opt.value = temp[i].v.id;
            opt.text = temp[i].v.nama_jenis_data;
            x.appendChild(opt);
        }
    });
}

function getKategori(web_kategori_data_id) {
    $.get("{{ url('getKategoriCekData') }}" + "/" + web_kategori_data_id, function(datakategori) {
        var temp = [];
        $.each(datakategori, function(key, value) {
            temp.push({
                v: value,
                k: key
            });
        });
        var x = document.getElementById("kategori_data_id");
        $('#kategori_data_id').empty();
        var opt_head = document.createElement('option');
        opt_head.text = '-- Pilih Kategori Data --';
        opt_head.value = '0';
        opt_head.disabled = true;
        opt_head.selected = true;
        x.appendChild(opt_head);
        console.log(temp[0].v);
        for (var i = 0; i < temp.length; i++) {
            var opt = document.createElement('option');
            opt.value = temp[i].v.id;
            opt.text = temp[i].v.nama_kategori_data;
            x.appendChild(opt);
        }
    });

}
</script>
<script>
$(function() {
    var $sections = $('.form-section');

    function navigateTo(index) {
        $sections.removeClass('current').eq(index).addClass('current');
        $('.form-navigation .previous').toggle(index > 0);
        var atTheEnd = index >= $sections.length - 1;
        $('.form-navigation .next').toggle(!atTheEnd);
        $('.form-navigation [type=submit]').toggle(atTheEnd);
    }

    function curIndex() {
        return $sections.index($sections.filter('.current'));
    }

    $('.form-navigation .previous').click(function() {
        navigateTo(curIndex() - 1);
    });

    $('.form.navigation .next').click(function() {
        $('.contact-form').parsley().whenValidate({
            group: 'block-' + curIndex()
        }).done(function() {
            navigateTo(curIndex() + 1);
        });
    });

    $sections.each(function(index, section) {
        $(section).find(':input').attr('data-parsley-group', 'blok' + index);
    });

    navigateTo(0);
});

const wizard = new Enchanter('form');

const wizard = new Enchanter('form', {}, {
    onNext: () => {
        // do something
    },
    onPrevious: () => {
        // do something
    },
    onFinish: () => {
        // do something
    },
});
</script>

    

</body>

</html>