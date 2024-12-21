<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper" style="margin: 2px;text-align:center"><a href="{{ route('profile') }}"><img  class="img-fluid for-light"
                    src="{{ asset('assets/assets/img/logo-puskesmas.png') }}" style="height: 80px" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/assets/img/logo-puskesmas.png') }}"style="height: 80px" alt=""></a> 
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('profile') }}"><img class="img-fluid" style="height: 40px"
                    src="{{ asset('assets/assets/img/logo-puskesmas.png') }}" alt=""></a></div>
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
                
                     <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('patient.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                                    <!-- Ikon stroke gedung -->
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                    <!-- Ikon fill gedung -->
                                </svg>
                                <span>Pasien</span>
                            </a>
                        </li>
                     <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('profile') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                    <!-- Ikon stroke gedung -->
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                    <!-- Ikon fill gedung -->
                                </svg>
                                <span>Profile</span>
                            </a>
                        </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg><span>Poli Umum</span></a>
                        <ul class="sidebar-submenu">
                            {{-- <li><a href="{{ route('chart-widget') }}">Users</a></li> --}}
                           
                            <li><a href="{{ route('action.index') }}">Tindakan</a></li>
                            <li><a href="{{ route('report.index') }}">Laporan</a></li>
                     
                        </ul>
                    </li>
                    
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
