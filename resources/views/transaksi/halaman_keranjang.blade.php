@extends('templating.main')
@section('content')
    <style>
        .table td {
            padding: 5px;
        }

        .table td a {
            margin: 0 5px;
        }

        .actions-cell {
            display: flex;
            /* Enables flexbox layout */
            align-items: center;
            /* Vertically centers the items */
            gap: 10px;
            /* Sets a consistent space between elements */
        }

        /* Optional: Add some margin or padding adjustments if needed */
        .actions-cell .btn {
            margin: 0;
            /* Removes any default margin */
            padding: 5px 10px;
            /* Adjust the padding for buttons */
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            @if (count($data) == 0)
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning text-white" role="alert">
                            <strong>Warning!</strong> Tidak ada data produk di keranjang anda, segera pesan sekarang ya
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    @foreach ($data as $item)
                    <form action="{{ route('pemesanan') }}" method="post">
                        @csrf
                        <div class="card-body">
                            {{-- <div class="table-responsive p-0"> --}}
                            <table class="table table-striped">
                                {{-- <table class="table table-striped"> --}}
                                <tr>
                                    <th>
                                    <td> <input type="checkbox" class="product-checkbox"
                                            data-harga="{{ $item->sub_total }}" onchange="hitungTotal()"
                                            name="id_keranjang[]" value="{{ $item->id }}"></td>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Gambar produk</th>
                                    <td><img src="{{ asset('produk/' . $item->barang->gambar) }}" width="100"
                                            style="max-width: 100px; height: auto;"></td>
                                    <!-- Kolom dan isinya berada dalam satu baris -->
                                </tr>
                                <tr>
                                    <th>Nama produk</th>
                                    <td>{{ $item->barang->nama_produk }}</td>
                                    <!-- Kolom dan isinya berada dalam satu baris -->
                                </tr>
                                <tr>
                                    <th>Harga peritem</th>
                                    <td>Rp. {{ number_format($item->barang->harga) }}</td> <!-- Contoh baris tambahan -->
                                </tr>
                                <tr>
                                    <th>Jumlah dipesan</th>
                                    @if ($item->qty <= 1)
                                        <td class="actions-cell">
                                            {{-- <a href="" class="btn btn-sm btn-primary"><i class="fa-solid fa-trash"></i></a> --}}
                                            <button class="btn btn-sm btn-primary"
                                                onclick="deleteData({{ $item->id }})"><i
                                                    class="fa-solid fa-trash"></i></button>
                                            {{ $item->qty }}
                                            <a href="{{ route('tambah_qty', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-info">+</a>
                                        </td>
                                    @else
                                        <td><a href="{{ route('kurang_qty', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-primary">-</a>

                                            {{ $item->qty }}
                                            <a href="{{ route('tambah_qty', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-info">+</a>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>subtotal</th>
                                    <td>Rp. {{ number_format($item->sub_total) }}</td> <!-- Contoh baris tambahan -->
                                </tr>
                            </table>
                            <br>
                            {{-- {{ $data->withQueryString()->links() }} --}}
                            {{-- </div> --}}
                        </div>
                    @endforeach
                </div>
        </div>
        <hr>
        {{-- <div class="col-lg-6"> --}}
        <div class="card">
            <div class="card-body">
                <div><span>Tanggal Ambil Pesanan</span></div>
                <div class="input-group input-group-outline mb-4">
                    {{-- <label class="form-label">Tanggal Yang Mau diambil</label> --}}
                    <input type="date" class="form-control" id="tanggalInput" name="tanggal_ambil">
                </div>
                <div><span>Total Harga</span></div>
                <div class="input-group input-group-outline mb-4">
                    {{-- <label class="form-label">Tanggal Yang Mau diambil</label> --}}
                    <input type="text" class="form-control" name="total_harga" id="total_harga">
                </div>
                {{-- <input type="text" class="form-control" name="total_harga" id="total_harga" readonly=""> --}}
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">pesan</button>
            </div>
        </div>
    </form>
        {{-- </div> --}}
        @endif
    </div>
    <script>
        function hitungTotal() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            var totalHarga = 0;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    totalHarga += parseInt(checkbox.getAttribute('data-harga'));
                }
            });

            // Menyimpan total harga ke input total_harga
            document.getElementById('total_harga').value = formatCurrency(totalHarga);
        }
        // Mendapatkan elemen input tanggal
        var inputTanggal = document.getElementById('tanggalInput');

        // Mendapatkan tanggal hari ini
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Mengatur atribut min pada input tanggal ke tanggal hari ini
        inputTanggal.setAttribute('min', today);

        function deleteData(id) {
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Apakah Kamu Yakin Ingin Menghapus Data produk dari keranjang?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log(id);
                    window.location.href = `/reset_qty/${id}`;
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
