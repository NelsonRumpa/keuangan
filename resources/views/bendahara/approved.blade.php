<!DOCTYPE html>
<html>
<head>
    @extends('layout.sidebar3')
</head>
<body>
    @section('approved')
    <h2 class="mb-4">Transaksi</h2>

    <table class="table" action="{{ route('getapp') }}" method="get">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
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
        @foreach($dataTransaksi as $dt)
        @php $no++; @endphp
        <tbody>
                <td>{{ $no}}</td>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-gambar-{{$dt->id}}">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </button>

                  @if ($dt->is_approved == 0)
                    <a href="{{ route('appro', $dt->id) }}" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-reject-{{$dt->id}}">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                  @endif
                </td>         
        </tbody>
         <div class="modal fade" id="modal-gambar-{{$dt->id}}" tabindex="-1" aria-labelledby="modal-gambar-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-gambar-label">Gambar</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <img src="{{ asset($dt->gambar) }}" alt="Gambar Kecil" style="width: 250px; height: 200px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-reject-{{$dt->id}}" tabindex="-1" aria-labelledby="modal-reject-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-reject-label">Reject Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this transaction?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('reject', $dt->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        @endforeach
      </table>
    @endsection
</body>
</html>
