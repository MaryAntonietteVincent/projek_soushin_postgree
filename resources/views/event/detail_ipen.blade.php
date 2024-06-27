@extends('templating.main')
@section('content')
<style>
    .event-description {
    max-height: 200px; /* Tentukan ketinggian maksimum yang sesuai */
    overflow-y: auto; /* Tambahkan scroll jika konten melebihi max-height */
    white-space: pre-wrap; /* Pastikan teks membungkus ke baris baru jika panjang */
    word-wrap: break-word; /* Memecah kata-kata panjang agar sesuai dengan lebar elemen */
    line-height: 1.5; /* Menambah jarak antar baris untuk kenyamanan membaca */
    padding: 10px; /* Menambahkan padding untuk kenyamanan visual */
    background-color: #f8f9fa; /* Tambahkan warna background jika diinginkan */
    border: 1px solid #ddd; /* Tambahkan border jika diinginkan */
    border-radius: 4px; /* Tambahkan border-radius untuk sudut yang lebih halus */
}
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <img src="{{ asset('event/' . $data->image_event) }}" alt="Gambar Projek" class="img-fluid">
                        </div>
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Judul event</th>
                                        <td>{{ $data->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi Event</th>
                                        <td style="max-height: 200px; overflow-y: auto;"><textarea name="" id="" cols="30" rows="10" readonly disabled>{{ $data->description }}</textarea></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Acara  Event</th>
                                        <td>{{ $data->jenisacara->jenis_acara }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dari Tanggal</th>
                                        <td>{{ $data->start_date }}</td>
                                    </tr>
                                    <tr>
                                    <th>Sampai Tanggal</th>
                                    <td>{{ $data->end_date }}</td>
                                    </tr>
                                    <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $data->location }}</td>
                                    </tr>
                                    <tr>
                                    <th>Organisasi Yang Bertanggung Jawab</th>
                                    <td>{{ $data->organizer }}</td>
                                    </tr>
                                    <tr>
                                    <th>Status Evennt</th>
                                    <td>{{ $data->status }}</td>
                                    </tr>
                                    <tr>
                                    <th>capasitas orang</th>
                                    <td>{{ $data->capacity }}</td>
                                    </tr>
                                    <tr>
                                    <th>Harga</th>
                                    <td>{{ number_format($data->price) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
