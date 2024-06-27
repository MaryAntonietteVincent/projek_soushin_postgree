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
                                    value="{{ Request()->search }}" placeholder="Cari Data Barang..."
                                    oninput="searchOnChange()">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    <a href="{{ route('barang') }}" class="btn btn-success">refresh</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('tambah_barang') }}" class="btn btn-info">Tambah Barang</a>
                    @endif
                    <div class="row">
                        @foreach ($data as $item)
                            <div class="card mb-3" style="width: 18rem;">
                                <img src="{{ asset('produk/' . $item->gambar) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nama_produk }} </h5>
                                    <h6>Harga : {{ number_format($item->harga) }}</h6>
                                    <p class="card-text">{{ $item->deskripsi }}</p>
                                    @if (auth()->user()->role == 'admin')
                                        <a href="{{ route('edit_barang', ['id' => $item->id]) }}"
                                            class="btn btn-warning">Edit</a> <button type="button"
                                            class="btn btn-danger delete-btn" onclick="deleteData({{ $item->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                    @endif
                                    @if (auth()->user()->role == 'pelanggan')
                                        <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="addToCart({{ $item }})">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                    @endif
                                    {{--  --}}
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{ $data->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_keranjang') }}" method="post">
                        @csrf
                        <div><span>Nama Produk</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Nama Produk</label> --}}
                            <input type="text" class="form-control" name="nama_produk" id="nama_produk" readonly
                                disabled>
                        </div>
                        <div><span>Harga Peritem</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Nama Produk</label> --}}
                            <input type="text" class="form-control" name="harga" id="hargaa" readonly disabled>
                            <input type="hidden" name="id_barang" id="id_barang">
                            <input type="hidden" id="harga">
                        </div>
                        <div><span>qty</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Nama Produk</label> --}}
                            <input type="number" min="1" class="form-control" name="qty" id="qty"
                                oninput="updateSubtotal(this)">
                        </div>
                        <div><span>subtotal harga</span></div>
                        <div class="input-group input-group-outline mb-4">
                            {{-- <label class="form-label">Nama Produk</label> --}}
                            <input type="text" class="form-control" name="subtotal_harga" id="subtotal_harga" readonly>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        //fungsi update subtotal dengan parameter input yang berisikan qty dan harga unutk menentukan subtotal harga
        function updateSubtotal(input) {
            const qty = input.value;
            const hargaa = document.getElementById("harga").value;
            console.log(hargaa);
            document.getElementById("subtotal_harga").value = (qty * hargaa).toLocaleString('id-ID');// to locale String digunakan untuk mengubah angka menjadi format rupiah
        }
//merupakan fungsi tambah keranjang yang mana nilai paramternya adalah item yang dikirimkan dari fungsi addToCart
        function addToCart(item) {
            // console.log(item);
            document.getElementById("hargaa").value = item.harga.toLocaleString('id-ID');
            document.getElementById("harga").value = item.harga;
            document.getElementById("qty").value = 1;
            document.getElementById("subtotal_harga").value = item.harga.toLocaleString('id-ID');
            document.getElementById("nama_produk").value = item.nama_produk;
            document.getElementById("id_barang").value = item.id;
            document.getElementById("exampleModal").click();
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
                    window.location.href = `/hapus_barang/${id}`;
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
