@extends('layout.master')

@section('title','Manajemen Data')
@section('content')
<div class="row pt-2">
    <div class="col-md-12">
       <form action="/data-kabupaten" method="POST">
        @csrf
        
        @if ($kelurahanBelumUpdate->count() > 0)
        <div class="card card-maroon">
        @else
        <div class="card card-green mt-5">
        @endif
            
                <div class="card-header">
                    <h3 class="card-title">Tambah/update Data</h3>
                </div>
                <div class="card-body">
                   
                    @if ($kelurahanBelumUpdate->count() > 0)
                    <div class="callout callout-danger red">
                    <h4><i class="icon fa fa-calendar red"></i> Data Kelurahan Yang Belum Diupdate per <strong>{{$tanggalSekarang}}</strong> <a href="#" id="expandable">Lihat detail</a></h4>
                        <p id="listKelurahan" style="display:none">
                        @foreach ($kelurahanBelumUpdate as $item)
                        {{$item->kelurahan}} ,
                        @endforeach    
                        </p>
                    </div>
                    @else
                        <div class="callout callout-success green">
                            <h4><i class="icon fa fa-check green"></i> Data <strong>{{$tanggalSekarang}}</strong></h4>
                            <p>
                                Semua Data Kelurahan Sudah Ter-update
                            </p>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kabupaten</label>
                        <select class="form-control" style="width: 100%;" name="kabupaten" id="selectKabupaten" required>
                            <option value="">Pilih kabupaten</option>
                            @foreach ($kabupaten as $item)
                                <option value="{{$item->id}}">{{ucfirst($item->kabupaten)}}</option>      
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select class="form-control" style="width: 100%;" name="kecamatan" id="selectKecamatan" required>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select class="form-control" style="width: 100%;" name="kelurahan" id="selectKelurahan" required>
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">PP-LN</label>
                        <input type="number" name="ppln" class="form-control" placeholder="Jumlah PP-LN" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">PP-DN</label>
                        <input type="number" name="ppdn" class="form-control" placeholder="Jumlah PP-DN" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">TL</label>
                        <input type="number" name="tl" class="form-control" placeholder="Jumlah TL" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Lainnya</label>
                        <input type="number" name="lainnya" class="form-control" placeholder="Jumlah Lainnya" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Sembuh</label>
                        <input type="number" name="sembuh" class="form-control" placeholder="Jumlah Sembuh" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Dirawat</label>
                        <input type="number" name="perawatan" class="form-control" placeholder="Jumlah Dirawat" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">meninggal</label>
                        <input type="number" name="meninggal" class="form-control" placeholder="Jumlah Meninggal" required>
                    </div>
                    
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </div>
        </form>

        

    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
{{-- <script src="/js/app.js"></script> --}}
<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#selectKabupaten').on('change', function() {
            $.ajax({
                
                url:'getKecamatan',
                type:'get',
                dataType:'json',
                data:{id_kabupaten: this.value},
                success: function(response){
                    var $kecamatan = $('#selectKecamatan');
                    $kecamatan.empty();
                    console.log(response);
                    for(var i = 0; i < response.length; i++){
                        $kecamatan.append('<option id=' + response[i].id + ' value=' + response[i].id + '>' + response[i].kecamatan + '</option>');
                    }
                    $kecamatan.change();
                }
            });
        });

        $('#selectKecamatan').on('change', function() {
            $.ajax({
                url:'getKelurahan',
                type:'get',
                dataType:'json',
                data:{id_kecamatan: this.value},
                success: function(response){
                    var $kelurahan = $('#selectKelurahan');
                    $kelurahan.empty();
                    console.log(response);
                    for(var i = 0; i < response.length; i++){
                        $kelurahan.append('<option id=' + response[i].id + ' value=' + response[i].id + '>' + response[i].kelurahan + '</option>');
                    }
                    $kelurahan.change();
                }
            });
        });

        $('#expandable').on('click', function(){
            if($('#listKelurahan').is(':hidden')){
                $('#listKelurahan').show();
                $('#expandable').text("Sembunyikan");
            }else{
                $('#listKelurahan').hide();
                $('#expandable').text("Lihat detail");
            }
        });
    });

    
</script>
@endsection