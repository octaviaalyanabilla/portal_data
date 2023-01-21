@section('js')

<script type="text/javascript">
    $(document).ready(function () {
        $(".users").select2();
    });

</script>

<script type="text/javascript">
    function readURL() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(input).prev().attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $(".uploads").change(readURL)
        $("#f").submit(function () {
            // do ajax submit or just classic form submit
            //  alert("fake subminting")
            return false
        })
    })

</script>
@stop

@extends('layouts.app')

@section('content')

<form action="{{ route('data_utama.update', $data_utama->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Data - <b>{{$data_utama->nama_data}}</b> </h4>
                            <form class="forms-sample">
                                <div class="form-group{{ $errors->has('nama_data') ? ' has-error' : '' }}">
                                    <label for="nama_data" class="col-md-4 control-label">Nama Data</label>
                                    <div class="col-md-6">
                                        <input id="nama_data" type="text" class="form-control" name="nama_data" placeholder="Nama Data Utama"
                                            value="{{ $data_utama->nama_data }}" required>
                                        @if ($errors->has('nama_data'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_data') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit">
                                    Update
                                </button>
                                <a href="{{route('data_utama.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
