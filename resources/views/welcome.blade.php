@extends('layout.master')

@section('title','Beranda')
@section('content')
<div class="row pt-2">
  <div class="col-12">
    <h5>Cari tanggal</h5>
    <form action="/search" method="POST">
      @csrf
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
        <input id="tanggalSearch" type="date" @if(isset($tanggal)) value="{{$tanggal}}" @endif name="tanggal"
          class="form-control" required>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>
</div>
<hr>
<div class="row mt-3">
  <div class="col-12">
    <h3>Tanggal {{$tanggalSekarang}}</h3>
  </div>
</div>
<!-- Small boxes (Stat box) -->
<div class="row mt-1">

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-indigo">
      <div class="inner">
      <h3>{{$totalPositif[0]->total}}<sup style="font-size: 20px">Org</sup></h3>

        <p>Positif</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3> {{$totalSembuh[0]->sembuh}}<sup style="font-size: 20px">Org</sup></h3>

        <p>Sembuh</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3> {{$totalDirawat[0]->perawatan}}<sup style="font-size: 20px">Org</sup></h3>

        <p>Dirawat</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3> {{$totalMeninggal[0]->meninggal}}<sup style="font-size: 20px">Org</sup></h3>

        <p>Meninggal</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
</div>

<div class="row mt-2">
  <div class="col-12">

    <div class="card card-blue">
      <div class="card-header">
        <h3 class="card-title">Peta Penyebaran Covid Provinsi Bali <strong>{{$tanggalSekarang}}</strong></h3>
      </div>
      
      <div class="card-body no-padding p-0">
        <div class="row">
          <div class="col-12">
            <div class="pad">
              <div id="mapid" style="height: 500px"></div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-footer color-palette-box">
        <strong>Keterangan Warna:</strong>
        <div class="row" style="font-size:70%">
          <p class="pl-2 pr-2 pt-1 pb-1 m-2" style="background: #81F781">Tidak Pernah Ada Positif</p>
          <p class="pl-2 pr-2 pt-1 pb-1 m-2 text-light" style="background: #088A08">pernah ada (+) dan kondisi (semuanya sudah sembuh / semuanya meninggal)</p>
          <p class="pl-2 pr-2 pt-1 pb-1 m-2" style="background: #FFFF00">Hanya ada 1 positif PP-LN/PP-DN & kondisi masih dirawat</p>
          <p class="pl-2 pr-2 pt-1 pb-1 m-2" style="background: #F78181">Lebih dari 1 positif PP-LN/DN & kondisi masih dirawat</p>
          <p class="pl-2 pr-2 pt-1 pb-1 m-2 text-light" style="background: #B40404">Ada 1 atau lebih TL positif & kondisi masih dirawat</p>
        </div>
      </div>
      
    </div>
    
  </div>
</div>


<div class="row mt-2">
  <div class="col-12">

    <div class="card card-maroon">
      <div class="card-header">
        <h3 class="card-title">Covid-19 Provinsi Bali <strong>{{$tanggalSekarang}}</strong></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">

        <table id="example1" class="table table-striped table-bordered">
          <thead>
          <tr>
            <tr>
              <th rowspan=2 style="text-align: center">No</th>
              <th rowspan=2>Kabupaten</th>
              <th rowspan=2>Kecamatan</th>
              <th rowspan=2>Kelurahan</th>
              <th rowspan=2>Level</th>
              <th colspan=5 style="text-align: center">Penyebaran</th>
              <th colspan=4 style="text-align: center">Kondisi</th>
            </tr>
            <tr>
              <th>PP-LN</th>
              <th>PP-DN</th>
              <th>TL</th>
              <th>Lainnya</th>
              <th>Total</th>
              <th>Perawatan</th>
              <th>Sembuh Covid</th>
              <th>Meninggal</th>
              <th>Total</th>
            </tr>
          </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ucfirst($item->kabupaten)}}</td>
              <td>{{ucfirst($item->kecamatan)}}</td>
              <td>{{ucfirst($item->kelurahan)}}</td>
              <td>{{$item->level}}</td>
              <td>{{$item->ppln}}</td>
              <td>{{$item->ppdn}}</td>
              <td>{{$item->tl}}</td>
              <td>{{$item->lainnya}}</td>
              <td>{{$item->total}}</td>
              <td>{{$item->perawatan}}</td>
              <td>{{$item->sembuh}}</td>
              <td>{{$item->meninggal}}</td>
              <td>{{$item->total}}</td>
            </tr>
            @endforeach
          
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
  
@endsection
@section("js")
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
<script src="https://pendataan.baliprov.go.id/assets/frontend/map/leaflet.markercluster-src.js"></script>
<script src="http://leaflet.github.io/Leaflet.label/leaflet.label.js" charset="utf-8"></script>
<script>
  $(document).ready(function () {
    $('#example1').DataTable()
    var dataMap=null;
    var tanggal = $('#tanggalSearch').val();
    $.ajax({
      async:false,
      url:'getDataMap',
      type:'get',
      dataType:'json',
      data:{date: tanggal},
      success: function(response){
        dataMap = response["dataMap"];
      }
    });
    // console.log(dataMap);
    var map = L.map('mapid',{
      fullscreenControl:true,
    });
    
    
    map.setView(new L.LatLng(-8.500410, 115.195839),10);
    var OpenTopoMap = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 20,
            zoomAnimation:true,
            id: 'mapbox/streets-v11',
            accessToken: 'pk.eyJ1Ijoid2lkaWFuYXB3IiwiYSI6ImNrNm95c2pydjFnbWczbHBibGNtMDNoZzMifQ.kHoE5-gMwNgEDCrJQ3fqkQ',
        }).addTo(map);
    OpenTopoMap.addTo(map);
    var defStyle = {opacity:'1',color:'#000000',fillOpacity:'0.8',fillColor:'#CCCCCC',dashArray:'4'};
    setMapAttr();

    function setMapAttr(){
      var markerIcon = L.icon({
        iconUrl: '/img/marker.png',
        iconSize: [40, 40],
      });  
      var kmzParser = new L.KMZParser({
          
          onKMZLoaded: function (kmz_layer, name) {
            
              control.addOverlay(kmz_layer, name);
              var markers = L.markerClusterGroup();
              var layers = kmz_layer.getLayers()[0].getLayers();
              console.log(layers[0]);
              layers.forEach(function(layer, index){
                var kab  = layer.feature.properties.NAME_2;
                var kec =  layer.feature.properties.NAME_3;
                var kel = layer.feature.properties.NAME_4;
                var data;
              
                var HIJAU_MUDA = {opacity:'0.8',color:'#000', fillColor:'#81F781', fillOpacity:'0.8',dashArray:'4'};
                var HIJAU_TUA = {opacity:'0.8',color:'#000', fillColor:'#088A08',fillOpacity:'0.8',dashArray:'4'};
                var KUNING = {opacity:'0.8',color:'#000', fillColor:'#FFFF00',fillOpacity:'0.8',dashArray:'4'};
                var MERAH_MUDA = {opacity:'0.8',color:'#000', fillColor:'#F78181',fillOpacity:'0.8',dashArray:'4'};
                var MERAH_TUA = {opacity:'0.8',color:'#000', fillColor:'#B40404',fillOpacity:'0.8', dashArray:'4'};
                if(!Array.isArray(dataMap) || !dataMap.length == 0){
                    var searchResult = dataMap.filter(function(it){
                      return it.kecamatan.replace(/\s/g,'').toLowerCase() === kec.replace(/\s/g,'').toLowerCase() &&
                              it.kelurahan.replace(/\s/g,'').toLowerCase() === kel.replace(/\s/g,'').toLowerCase();
                    });
                    if(!Array.isArray(searchResult) || !searchResult.length ==0){
                      var item = searchResult[0];
                      if(item.total == 0 ){
                        layer.setStyle(HIJAU_MUDA);  
                      }else if(item.perawatan == 0 && item.total>0 && item.sembuh >= 0 && item.meninggal >=0){
                        layer.setStyle(HIJAU_TUA);
                      }else if(item.ppln ==1 && item.perawatan == 1 && item.total == 1 && item.tl==0 || item.ppdn ==1 && item.perawatan == 1 && item.total == 1 && item.tl==0){
                        layer.setStyle(KUNING);
                      }else if((item.ppln >1 && item.perawatan <= item.ppln && item.sembuh <= item.ppln && item.tl == 0) || (item.ppdn >1 && item.perawatan <= item.ppdn && item.sembuh <= item.ppdn && item.tl == 0)  ){
                        layer.setStyle(MERAH_MUDA);
                      }else{
                        layer.setStyle(MERAH_TUA);
                      }
                      data = '<table width="300">';
                      data +='  <tr>';
                      data +='    <th colspan="2">Keterangan</th>';
                      data +='  </tr>';
                    
                      data +='  <tr>';
                      data +='    <td>Kabupaten</td>';
                      data +='    <td>: '+kab+'</td>';
                      data +='  </tr>';              
      
                      data +='  <tr >';
                      data +='    <td>Kecamatan</td>';
                      data +='    <td>: '+kec+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>Kelurahan</td>';
                      data +='    <td>: '+kel+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>PP-LN</td>';
                      data +='    <td>: '+item.ppln+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>PP-DN</td>';
                      data +='    <td>: '+item.ppdn+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>TL</td>';
                      data +='    <td>: '+item.tl+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>Lainnya</td>';
                      data +='    <td>: '+item.lainnya+'</td>';
                      data +='  </tr>';

                      data +='  <tr style="color:green">';
                      data +='    <td>Sembuh</td>';
                      data +='    <td>: '+item.sembuh+'</td>';
                      data +='  </tr>';

                      data +='  <tr style="color:blue">';
                      data +='    <td>Dalam Perawatan</td>';
                      data +='    <td>: '+item.perawatan+'</td>';
                      data +='  </tr>';

                      data +='  <tr style="color:red">';
                      data +='    <td>Meninggal</td>';
                      data +='    <td>: '+item.meninggal+'</td>';
                      data +='  </tr>';
                    }else{
                      console.log(kel.replace(/\s/g,'').toLowerCase());
                      console.log(kec.replace(/\s/g,'').toLowerCase());
                      data = '<table width="300">';
                      data +='  <tr>';
                      data +='    <th colspan="2">Keterangan</th>';
                      data +='  </tr>';
                    
                      data +='  <tr>';
                      data +='    <td>Kabupaten</td>';
                      data +='    <td>: '+kab+'</td>';
                      data +='  </tr>';              
      
                      data +='  <tr style="color:red">';
                      data +='    <td>Kecamatan</td>';
                      data +='    <td>: '+kec+'</td>';
                      data +='  </tr>';

                      data +='  <tr style="color:red">';
                      data +='    <td>Kelurahan</td>';
                      data +='    <td>: '+kel+'</td>';
                      data +='  </tr>';
                    }
                 
                }else{
                  layer.setStyle(defStyle);
                  data = '<table width="300">';
                      data +='  <tr>';
                      data +='    <th colspan="2">Keterangan</th>';
                      data +='  </tr>';
                    
                      data +='  <tr>';
                      data +='    <td>Kabupaten</td>';
                      data +='    <td>: '+kab+'</td>';
                      data +='  </tr>';              
      
                      data +='  <tr>';
                      data +='    <td>Kecamatan</td>';
                      data +='    <td>: '+kec+'</td>';
                      data +='  </tr>';

                      data +='  <tr>';
                      data +='    <td>Kelurahan</td>';
                      data +='    <td>: '+kel+'</td>';
                      data +='  </tr>';  
                }
                layer.bindPopup(data);
                // markers.addLayer(L.marker(getRandomLatLng(map)));
                markers.addLayer( 
                  L.marker(layer.getBounds().getCenter(),{
                    icon: markerIcon
                  }).bindPopup(data)
                );
              });
              map.addLayer(markers);
              kmz_layer.addTo(map);
          }
      });
      kmzParser.load('bali-kelurahan.kmz');
      var control = L.control.layers(null, null, {
          collapsed: true
      }).addTo(map);
      $('.leaflet-control-layers').hide();
    }
  });
</script>
@endsection