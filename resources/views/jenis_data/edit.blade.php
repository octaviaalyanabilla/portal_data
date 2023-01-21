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

<form action="{{ route('jenis_data.update', $jenis_datas->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Data - <b>{{$jenis_datas->data_utama->nama_data}}</b> </h4>
                            <form class="forms-sample">
                                <div class="form-group{{ $errors->has('web_data_utama_id') ? ' has-error' : '' }} "
                                    style="margin-bottom: 20px;">
                                    <label for="web_data_utama_id" class="col-md-4 control-label">Data Utama</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="web_data_utama_id" required="">
                                            <option value="">-- Pilih Data Utama --</option>
                                            @foreach($data_utama as $data_utamas)
                                            <option value="{{$data_utamas->id}}" {{$jenis_datas->web_data_utama_id == $data_utamas->id ? "selected":""}}>
                                                {{$data_utamas->nama_data}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('nama_jenis_data') ? ' has-error' : '' }}">
                                    <label for="nama_jenis_data" class="col-md-4 control-label">Jenis Data</label>
                                    <div class="col-md-6">
                                        <input id="nama_jenis_data" type="text" class="form-control" name="nama_jenis_data" placeholder="Nama Jenis Data"
                                            value="{{ $jenis_datas->nama_jenis_data }}" required>
                                        @if ($errors->has('nama_jenis_data'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_jenis_data') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nama_kategori_data') ? ' has-error' : '' }}">
                                    <label for="nama_kategori_data" class="col-md-4 control-label">Kategori Data</label>
                                    @foreach($jenis_datas->kategori_datas as $key => $item )
                                    <div class="input-group mb-3 col-md-6">
                                        @if($key == 0)
                                        <input type="text" class="form-control kategori_item" name="kategori_data[]" value="{{$item->nama_kategori_data}}" placeholder="Kategori"
                                        aria-label="Recipient's username" aria-describedby="button-addon2" id=kat_data_item_{{$key}}>
                                        <button class="btn btn-outline-success add_kategori" type="button"
                                            id="button-addon2">Add</button>
                                        @else
                                        <input type="text" name="kategori_data[]" id=kat_data_item_{{$key}} class="form-control" value="{{$item->nama_kategori_data}}" placeholder="Kategori" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-danger remove_kategori" id=kat_data_btn_{{$key}} onclick="delRow({{$key}})" type="button" id="button-addon2">Remove</button>
                                        @endif
                                    </div>
                                    @endforeach
                                    <div id="extra-kategori"></div>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit">
                                    Update
                                </button>
                                <a href="{{route('jenis_data.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
@push('js')
<script>
    //get currently count item
    var row = $('.kategori_item').length;
    let item_first = parseInt(row);
    let item = parseInt(row) + 1;
    const add = document.querySelectorAll(".input-group .add_kategori")
    add.forEach(function(e){
        e.addEventListener('click', function(){
            let element = this.parentElement
            // console.log(element);
            let newElement = document.createElement('div')
                newElement.classList.add('input-group','mb-3','col-md-6')
                newElement.innerHTML = `<input type="text" name="kategori_data[]" id=ket_data_item_`+item+` class="form-control" placeholder="Kategori" aria-label="Recipient's username" aria-describedby="button-addon2"> <button class="btn btn-outline-danger remove_kategori" id=ket_data_btn_`+item+` onclick="delRow(`+item+`)" type="button" id="button-addon2">Remove</button>`
            document.getElementById('extra-kategori').appendChild(newElement)

            document.querySelector('form').querySelectorAll('.remove_kategori').forEach(function(remove){
                remove.addEventListener('click',function(elmClick){
                    elmClick.target.parentElement.remove()
                })
            })
        })
    })

    function delRow(id)
    {
        $('#kat_data_item_'+id).remove();
        $('#kat_data_btn_'+id).remove();
    }
</script>
@endpush
