@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-6 mb-3">
                        <form action="" method="GET" class="form-inline ml-2" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="searchInput"
                                    value="{{ Request()->search }}" placeholder="Cari Data Jadwal..."
                                    oninput="searchOnChange()">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    <a href="{{ route('jadwal') }}" class="btn btn-success">refresh</a>
                                </div>
                            </div>
                        </form>
                    </div>

                 
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
                                            Nama Pelanggan</th>
                                        <th>
                                            No telp</th>
                                        <th>
                                            Tanggal Pesan</th>
                                        <th>
                                            Tanggal Ambil</th>
                                    
                                        <th>
                                            Total Harga</th>
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
                                            <td>{{ $item->pelanggan->name }}</td>
                                            <td>{{ $item->pelanggan->no_hp }}</td>
                                            <td>{{ $item->tanggal_pesan }}</td>
                                            <td>{{ $item->tanggal_ambil }}</td>
                                            <td>{{ number_format($item->total_harga) }}</td>
                                            <td>
                                                <a href="{{ route('detail_pesanan', $item->id) }}" class="btn btn-info">Detail Pesanan</a>
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
