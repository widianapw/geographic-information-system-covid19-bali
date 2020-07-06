@extends('layout.master')

@section('title','Manajemen Data')
@section('content')
<div class="row pt-2">
    <div class="col-md-12">
       <form action="/data" method="POST">
        @csrf
        @if ($kelurahanBelumUpdate->count() > 0)
            <div class="card card-maroon">
        @else
            <div class="card card-green mt-5">
        @endif
                <div class="card-header">
                    <h4 class="card-title">Tambah dan update Data</h4>
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
                            <input type="date" name="tanggal" @if(isset($data)) value="{{$data->tanggal}}" readonly @endif class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kabupaten</label>
                        <select class="form-control" style="width: 100%;" name="kabupaten" @if(isset($data)) readonly @endif id="selectKabupaten" required>
                            @if (isset($thisKabupaten))
                                <option value="{{$thisKabupaten->id}}" selected>{{ucfirst($thisKabupaten->kabupaten)}}</option>
                            @else
                                <option value="">Pilih kabupaten</option>    
                                @foreach ($kabupaten as $item)
                                    <option value="{{$item->id}}">{{ucfirst($item->kabupaten)}}</option>      
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select class="form-control" style="width: 100%;" name="kecamatan" id="selectKecamatan" required @if (isset($thisKecamatan)) readonly @else disabled @endif>
                            @if (isset($thisKecamatan))
                                <option value="{{$thisKecamatan->id}}">{{$thisKecamatan->kecamatan}}</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select class="form-control" style="width: 100%;" name="kelurahan" id="selectKelurahan" required @if (isset($thisKecamatan))  readonly @else disabled  @endif>
                            @if (isset($thisKelurahan))
                                <option value="{{$thisKelurahan->id}}">{{$thisKelurahan->kelurahan}}</option>
                            @endif
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">level</label>
                    <input type="number" name="level" @if(isset($data)) value="{{$data->level}}" @endif class="form-control" placeholder="Level" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">PP-LN</label>
                        <input type="number" name="ppln" class="form-control" placeholder="Jumlah PP-LN" @if(isset($data)) value="{{$data->ppdn}}" @endif required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">PP-DN</label>
                        <input type="number" name="ppdn" class="form-control" placeholder="Jumlah PP-DN" @if(isset($data)) value="{{$data->ppdn}}" @endif required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">TL</label>
                        <input type="number" name="tl" class="form-control" placeholder="Jumlah TL" @if(isset($data)) value="{{$data->tl}}" @endif required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Lainnya</label>
                        <input type="number" name="lainnya" class="form-control" placeholder="Jumlah Lainnya" @if(isset($data)) value="{{$data->lainnya}}" @endif required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Sembuh</label>
                        <input type="number" name="sembuh" class="form-control" placeholder="Jumlah Sembuh" @if(isset($data)) value="{{$data->sembuh}}" @endif required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Dirawat</label>
                        <input type="number" name="perawatan" class="form-control" placeholder="Jumlah Dirawat" @if(isset($data)) value="{{$data->perawatan}}" @endif required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">meninggal</label>
                        <input type="number" name="meninggal" class="form-control" placeholder="Jumlah Meninggal" @if(isset($data)) value="{{$data->meninggal}}" @endif required>
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
            var $kecamatan = $('#selectKecamatan');
            var $kelurahan = $('#selectKelurahan');
            if (this.value == "") {
                $('#selectKecamatan').prop('disabled', 'disabled');
                $('#selectKelurahan').prop('disabled', 'disabled');
                $kecamatan.empty();
                $kelurahan.empty();
            } else {
                $('#selectKecamatan').prop('disabled', false);
                $('#selectKelurahan').prop('disabled', false);
            }
            
            $.ajax({
                
                url:'../getKecamatan',
                type:'get',
                dataType:'json',
                data:{id_kabupaten: this.value},
                success: function(response){
                    
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
                url:'../getKelurahan',
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