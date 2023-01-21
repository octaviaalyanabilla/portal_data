@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-lg-2">
            <a href="{{ route('input_data.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i>
                Add Data</a>
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
                                        Data Utama
                                    </th>
                                    <th>
                                        Jenis Data
                                    </th>
                                    <th>
                                        Kategori Data
                                    </th>
                                    <th>
                                        Jumlah Data
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($input_datas as $input_data)
                                    <tr>
                                        <td>
                                            {{ $input_data->tahun_data->tahun_data }}
                                        </td>
                                        <td class="py-1">
                                            <a href="{{ route('input_data.show', $input_data->id) }}">
                                                {{ $input_data->data_utama->nama_data }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $input_data->jenis_data->nama_jenis_data }}
                                        </td>
                                        <td>
                                            @php $dataKategori = \DB::table('web_input_data')->where('web_jenis_data_id',$input_data->web_jenis_data_id)->select('web_kategori_data_id as web_kategori_id')->get();
                                                 $arrDataKkategori = [];
                                            @endphp
                                                 @foreach($dataKategori as $key => $valData)
                                                 @php
                                                    $arrDataKkategori[$key]['val'] = '';
                                                 @endphp
                                                    @php
                                                        $check = \DB::table('web_kategori_data')->where('id',$valData->web_kategori_id)->first();
                                                        $jml = \DB::table('web_input_data')->where('web_kategori_data_id',$valData->web_kategori_id)->sum('jumlah_data');
                                                    @endphp
                                                    @if($check)
                                                        @php
                                                            $arrDataKkategori[$key]['val'] = $check->nama_kategori_data;
                                                        @endphp
                                                    @endif
                                                 @endforeach
                                            
                                            <ul>
                                            @foreach($arrDataKkategori as $kk => $valK)
                                                <li>{{$valK['val']}}</li>
                                            @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @php $dataKategori = \DB::table('web_input_data')->where('web_jenis_data_id',$input_data->web_jenis_data_id)->select('web_kategori_data_id as web_kategori_id')->get();
                                                 $arrDataKkategori = [];
                                            @endphp
                                                 @foreach($dataKategori as $key => $valData)
                                                 @php
                                                    $arrDataKkategori[$key]['jml'] = 0;
                                                 @endphp
                                                    @php
                                                        $check = \DB::table('web_kategori_data')->where('id',$valData->web_kategori_id)->first();
                                                        $jml = \DB::table('web_input_data')->where('web_kategori_data_id',$valData->web_kategori_id)->sum('jumlah_data');
                                                    @endphp
                                                    @if($check)
                                                        @php
                                                            $arrDataKkategori[$key]['jml'] = $jml;
                                                        @endphp
                                                    @endif
                                                 @endforeach
                                            
                                            <ul>
                                            @foreach($arrDataKkategori as $kk => $valK)
                                                <li>{{$valK['jml']}}</li>
                                            @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                                                    <a class="dropdown-item"
                                                        href="{{ route('input_data.edit', $input_data->id) }}"> Edit </a>
                                                    <form action="{{ route('input_data.destroy', $input_data->id) }}"
                                                        class="pull-left" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        <button class="dropdown-item"
                                                            onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--  {!! $input_datas->links() !!} --}}
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
