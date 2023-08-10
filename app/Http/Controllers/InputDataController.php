<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use App\Models\TahunData;
use App\Models\InputData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class InputDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 'admin_user') 
        {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $input_datas = InputData::get();
        return view('input_data.index', compact('input_datas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::all();
        $jenis_data = JenisData::all();
        $kategori_data = KategoriData::all();
        $tahun_data = TahunData::all();
        return view('input_data.create', compact('data_utama', 'jenis_data', 'kategori_data', 'tahun_data'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $input_data = Excel::load($path, function($reader){})->get();
            $a = collect($input_data);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'jumlah_data' => $value->jumlah_data,];

                    InputData::create($insert[$key]);

                    }
            };
        }
        alert()->success('Berhasil.','Data telah diimport!');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = InputData::where('id',$request->input('id'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('input_data');
        }

        $this->validate($request, [
            'web_tahun_data_id' => 'required',
            'web_data_utama_id' => 'required',
            'web_jenis_data_id' => 'required',
            'web_kategori_data_id' => 'required',
            'jumlah_data' => 'required',
        ]);
        $jml = $request->web_kategori_data_id;
        foreach($jml as $key => $val)
        {
            $input =new  InputData;
            $input->web_tahun_data_id = $request->web_tahun_data_id;
            $input->web_data_utama_id = $request->web_data_utama_id;
            $input->web_kategori_data_id = $request->web_kategori_data_id[$key];
            $input->web_jenis_data_id = $request->web_jenis_data_id;
            $input->jumlah_data = $request->jumlah_data[$key];
            $input->save();
        }
        
        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('input_data.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $input_datas = InputData::findOrFail($id);

        return view('input_data.show', compact('input_datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if((Auth::user()->level == 'admin_user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $input_data = InputData::findOrFail($id);
        $data_utama = DataUtama::get();
        $jenis_data = JenisData::get();
        $kategori_data = KategoriData::get();
        $tahun_data = TahunData::get();
        return view('input_data.edit', compact('input_data', 'jenis_data', 'data_utama', 'kategori_data', 'tahun_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        InputData::find($id)->update($request->all());

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('input_data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InputData::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('input_data.index');
    }
}
