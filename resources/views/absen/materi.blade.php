@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{ route('absen') }}" class="btn btn-primary">Kembali</a>
                   

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
                                            Nama Materi</th>
                                        <th>
                                            File </th>

                                       
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $offset = ($data->currentPage() - 1) * $data->perPage();
                                    @endphp

                                    @foreach ($data as $item)
                                        <tr>
                                            <td> {{ $offset + $loop->iteration }}</td>
                                            <td>{{ $item->nama_materi }}</td>
                                            <td><a href="/materi/{{ $item->file_materi }}"
                                                    class="btn btn-sm btn-info">file</a></td>

                                           

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


   
@endsection
