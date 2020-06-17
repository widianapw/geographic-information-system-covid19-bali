<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Kabupaten;
use App\Data;
use Carbon\Carbon as Carbon;
class IndexController extends Controller
{

    private $dateTimeNow;
    private $dateNow;
    private $dateFormatName;
    private $dateFormatName1;

    public function __construct()
    {
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
        // $dataMap = Data::get();
        
        // $dataMap = Data::Select("*","kelurahan","kecamatan")
        //     ->rightJoin('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
        //     ->rightJoin('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            
        //     ->get();
        // return $dataMap;
        // return $this->dateNow->locale('in')->format('Y/m/d');
        // $now1 = date("F d, Y h:i:s A");
        // return $now1;
        // \
        // return $this->dateFormatName;
        $data = Data::select('kabupaten',DB::raw('COALESCE(SUM(meninggal),0) as meninggal'),DB::raw('COALESCE(SUM(total),0) as total'),DB::raw('COALESCE(SUM(perawatan),0) as perawatan'),DB::raw('COALESCE(SUM(sembuh),0) as sembuh'),'tanggal')
            ->join('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
            ->join('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            ->join('tb_kabupaten','tb_kecamatan.id_kabupaten','=','tb_kabupaten.id')
            ->where('tanggal',$this->dateNow)
            ->groupBy('kabupaten')
            ->orderBy('total','DESC')
            ->get();
            // return $data;
        $tanggalSekarang = $this->dateFormatName;
        $totalMeninggal = Data::select(DB::raw('COALESCE(SUM(meninggal),0) as meninggal'))->where('tanggal',$this->dateNow)->get();
        $totalPositif = Data::select(DB::raw('COALESCE(SUM(total),0) as total'))->where('tanggal',$this->dateNow)->get();
        $totalDirawat = Data::select(DB::raw('COALESCE(SUM(perawatan),0) as perawatan'))->where('tanggal',$this->dateNow)->get();
        $totalSembuh = Data::select(DB::raw('COALESCE(SUM(sembuh),0) as sembuh'))->where('tanggal',$this->dateNow)->get();
        // return $data;
        // return $totalMeninggal;
        return view('welcome',compact("data","totalMeninggal","totalPositif","totalDirawat","totalSembuh","tanggalSekarang"));
    }

    public function search(Request $request){
        // return $request;
        $tanggal = $request->tanggal;
        $tanggalSekarang = date("d M Y", strtotime($tanggal));
        
        $cekData = Data::select('kabupaten',DB::raw('COALESCE(SUM(meninggal),0) as meninggal'),DB::raw('COALESCE(SUM(total),0) as total'),DB::raw('COALESCE(SUM(perawatan),0) as perawatan'),DB::raw('COALESCE(SUM(sembuh),0) as sembuh'),'tanggal')
            ->join('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
            ->join('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            ->join('tb_kabupaten','tb_kecamatan.id_kabupaten','=','tb_kabupaten.id')
            ->where('tanggal',$request->tanggal)
            ->groupBy('kabupaten')
            ->orderBy('total','DESC')
            ->get();

        if (count($cekData) == 0) {
            $data = Kabupaten::select('kabupaten',DB::raw('IFNULL("0",0) as meninggal'), DB::raw('IFNULL("0",0) as total'), DB::raw('IFNULL("0",0) as perawatan'),DB::raw('IFNULL("0",0) as sembuh'))->get();
        }else{
            $data = $cekData;
        }
        $totalMeninggal = Data::select(DB::raw('COALESCE(SUM(meninggal),0) as meninggal'))->where('tanggal',$tanggal)->get();
        $totalPositif = Data::select(DB::raw('COALESCE(SUM(total),0) as total'))->where('tanggal',$tanggal)->get();
        $totalDirawat = Data::select(DB::raw('COALESCE(SUM(perawatan),0) as perawatan'))->where('tanggal',$tanggal)->get();
        $totalSembuh = Data::select(DB::raw('COALESCE(SUM(sembuh),0) as sembuh'))->where('tanggal',$tanggal)->get();
        // return $data;
        
        return view('welcome',compact("data","totalMeninggal","totalPositif","totalDirawat","totalSembuh","tanggalSekarang","tanggal"));
    }

    public function getDataMap(Request $request){
        if (is_null($request->date)) {
            $tanggal = $this->dateNow;
        }else{
            $tanggal = $request->date;
        }
    
        $dataMap = Data::Select("*","kelurahan","kecamatan")
            ->rightJoin('tb_kelurahan','tb_laporan.id_kelurahan','=','tb_kelurahan.id')
            ->rightJoin('tb_kecamatan','tb_kelurahan.id_kecamatan','=','tb_kecamatan.id')
            ->where('tanggal',$tanggal)
            ->get();
       
        return response()->json(["dataMap"=>$dataMap]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createPallette(Request $request)
    {

        $HexFrom = ltrim($request->start, '#');
        $HexTo = ltrim($request->end, '#');

    
        $ColorSteps = 9;
        $FromRGB['r'] = hexdec(substr($HexFrom, 0, 2));
        $FromRGB['g'] = hexdec(substr($HexFrom, 2, 2));
        $FromRGB['b'] = hexdec(substr($HexFrom, 4, 2));
    
        $ToRGB['r'] = hexdec(substr($HexTo, 0, 2));
        $ToRGB['g'] = hexdec(substr($HexTo, 2, 2));
        $ToRGB['b'] = hexdec(substr($HexTo, 4, 2));
    
        $StepRGB['r'] = ($FromRGB['r'] - $ToRGB['r']) / ($ColorSteps - 1);
        $StepRGB['g'] = ($FromRGB['g'] - $ToRGB['g']) / ($ColorSteps - 1);
        $StepRGB['b'] = ($FromRGB['b'] - $ToRGB['b']) / ($ColorSteps - 1);
    
        $GradientColors = array();
    
        for($i = 0; $i <= $ColorSteps; $i++) {
        $RGB['r'] = floor($FromRGB['r'] - ($StepRGB['r'] * $i));
        $RGB['g'] = floor($FromRGB['g'] - ($StepRGB['g'] * $i));
        $RGB['b'] = floor($FromRGB['b'] - ($StepRGB['b'] * $i));
    
        $HexRGB['r'] = sprintf('%02x', ($RGB['r']));
        $HexRGB['g'] = sprintf('%02x', ($RGB['g']));
        $HexRGB['b'] = sprintf('%02x', ($RGB['b']));
    
        $GradientColors[] = implode(NULL, $HexRGB);
        }
        $collect = collect($GradientColors);
        $filtered = $collect->filter(function($value, $key){
            return strlen($value) == 6;
        });
        return $filtered;
    }

    
    function len($val){
        return (strlen($val) == 6 ? true : false );
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
