<?php

namespace App\Http\Controllers;

use App\Data;
use App\Kabupaten;
use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;
class DataController extends Controller
{
    private $dateTimeNow;
    private $dateNow;
    private $dateFormatName;
    public function __construct(){
        
        $this->dateTimeNow = Carbon::now()->addHours(8);
        $this->dateNow = Carbon::now()->format('Y-m-d');
        $this->dateFormatName = Carbon::now()->locale('id')->isoFormat('LL');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tanggalSekarang = $this->dateFormatName;
        $kabupaten = Kabupaten::get();
        $data1 = Data::select('updated_at')->get();
        $kabupatenBelumUpdate = Kabupaten::whereDoesntHave('data', function($query){
            $query->where('tanggal','=',$this->dateNow)->where('status','=',1);
        })->get();
     
        return view('data.index', compact("kabupaten","kabupatenBelumUpdate","tanggalSekarang"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Data::where('id_kabupaten',$request->kabupaten)->where('tanggal',$request->tanggal)->count();
        if($cek == 0){
            $data = new Data();
        }else{
            $data = Data::where('id_kabupaten',$request->kabupaten)->where('tanggal',$request->tanggal)->first();
            $data->status = 1;
        }
        
        $data->id_kabupaten = $request->kabupaten;
        $data->meninggal = $request->meninggal;
        $data->sembuh = $request->sembuh;
        $data->dirawat = $request->dirawat;
        $data->tanggal = $request->tanggal;
        $data->positif = $request->sembuh + $request->dirawat + $request->meninggal;
        if($cek == 0){
            $data->save();
        }else{
            $data->update();
        }
        
        return redirect('/data-kabupaten');
        return $request;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        //
    }

    

}
