<!DOCTYPE html>
<html>
<head>
    @extends('layout.sidebar2')
</head>
<body>
    @section('kategori')
    <h2 class="mb-4">Kategori</h2>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
      Buka Form
    </button>

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
          <div class="modal-body flex-column">
            <form action="{{ route('peka') }}" method="post">
              @csrf

              <div class="form-group">
                <label for="jenis">Jenis</label>
                <select id="jenis" name="jenis" required>
                  <option value="Pemasukan">Pemasukan</option>
                  <option value="Pengeluaran">Pengeluaran</option>
                </select>
              </div>

              <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" placeholder="Masukkan Kategori">
              </div>

              <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>


    <table class="table" action="{{ route('getkate') }}" method="get">
        <thead class="thead-dark">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Jenis</th>
            <th scope="col">Kategori</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        @php $no=0; @endphp
        @foreach($dataKategori as $dk)
        @php $no++; @endphp
        <tbody>
                <td>{{ $no}}</td>
                <td>{{ $dk['jenis'] }}</td>
                <td>{{ $dk['kategori'] }}</td>
                <td>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-edit-{{$dk->id}}">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
                  <a href="{{ route('delete', $dk->id) }}" class="btn btn-danger fa fa-trash-o" aria-hidden="true"></a>
                </td>                
        </tbody>

        <div class="modal fade" id="modal-edit-{{$dk->id}}" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="{{ route('data.updatee', ['id' => $dk->id]) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="modal-header">
                          <h5 class="modal-title" id="modal-edit-label">Edit Data</h5>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <!-- Isi form edit sesuai dengan entitas Anda -->
                          <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select id="jenis" name="jenis" required>
                                <option value="Pemasukan"<?php if ($dk['jenis'] == 'Pemasukan') echo ' selected="selected"'; ?>>Pemasukan</option>
                                <option value="Pengeluaran"<?php if ($dk['jenis'] == 'Pengeluaran') echo ' selected="selected"'; ?>>Pengeluaran</option>
                            </select>
                        </div>
    
                          <div class="form-group">
                              <label for="kategori">Kategori:</label>
                              <input type="text" id="kategori" name="kategori" value={{$dk->kategori}}>
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
    @endsection
</body>
</html>
