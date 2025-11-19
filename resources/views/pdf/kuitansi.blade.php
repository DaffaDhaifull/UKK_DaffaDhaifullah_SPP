<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kuitansi Pembayaran SPP</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .card {
            border: 1px solid #cfcfcf;
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        th {
            text-align: left;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 6px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="card">
        <h3 style="text-align: center; margin-bottom: 0;">PEMBAYARAN SPP</h3>
        <p style="text-align: center; margin-top: 0;">{{ strtoupper($tanggalCetak) }}</p>

        <table style="width:100%; margin-top:10px; border-collapse: collapse;" border="0">
            <tr>
                <td style="font-weight:bold; width:10%; border:0;">NISN</td>
                <td style="width:25%; border:0;">: {{ $utama->nisn }}</td>

                <td style="font-weight:bold; width:20%; border:0;">Nama</td>
                <td style="width:25%; border:0;">: {{ $utama->siswa->nama }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold; border:0;">Kelas</td>
                <td style="border:0;">: {{ $utama->siswa->kelas->nama_kelas }}</td>

                <td style="font-weight:bold; border:0;">Tanggal Bayar</td>
                <td style="border:0;">: {{ $utama->tgl_bayar }}</td>
            </tr>
        </table>

        <hr>

        <table>
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semuaPembayaran as $item)
                    <tr>
                        <td>{{ $item->tahun_dibayar }}</td>
                        <td>{{ $item->bulan_dibayar }}</td>
                        <td>Rp {{ number_format($item->jumlah_bayar,0,',','.') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td><strong>Total Bayar</strong></td>
                    <td><strong>Rp {{ number_format($totalBayar,0,',','.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: right; margin-top: 20px;">Petugas: {{ $utama->petugas->nama_petugas }}</p>
    </div>

</body>
</html>
