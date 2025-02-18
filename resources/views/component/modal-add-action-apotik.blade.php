<!-- Modal Add Action -->
<div class="modal fade" style="z-index: 1050;" id="addActionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary">
         
                    <h5 class="modal-title" id="exampleModalLabel">TINDAKAN POLI APOTIK</h5>
   
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-apotikel="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addPatientForm" action="" method="POST" class="px-3">
                    @csrf
                    @if ($routeName === 'action.apotik.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-umum">
                    @elseif($routeName === 'action.apotik.gigi.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-gigi">
                    @elseif($routeName === 'action.apotik.kia.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kia">
                    @elseif($routeName === 'action.apotik.kb.index')
                        <input type="hidden" name="tipe" id="tipe" value="poli-kb">
                    @else
                        <input type="hidden" name="tipe" id="tipe" value="ruang-tindakan">
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <h5>Detail Pasien</h5>
                            <div id="patientDetails"
                                style="display:none; margin-top: 10px; padding: 10px; border-radius: 5px;">
                                <p><strong>N I K</strong> : <span id="displayNIK"></span></p>
                                <p><strong>Nama Pasien</strong> : <span id="displayName"></span></p>
                                <p><strong>Umur</strong> : <span id="displayAge"></span></p>
                                <p><strong>Telepon/WA</strong> : <span id="displayPhone"></span></p>
                                <p><strong>Alamat</strong> : <span id="displayAddress"></span></p>
                                <p><strong>Darah</strong> : <span id="displayBlood"></span></p>
                                <p><strong>Nomor RM</strong> : <span id="displayRmNumber"></span></p>
                            </div>
                        </div>
                        <div class="row col-8">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nik">Cari Pasien</label>
                                            <div class="input-group">
                                                <input type="text" hidden id="idAction" name="idAction"
                                                    value="">
                                                <input readonly type="text" class="form-control" id="nik"
                                                    name="nik" placeholder="NIK" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnCariNIK"
                                                        data-bs-toggle="modal" data-bs-target="#modalPasienApotik">
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                placeholder="Pilih Tanggal" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor">Dokter</label>
                                            <select class="form-control" id="doctor" name="doctor" disabled>
                                                <option value="" disabled selected>Pilih Dokter</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <label for="obat" style="color: rgb(19, 11, 241);">Obat</label>
                            <textarea class="form-control" id="obat" name="obat" readonly placeholder="Obat"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="update_obat" style="color: rgb(19, 11, 241);">Update Obat</label>
                            <textarea class="form-control" id="update_obat" name="update_obat" placeholder="Update Obat"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>

</div>


@include('component.modal-table-pasien-apotik')





<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Display success message if session has a success
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message if validation errors exist
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                html: '<ul>' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
