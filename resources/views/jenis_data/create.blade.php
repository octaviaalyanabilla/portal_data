@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('jenis_data.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Jenis Data</h4>

                            <div class="form-group{{ $errors->has('web_data_utama_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="web_data_utama_id" class="col-md-4 control-label">Data Utama</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="web_data_utama_id" required="">
                                        <option value="">-- Pilih Data Utama --</option>
                                        @foreach($data_utama as $data_utamas)
                                        <option value="{{$data_utamas->id}}">{{$data_utamas->nama_data}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('nama_jenis_data') ? ' has-error' : '' }}">
                                <label for="nama_jenis_data" class="col-md-4 control-label">Jenis Data</label>
                                <div class="col-md-6">
                                    <input id="nama_jenis_data" type="text" class="form-control" name="nama_jenis_data" placeholder="Enter Jenis Data"
                                        required>
                                    @if ($errors->has('nama_jenis_data'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_jenis_data') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('nama_kategori_data') ? ' has-error' : '' }}">
                                <label for="nama_kategori_data" class="col-md-4 control-label">Kategori Data</label>
                                <div class="input-group mb-3 col-md-6">
                                    <input type="text" class="form-control kategori_item" name="kategori_data[]" value="{{$jenis_data->kategori_datas[0]->nama_kategori_data ?? '' }}" placeholder="Enter Kategori Data"
                                        aria-label="Recipient's username" aria-describedby="button-addon2" id="kat_data_item">
                                    <button class="btn btn-outline-success add_kategori" type="button"
                                        id="button-addon2">Add</button>
                                </div>
                                <div id="extra-kategori"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
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
@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
var i = 0;
$("#dynamic-ar").click(function() {
    ++i;
    $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
        '][nama_keterangan_data]" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
    );
});
$(document).on('click', '.remove-input-field', function() {
    $(this).parents('tr').remove();
});
</script>

@stop
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
                newElement.innerHTML = `<input type="text" name="kategori_data[]" id=kat_data_item_`+item+` class="form-control" placeholder="Enter Kategori Data" aria-label="Recipient's username" aria-describedby="button-addon2"> <button class="btn btn-outline-danger remove_kategori" id=kat_data_btn_`+item+` onclick="delRow(`+item+`)" type="button" id="button-addon2">Remove</button>`
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
