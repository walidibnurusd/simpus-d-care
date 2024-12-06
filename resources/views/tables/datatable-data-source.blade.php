@extends('layouts.simple.master')
@section('title', 'DATA Source DataTables')

@section('css')
    
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>DATA Source DataTables</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">DATA Source DataTables</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- HTML (DOM) sourced data  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">HTML (DOM) sourced data</h3><span>The foundation for DataTables is progressive
                            enhancement, so it is very adept at reading table information directly from the DOM. This
                            example shows how easy it is to add searching, ordering and paging to your HTML table by simply
                            running DataTables on it.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Salary</th>
                                        <th>Office</th>
                                        <th>CV</th>
                                        <th>Status</th>
                                        <th>E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>$320,800</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="sample.pdf') }}" target="_blank"><i
                                                    class="icofont icofont-file-pdf"></i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>t.nixon@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>$170,750</td>
                                        <td>Tokyo</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>g.winters@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>$86,000</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>a.cox@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>$433,060</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>c.kelly@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>$162,700</td>
                                        <td>Tokyo</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>a.satou@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>$372,000</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>b.williamson@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Herrod Chandler</td>
                                        <td>Sales Assistant</td>
                                        <td>$137,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>h.chandler@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rhona Davidson</td>
                                        <td>Integration Specialist</td>
                                        <td>$327,900</td>
                                        <td>Tokyo</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>r.davidson@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Colleen Hurst</td>
                                        <td>Javascript Developer</td>
                                        <td>$205,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>c.hurst@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sonya Frost</td>
                                        <td>Software Engineer</td>
                                        <td>$103,600</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>s.frost@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jena Gaines</td>
                                        <td>Office Manager</td>
                                        <td>$90,560</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>j.gaines@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quinn Flynn</td>
                                        <td>Support Lead</td>
                                        <td>$342,000</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>q.flynn@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Charde Marshall</td>
                                        <td>Regional Director</td>
                                        <td>$470,600</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>c.marshall@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Haley Kennedy</td>
                                        <td>Senior Marketing Designer</td>
                                        <td>$313,500</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>h.kennedy@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Regional Director</td>
                                        <td>$385,750</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>t.fitzpatrick@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Silva</td>
                                        <td>Marketing Designer</td>
                                        <td>$198,500</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>m.silva@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td>Chief Financial Officer (CFO)</td>
                                        <td>$725,000</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>p.byrd@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gloria Little</td>
                                        <td>Systems Administrator</td>
                                        <td>$237,500</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>g.little@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bradley Greer</td>
                                        <td>Software Engineer</td>
                                        <td>$132,000</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>b.greer@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dai Rios</td>
                                        <td>Personnel Lead</td>
                                        <td>$217,500</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>d.rios@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenette Caldwell</td>
                                        <td>Development Lead</td>
                                        <td>$345,000</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>j.caldwell@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Yuri Berry</td>
                                        <td>Chief Marketing Officer (CMO)</td>
                                        <td>$675,000</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>y.berry@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Vance</td>
                                        <td>Pre-Sales Support</td>
                                        <td>$106,450</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>c.vance@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Doris Wilder</td>
                                        <td>Sales Assistant</td>
                                        <td>$85,600</td>
                                        <td>Sidney</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>d.wilder@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Angelica Ramos</td>
                                        <td>Chief Executive Officer (CEO)</td>
                                        <td>$1,200,000</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>a.ramos@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Joyce</td>
                                        <td>Developer</td>
                                        <td>$92,575</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>g.joyce@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>$357,650</td>
                                        <td>Singapore</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>j.chang@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>$206,850</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>b.wagner@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>$850,000</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>f.green@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>$163,000</td>
                                        <td>Tokyo</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>s.itou@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>$95,400</td>
                                        <td>Sidney</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>m.house@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>$114,500</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>s.burks@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>$145,000</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>p.bartlett@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>$235,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>g.cortez@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>$324,050</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>m.mccray@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>$85,675</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>u.butler@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>$164,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>h.hatfield@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>$109,850</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>h.fuentes@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>$452,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>v.harrell@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>$136,200</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>t.mooney@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>$645,750</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>j.bradshaw@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>$234,500</td>
                                        <td>Singapore</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>o.liang@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>$163,500</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>b.nash@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>$139,575</td>
                                        <td>Tokyo</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>s.yamamoto@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>$98,540</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>t.walton@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>$87,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>f.camacho@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>$138,575</td>
                                        <td>Singapore</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>s.baldwin@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>$125,250</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>z.frank@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>$115,000</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>z.serrano@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>$75,650</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>j.acosta@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>$145,600</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>c.stevens@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>$356,250</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>h.butler@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>$103,500</td>
                                        <td>London</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-danger">Pending</span></td>
                                        <td>l.greer@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>$86,500</td>
                                        <td>San Francisco</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-warning"> in process</span></td>
                                        <td>j.alexander@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>$183,000</td>
                                        <td>Edinburgh</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>s.decker@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>$183,000</td>
                                        <td>Singapore</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>m.bruce@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>$112,000</td>
                                        <td>New York</td>
                                        <td class="action"> <a class="pdf" href="{{ asset('assets/pdf/sample.pdf') }}"
                                                target="_blank"><i class="icofont icofont-file-pdf"> </i></a></td>
                                        <td> <span class="badge rounded-pill badge-success">hired</span></td>
                                        <td>d.snider@datatables.net</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a>
                                                </li>
                                                <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Salary</th>
                                        <th>Office</th>
                                        <th>CV</th>
                                        <th>Status</th>
                                        <th>E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HTML (DOM) sourced data  Ends-->
            <!-- Ajax sourced data  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Ajax sourced data</h3><span>DataTables has the ability to read data from
                            virtually any JSON data source that can be obtained by Ajax. This can be done, in its most
                            simple form, by setting the <code>ajax:option</code> option to the address of the JSON data
                            source.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Extn.</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ajax sourced data Ends-->
            <!-- Javascript sourced data  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Javascript sourced data</h3><span>
                            At times you will wish to be able to create a table from dynamic information passed directly to
                            DataTables, rather than having it read from the document.
                            This is achieved using the <code class="option"
                                title="DataTables initialisation option">data</code> option in the initialisation object,
                            passing in an array of data to be used (like all other DataTables handled data, this can be
                            arrays or objects using the<code class="option"
                                title="DataTables initialisation option">columns.data</code> option).</span><span>A <code
                                class="tag" title="HTML tag">table</code> must be available on the page for DataTables
                            to use. This examples shows an empty <code class="tag" title="HTML tag">table</code>
                            element being initialising as a DataTable with a set of data from a Javascript array. The
                            columns in the table are dynamically created
                            based on the <code class="option"
                                title="DataTables initialisation option">columns.title</code> configuration option.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display w-100" id="data-source-3"></table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Javascript sourced data Ends-->
            <!-- Server-side processing Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3 class="mb-3">Server-side processing</h3><span>There are many ways to get your data into
                            DataTables, and if you are working with seriously large databases, you might want to consider
                            using the server-side options that DataTables provides. With server-side processing enabled, all
                            paging, searching, ordering actions that DataTables performs are handed off to a server where an
                            SQL engine (or similar) can perform these actions on the large data set (after all, that's what
                            the database engine is designed for!). As such, each draw of the table will result in a new Ajax
                            request being made to get the required data.</span><span>Server-side processing is enabled by
                            setting the <code class="option"
                                title="DataTables initialisation option">serverSide:option</code> option to
                            <code>true</code> and providing an Ajax data source through the <code class="option"
                                title="DataTables initialisation option">ajax:option</code> option.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-4" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection
