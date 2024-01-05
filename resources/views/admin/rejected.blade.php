<!DOCTYPE html>
<html>
<head>
    @extends('layout.sidebar')

</head>
<body>
    @section('rejected')
    <h2 class="mb-4">Rejected Data</h2>

    <br><br>


    @php
    $dataByDate = $dataRejected->groupBy('tanggal');
    $sortedDates = $dataByDate->keys()->sortDesc();
@endphp

@foreach($sortedDates as $tanggal)
    <table class="table" action="{{ route('rejected') }}" method="get">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Jenis</th>
                <th scope="col">Kategori</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Hasil</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        @php $no=0; @endphp
        @foreach($dataByDate[$tanggal] as $dr)
            @php $no++; @endphp
            <tbody>
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $dr['tanggal'] }}</td>
                    <td>{{ $dr['jenis'] }}</td>
                    <td>{{ $dr['kategori'] }}</td>
                    <td>{{ number_format($dr['jumlah']) }}</td>
                    <td>{{ $dr['keterangan'] }}</td>
                    <td>
                    <span class="badge badge-danger">Rejected</span>
                    </td>
                    <td>
                  <button type="button" class="btn btn-primary" data-toggle="modal"
                      data-target="#modal-gambar-{{$dr->id}}">
                      <i class="fa fa-picture-o" aria-hidden="true"></i>
                  </button>
                    </td>
                </tr>
            </tbody>

        {{-- pop up gambar --}}
        <div class="modal fade" id="modal-gambar-{{$dr->id}}" tabindex="-1" aria-labelledby="modal-gambar-label" aria-hidden="true">
          <div class="modal-dialog text-center">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modal-gambar-label">Gambar</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <img src="{{ asset($dr->gambar) }}" alt="Gambar Kecil" style="max-width: 100%; max-height: 100%;">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </div>
              </div>
          </div>
      </div>      
  
  @endforeach
</table>
@endforeach


      <script>
    // Fungsi untuk mengisi opsi kategori berdasarkan jenis yang dipilih
    function populateKategori() {
        var jenis = document.getElementById('jenis').value;
        var kategoriSelect = document.getElementById('kategori');
        kategoriSelect.innerHTML = '<option value="">Silahkan Pilih</option>';

        @foreach ($dataKategori as $dk)
            if (jenis === '{{ $dk->jenis }}') {
                var option = document.createElement('option');
                option.value = '{{ $dk->kategori }}';
                option.text = '{{ $dk->kategori }}';
                kategoriSelect.appendChild(option);
            }
        @endforeach
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        populateKategori();
    });

    // Panggil fungsi saat jenis berubah
    document.getElementById('jenis').addEventListener('change', function () {
        populateKategori();
    });
</script>


    @endsection
</body>
</html>
