<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        th {
            background: #eaeaea;
        }
    </style>
</head>
<body>

<h3 style="text-align:center;">LAPORAN PEMBAYARAN SPP</h3>
<p style="text-align:center">
    Periode:
    <b>{{ $tglAwal ?? '-' }}</b>
    s/d
    <b>{{ $tglAkhir ?? '-' }}</b>
</p>

<table>
    <thead>
        <tr>
            <th style="width: 20px;">NO</th>
            <th>Tanggal</th>
            <th>Petugas</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th style="width: 70px;">Bulan Dibayar</th>
            <th>Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pembayaran as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->tgl_bayar }}</td>
                <td>{{ $p->petugas->nama_petugas }}</td>
                <td>{{ $p->nisn }}</td>
                <td style="text-align:left;">{{ $p->siswa->nama }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                <td>{{ $p->total_bulan }}</td>
                <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<table style="width: 100%; border: none; margin-top: 40px;">
    <tr>
        <td style="border: none;"></td>
        <td style="border: none; width: 140px; text-align: center;">
            <p>Penanggung Jawab,</p>
            <br><br><br>
            <p>( ______________________ )</p>
        </td>
    </tr>
</table>

</body>
</html>
