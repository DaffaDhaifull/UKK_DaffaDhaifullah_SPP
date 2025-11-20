<ul class="list-unstyled px-3">
    <li class="{{ Request::is('*beranda') ? 'active' : ''}}"><a href="{{ route('beranda.siswa') }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">Transaksi</span>
    <li class="{{ Request::is('*riwayat*') ? 'active' : ''}}"><a href="{{ route('riwayat.siswa') }}"><i class="bi bi-clock-history"></i>Riwayat</a></li>
</ul>
