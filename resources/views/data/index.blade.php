@extends('layout.master')

@section('title','Manajemen Data')
@section('content')
<div class="row pt-2">
    <div class="col-md-12">
       <form action="/data-kabupaten" method="POST">
        @csrf
        @if ($kabupatenBelumUpdate->count() > 0)
        <div class="card card-maroon">
        @else
        <div class="card card-green mt-5">
        @endif
            
                <div class="card-header">
                    <h3 class="card-title">Tambah/update Data</h3>
                </div>
                <div class="card-body">
                    @if ($kabupatenBelumUpdate->count() > 0)
                    <div class="callout callout-danger red">
                    <h4><i class="icon fa fa-calendar red"></i> Data Kabupaten Yang Belum Diupdate per <strong>{{$tanggalSekarang}}</strong></h4>
                        <p>
                        @foreach ($kabupatenBelumUpdate as $item)
                        {{$item->kabupaten}} ,
                        @endforeach    
                        </p>
                    </div>
                    @else
                        <div class="callout callout-success green">
                            <h4><i class="icon fa fa-check green"></i> Data <strong>{{$tanggalSekarang}}</strong></h4>
                            <p>
                                Semua Data Kabupaten Sudah Ter-update
                            </p>
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label>Kabupaten</label>
                        <select class="select2" style="width: 100%;" name="kabupaten" required>
                            <option value="">Pilih kabupaten</option>
                            @foreach ($kabupaten as $item)
                                <option value="{{$item->id}}">{{ucfirst($item->kabupaten)}}</option>      
                            @endforeach
                        </select>
                      </div>
                    
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
                        <label for="exampleInputEmail1">Sembuh</label>
                        <input type="number" name="sembuh" class="form-control" placeholder="Jumlah Sembuh" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Dirawat</label>
                        <input type="number" name="dirawat" class="form-control" placeholder="Jumlah Dirawat" required>
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
    });
</script>
@endsection