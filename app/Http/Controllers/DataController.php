<?php

namespace App\Http\Controllers;
Use Alert;
use App\Data;
use App\Kabupaten;
use App\Kecamatan;
use DB;
use App\Kelurahan;
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
        // $kabupaten = Kabupaten::get();
        // $data1 = Data::select('updated_at')->get();

        // $kelurahanBelumUpdate = Kelurahan::whereDoesntHave('data', function($query){
        //     $query->where('tanggal','=',$this->dateNow)->where('status','=',1);
        // })->get();
        
     
        // return view('data.index', compact("kabupaten","kelurahanBelumUpdate","tanggalSekarang"));
        $data = Data::select('*','tb_laporan.id','kabupaten','kecamatan','kelurahan')
            ->join('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
            ->join('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            ->join('tb_kabupaten','tb_kecamatan.id_kabupaten','=','tb_kabupaten.id')
            ->where('tanggal',$this->dateNow)
            ->orderBy('tb_laporan.id','ASC')
            ->get();
        // return $data;
        return view("data.data", compact("data","tanggalSekarang"));
    }


    public function searchData(Request $request){
        $tanggal = $request->tanggal;
        $tanggalSekarang = date("d M Y", strtotime($tanggal));
        $cekData = Data::select('*','tb_laporan.id','kabupaten','kecamatan','kelurahan')
            ->join('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
            ->join('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            ->join('tb_kabupaten','tb_kecamatan.id_kabupaten','=','tb_kabupaten.id')
            ->where('tanggal',$tanggal)
            ->orderBy('tb_laporan.id','ASC')
            ->get();
        if (count($cekData) == 0) {
            // Alert::error('Tidak Ditemukan', 'Tidak ada data pada tanggal '.$tanggalSekarang);
            return redirect('/data')->with('alert','Data pada Tanggal '.$tanggalSekarang.' Tidak Ditemukan');
        }else{
            $data = $cekData;
            return view('data.data',compact("data","tanggalSekarang","tanggal"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanggalSekarang = $this->dateFormatName;
        $kabupaten = Kabupaten::get();
        $data1 = Data::select('updated_at')->get();

        $kelurahanBelumUpdate = Kelurahan::whereDoesntHave('data', function($query){
            $query->where('tanggal','=',$this->dateNow)->where('status','=',1);
        })->get();
        return view('data.index', compact("kabupaten","kelurahanBelumUpdate","tanggalSekarang"));
    }

    public function getKecamatan(Request $request){
        return Kecamatan::where('id_kabupaten',$request->id_kabupaten)->get();
    }

    public function getKelurahan(Request $request){
        return Kelurahan::where('id_kecamatan',$request->id_kecamatan)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $cek = Data::where('id_kelurahan',$request->kelurahan)->where('tanggal',$request->tanggal)->count();
        if($cek == 0){
            $data = new Data();
        }else{
            $data = Data::where('id_kelurahan',$request->kelurahan)->where('tanggal',$request->tanggal)->first();
            $data->status = 1;
        }
        
        $data->id_kelurahan = $request->kelurahan;
        $data->level = $request->level;
        $data->ppln = $request->ppln;
        $data->ppdn = $request->ppdn;
        $data->tl = $request->tl;
        $data->lainnya = $request->lainnya;
        
        $data->sembuh = $request->sembuh;
        $data->meninggal = $request->meninggal;
        $data->perawatan = $request->perawatan;
        $data->tanggal = $request->tanggal;
        $data->total = $request->sembuh + $request->perawatan + $request->meninggal;
        if($cek == 0){
            $data->save();
        }else{
            $data->save();
        }
        return redirect('/data')->with('alertSuccess','Data Berhasil diupdate!');
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
        // return $data;
        $tanggalSekarang = $this->dateFormatName;
        $kabupaten = Kabupaten::get();
        $thisKec = Kelurahan::select('id_kecamatan')->where('id',$data->id_kelurahan)->first();
        // return $thisKec;
        $thisKecamatan = Kecamatan::where('id',$thisKec->id_kecamatan)->first();
        $thisKab = Kecamatan::select('id_kabupaten')->where('id',$thisKec->id_kecamatan)->first();
        $thisKabupaten = Kabupaten::where('id',$thisKab->id_kabupaten)->first();
        $thisKelurahan = Kelurahan::where('id',$data->id_kelurahan)->first();
        $data1 = Data::select('updated_at')->get();
        $kelurahanBelumUpdate = Kelurahan::whereDoesntHave('data', function($query){
            $query->where('tanggal','=',$this->dateNow)->where('status','=',1);
        })->get();
        return view('data.index', compact("kabupaten","kelurahanBelumUpdate","data","tanggalSekarang","thisKecamatan","thisKabupaten","thisKelurahan"));
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
