<!DOCTYPE html>
<html>
<head>
    @extends('layout.sidebar')
    <link rel="stylesheet" type="text/css">
</head>
<body>
    @section('dashboard')
    <h2 class="mb-4">Dashboard</h2>

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
    
    @endsection
</body>
</html>
