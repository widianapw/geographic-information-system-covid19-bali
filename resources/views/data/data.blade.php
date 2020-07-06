@extends('layout.master')

@section('title','Manajemen Data')
@section('content')
<div class="row pt-2">
    <div class="col-md-12">
        <div class="card card-maroon">
            <div class="card-header">
                <h3 class="card-title">
                    Manajemen Data tanggal {{$tanggalSekarang}}
                </h3>
            </div>
            <div class="card-body">
                @if (session('alert'))
                    <div class="alert alert-danger">
                        {{ session('alert') }}
                    </div>
                @endif
                @if (session('alertSuccess'))
                    <div class="alert alert-success">
                        {{ session('alertSuccess') }}
                    </div>
                @endif
                <form action="/searchData" method="POST">
                    @csrf
                    <h5>Cari Tanggal </h5>
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
                  <a href="/data/create"><button type="submit" class="btn btn-success mt-5">+ Tambah Data</button></a>
                <div class="table-responsive mt-3">
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
                        <th rowspan=2>Action</th>
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
                                <td><a href="{{route('data.edit',$item)}}"><button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i></button></a></td>
                                </tr>
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("js")
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example1').DataTable()
        });
    </script>
@endsection