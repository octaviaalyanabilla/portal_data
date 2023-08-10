@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-2">
        <a href="{{ route('input_data.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i>
            Add Data</a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        {{-- <form action="{{ url('import_data') }}" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="input-group {{ $errors->has('importdata') ? 'has-error' : '' }}">
            <input type="file" class="form-control" name="importdata" required="">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-success" style="height: 38px;margin-left: -2px;">Import</button>
            </span>
        </div>
        </form> --}}

    </div>
    <div class="col-lg-12">
        @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">
            {{ Session::get('message') }}</div>
        @endif
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h4 class="card-title pull-left">Portal Data</h4>
                {{-- <a href="{{url('format_data')}}" class="btn btn-xs btn-info pull-right">Format data</a> --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th>
                                    Tahun Data
                                </th>
                                <th>
                                    Detail
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($input_datas as $input_datasKey => $input_datasValue)
                            <tr>
                                <td>
                                    {{ $input_datasKey }}
                                </td>
                                <td class="py-1">
                                    @foreach($input_datasValue as $utamaKey => $utamaValue)
                                    <br>
                                        <b>{{$utamaKey}}</b>
                                        <br>
                                        @foreach($utamaValue as $jenisKey => $jenisValue)
                                        <br>
                                            &nbsp;&nbsp;  <b>{{$jenisKey}}</b>
                                        <br>
                                            @foreach($jenisValue as $kategoriKey => $kategoriValue)
                                            <br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;: <b>{{$kategoriKey}} : {{$kategoriValue['jumlah']}}</b>
                                            <br>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable({
        "iDisplayLength": 50
    });

});
</script>
@stop