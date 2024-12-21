<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('index') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('index') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('index') }}"><img class="img-fluid"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <label class="badge badge-light-primary">5</label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg><span class="lan-3">Dashboard</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="lan-4" href="{{ route('index') }}">Default</a></li>
                            <li><a class="lan-5" href="{{ route('dashboard-02') }}">Ecommerce</a></li>
                            <li><a href="{{ route('dashboard-03') }}">Online course</a></li>
                            <li><a href="{{ route('dashboard-04') }}">Crypto</a></li>
                            <li><a href="{{ route('dashboard-05') }}">Social</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                            </svg><span class="lan-6">Widgets</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('general-widget') }}">General</a></li>
                            <li><a href="{{ route('chart-widget') }}">Chart</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-layout') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-layout') }}"></use>
                            </svg><span class="lan-7">Page layout</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('box-layout') }}">Boxed</a></li>
                            <li><a href="{{ route('layout-rtl') }}">RTL</a></li>
                            <li><a href="{{ route('layout-dark') }}">Dark Layout</a></li>
                            <li><a href="{{ route('hide-on-scroll') }}">Hide Nav Scroll</a></li>
                            <li><a href="{{ route('footer-light') }}">Footer Light</a></li>
                            <li><a href="{{ route('footer-dark') }}">Footer Dark</a></li>
                            <li><a href="{{ route('footer-fixed') }}">Footer Fixed</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Applications</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <label class="badge badge-light-secondary">New</label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                            </svg><span>Project </span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('projects')}}">Project List</a></li>
                            <li><a href="{{ route('projectcreate')}}">Create new</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('file-manager')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                            </svg><span>File manager</span></a></li>
                    <li class="sidebar-list">
                        <label class="badge badge-light-danger">Latest </label><a
                            class="sidebar-link sidebar-title link-nav" href="{{ route('kanban')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg><span>kanban Board</span></a>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                            </svg><span>Ecommerce</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('product')}}">Product</a></li>
                            <li><a href="{{ route('product-page')}}">Product page</a></li>
                            <li><a href="{{ route('list-products')}}">Product list</a></li>
                            <li><a href="{{ route('payment-details')}}">Payment Details</a></li>
                            <li><a href="{{ route('order-history')}}">Order History</a></li>
                            <li><a href="{{ route('invoice-template')}}">Invoice</a></li>
                            <li><a href="{{ route('cart')}}">Cart</a></li>
                            <li><a href="{{ route('list-wish')}}">Wishlist</a></li>
                            <li><a href="{{ route('checkout')}}">Checkout</a></li>
                            <li><a href="{{ route('pricing')}}">Pricing </a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg><span>Email</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('email-application')}}">Email App</a></li>
                            <li><a href="{{ route('email-compose')}}">Email Compose</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                            </svg><span>Chat</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('chat')}}">Chat App</a></li>
                            <li><a href="{{ route('chat-video')}}">Video chat</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg><span>Users</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('user-profile')}}">Users Profile</a></li>
                            <li><a href="{{ route('edit-profile')}}">Users Edit</a></li>
                            <li><a href="{{ route('user-cards')}}">Users Cards</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('bookmark')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                            </svg><span>Bookmarks</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('contacts')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-contact') }}"> </use>
                            </svg><span>Contacts</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('task')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"> </use>
                            </svg><span>Tasks</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('calendar-basic')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-calendar') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-calender') }}"></use>
                            </svg><span>Calendar</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('social-app')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-social') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-social') }}"> </use>
                            </svg><span>Social App</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('to-do')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-to-do') }}"> </use>
                            </svg><span>To-Do</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('search')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-search') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-search') }}"> </use>
                            </svg><span>Search Result</span></a></li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Forms & Table</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-form') }}"> </use>
                            </svg><span>Forms</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="submenu-title" href="#">Form Controls<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('form-validation')}}">Form Validation</a></li>
                                    <li><a href="{{ route('base-input')}}">Base Inputs</a></li>
                                    <li><a href="{{ route('radio-checkbox-control')}}">Checkbox & Radio</a></li>
                                    <li><a href="{{ route('input-group')}}">Input Groups</a></li>
                                    <li><a href="{{ route('megaoptions')}}">Mega Options</a></li>
                                </ul>
                            </li>
                            <li><a class="submenu-title" href="#">Form Widgets<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('datepicker')}}">Datepicker</a></li>
                                    <li><a href="{{ route('time-picker')}}">Timepicker</a></li>
                                    <li><a href="{{ route('datetimepicker')}}">Datetimepicker</a></li>
                                    <li><a href="{{ route('daterangepicker')}}">Daterangepicker</a></li>
                                    <li><a href="{{ route('touchspin')}}">Touchspin</a></li>
                                    <li><a href="{{ route('select2')}}">Select2</a></li>
                                    <li><a href="{{ route('switch')}}">Switch</a></li>
                                    <li><a href="{{ route('typeahead')}}">Typeahead</a></li>
                                    <li><a href="{{ route('clipboard')}}">Clipboard</a></li>
                                </ul>
                            </li>
                            <li><a class="submenu-title" href="#">Form layout<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('default-form')}}">Default Forms</a></li>
                                    <li><a href="{{ route('form-wizard')}}">Form Wizard 1</a></li>
                                    <li><a href="{{ route('form-wizard-two')}}">Form Wizard 2</a></li>
                                    <li><a href="{{ route('form-wizard-three')}}">Form Wizard 3</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-table') }}"></use>
                            </svg><span>Tables</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="submenu-title" href="#">Bootstrap Tables<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('bootstrap-basic-table')}}">Basic Tables</a></li>
                                    <li><a href="{{ route('table-components')}}">Table components</a></li>
                                </ul>
                            </li>
                            <li><a class="submenu-title" href="#">Data Tables<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('datatable-basic-init')}}">Basic Init</a></li>
                                    <li><a href="{{ route('datatable-api')}}">API</a></li>
                                    <li><a href="{{ route('datatable-data-source')}}">Data Sources</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('datatable-ext-autofill')}}">Ex. Data Tables</a></li>
                            <li><a href="{{ route('jsgrid-table')}}">Js Grid Table </a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Components</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg><span>Ui Kits</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('typography')}}">Typography</a></li>
                            <li><a href="{{ route('avatars')}}">Avatars</a></li>
                            <li><a href="{{ route('helper-classes')}}">helper classes</a></li>
                            <li><a href="{{ route('grid')}}">Grid</a></li>
                            <li><a href="{{ route('tag-pills')}}">Tag & pills</a></li>
                            <li><a href="{{ route('progress-bar')}}">Progress</a></li>
                            <li><a href="{{ route('modal')}}">Modal</a></li>
                            <li><a href="{{ route('alert')}}">Alert</a></li>
                            <li><a href="{{ route('popover')}}">Popover</a></li>
                            <li><a href="{{ route('tooltip')}}">Tooltip</a></li>
                            <li><a href="{{ route('loader')}}">Spinners</a></li>
                            <li><a href="{{ route('dropdown')}}">Dropdown</a></li>
                            <li><a href="{{ route('accordion')}}">Accordion</a></li>
                            <li><a class="submenu-title" href="#">Tabs<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('tab-bootstrap')}}">Bootstrap Tabs</a></li>
                                    <li><a href="{{ route('tab-material')}}">Line Tabs</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('box-shadow')}}">Shadow</a></li>
                            <li><a href="{{ route('list')}}">Lists</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bonus-kit') }}"></use>
                            </svg><span>Bonus Ui</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('scrollable')}}">Scrollable</a></li>
                            <li><a href="{{ route('tree')}}">Tree view</a></li>
                            <li><a href="{{ route('bootstrap-notify')}}">Bootstrap Notify</a></li>
                            <li><a href="{{ route('rating')}}">Rating</a></li>
                            <li><a href="{{ route('dropzone')}}">dropzone</a></li>
                            <li><a href="{{ route('tour')}}">Tour</a></li>
                            <li><a href="{{ route('sweet-alert2')}}">SweetAlert2</a></li>
                            <li><a href="{{ route('modal-animated')}}">Animated Modal</a></li>
                            <li><a href="{{ route('owl-carousel')}}">Owl Carousel</a></li>
                            <li><a href="{{ route('ribbons')}}">Ribbons</a></li>
                            <li><a href="{{ route('pagination')}}">Pagination</a></li>
                            <li><a href="{{ route('breadcrumb')}}">Breadcrumb</a></li>
                            <li><a href="{{ route('range-slider')}}">Range Slider</a></li>
                            <li><a href="{{ route('image-cropper')}}">Image cropper</a></li>
                            <li><a href="{{ route('sticky')}}">Sticky</a></li>
                            <li><a href="{{ route('basic-card')}}">Basic Card</a></li>
                            <li><a href="{{ route('creative-card')}}">Creative Card</a></li>
                            <li><a href="{{ route('tabbed-card')}}">Tabbed Card</a></li>
                            <li><a href="{{ route('dragable-card')}}">Draggable Card</a></li>
                            <li><a class="submenu-title" href="#">Timeline<span class="sub-arrow"><i
                                            class="fa fa-angle-right"></i></span></a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a href="{{ route('timeline-v-1')}}">Timeline 1</a></li>
                                    <li><a href="{{ route('timeline-v-2')}}">Timeline 2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-builders') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-builders') }}"></use>
                            </svg><span>Builders</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('form-builder-1')}}"> Form Builder 1</a></li>
                            <li><a href="{{ route('form-builder-2')}}"> Form Builder 2</a></li>
                            <li><a href="{{ route('pagebuild')}}">Page Builder</a></li>
                            <li><a href="{{ route('button-builder')}}">Button Builder</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-animation') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-animation') }}"></use>
                            </svg><span>Animation</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('animate')}}">Animate</a></li>
                            <li><a href="{{ route('scroll-reval')}}">Scroll Reveal</a></li>
                            <li><a href="{{ route('aos')}}">AOS animation</a></li>
                            <li><a href="{{ route('tilt')}}">Tilt Animation</a></li>
                            <li><a href="{{ route('wow')}}">Wow Animation</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-icons') }}"></use>
                            </svg><span>Icons</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('flag-icon')}}">Flag icon</a></li>
                            <li><a href="{{ route('font-awesome')}}">Fontawesome Icon</a></li>
                            <li><a href="{{ route('ico-icon')}}">Ico Icon</a></li>
                            <li><a href="{{ route('themify-icon')}}">Themify Icon</a></li>
                            <li><a href="{{ route('feather-icon')}}">Feather icon</a></li>
                            <li><a href="{{ route('whether-icon')}}">Whether Icon</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-button') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-botton') }}"></use>
                            </svg><span>Buttons</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('buttons')}}">Default Style</a></li>
                            <li><a href="{{ route('flat-buttons')}}">Flat Style</a></li>
                            <li><a href="{{ route('buttons-edge')}}">Edge Style</a></li>
                            <li><a href="{{ route('raised-button')}}">Raised Style</a></li>
                            <li><a href="{{ route('button-group')}}">Button Group</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-charts') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-charts') }}"></use>
                            </svg><span>Charts</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('echarts')}}">Echarts</a></li>
                            <li><a href="{{ route('chart-apex')}}">Apex Chart</a></li>
                            <li><a href="{{ route('chart-google')}}">Google Chart</a></li>
                            <li><a href="{{ route('chart-sparkline')}}">Sparkline chart</a></li>
                            <li><a href="{{ route('chart-flot')}}">Flot Chart</a></li>
                            <li><a href="{{ route('chart-knob')}}">Knob Chart</a></li>
                            <li><a href="{{ route('chart-morris')}}">Morris Chart</a></li>
                            <li><a href="{{ route('chartjs')}}">Chatjs Chart</a></li>
                            <li><a href="{{ route('chartist')}}">Chartist Chart</a></li>
                            <li><a href="{{ route('chart-peity')}}">Peity Chart</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Pages</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('landing-page')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-landing-page') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-landing-page') }}"></use>
                            </svg><span>Landing page</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('sample-page')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-sample-page') }}"></use>
                            </svg><span>Sample page</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('internationalization')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-internationalization') }}">
                                </use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-internationalization') }}"></use>
                            </svg><span>Internationalization</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="#" target="_blank">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-starter-kit') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-starter-kit') }}"></use>
                            </svg><span>Starter kit</span></a></li>
                    <li class="mega-menu"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-others') }}"></use>
                            </svg><span>Others</span></a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Error Page</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('error-400')}}">Error 400</a></li>
                                                <li><a href="{{ route('error-401')}}">Error 401</a></li>
                                                <li><a href="{{ route('error-403')}}">Error 403</a></li>
                                                <li><a href="{{ route('error-404')}}">Error 404</a></li>
                                                <li><a href="{{ route('error-500')}}">Error 500</a></li>
                                                <li><a href="{{ route('error-503')}}">Error 503</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5> Authentication</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('login')}}" target="_blank">Login Simple</a></li>
                                                <li><a href="{{ route('login-one')}}" target="_blank">Login with bg image</a>
                                                </li>
                                                <li><a href="{{ route('login-two')}}" target="_blank">Login with image two </a>
                                                </li>
                                                <li><a href="{{ route('login-bs-validation')}}" target="_blank">Login With
                                                        validation</a></li>
                                                <li><a href="{{ route('login-bs-tt-validation')}}" target="_blank">Login with
                                                        tooltip</a></li>
                                                <li><a href="{{ route('login-sa-validation')}}" target="_blank">Login with
                                                        sweetalert</a></li>
                                                <li><a href="{{ route('sign-up')}}" target="_blank">Register Simple</a></li>
                                                <li><a href="{{ route('sign-up-one')}}" target="_blank">Register with Bg Image
                                                    </a></li>
                                                <li><a href="{{ route('sign-up-two')}}" target="_blank">Register with image
                                                        two</a></li>
                                                <li><a href="{{ route('sign-up-wizard')}}" target="_blank">Register wizard</a>
                                                </li>
                                                <li><a href="{{ route('unlock')}}">Unlock User</a></li>
                                                <li><a href="{{ route('forget-password')}}">Forget Password</a></li>
                                                <li><a href="{{ route('reset-password')}}">Reset Password</a></li>
                                                <li><a href="{{ route('maintenance')}}">Maintenance</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Coming Soon</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('comingsoon')}}">Coming Simple</a></li>
                                                <li><a href="{{ route('comingsoon-bg-video')}}">Coming with Bg video</a></li>
                                                <li><a href="{{ route('comingsoon-bg-img')}}">Coming with Bg Image</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Email templates</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('basic-template')}}">Basic Email</a></li>
                                                <li><a href="{{ route('email-header')}}">Basic With Header</a></li>
                                                <li><a href="{{ route('template-email')}}">Ecomerce Template</a></li>
                                                <li><a href="{{ route('template-email-2')}}">Email Template 2</a></li>
                                                <li><a href="{{ route('ecommerce-templates')}}">Ecommerce Email</a></li>
                        <li><a href="{{ route('email-order-success')}}">Order Success</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Miscellaneous</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                            </svg><span>Gallery</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('gallery')}}">Gallery Grid</a></li>
                            <li><a href="{{ route('gallery-with-description')}}">Gallery Grid Desc</a></li>
                            <li><a href="{{ route('gallery-masonry')}}">Masonry Gallery</a></li>
                            <li><a href="{{ route('masonry-gallery-with-disc')}}">Masonry with Desc</a></li>
                            <li><a href="{{ route('gallery-hover')}}">Hover Effects</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-blog') }}"></use>
                            </svg><span>Blog</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('blog')}}">Blog Details</a></li>
                            <li><a href="{{ route('blog-single')}}">Blog Single</a></li>
                            <li><a href="{{ route('add-post')}}">Add Post</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('faq')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-faq') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-faq') }}"></use>
                            </svg><span>FAQ</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-job-search') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-job-search') }}"></use>
                            </svg><span>Job Search</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('job-cards-view')}}">Cards view</a></li>
                            <li><a href="{{ route('job-list-view')}}">List View</a></li>
                            <li><a href="{{ route('job-details')}}">Job Details</a></li>
                            <li><a href="{{ route('job-apply')}}">Apply</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-learning') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-learning') }}"></use>
                            </svg><span>Learning</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('learning-list-view')}}">Learning List</a></li>
                            <li><a href="{{ route('learning-detailed')}}">Detailed Course</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-maps') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-maps') }}"></use>
                            </svg><span>Maps</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('map-js')}}">Maps JS</a></li>
                            <li><a href="{{ route('vector-map')}}">Vector Maps</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-editors') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-editors') }}"></use>
                            </svg><span>Editors</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('summernote')}}">Summer Note</a></li>
                            <li><a href="{{ route('ckeditor')}}">CK editor</a></li>
                            <li><a href="{{ route('simple-mde')}}">MDE editor</a></li>
                            <li><a href="{{ route('ace-code-editor')}}">ACE code editor </a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('knowledgebase')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-knowledgebase') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-knowledgebase') }}"></use>
                            </svg><span>Knowledgebase</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('support-ticket')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-support-tickets') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-support-tickets') }}"></use>
                            </svg><span>Support Ticket</span></a></li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>