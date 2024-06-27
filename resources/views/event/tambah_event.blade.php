@extends('templating.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('barang') }}" class="btn btn-danger mb-4">Kembali</a>
                    <h5>for tambah</h1>
                        <form action="{{ route('tambah_event_proses') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Judul Event</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="description" id="" cols="30" rows="4" class="form-control"
                                    placeholder="Deskripsi Event"></textarea>
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Pihak Yang bertanggung jawab</label>
                                <input type="text" class="form-control" name="organizer">
                            </div>
                            <div><span>dari tanggal</span></div>
                            <div class="input-group input-group-outline mb-4">
                                
                                {{-- <label class="form-label">dari tanggal</label> --}}
                                <input type="date" class="form-control" id="start_date" placeholder="Dari Tanggal" name="start_date">
                            </div>
                            <div><span>sampai tanggal</span></div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">sampai tanggal</label> --}}
                                <input type="date" class="form-control" id="end_date" placeholder="Sampai Tanggal" name="end_date">
                            </div>

                          
                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="location" id="" cols="30" rows="4" class="form-control"
                                    placeholder="Lokasi Event"></textarea>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label for="status_event" class="ms-0">Status event</label>
                                <select class="form-control" id="status_event" name="status">
                                  <option>upcoming</option>
                                  <option>ongoing</option>
                                  <option>completed</option>
                                  <option>cancelled</option>
                                
                                </select>
                              </div>
                            <div class="input-group input-group-static mb-4">
                                <label for="Id_jenis" class="ms-0">Jenis event</label>
                                <select class="form-control" id="Id_jenis" name="id_jenisacara">
                                    @foreach ($jenis_acara as $item)
                                        
                                    <option value="{{ $item->id }}">{{ $item->jenis_acara }}</option>
                                    @endforeach
                                
                                
                                </select>
                              </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">price</label>
                                <input type="text" class="form-control" name="price"  oninput="formatCurrency(this)">
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Kapasitas orang</label>
                                <input type="number" class="form-control" name="capacity"  oninput="formatCurrency(this)">
                            </div>
                          
                            <div class="input-group input-group-dynamic mb-4">
                                <input type="file" class="form-control" aria-describedby="basic-addon2" name="image_event"  accept="image/*"   onchange="previewImage(this);">
                                <span class="input-group-text" id="basic-addon2">Gambar terkait Event</span>
                              
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
        function formatCurrency(input) {
            // Hapus tanda titik atau koma jika ada
            let valueWithoutCommas = input.value.replace(/[,.]/g, '');

            // Format angka dengan tanda titik sebagai pemisah ribuan
            let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);

            // Tampilkan nilai yang diformat pada input
            input.value = formattedValue;
        }

        document.getElementById('start_date').addEventListener('change', function() {
        const startDate = this.value;
        const endDateInput = document.getElementById('end_date');

        if (startDate) {
            endDateInput.setAttribute('min', startDate);
        } else {
            endDateInput.removeAttribute('min');
        }
    });

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
