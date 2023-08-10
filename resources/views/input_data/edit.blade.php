@extends('layouts.app')

@section('content')

<form action="{{ route('input_data.update', $input_data->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form">
                                @csrf
                                <div class="tab-content py" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="step1">
                                        <h4 class="card-title">Edit Data</h4>
                                        <div class="form-group{{ $errors->has('web_tahun_data_id') ? ' has-error' : '' }} "
                                            style="margin-bottom: 20px;">
                                            <label for="web_tahun_data_id" class="col-md-4 control-label">Tahun
                                                Data</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="web_tahun_data_id" required="">
                                                    <option value="">-- Pilih Tahun Data --</option>
                                                    @foreach ($tahun_data as $tahun_datas)
                                                    <option value="{{ $tahun_datas->id }}"
                                                        {{$input_data->web_tahun_data_id == $tahun_datas->id ? "selected":""}}>
                                                        {{ $tahun_datas->tahun_data }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('web_data_utama_id') ? ' has-error' : '' }} "
                                            style="margin-bottom: 20px;">
                                            <label for="web_data_utama_id" class="col-md-4 control-label">Data
                                                Utama</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="web_data_utama_id" required=""
                                                    onchange="getJenis(this.value)">
                                                    <option value="">-- Pilih Data Utama --</option>
                                                    @foreach ($data_utama as $data_utamas)
                                                    <option value="{{ $data_utamas->id }}"
                                                        {{$input_data->web_data_utama_id == $data_utamas->id ? "selected":""}}>
                                                        {{ $data_utamas->nama_data }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('web_jenis_data_id') ? ' has-error' : '' }} "
                                            style="margin-bottom: 20px;">
                                            <label for="web_jenis_data_id" class="col-md-4 control-label">Jenis
                                                Data</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="web_jenis_data_id" required=""
                                                    id="jenis_data_id" onchange="getKategori(this.value)">
                                                    <option value="">-- Pilih Jenis Data --</option>
                                                    @foreach($jenis_data as $jenis_datas)
                                                    <option value="{{$jenis_datas->id}}"
                                                        {{$input_data->web_jenis_data_id == $jenis_datas->id ? "selected":""}}>
                                                        {{$jenis_datas->nama_jenis_data}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="step2">
                                        <h4 class="card-title">Edit Data</h4>
                                        <div class="form-group row" id="kategori_data_id">
                                        </div>
                                    </div>

                                    <div class="row justify-content-between">
                                        <div class="nav nav-pills nav-fill" role="tablist">
                                            <button id="step1-tab" data-toggle="tab" href="#step1" type="button"
                                                class="btn btn-secondary">Previous</button>
                                            <button id="step2-tab" data-toggle="tab" href="#step2" type="button"
                                                class="btn btn-primary">Next</button>
                                        </div>
                                        <div class="nav nav-pills nav-fill" role="tablist">
                                            <button type="submit" class="btn btn-primary"
                                                data-enchanter="finish">Update</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});

function getJenis(web_jenis_data_id) {
    $('#kategori_data_id').empty();
    $.get("{{ url('getJenis') }}" + "/" + web_jenis_data_id, function(data) {
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
        //console.log(temp[0].v);
        for (var i = 0; i < temp.length; i++) {
            var opt = document.createElement('option');
            opt.value = temp[i].v.id;
            opt.text = temp[i].v.nama_jenis_data;
            x.appendChild(opt);
        }
    });
}

function getKategori(web_kategori_data_id) {
    $.get("{{ url('getKategori') }}" + "/" + web_kategori_data_id, function(datakategori) {
        var temp = [];
        $.each(datakategori, function(key, value) {
            temp.push({
                v: value,
                k: key
            });
        });
        var x = document.getElementById("kategori_data_id");
        $('#kategori_data_id').empty();
        var item = ``;
        for (var i = 0; i < temp.length; i++) {
            // var opt = document.createElement('option');
            // opt.value = temp[i].v.id;
            // opt.text = temp[i].v.nama_kategori_data;
            // x.appendChild(opt);
            item += `<div class="col-md-6" >
                        <label>Nama Kategori</label>
                            <input type="text" value="` + temp[i].v.nama_kategori_data + `" class="form-control"><p>
                            <input type="hidden" value="` + temp[i].v.id + `" class="form-control" name="web_kategori_data_id[]">
                        </div>
                        <div class="col-md-4">
                        <label>Jumlah</label>
                            <input id="jumlah_data" type="text" class="form-control"
                                   name="jumlah_data[]" value="" required>
                        </div>`;
        }
        $('#kategori_data_id').append(item);
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
@stop