<ul class="list-unstyled px-3">
    <li class="{{ Request::is('admin/beranda') ? 'active' : ''}}"><a href="{{ route('beranda.admin') }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">data master</span>
    <li class="{{ Request::is('admin/petugas') ? 'active' : ''}}"><a href="/admin/petugas"><i class="bi bi-person"></i>Petugas</a></li>
    <li><a href="#"><i class="bi bi-door-open"></i>Kelas</a></li>
    <li><a href="#"><i class="bi bi-cash-stack"></i>Spp</a></li>
    <li><a href="#"><i class="bi bi-people"></i>Siswa</a></li>

    <span class="section-title text-capitalize small text-muted mb-1 mt-2">Transaksi</span>
    <li><a href="#"><i class="bi bi-receipt-cutoff"></i>Pembayaran</a></li>
    <li><a href="#"><i class="bi bi-clock-history"></i>Riwayat</a></li>
    <li><a href="#"><i class="bi bi-printer"></i>Laporan</a></li>
</ul>
