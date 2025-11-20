<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        th {
            background: #e8e8e8;
        }
    </style>
</head>
<body>

<h3 style="text-align:center;">LAPORAN PEMBAYARAN SPP</h3>
<p style="text-align:center;">KELAS {{ $kelas->nama_kelas }}</p>

@php
    $totalBayarKelas = 0;
    $totalTunggakanKelas = 0;
@endphp

<table>
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>

            @foreach ($bulan as $b)
                <th>{{ $b }}</th>
            @endforeach

            <th>Total Dibayar</th>
            <th>Tunggakan</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)

            @php
                $countLunas = collect($item['status'])->filter(fn($v) => $v === 'lunas')->count();
                $countBelum = collect($item['status'])->filter(fn($v) => $v !== 'lunas')->count();

                $dibayar = $countLunas * $item['nominal'];
                $tunggakan = $countBelum * $item['nominal'];

                $totalBayarKelas += $dibayar;
                $totalTunggakanKelas += $tunggakan;
            @endphp

            <tr>
                <td>{{ $item['nisn'] }}</td>
                <td style="text-align:left;">{{ $item['nama'] }}</td>
                <td>{{ $item['kelas'] }}</td>

                @foreach ($item['status'] as $sts)
                    <td>
                        @if ($sts === 'lunas')
                            {{ number_format($item['nominal'], 0, ',', '.') }}
                        @else
                            0
                        @endif
                    </td>
                @endforeach

                <td><b>{{ number_format($dibayar, 0, ',', '.') }}</b></td>
                <td><b>{{ number_format($tunggakan, 0, ',', '.') }}</b></td>
            </tr>

        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="{{ 3 + count($bulan) }}" style="text-align:right;">TOTAL SEMUA:</th>
            <th style="background:#dfffd9;">Rp. {{ number_format($totalBayarKelas, 0, ',', '.') }}</th>
            <th style="background:#ffd9d9;">Rp. {{ number_format($totalTunggakanKelas, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

</body>
</html>
