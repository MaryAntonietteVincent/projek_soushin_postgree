@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    

                   <a href="{{ route('pembayaran_danpengambilan') }}" class="btn btn-danger">Kembali</a>
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">


                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>
                                        Gambar</th>
                                        
                                        <th>
                                            Nama Barang</th>
                                        <th>
                                            Harga  Barang</th>

                                        <th>
                                            qty</th>
                                        <th>
                                            subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    

                                    @foreach ($data as $item)
                                        <tr>
                                       
                                            <td><img src="{{ asset('produk/' . $item->barang->gambar) }}" style="width: 70px; height: 70px; object-fit: cover;"
                                                alt="" class="rounded-circle"></td>
                                                <td>{{ $item->barang->nama_produk }}</td>
                                                <td>{{ number_format( $item->barang->harga) }}</td>
                                                <td>{{ $item->qty  }}</td>
                                                <td>{{ number_format( $item->sub_total) }}</td>

                                           

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
@endsection
