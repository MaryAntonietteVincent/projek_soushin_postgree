@extends('templating.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('barang') }}" class="btn btn-danger mb-4">Kembali</a>
                    <h5>for tambah</h1>
                        <form action="{{ route('tambah_barang_proses') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk">
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Harga</label>
                                <input type="text" class="form-control" name="harga"  oninput="formatRupiah(this)">
                            </div>
                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="deskripsi" id="" cols="30" rows="4" class="form-control"
                                    placeholder="deskripsi prduk"></textarea>
                            </div>
                            <div class="input-group input-group-dynamic mb-4">
                                <input type="file" class="form-control" aria-describedby="basic-addon2" name="gambar"  accept="image/*"   onchange="previewImage(this);">
                                <span class="input-group-text" id="basic-addon2">Gambar Produk</span>
                              
                            </div>
                            <div>
                                <img id="gambar-preview" src="#" alt="Gambar Pratinjau"
                                style="max-width: 50%; display: none;">
                            </div>


                            <button type="submit" class="btn btn-info">Tambah</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      
        function previewImage(input) {
            var preview = document.getElementById('gambar-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Tampilkan gambar terpilih
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file yang dipilih
            }
        }
    </script>
@endsection
