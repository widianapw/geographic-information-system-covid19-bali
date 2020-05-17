@extends('layout.master')

@section('title','Dashboard')
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
        <h3>{{$totalPositif[0]->positif}} <sup style="font-size: 20px">Org</sup></h3>

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
        <h3>{{$totalSembuh[0]->sembuh}} <sup style="font-size: 20px">Org</sup></h3>

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
        <h3>{{$totalDirawat[0]->dirawat}} <sup style="font-size: 20px">Org</sup></h3>

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
        <h3>{{$totalMeninggal[0]->meninggal}} <sup style="font-size: 20px">Org</sup></h3>

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
      <!-- /.card-header -->
      <div class="card-body no-padding p-0">
        <div class="row">
          <div class="col-12">
            <div class="pad">
              <div id="mapid" style="height: 500px"></div>
            </div>
          </div>
        </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="background: white">
        <div class="row">
          <div class="col-6">
            <p>Color Start:</p>
            <input type="color" value="#edff6b" class="form-control" id="colorStart">
          </div>
          <div class="col-6">
            <p>Color End:</p>
            <input type="color" value="#6b6a01" class="form-control" id="colorEnd">
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <button class="btn btn-primary form-control" id="btnGenerateColor">Generate Color</button>
          </div>

        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
</div>


<div class="row mt-2">
  <div class="col-12">

    <div class="card card-maroon">
      <div class="card-header">
        <h3 class="card-title">Covid-19 Provinsi Bali <strong>{{$tanggalSekarang}}</strong></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Kabupaten</th>
              <th>Positif</th>
              <th>Meninggal</th>
              <th>Sembuh</th>
              <th>Dirawat</th>
              {{-- <th>Tanggal</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ucfirst($item->kabupaten)}}</td>
              <td>{{$item->positif}}</td>
              <td>{{$item->meninggal}}</td>
              <td>{{$item->sembuh}}</td>
              <td>{{$item->dirawat}}</td>
              {{-- <td>{{$item->tanggal}}</td> --}}
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
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
<script src="https://pendataan.baliprov.go.id/assets/frontend/map/leaflet.markercluster-src.js"></script>
<script src="http://leaflet.github.io/Leaflet.label/leaflet.label.js" charset="utf-8"></script>
<script>
  $(document).ready(function () {
    var dataMap=null;
    var colorMap=[
      "edff6b",
      "dcec5d",
      "ccd950",
      "bcc743",
      "acb436",
      "9ba128",
      "8b8f1b",
      "7b7c0e",
      "6b6a01"
    ];
    var tanggal = $('#tanggalSearch').val();
    $.ajax({
      async:false,
      url:'getDataMap',
      type:'get',
      dataType:'json',
      data:{date: tanggal},
      success: function(response){
        dataMap = response;
      }
    });
    console.log(dataMap);
    var map = L.map('mapid',{
      fullscreenControl:true,
    });
    
    $('#btnGenerateColor').on('click',function(e){
      var colorStart = $('#colorStart').val();
      var colorEnd = $('#colorEnd').val();
      $.ajax({
        async:false,
        url:'/create-pallete',
        type:'get',
        dataType:'json',
        data:{start: colorStart, end:colorEnd},
        success: function(response){
          colorMap = response;
          setMapColor();
          
        }
      });
      
    });
    
    
    map.setView(new L.LatLng(-8.500410, 115.195839),10);
    var OpenTopoMap = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 20,
            // zoomAnimation:true,
            id: 'mapbox/streets-v11',
            // tileSize: 512,
            // zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoid2lkaWFuYXB3IiwiYSI6ImNrNm95c2pydjFnbWczbHBibGNtMDNoZzMifQ.kHoE5-gMwNgEDCrJQ3fqkQ',
        }).addTo(map);
    OpenTopoMap.addTo(map);
    var defStyle = {opacity:'1',color:'#000000',fillOpacity:'0',fillColor:'#CCCCCC'};
    setMapColor();
    // var m = L.marker([-8.500410, 115.195839]).bindLabel('A sweet static label!', { noHide: true })
		// 	.addTo(map)
		// 	.showLabel();

    function setMapColor(){
      var markerIcon = L.icon({
        iconUrl: '/img/marker.png',
        iconSize: [40, 40],
      });
      var BADUNG,BULELENG,BANGLI,DENPASAR,GIANYAR,JEMBRANA,KARANGASEM,KLUNGKUNG,TABANAN;
      dataMap.forEach(function(value,index){
        
        var colorKab = dataMap[index].kabupaten.toUpperCase();
        if(colorKab == "BADUNG"){
          BADUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="BULELENG"){
          BULELENG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        } else if(colorKab=="BANGLI"){
          BANGLI = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="DENPASAR"){
          DENPASAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="GIANYAR"){
          GIANYAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="JEMBRANA"){
          JEMBRANA = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="KARANGASEM"){
          KARANGASEM = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="TABANAN"){
          TABANAN = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="KLUNGKUNG"){
          KLUNGKUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }

      });
      var kmzParser = new L.KMZParser({
          onKMZLoaded: function (kmz_layer, name) {
              control.addOverlay(kmz_layer, name);
              var markers = L.markerClusterGroup();
              var layers = kmz_layer.getLayers()[0].getLayers();
              layers.forEach(function(layer, index){
                var kab  = layer.feature.properties.NAME_2;
                kab = kab.toUpperCase();
                var kabLower = kab.toLowerCase();

                if(!Array.isArray(dataMap) || !dataMap.length == 0){
                // set sub layer default style positif covid
                  // var STYLE = {opacity:'1',color:'#000',fillOpacity:'1',fillColor:'#'+colorMap[index]}; 
                  // layer.setStyle(STYLE);
                  if(kab == 'BADUNG'){
                    layer.setStyle(BADUNG);
                  }else if(kab == 'BANGLI'){
                    layer.setStyle(BANGLI);
                  }else if(kab == 'BULELENG'){
                    layer.setStyle(BULELENG);
                  }else if(kab == 'DENPASAR'){
                    layer.setStyle(DENPASAR);
                  }else if(kab == 'GIANYAR'){
                    layer.setStyle(GIANYAR);
                  }else if(kab == 'JEMBRANA'){
                    layer.setStyle(JEMBRANA);
                  }else if(kab == 'KARANGASEM'){
                    layer.setStyle(KARANGASEM);
                  }else if(kab == 'KLUNGKUNG'){
                    layer.setStyle(KLUNGKUNG);
                  }else if(kab == 'TABANAN'){
                    layer.setStyle(TABANAN);
                  } 
                  var data = '<table width="300">';
                    data +='  <tr>';
                    data +='    <th colspan="2">Keterangan</th>';
                    data +='  </tr>';
                  
                    data +='  <tr>';
                    data +='    <td>Kabupaten</td>';
                    data +='    <td>: '+kab+'</td>';
                    data +='  </tr>';              
    
                    data +='  <tr style="color:red">';
                    data +='    <td>Positif</td>';
                    data +='    <td>: '+dataMap[index].positif+'</td>';
                    data +='  </tr>';

                    data +='  <tr style="color:green">';
                    data +='    <td>Sembuh</td>';
                    data +='    <td>: '+dataMap[index].sembuh+'</td>';
                    data +='  </tr>'; 

                    data +='  <tr style="color:black">';
                    data +='    <td>Meninggal</td>';
                    data +='    <td>: '+dataMap[index].meninggal+'</td>';
                    data +='  </tr>';

                    data +='  <tr style="color:blue">';
                    data +='    <td>Dalam Perawatan</td>';
                    data +='    <td>: '+dataMap[index].dirawat+'</td>';
                    data +='  </tr>';               
                                  
                    data +='</table>';
                    if(kab == 'BANGLI'){
                      markers.addLayer( 
                        L.marker([-8.254251, 115.366936] ,{
                          icon: markerIcon
                        }).bindPopup(data).addTo(map)
                      );
                    }
                    else if(kab == 'GIANYAR'){
                      markers.addLayer( 
                        L.marker([-8.422739, 115.255700] ,{
                          icon: markerIcon
                        }).bindPopup(data).addTo(map)
                      );

                    }else if(kab == 'KLUNGKUNG'){
                      markers.addLayer( 
                        L.marker([-8.487338, 115.380029] ,{
                          icon: markerIcon
                        }).bindPopup(data).addTo(map)
                      );

                    }else{
                      markers.addLayer( 
                        L.marker(layer.getBounds().getCenter(),{
                          icon: markerIcon
                        }).bindPopup(data).addTo(map)
                      );
                    }
                }else{
                  var data = "Tidak ada Data pada tanggal tersebut"
                  layer.setStyle(defStyle);
                }
                layer.bindPopup(data);
                
              });
              map.addLayer(markers);
              kmz_layer.addTo(map);
          }
      });
      kmzParser.load('bali-kabupaten.kmz');
      var control = L.control.layers(null, null, {
          collapsed: true
      }).addTo(map);
      $('.leaflet-control-layers').hide();

    }
  });
</script>
@endsection