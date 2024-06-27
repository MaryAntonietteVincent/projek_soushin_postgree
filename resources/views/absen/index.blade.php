@extends('templating.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if ($jadwals->isEmpty())
                <div class="alert alert-warning text-white" role="alert">
                    Tidak Ada Jadwal Untuk hari ini
                </div>
            @else
                @foreach ($jadwals as $item)
                    {{-- @php
            // Konversi waktu ke format Carbon
            $jamAwal = \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_awal);
            $jamAkhir = \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_akhir);
            $waktuSekarang = \Carbon\Carbon::createFromFormat('H:i:s',$jam_sekarang);
        @endphp --}}

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Kelas :{{ $item->kelas }}</h5>
                            <p class="text-center">Tanggal :{{ $item->tanggal }}</p>
                            {{-- <p class="text-center">Kelas</p> --}}
                            <p class="text-center">dari jam:{{ $item->jam_awal }} sampai {{ $item->jam_akhir }}</p>
                            <p class="text-center"><a href="{{ route('lihat_materiuser', $item->id_kelas) }}">lihat materi</a></p>

                            {{-- @if ($waktuSekarang >= $jamAwal)
                        <p class="text-center text-success">Waktu Sekarang berada di antara jam awal dan jam akhir</p>
                    @else
                        <p class="text-center text-danger">Waktu Sekarang tidak berada di antara jam awal dan jam akhir</p>
                    @endif --}}
                            @php
                                // Konversi waktu ke format Carbon
                                $jamAwal = \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_awal);
                                $jamAkhir = \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_akhir);
                                $waktuSekarang = \Carbon\Carbon::now();

                                // Debugging - Cetak waktu untuk memastikan

                            @endphp
                            @if ($item->absen_status)
                                <p class="text-center">Status Absen: {{ $item->absen_status }}</p>
                            @else
                                {{-- <p class="text-center">Status Absen: Belum Absen</p> --}}
                                <div class="text-center">
                                    @if ($waktuSekarang->between($jamAwal, $jamAkhir))
                                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="absen({{ $item->id }})">
                                            absen
                                        </button>
                                    @else
                                        <button class="btn btn-danger">Absen di tutup</button>
                                    @endif
                                </div>
                            @endif


                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Absensi</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actabsen') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_jadwal" id="id_jadwal">
                        <div class="input-group input-group-static mb-4">
                            <label for="kehadiran" class="ms-0">Absen</label>
                            <select class="form-control" id="kehadiran" name="status">
                                <option value="hadir">hadir</option>
                                <option value="tidak hadir">tidak hadir</option>
                                <option value="izin">izin</option>

                            </select>
                        </div>

                        <div class="form-group mb-3" id="bukti_izin">
                            <label class="col-form-label">Bukti izin</label>
                            <input type="file" class="form-control" name="bukti_surat">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBuktiBayar() {
            var Absen = document.getElementById("kehadiran").value;
            var buktiIzin = document.getElementById("bukti_izin");
            if (Absen === "izin") {
                buktiIzin.style.display = "block";
            } else {
                buktiIzin.style.display = "none";
                buktiIzin.value = ""; // Set nilai menjadi null jika model pembayaran bukan TF
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state
            toggleBuktiBayar();
            // Add event listener to dropdown
            document.getElementById("kehadiran").addEventListener("change", toggleBuktiBayar);
        });


        function absen(id) {

            document.getElementById("id_jadwal").value = id;
        }
    </script>
@endsection
