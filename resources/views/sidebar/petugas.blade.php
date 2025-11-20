<ul class="list-unstyled px-3">
    <li class="{{ Request::is('*beranda') ? 'active' : ''}}"><a href="{{ route('beranda.petugas') }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">Transaksi</span>
    {{-- <li class="{{ Request::is('*pembayaran*') ? 'active' : ''}}"><a href="{{ route('Xpembayaran.index') }}"><i class="bi bi-receipt-cutoff"></i>Pembayaran</a></li> --}}
    <li class="{{ Request::is('*pembayaran*') ? 'active' : ''}}"><a href="{{ route('petugas.pembayaran.index') }}"><i class="bi bi-receipt-cutoff"></i>Pembayaran</a></li>

    <li class="{{ Request::is('*riwayat*') ? 'active' : ''}}"><a href="{{ route('petugas.riwayat.index') }}"><i class="bi bi-clock-history"></i>Riwayat</a></li>
</ul>
