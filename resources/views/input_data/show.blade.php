@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>

<script type="text/javascript">
function readURL() {
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).prev().attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
    $(".uploads").change(readURL)
    $("#f").submit(function() {
        // do ajax submit or just classic form submit
        //  alert("fake subminting")
        return false
    })
})
</script>
@stop

@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Data - <b>{{$input_datas->data_utama->nama_data}}</b> </h4>
                        <form class="forms-sample">
                            <div class="form-group{{ $errors->has('tahun_data') ? ' has-error' : '' }}">
                                <label for="tahun_data" class="col-md-4 control-label">Tahun Data</label>
                                <div class="col-md-6">
                                    <input id="judul" type="text" class="form-control" name="tahun_data"
                                        value="{{ $input_datas->tahun_data->tahun_data }}" readonly="">
                                    @if ($errors->has('tahun_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tahun_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_data') ? ' has-error' : '' }}">
                                <label for="nama_data" class="col-md-4 control-label">Nama Data Utama</label>
                                <div class="col-md-6">
                                    <input id="judul" type="text" class="form-control" name="nama_data"
                                        value="{{ $input_datas->data_utama->nama_data }}" readonly="">
                                    @if ($errors->has('nama_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_jenis_data') ? ' has-error' : '' }}">
                                <label for="nama_jenis_data" class="col-md-4 control-label">Nama Jenis Data</label>
                                <div class="col-md-6">
                                    <input id="nama_jenis_data" type="text" class="form-control" name="nama_jenis_data"
                                        value="{{ $input_datas->jenis_data->nama_jenis_data }}" readonly="">
                                    @if ($errors->has('nama_jenis_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_jenis_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_kategori_data') ? ' has-error' : '' }}">
                                <label for="nama_kategori_data" class="col-md-4 control-label">Nama Kategori
                                    Data</label>
                                <div class="col-md-6">
                                    <input id="judul" type="text" class="form-control" name="nama_kategori_data"
                                        value="{{ $input_datas->kategori_data->nama_kategori_data }}" readonly="">
                                    @if ($errors->has('nama_kategori_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_kategori_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('jumlah_data') ? ' has-error' : '' }}">
                                <label for="jumlah_data" class="col-md-4 control-label">Jumlah Data</label>
                                <div class="col-md-6">
                                    <input id="judul" type="text" class="form-control" name="jumlah_data"
                                        value="{{ $input_datas->jumlah_data }}" readonly="">
                                    @if ($errors->has('jumlah_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('input_data.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection