@extends('templating.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('barang') }}" class="btn btn-danger mb-4">Kembali</a>
                    <h5>Form Edit</h1>
                        <form action="{{ url('/update_barang/'.$data->id) }}" method="post" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label"></label>
                                <input type="text" class="form-control" name="nama_produk" value="{{ $data->nama_produk }}">
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label"></label>
                                <input type="text" class="form-control" name="harga" value="{{ number_format($data->harga) }}" oninput="formatCurrency(this)">
                            </div>
                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="deskripsi" id="" cols="30" rows="4" class="form-control"
                                    placeholder="deskripsi prduk">{{ $data->deskripsi }}</textarea>
                            </div>
                            <div class="input-group input-group-dynamic mb-4">
                                <input type="file" class="form-control" aria-describedby="basic-addon2" name="gambar"  accept="image/*"   onchange="previewImage(this);">
                                <span class="input-group-text" id="basic-addon2">Gambar Produk</span>
                              
                            </div>
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <a class="d-block blur-shadow-image">
                                  <img src="{{ asset('produk/'.$data->gambar) }}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" id="gambar-preview" >
                                </a>
                              </div>


                            <button type="submit" class="btn btn-info">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function formatCurrency(input) {
            // Hapus tanda titik atau koma jika ada
            let valueWithoutCommas = input.value.replace(/[,.]/g, '');

            // Format angka dengan tanda titik sebagai pemisah ribuan
            let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);

            // Tampilkan nilai yang diformat pada input
            input.value = formattedValue;
        }
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
