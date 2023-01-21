<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataUtama;
use App\Models\JenisData;
use App\Models\KategoriData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DataUtamaController extends Controller
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

    public function getJenis($web_jenis_data_id){
        $data = JenisData::where('web_data_utama_id', $web_jenis_data_id)->get();
        return response()->json($data);
    }
 
    public function index()
    {
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $data_utama = DataUtama::get();
        return view('data_utama.index', compact('data_utama'));
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

        return view('data_utama.create');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $data_utama = Excel::load($path, function($reader){})->get();
            $a = collect($data_utama);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'nama_data' => $value->nama_data];

                    DataUtama::create($insert[$key]);
                        
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
        $this->validate($request, [
            'nama_data' => 'required|string|max:255'
        ]);

        DataUtama::create([
                'nama_data' => $request->get('nama_data'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('data_utama.index');

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

        $data_utama = DataUtama::findOrFail($id);

        return view('data_utama.show', compact('data_utama'));
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

        $data_utama = DataUtama::findOrFail($id);
        return view('data_utama.edit', compact('data_utama'));
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
        DataUtama::find($id)->update([
            'nama_data' => $request->get('nama_data')
        ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('data_utama.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataUtama::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('data_utama.index');
    }
}
