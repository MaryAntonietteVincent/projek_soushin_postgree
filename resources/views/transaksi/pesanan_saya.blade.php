@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                  

                 
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">


                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            No</th>
                                       
                                        <th>
                                            Tanggal Pesan</th>
                                        <th>
                                            Tanggal Ambil</th>
                                    
                                        <th>
                                            Total Bayar</th>
                                        <th>
                                            Total Harga</th>
                                        <th>
                                            status ambil</th>
                                        <th>
                                            status pesanan</th>
                                        <th>
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $offset = ($data->currentPage() - 1) * $data->perPage();
                                    @endphp

                                    @foreach ($data as $item)
                                        <tr>
                                            <td> {{ $offset + $loop->iteration }}</td>
                                       
                                            <td>{{ $item->tanggal_pesan }}</td>
                                            <td>{{ $item->tanggal_ambil }}</td>
                                            <td>{{ number_format($item->total_bayar) }}</td>
                                            <td>{{ number_format($item->total_harga) }}</td>
                                            <td>{{ $item->status_pesanan }}</td>
                                            <td>{{ $item->status_ambil }}</td>
                                            <td>
                                                <a href="{{ route('pesanan_saya_detail', $item->id) }}" class="btn btn-info">Detail Pesanan</a>
                                                {{-- <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    onclick="deleteData({{ $item->id }})">
                                                    <i class="bi bi-trash-fill"></i> hapus data
                                                </button> --}}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $data->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    


   
    </script>
@endsection
