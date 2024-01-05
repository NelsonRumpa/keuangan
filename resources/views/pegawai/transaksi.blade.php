<!DOCTYPE html>
<html>
<head>
    @extends('layout.sidebar2')
    <link rel="stylesheet" href="js/transaksi.js">
    <script>src="https://code.jquery.com/jquery-3.6.0.min.js"</script>

</head>
<body>
    @section('transaksi')
    <h2 class="mb-4">Transaksi</h2>
    
    <br>

    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Pemasukan</h5>
              <h3 class="card-text">{{number_format($jumlah5)}}</h3>
            </div>
          </div>
        </div>
    
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-danger">Pengeluaran</h5>
              <h3 class="card-text">{{number_format($jumlah6)}}</h3>
            </div>
          </div>
        </div>
    
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Saldo</h5>
              <h3 class="card-text">{{number_format($saldo)}}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <br><br>

    <form action="{{ route('filter2') }}" method="get" class="mb-3">
      @csrf
    
      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="tanggal-start">Start Date:</label>
            <input type="date" class="form-control" name="tanggal_start" id="tanggal-start" style="max-width: 200px;" />
          </div>
        </div>
    
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal-end">End Date:</label>
            <input type="date" class="form-control" name="tanggal_end" id="tanggal-end" style="max-width: 200px;" />
          </div>
        </div>
      </div>
    
      <div class="form-group form-check">
        <label class="form-check-label" for="approved">Status:</label>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="approved" id="approved" value="1" />
          <label class="form-check-label" for="approved">Approved</label>
        </div>
      </div>
    
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>     

    <br><br>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
      Buka Form
    </button>

    <button type="button" class="btn btn-primary" onclick="window.location='{{ route('cetakpdf') }}'" href>Cetak PDF</button>

    <button type="button" class="btn btn-primary" onclick="window.location='{{ route('excel') }}'" href>Cetak EXCEL</button>

    <br><br>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Formulir</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('postra') }}" method="post" enctype="multipart/form-data">
              @csrf
    
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Masukkan tanggal" required>
              </div>
    
              <div class="form-group">
                <label for="jenis">Jenis</label>
                <select class="form-control" id="jenis" name="jenis" required>
                  <option value="Pemasukan">Pemasukan</option>
                  <option value="Pengeluaran">Pengeluaran</option>
                </select>
              </div>
    
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                  <option value="">Silahkan Pilih</option>
                  <!-- Add your category options here -->
                </select>
              </div>
    
              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah" required>
              </div>
    
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan keterangan" style="width: 80%" required>
              </div>
    
              <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" class="form-control-file" name="gambar" id="gambar" required>
              </div>
    
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Kirim</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    @php
    $dataByDate = $dataTransaksi->groupBy('tanggal');
    $sortedDates = $dataByDate->keys()->sortDesc();
    @endphp


@foreach($sortedDates as $tanggal)
<table class="table" action="{{ route('gettran') }}" method="get">
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
    @foreach($dataByDate[$tanggal] as $dt)

        @php $no++; @endphp
        <tbody>
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $dt['tanggal'] }}</td>
                <td>{{ $dt['jenis'] }}</td>
                <td>{{ $dt['kategori'] }}</td>
                <td>{{ number_format($dt['jumlah']) }}</td>
                <td>{{ $dt['keterangan'] }}</td>
                <td>
                    @if ($dt->is_approved == 1)
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-danger">Pending</span>
                    @endif
                </td>
                <td>
                  @if ($dt->is_approved == 1)
              @else
                  
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-edit-{{$dt->id}}">
                      <i class="fa fa-pencil" aria-hidden="true"></i>
                  </button>
          
                  <a href="{{ route('deletee', $dt->id) }}" class="btn btn-danger fa fa-trash-o"
                      aria-hidden="true"></a>
              @endif
          
              <button type="button" class="btn btn-primary" data-toggle="modal"
                  data-target="#modal-gambar-{{$dt->id}}">
                  <i class="fa fa-file" aria-hidden="true"></i>
              </button>
                </td>
            </tr>
        </tbody>

        {{-- pop up gambar --}}
        <div class="modal fade" id="modal-gambar-{{$dt->id}}" tabindex="-1" aria-labelledby="modal-gambar-label" aria-hidden="true">
          <div class="modal-dialog text-center">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modal-gambar-label">Gambar</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <img src="{{ asset($dt->gambar) }}" alt="Gambar Kecil" style="max-width: 100%; max-height: 100%;">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </div>
              </div>
          </div>
      </div>

    {{-- pop up edit --}}

    <div class="modal fade" id="modal-edit-{{$dt->id}}" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <form action="{{ route('data.update', ['id' => $dt->id]) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
  
                  <div class="modal-header">
                      <h5 class="modal-title" id="modal-edit-label">Edit Data</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
  
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="tanggal">Tanggal:</label>
                          <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{$dt->tanggal}}">
                      </div>
  
                      <div class="form-group">
                          <label for="jenis">Jenis</label>
                          <select class="form-control" id="jenis" name="jenis" required>
                              <option value="Pemasukan"{{ $dt->jenis == 'Pemasukan' ? ' selected' : '' }}>Pemasukan</option>
                              <option value="Pengeluaran"{{ $dt->jenis == 'Pengeluaran' ? ' selected' : '' }}>Pengeluaran</option>
                          </select>
                      </div>
  
                      <div class="form-group">
                          <label for="kategori">Kategori</label>
                          <select class="form-control" id="kategori" name="kategori" required>
                              <option value="">Silahkan Pilih</option>
                              @foreach ($dataKategori as $item)
                                  <option value="{{$item->kategori}}"{{ $item->kategori == $dt->kategori ? ' selected' : '' }}>
                                      {{$item->kategori}}
                                  </option>
                              @endforeach
                          </select>
                      </div>
  
                      <div class="form-group">
                          <label for="jumlah">Jumlah:</label>
                          <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{$dt->jumlah}}">
                      </div>
  
                      <div class="form-group">
                          <label for="keterangan">Keterangan:</label>
                          <textarea class="form-control" id="keterangan" name="keterangan">{{$dt->keterangan}}</textarea>
                      </div>
  
                      <div class="form-group">
                          <label for="gambar">Gambar:</label>
                          <input type="file" class="form-control" id="gambar" name="gambar">
                      </div>
                  </div>
  
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  
        @endforeach
      </table>
      @endforeach

{{-- untuk memilih jenis agar dapat ditampilkan --}}

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
