<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper" style="margin: 2px;text-align:center"><a href="{{ route('profile') }}"><img
                    class="img-fluid for-light" src="{{ asset('assets/assets/img/logo-app1.png') }}" style="height: 80px"
                    alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/assets/img/logo-app1.png') }}"style="height: 80px" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('profile') }}"><img class="img-fluid" style="height: 40px"
                    src="{{ asset('assets/assets/img/logo-app1.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('profile') }}"><img class="img-fluid"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    @if (Auth::user()->role == 'admin')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                                href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Dashboard</span></a>

                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('dashboard.patient') }}">Pasien</a></li>
                                <li><a href="{{ route('dashboard.kunjungan') }}">Kunjungan</a></li>

                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'admin-loket')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('patient.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>Pasien</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('kunjungan.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>Kunjungan</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'admin-skrining')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                                href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                                </svg><span>Skrining</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('skrining.index') }}">Skrining Ilp</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('profile') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                            </svg>
                            <span>Profile</span>
                        </a>
                    </li>
                    @if(Auth::user()->role == 'admin-referensi')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Referensi</span></a>

                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('reference.doctor') }}">Dokter</a></li>
                                <li><a href="{{ route('reference.poli') }}">Poli</a></li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'apotik')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('terima-obat') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <span>Penerimaan Obat</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('pengeluaran-obat') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <span class="sidebar-text nowrap">Pengeluaran Obat</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('stok-obat') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <span class="sidebar-text nowrap">Stok Obat</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('obat-master-data') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <span>Master Data Obat</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'dokter' ||
                            Auth::user()->role == 'admin-kajian-awal' ||
                            Auth::user()->role == 'apotik' ||
                            Auth::user()->role == 'lab')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                    @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'admin-kajian-awal')
                                </svg><span>Poli Umum</span></a>
                        @else
                            </svg><span>Poli</span></a>
                    @endif

                    <ul class="sidebar-submenu">
                        @if (Auth::user()->role == 'dokter')
                            <li><a href="{{ route('action.dokter.index') }}">Tindakan</a></li>
                            <li><a href="{{ route('report.index') }}">Laporan</a></li>
                        @elseif(Auth::user()->role == 'admin-kajian-awal')
                            <li><a href="{{ route('action.index') }}">Kajian Awal</a></li>
                            <li><a href="{{ route('report.index') }}">Laporan</a></li>
                        @elseif(Auth::user()->role == 'apotik')
                            <li><a href="{{ route('action.apotik.index') }}">Tindakan</a></li>
                            <li><a href="{{ route('report.index') }}">Laporan</a></li>
                        @else
                            <li><a href="{{ route('action.lab.index') }}">Tindakan</a></li>
                            <li><a href="{{ route('report.index') }}">Laporan</a></li>
                        @endif
                    </ul>
                    </li>
                    @endif
                    @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'admin-kajian-awal')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Poli Gigi</span></a>

                            <ul class="sidebar-submenu">
                                @if (Auth::user()->role == 'dokter')
                                    <li><a href="{{ route('action.dokter.gigi.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @elseif(Auth::user()->role == 'admin-kajian-awal')
                                    <li><a href="{{ route('action.index.gigi') }}">Kajian Awal</a></li>
                                    <li><a href="{{ route('report.index.gigi') }}">Laporan</a></li>
                                @else
                                    <li><a href="{{ route('action.lab.gigi.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'tindakan')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>UGD</span></a>

                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('action.dokter.ugd.index') }}">Tindakan</a></li>
                                <li><a href="{{ route('report.index') }}">Laporan</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Ruang Tindakan</span></a>

                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('action.dokter.ruang.tindakan.index') }}">Tindakan</a></li>
                                <li><a href="{{ route('report.index') }}">Laporan</a></li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'admin-kajian-awal')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Poli KIA</span></a>

                            <ul class="sidebar-submenu">
                                @if (Auth::user()->role == 'dokter')
                                    <li><a href="{{ route('action.kia.dokter.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @elseif(Auth::user()->role == 'admin-kajian-awal')
                                    <li><a href="{{ route('action.kia.index') }}">Kajian Awal</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @else
                                    <li><a href="{{ route('action.lab.kia.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'admin-kajian-awal')
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>

                                </svg><span>Poli KB</span></a>

                            <ul class="sidebar-submenu">
                                @if (Auth::user()->role == 'dokter')
                                    <li><a href="{{ route('action.kb.dokter.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @elseif(Auth::user()->role == 'admin-kajian-awal')
                                    <li><a href="{{ route('action.kb.index') }}">Kajian Awal</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @else
                                    <li><a href="{{ route('action.lab.kb.index') }}">Tindakan</a></li>
                                    <li><a href="{{ route('report.index') }}">Laporan</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg><span>KIA</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('layakHamil.admin') }}">Layak Hamil</a></li>
                            <li><a href="{{ route('hipertensi.admin') }}">Hipertensi</a></li>
                            <li><a href="{{ route('gangguan.autis.admin') }}">Gangguan Autis</a></li>
                            <li><a href="{{ route('anemia.admin') }}">Anemia</a></li>
                            <li><a href="{{ route('hiv.admin') }}">HIV & IMS</a></li>
                            <li><a href="{{ route('hepatitis.admin') }}">Hepatitis</a></li>
                            <li><a href="{{ route('talasemia.admin') }}">Talasemia</a></li>
                            <li><a href="{{ route('kecacingan.admin') }}">Kecacingan</a></li>
                            <li><a href="{{ route('diabetes.mellitus.admin') }}">Diabetes Mellitus</a></li>
                            <li><a href="{{ route('tbc.admin') }}">TBC</a></li>
                            <li><a href="{{ route('triple.eliminasi.admin') }}">Triple Eliminasi Bumil</a></li>
                            <li><a href="{{ route('kekerasan.anak.admin') }}">Kekerasan Terhadap Anak</a></li>
                            <li><a href="{{ route('kekerasan.perempuan.admin') }}">Kekerasan Terhadap
                                    Perempuan</a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg><span>MTBS</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('testPendengaran.mtbs.admin') }}">Tes Daya Dengar</a></li>
                            <li><a href="{{ route('merokok.mtbs.admin') }}"> Merokok Bagi Anak Usia Sekolah</a>
                            </li>
                            <li><a href="{{ route('sdq.mtbs.admin') }}">Keswa SDQ</a></li>
                            <li><a href="{{ route('sdq.remaja.mtbs.admin') }}">Keswa SDQ Remaja</a></li>
                            <li><a href="{{ route('napza.mtbs.admin') }}">Napza</a></li>
                            <li><a href="{{ route('obesitas.mtbs.admin') }}">Obesitas</a></li>
                            <li><a href="{{ route('kecacingan.admin.mtbs') }}">Kecacingan</a></li>
                            <li><a href="{{ route('diabetes.mellitus.admin.mtbs') }}">Diabetes Mellitus</a></li>
                            <li><a href="{{ route('tbc.admin.mtbs') }}">TBC</a></li>
                            <li><a href="{{ route('kekerasan.anak.admin.mtbs') }}">Kekerasan Terhadap Anak</a>
                            </li>
                            <li><a href="{{ route('kekerasan.perempuan.admin.mtbs') }}">Kekerasan Terhadap
                                    Perempuan</a></li>
                            <li><a href="{{ route('talasemia.admin.mtbs') }}"> Talasemia</a></li>
                            <li><a href="{{ route('anemia.admin.mtbs') }}">Anemia</a></li>
                            <li><a href="{{ route('hipertensi.admin.mtbs') }}">Hipertensi</a></li>

                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg><span>Lansia</span></a>
                        <ul class="sidebar-submenu">

                            <li><a href="{{ route('puma.lansia.admin') }}">Puma</a></li>
                            <li><a href="{{ route('geriatri.lansia.admin') }}">Geriatri</a></li>
                            <li><a href="{{ route('kankerParu.lansia.admin') }}">Kanker Paru</a></li>
                            <li><a href="{{ route('kankerPayudara.lansia.admin') }}">Kanker Payudara</a></li>
                            <li><a href="{{ route('kankerKolorektal.lansia.admin') }}">Kanker Kolorektal</a></li>
                            <li><a href="{{ route('layakHamil.admin.lansia') }}">Layak Hamil</a></li>
                            <li><a href="{{ route('hipertensi.admin.lansia') }}">Hipertensi</a></li>
                            <li><a href="{{ route('tbc.admin.lansia') }}">TBC</a></li>
                            <li><a href="{{ route('talasemia.admin.lansia') }}"> Talasemia</a></li>
                            <li><a href="{{ route('anemia.admin.lansia') }}">Anemia</a></li>

                        </ul>
                    </li> --}}

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
