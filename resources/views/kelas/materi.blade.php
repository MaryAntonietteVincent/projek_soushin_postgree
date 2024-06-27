@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{ route('kelas') }}" class="btn btn-primary">Kembali</a>
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
                                            Nama Materi</th>
                                        <th>
                                            File </th>

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
                                            <td>{{ $item->nama_materi }}</td>
                                            <td><a href="/materi/{{ $item->file_materi }}"
                                                    class="btn btn-sm btn-info">file</a></td>

                                            <td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editdata"onclick="edit({{ $item }})">
                                                    <i class="fa-solid fa-pen-to-square"></i>Edit
                                                </button>

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
                    <form action="{{ route('update_materi') }}" method="post" enctype="multipart/form-data">
                        @csrf




                        <input type="hidden" name="id" id="id_edit">
                        <div>Masukkan Nama materi</div>
                        <div class="input-group input-group-outline mb-4">

                            <input type="text" class="form-control" name="nama_materi" id="nama_materi">

                        </div>
                        <input type="hidden" name="id_kelas" value="{{ $id }}">
                        <div>Masukkan file materi</div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Masukkan File materi</label> --}}
                            <input type="file" class="form-control" name="file_materi">

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
                    <form action="{{ route('tambah_materi') }}" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Nama Materi</label>
                            <input type="text" class="form-control" name="nama_materi">

                        </div>
                        <input type="hidden" name="id_kelas" value="{{ $id }}">
                        <div>Masukkan file materi</div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Masukkan File materi</label> --}}
                            <input type="file" class="form-control" name="file_materi">

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
            document.getElementById("nama_materi").value = data.nama_materi;

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
                    window.location.href = `/hapus_materi/${id}`;
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
