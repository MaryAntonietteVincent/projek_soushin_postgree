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

                    <button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Data
                    </button>
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
                                            Kelas</th>
                                        <th>
                                            Tanggal</th>
                                        <th>
                                            Jam Awal</th>
                                        <th>
                                            Jam Akhir</th>
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
                                            <td>{{ $item->kelas->kelas }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->jam_awal }}</td>
                                            <td>{{ $item->jam_akhir }}</td>
                                            <td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editdata"onclick="edit({{ $item }})">
                                                    <i class="fa-solid fa-pen-to-square"></i>Edit
                                                </button>
                                                <a href="{{ route('rekapabsenid', ['id' => $item->id]) }}"
                                                    class="btn btn-primary">Lihat Rekap absen</a>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    onclick="deleteData({{ $item->id }})">
                                                    <i class="bi bi-trash-fill"></i> hapus data
                                                </button>
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


    <div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editdataLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_jadwal') }}" method="post">
                        @csrf


                        <div class="input-group input-group-static mb-4">
                            <label for="kelas" class="ms-0">Kelas</label>
                            <select class="form-control" id="kelass" name="id_kelas">
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->kelas }}</option>
                                @endforeach


                            </select>
                        </div>
                            <input type="hidden" name="id" id="id_edit">
                        <div class="form-group">
                            <label for="tanggall">Tanggal</label>
                            <input type="date" class="form-control bg-gray-100" name ="tanggal" id="tanggall"
                                placeholder="input tanggal">
                        </div>
                        <div class="form-group">
                            <label for="jam_awall">Dari Jam</label>
                            <input type="time" class="form-control bg-gray-100" name="jam_awal" id="jam_awall"
                                placeholder="input Dari Jam">
                        </div>
                        <div class="form-group">
                            <label for="jam_akhirr">sampai Jam</label>
                            <input type="time" class="form-control bg-gray-100" name="jam_akhir" id="jam_akhirr"
                                placeholder="input sampai Jam">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_jadwal') }}" method="post">
                        @csrf


                        <div class="input-group input-group-static mb-4">
                            <label for="kelas" class="ms-0">Kelas</label>
                            <select class="form-control" id="kelas" name="id_kelas">
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->kelas }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div> Tanggal</div>
                        <div class="input-group input-group-outline mb-4">

                            <input type="date" class="form-control" name="tanggal">

                        </div>
                        <div>Dari Jam</div>
                        <div class="input-group input-group-outline mb-4">

                            <input type="time" class="form-control" name="jam_awal">

                        </div>
                        <div>Sampai Jam</div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Sampai Jam</label> --}}
                            <input type="time" class="form-control" name="jam_akhir">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function edit(data) {
            console.log(data);
            document.getElementById("id_edit").value = data.id;
            // document.getElementById("kelass").value = data.kelas;
            document.getElementById("tanggall").value = data.tanggal;
            document.getElementById("jam_awall").value = data.jam_awal;
            document.getElementById("jam_akhirr").value = data.jam_akhir;
            const kelas = document.getElementById("kelass");
            for (let i = 0; i < kelas.options.length; i++) {
                if (kelas.options[i].value == data.id_kelas) {
                    kelas.selectedIndex = i;
                    break;
                }
            }
        }

        function deleteData(id) {

            // const itemId = document.getElementById("soal");
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Apakah Kamu Yakin Ingin Menghapus Data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log(id);
                    window.location.href = `/hapus_jadwal/${id}`;
                    // window.location.href = "/selesaikan/".itemId "";
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                }
            });
        }
    </script>
@endsection
