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
                                            <td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editdata"onclick="edit({{ $item }})">
                                                    <i class="fa-solid fa-pen-to-square"></i>Bayar
                                                </button>
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


    <div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editdataLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pembayaran_danpengambilan_proses') }}" method="post">
                        @csrf
                        <div><span>Total Harga</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Judul Event</label> --}}
                            <input type="text" class="form-control" name="total_harga" id="total_harga" readonly>
                            <input type="hidden" class="form-control" id="total_hargaa" readonly>
                        </div>
                        <input type="hidden" name="id" id="id_edit">
                        <div><span>Total bayar</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Judul Event</label> --}}
                            <input type="text" class="form-control" name="bayar" id="bayar" value="0" oninput="formatAndCalculateValues(this)">
                        </div>
                        <div><span>Kembalian </span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Judul Event</label> --}}
                            <input type="text" class="form-control" name="kembalian" id="kembalian" readonly>
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
      

      function formatAndCalculateValues(input) {
        const totalHarga = parseCurrency(document.getElementById('total_hargaa').value);
        
        // Get the value from the bayar field and remove non-numeric characters
        let bayar = parseCurrency(input.value);

        // Calculate kembalian
        const kembalian = bayar - totalHarga;
        
        // Update kembalian field (only if bayar is greater than totalHarga)
        document.getElementById('kembalian').value = formatCurrency(kembalian > 0 ? kembalian : 0);

        // Update bayar field with formatted value
        input.value = formatCurrency(bayar);
    }

    // Function to ensure only numeric input is allowed
    function restrictInputToNumbers(event) {
        const key = event.key;
        // Allow only digits, Backspace, and Delete keys
        if (!/[0-9]/.test(key) && key !== 'Backspace' && key !== 'Delete') {
            event.preventDefault();
        }
    }

    // Add event listener to the bayar input field
    document.getElementById('bayar').addEventListener('input', function() {
        formatAndCalculateValues(this);
    });

    // Add keydown event listener to restrict input to numbers only
    document.getElementById('bayar').addEventListener('keydown', restrictInputToNumbers);

       

        

        


        function edit(data) {
            document.getElementById("id_edit").value = data.id;
            document.getElementById("total_harga").value = data.total_harga.toLocaleString('id-ID');
            document.getElementById("total_hargaa").value = data.total_harga;
            // document.getElementById("bayar1").value = data.bayar.toLocaleString('id-ID');
            // document.getElementById("kembalian1").value = data.kembalian.toLocaleString('id-ID');
            // document.getElementById("total_harga1").value = parseInt(data.total_harga);
            // document.getElementById("kurang_bayar").value = data.kurang_bayar.toLocaleString('id-ID');
            // document.getElementById("kurang_bayar1").value = data.kurang_bayar.toLocaleString('id-ID');

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
