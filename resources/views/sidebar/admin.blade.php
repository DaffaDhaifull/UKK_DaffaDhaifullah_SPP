<ul class="list-unstyled px-3">
    <li class="{{ Request::is('admin/beranda') ? 'active' : ''}}"><a href="{{ route('beranda.admin') }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">data master</span>
    <li class="{{ Request::is('*petugas') ? 'active' : ''}}"><a href="{{ route('petugas.index') }}"><i class="bi bi-person"></i>Petugas</a></li>
    <li class="{{ Request::is('*kelas') ? 'active' : ''}}"><a href="{{ route('kelas.index') }}"><i class="bi bi-door-open"></i>Kelas</a></li>
    <li class="{{ Request::is('*spp') ? 'active' : ''}}"><a href="{{ route('spp.index') }}"><i class="bi bi-cash-stack"></i>Spp</a></li>
    <li class="{{ Request::is('*siswa') ? 'active' : ''}}"><a href="{{ route('siswa.index') }}"><i class="bi bi-people"></i>Siswa</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">Transaksi</span>
    <li class="{{ Request::is('*pembayaran*') ? 'active' : ''}}"><a href="{{ route('pembayaran.index') }}"><i class="bi bi-receipt-cutoff"></i>Pembayaran</a></li>
    <li class="{{ Request::is('*riwayat*') ? 'active' : ''}}"><a href="{{ route('riwayat.index') }}"><i class="bi bi-clock-history"></i>Riwayat</a></li>
    <li><a href="#"><i class="bi bi-printer"></i>Laporan</a></li>
</ul>
