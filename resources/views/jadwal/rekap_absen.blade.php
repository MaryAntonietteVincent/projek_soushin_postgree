@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">



                    <a href="{{ route('jadwal') }}" class="btn btn-sm btn-primary">Kembali</a>
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">

                                        <th>
                                            Kelas</th>
                                        <th>
                                            Tanggal</th>
                                        <th>
                                            Nama user</th>
                                        <th>
                                            Status kehadiran</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- @php
                                        $offset = ($data->currentPage() - 1) * $data->perPage();
                                    @endphp --}}

                                    @foreach ($data as $item)
                                        <tr class="text-center">
                                            {{-- <td> </td> --}}
                                            <td>{{ $item->jadwal->kelas->kelas }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->pelanggan->name }}</td>
                                            <td>{{ $item->status }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $data->withQueryString()->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
