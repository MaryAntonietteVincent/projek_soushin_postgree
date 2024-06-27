@extends('templating.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('ipen') }}" class="btn btn-danger mb-4">Kembali</a>
                    <h5>Form Edit</h1>
                        <form action="{{ url('/update_event/' . $data->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div>
                                <span>judul event</span>
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label"></label> --}}
                                <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                            </div>
                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="description" id="" cols="30" rows="4" class="form-control"
                                    placeholder="Deskripsi Event">{{ $data->description }}</textarea>
                            </div>
                            <div>
                                <span>Pihak Yang bertanggung Jawab</span>
                            </div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">Pihak Yang bertanggung jawab</label> --}}
                                <input type="text" class="form-control" name="organizer" value="{{ $data->organizer }}">
                            </div>
                            <div><span>dari tanggal</span></div>
                            <div class="input-group input-group-outline mb-4">

                                {{-- <label class="form-label">dari tanggal</label> --}}
                                <input type="date" class="form-control" id="start_date" placeholder="Dari Tanggal"
                                    value="{{ $data->start_date }}" name="start_date">
                            </div>
                            <div><span>sampai tanggal</span></div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">sampai tanggal</label> --}}
                                <input type="date" class="form-control" id="end_date" placeholder="Sampai Tanggal"
                                    name="end_date" value="{{ $data->end_date }}">
                            </div>


                            <div class="input-group input-group-dynamic mb-4">

                                <textarea name="location" id="" cols="30" rows="4" class="form-control" placeholder="Lokasi Event">{{ $data->location }}</textarea>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label for="status_event" class="ms-0">Status event</label>
                                <select class="form-control" id="status_event" name="status">
                                    <option value="upcoming" {{ $data->status === 'upcoming' ? 'selected' : '' }}>upcoming
                                    </option>
                                    <option value="ongoing" {{ $data->status === 'ongoing' ? 'selected' : '' }}>ongoing
                                    </option>
                                    <option value="completed" {{ $data->status === 'completed' ? 'selected' : '' }}>
                                        completed</option>
                                    <option value="cancelled" {{ $data->status === 'cancelled' ? 'selected' : '' }}>
                                        cancelled</option>
                                </select>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label for="Id_jenis" class="ms-0">Jenis event</label>
                                <select class="form-control" id="Id_jenis" name="id_jenisacara">
                                    @foreach ($jenis_acara as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $data->id_jenisacara == $item->id ? 'selected' : '' }}>
                                            {{ $item->jenis_acara }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>price</div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">price</label> --}}
                                <input type="text" class="form-control" name="price" value="{{ $data->price }}"
                                    oninput="formatCurrency(this)">
                            </div>
                            <div><span>Kapasitas orang</span></div>
                            <div class="input-group input-group-outline mb-4">
                                {{-- <label class="form-label">Kapasitas orang</label> --}}
                                <input type="number" class="form-control" name="capacity" value="{{ $data->capacity }}"
                                    oninput="formatCurrency(this)">
                            </div>

                            <div class="input-group input-group-dynamic mb-4">
                                <input type="file" class="form-control" aria-describedby="basic-addon2"
                                    name="image_event" accept="image/*" onchange="previewImage(this);">
                                <span class="input-group-text" id="basic-addon2">Gambar terkait Event</span>

                            </div>
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <a class="d-block blur-shadow-image">
                                    <img src="{{ asset('event/' . $data->image_event) }}" alt="img-blur-shadow"
                                        class="img-fluid shadow border-radius-lg" id="gambar-preview">
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
