<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SeksiController extends Controller
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
        if(Auth::user()->level == 'admin_user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $seksi = Seksi::get();
        return view('seksi.index', compact('seksi'));
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

        return view('seksi.create');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importData' => 'required'
        ]);

        if ($request->hasFile('importData')) {
            $path = $request->file('importData')->getRealPath();

            $seksi = Excel::load($path, function($reader){})->get();
            $a = collect($seksi);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'nama_seksi' => $value->nama_seksi];

                    Seksi::create($insert[$key]);
                        
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
            'nama_seksi' => 'required|string|max:255'
        ]);

        Seksi::create([
                'nama_seksi' => $request->get('nama_seksi'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('seksi.index');

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

        $seksi = Seksi::findOrFail($id);

        return view('seksi.show', compact('seksi'));
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

        $seksi = Seksi::findOrFail($id);
        return view('seksi.edit', compact('seksi'));
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
        Seksi::find($id)->update([
            'nama_seksi' => $request->get('nama_seksi')
        ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('seksi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Seksi::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('seksi.index');
    }
}
