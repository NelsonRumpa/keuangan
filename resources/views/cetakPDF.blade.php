<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .debit {
            color: green;
        }

        .kredit {
            color: red;
        }
    </style>
</head>
<body>
    <h2 class="mb-4">Laporan Keuangan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 0; $totalDebit = 0; $totalKredit = 0; @endphp
            @foreach($sortedDates as $tanggal)
                @foreach($dataByDate[$tanggal] as $dt)
                    @php
                        $no++;
                        $jumlah = $dt['jumlah'];
                        if ($dt['jenis'] == 'Pengeluaran') {
                            $jumlah *= -1; // Pengeluaran dianggap kredit (dikurangkan)
                            $totalKredit += $jumlah;
                        } else {
                            $totalDebit += $jumlah;
                        }
                    @endphp
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $dt['tanggal'] }}</td>
                        <td>{{ $dt['jenis'] }}</td>
                        <td>{{ $dt['kategori'] }}</td>
                        <td class="debit">{{ $dt['jenis'] == 'Pemasukan' ? number_format($jumlah) : '' }}</td>
                        <td class="kredit">{{ $dt['jenis'] == 'Pengeluaran' ? number_format($jumlah) : '' }}</td>
                        <td>{{ $dt['keterangan'] }}</td>
                        <td>
                            @if ($dt->is_approved == 1)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Pending</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div>
        <strong>Total Debit:</strong> <span class="debit">{{ number_format($totalDebit) }}</span>
    </div>
    <div>
        <strong>Total Kredit:</strong> <span class="kredit">{{ number_format($totalKredit) }}</span>
    </div>
</body>
</html>
