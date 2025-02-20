<div class="modal fade" id="modalPasienDokter" tabindex="-1" aria-labelledby="modalPasienDokterLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100">
                    <h5 class="modal-title" id="modalPasienDokterLabel">Cari Pasien</h5>
                    <div class="form-group mt-2">
                        <label for="filterDate" class="form-label">Filter Tanggal</label>
                        <input type="date" id="filterDate" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end m-2">
                    <button id="refreshTable" class="btn btn-primary btn-sm ms-2">Refresh</button>
                </div>
                <table class="table table-striped" id="pasienDokter">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {

        let table; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            // if ($.fn.DataTable.isDataTable('#pasien')) {
            //     $('#pasien').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            // }
            const tipe = $('#tipe').val(); // Ambil route name
            // console.log(tipe);
            const url = `/get-patients-dokter/${tipe}`;
            const filterDate = $('#filterDate').val();
            table = $('#pasienDokter').DataTable({
                ajax: {
                    url: url,
                    type: 'GET',
                    data: function(d) {
                        d.filterDate = filterDate;
                    },


                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data) {
                            if (!data) return '-'; // Jika data kosong, tampilkan tanda "-"

                            // Konversi ke format dd-mm-yyyy hh:mm:ss
                            const dateObj = new Date(data);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2,
                                '0'); // Bulan dimulai dari 0
                            const year = dateObj.getFullYear();
                            const hours = String(dateObj.getHours()).padStart(2, '0');
                            const minutes = String(dateObj.getMinutes()).padStart(2, '0');
                            const seconds = String(dateObj.getSeconds()).padStart(2, '0');

                            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // console.log(data);
                            return `
                        <button class="btn btn-success btnPilihPasien" 
                        data-id-patient="${row.id}" 
                        data-id="${row.action_id ? row.action_id : null}"
                        data-nik="${row.nik}" 
                        data-name="${row.name}" 
                        data-gender="${row.gender}" 
                        data-age="${row.dob}" 
                        data-phone="${row.phone}" 
                        data-address="${row.address}" 
                        data-blood="${row.blood_type}" 
                        data-education="${row.education}" 
                        data-job="${row.occupation}" 
                        data-rm="${row.no_rm}" 
                        data-tanggal="${row.tanggal}" 
                        data-doctor="${row.doctor}" 
                        data-kasus="${row.kasus}" 
                        data-kartu="${row.jenis_kartu}" 
                        data-nomor="${row.nomor_kartu}" 
                        data-wilayahfaskes="${row.wilayah_faskes}" 
                        data-sistol="${row.sistol}" 
                        data-diastol="${row.diastol}" 
                        data-beratbadan="${row.beratBadan}" 
                        data-tinggibadan="${row.tinggiBadan}" 
                        data-lingkarpinggang="${row.lingkarPinggang}" 
                        data-gula="${row.gula}" 
                        data-merokok="${row.merokok}" 
                        data-fisik="${row.fisik}" 
                        data-garam="${row.garam}" 
                        data-gulalebih="${row.gula_lebih}" 
                        data-lemak="${row.lemak}" 
                        data-alkohol="${row.alkohol}" 
                        data-hidup="${row.hidup}" 
                        data-buahsayur="${row.buah_sayur}" 
                        data-hasiliva="${row.hasil_iva}" 
                        data-tindakiva="${row.tindak_iva}" 
                        data-hasilsadanis="${row.hasil_sadanis}" 
                        data-tindaksadanis="${row.tindak_sadanis}" 
                        data-konseling="${row.konseling}" 
                        data-car="${row.car}" 
                        data-rujukubm="${row.rujuk_ubm}" 
                        data-kondisi="${row.kondisi}" 
                        data-edukasi="${row.edukasi}" 
                        data-riwayatpenyakitsekarang='${row.riwayat_penyakit_sekarang}' 
                        data-riwayatpenyakitdulu='${row.riwayat_penyakit_dulu}' 
                        data-riwayatpengobatan='${row.riwayat_pengobatan}' 
                        data-riwayatalergi='${row.riwayat_alergi}' 
                        data-riwayatpenyakitlainnya='${row.riwayat_penyakit_lainnya}' 
                        data-riwayatpenyakitkeluarga='${row.riwayat_penyakit_keluarga}' 
                        data-riwayatpenyakitlainnyakeluarga='${row.riwayat_penyakit_lainnya_keluarga}' 
                        data-keluhan="${row.keluhan}" 
                        data-diagnosa='${JSON.stringify(row.diagnosa)}' 
                        data-tindakan="${row.tindakan}" 
                        data-rujukrs="${row.rujuk_rs}" 
                        data-keterangan="${row.keterangan}" 
                        data-nadi="${row.nadi}" 
                        data-nafas="${row.nafas}" 
                        data-suhu="${row.suhu}" 
                        data-mataanemia="${row.mata_anemia}" 
                        data-pupil="${row.pupil}" 
                        data-ikterus="${row.ikterus}" 
                        data-udempalpebral="${row.udem_palpebral}" 
                        data-nyeritekan="${row.nyeri_tekan}" 
                        data-peristaltik="${row.peristaltik}" 
                        data-ascites="${row.ascites}" 
                        data-lokasiabdomen="${row.lokasi_abdomen}" 
                        data-thorax="${row.thorax}" 
                        data-thoraxbj="${row.thorax_bj}" 
                        data-paru="${row.paru}" 
                        data-suara-nafas="${row.suara_nafas}" 
                        data-ronchi="${row.ronchi}" 
                        data-wheezing="${row.wheezing}" 
                        data-ekstremitas="${row.ekstremitas}" 
                        data-edema="${row.edema}" 
                        data-tonsil="${row.tonsil}" 
                        data-fharing="${row.fharing}" 
                        data-kelenjar="${row.kelenjar}" 
                        data-genetalia="${row.genetalia}" 
                        data-warnakulit="${row.warna_kulit}" 
                        data-turgor="${row.turgor}" 
                        data-neurologis="${row.neurologis}" 
                        data-hasillab="${row.hasil_lab}" 
                        data-pemeriksaanpenunjang="${row.pemeriksaan_penunjang}" 
                        data-hamil="${row.hamil}" 
                        data-tipe="${row.tipe}" 
                        data-icd10="${row.icd10}" 
                        data-oralit="${row.oralit}" 
                        data-zinc="${row.zinc}" data-bs-dismiss="modal" >
                        Pilih
                    </button>

                        `;
                        },
                    },
                ],
                destroy: true, // Mengizinkan inisialisasi ulang
                processing: true,
                serverSide: true,
            });
        }

        $('#filterDate').on('change', function() {
            table.destroy();
            $('#pasienDokter tbody').empty();
            initializeTable();
        });


        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();
            var dob = data.age; // data.dob should be in the format 'YYYY-MM-DD'

            // Function to calculate age from dob
            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime(); // Difference in milliseconds
                var ageDate = new Date(ageDifMs); // Convert ms to date object
                return Math.abs(ageDate.getUTCFullYear() - 1970); // Get the age in years
            }

            // Get the age
            var age = calculateAge(dob);
            const tipe = $('#tipe').val(); // Ambil route name
            // Tampilkan data pasienDokter di elemen luar modal
            $('#displayNIK').text(data.nik);
            $('#displayName').text(data.name);
            $('#displayGender').text(data.gender);
            $('#displayAge').text(age);
            $('#displayPhone').text(data.phone);
            $('#displayAddress').text(data.address);
            $('#displayBlood').text(data.blood);
            $('#displayEducation').text(data.education);
            $('#displayJob').text(data.job);
            $('#displayRmNumber').text(data.rm);
            const actionId = data.id;
            let actionUrl;


            if (tipe == 'tindakan' && actionId) {
                actionUrl = "{{ route('action.update.dokter.tindakan', '__ID__') }}".replace('__ID__',
                    actionId);
            } else {
                actionUrl = actionId ?
                    "{{ route('action.update.dokter', '__ID__') }}".replace('__ID__', actionId) :
                    "{{ route('action.store') }}";
            }


            $('#addPatientForm').attr('action', actionUrl);
            // Set nilai ID ke input form
            $('#action_id').val(data.id);
            $('#nik').val(data.nik);
            $('#idAction').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#doctor').val(data.doctor);
            $('#nomor_kartu').val(data.nomor);
            let jenisKartu = data.kartu;
            if (jenisKartu === 'pbi') {
                jenisKartu = 'PBI (KIS)';
            } else if (jenisKartu === 'askes') {
                jenisKartu = 'AKSES'
            } else if (jenisKartu === 'jkn_mandiri') {
                jenisKartu = 'JKN Mandiri'
            } else if (jenisKartu === 'umum') {
                jenisKartu = 'Umum'
            } else {
                jenisKartu = 'JKD'
            }
            $('#jenis_kartu').val(jenisKartu);


            $('#kasus').val(data.kasus);
            if (data.wilayahfaskes === 1) {
                $('#wilayah_faskes').val(
                    'Ya');
            } else {
                $('#wilayah_faskes').val('Luar Wilayah');
            }

            $('#sistol').val(data.sistol);
            $('#diastol').val(data.diastol);
            $('#berat_badan').val(data.beratbadan);
            $('#tinggi_badan').val(data.tinggibadan);
            $('#ling_pinggang').val(data.lingkarpinggang);
            $('#gula').val(data.gula);
            $('#nadi').val(data.nadi);
            $('#nafas').val(data.nafas);
            $('#suhu').val(data.suhu);
            $('#merokok').val(data.merokok);
            $('#aktivitas_fisik').val(data.fisik);
            $('#gula_lebih').val(data.gulalebih);
            $('#garam').val(data.garam);
            $('#buah_sayur').val(data.buahsayur);
            $('#alkohol').val(data.alkohol);
            $('#kondisi_hidup').val(data.hidup);
            $('#hasil_iva').val(data.hasiliva);
            $('#tindak_iva').val(data.tindak_iva);
            $('#hasil_sadanis').val(data.hasilsadanis);
            $('#tindak_sadanis').val(data.tindaksadanis);
            $('#konseling').val(data.konseling);
            $('#car').val(data.car);
            $('#rujuk_ubm').val(data.rujukubm);
            $('#kondisi').val(data.kondisi);
            $('#edukasi').val(data.edukasi);
            $('#mata_anemia').val(data.mataanemia);
            $('#ikterus').val(data.ikterus);
            $('#udem_palpebral').val(data.udempalpebral);
            $('#nyeri_tekan').val(data.nyeritekan);
            $('#peristaltik').val(data.peristaltik);
            $('#lokasi_abdomen').val(data.lokasiabdomen);
            $('#thorax_bj').val(data.thoraxbj);
            $('#paru').val(data.paru);
            $('#suara_nafas').val(data.suaranafas);
            $('#ronchi').val(data.ronchi);
            $('#wheezing').val(data.wheezing);
            $('#ekstremitas').val(data.ekstremitas);
            $('#edema').val(data.edema);
            $('#tonsil').val(data.tonsil);
            $('#fharing').val(data.fharing);
            $('#kelenjar').val(data.kelenjar);
            $('#genetalia').val(data.genetalia);
            $('#warna_kulit').val(data.warnakulit);
            $('#turgor').val(data.turgor);
            $('#neurologis').val(data.neurologis);
            $('#hasil_lab').val(data.hasillab);
            // Set nilai dari riwayat_penyakit_sekarang dan trigger 'change'
            $('#riwayat_penyakit_sekarang').val(data.riwayatpenyakitsekarang).trigger('change');

            // Cek apakah nilai dari riwayat_penyakit_sekarang tidak kosong
            if (data.riwayatpenyakitlainnya) {
                $('#penyakit_lainnya_container').css('display', 'block'); // Tampilkan div
            } else {
                $('#penyakit_lainnya_container').css('display', 'none'); // Sembunyikan div
            }

            $('#riwayat_penyakit_dulu').val(data.riwayatpenyakitdulu).trigger('change');
            $('#riwayat_penyakit_lainnya').val(data.riwayatpenyakitlainnya);
            $('#riwayat_penyakit_keluarga').val(data.riwayatpenyakitkeluarga).trigger('change');
            // Atur nilai untuk riwayat_penyakit_lainnya_keluarga
            $('#riwayat_penyakit_lainnya_keluarga').val(data.riwayatpenyakitlainnyakeluarga);

            // Cek apakah nilai riwayat_penyakit_lainnya_keluarga tidak kosong
            if (data.riwayatpenyakitlainnyakeluarga) {
                $('#penyakit_lainnya_keluarga_container').css('display',
                    'block'); // Tampilkan container
            } else {
                $('#penyakit_lainnya_keluarga_container').css('display',
                    'none'); // Sembunyikan container
            }

            $('#pemeriksaan_penunjang').val(data.pemeriksaanpenunjang || '').trigger('change');
            $('#keluhan').val(data.keluhan);
            var diagnosaArray = JSON.parse(data.diagnosa); // Parse the diagnosa data

            // Clear previous selections before setting new ones
            // Ensure that there's data in diagnosaArray before proceeding
            if (diagnosaArray && diagnosaArray.length > 0) {
                // Clear previous selections
                $('#diagnosaEdit').val([]).trigger('change');

                // Ensure the select element has the 'multiple' attribute for multi-selection
                $('#diagnosaEdit').attr('multiple', 'multiple');

                // Manually mark options as selected based on diagnosaArray
                $('#diagnosaEdit option').each(function() {
                    if (diagnosaArray.includes(parseInt($(this).val()))) {
                        $(this).prop('selected', true); // Mark the option as selected
                    }
                });

                // Trigger a change event to update the select input UI
                $('#diagnosaEdit').trigger('change');
            } else {
                // If diagnosaArray is empty or undefined, handle it accordingly
                $('#diagnosaEdit').val([]).trigger('change'); // Clear any selections (optional)
            }

            // Trigger the change event to update Select2 after manually selecting options
            $('#diagnosaEdit').trigger('change'); // This should update Select2 if it's used

            // Reinitialize Select2 if necessary to ensure the selected options are displayed

            $('#diagnosaEdit').select2();
            $('#icd10').val(data.icd10);
            $('#tindakan').val(data.tindakan).trigger('change');
            $('#rujuk_rs').val(data.rujukrs);
            $('#keterangan').val(data.keterangan);
            $('#riwayat_pengobatan').val(data.riwayatpengobatan);
            $('#riwayat_alergi').val(data.riwayatalergi);


            $('#patientDetails').show();
            const patientId = $(this).data('id-patient');
            $('#btnCariskrining').data('id', patientId);


            // Tutup modal
            $('#modalPasienDokter').modal('hide');

        });
        // table.ajax.reload(null, false);

        initializeTable();

        $('#modalPasienDokter').on('shown.bs.modal', function() {


            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });
        $('#addPatientForm').submit(async function(e) {
            e.preventDefault();
            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let actionId = $('#action_id').val() ?? null;
            let url = actionId ? `/tindakan-dokter/${actionId}` : '/tindakan';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    // Menampilkan notifikasi sukses
                    await Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil diproses!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Sembunyikan detail pasien & reset form
                    $('#patientDetails').hide();
                    $('#displayNIK, #displayName, #displayAge, #displayPhone, #displayAddress, #displayBlood, #displayRmNumber, #diagnosa')
                        .text('');
                    $('#addPatientForm')[0].reset();

                    // Reload DataTable dan tunggu sampai selesai
                    await new Promise((resolve) => {
                        table.ajax.reload(resolve, false);
                        const section1 = document.getElementById(
                            'formSection1');
                        const section2 = document.getElementById(
                            'formSection2');
                        const button = this;

                        // Kembali ke Section 1
                        section1.classList.remove('d-none');
                        section2.classList.add('d-none');
                        button.textContent = 'Lanjut Pemeriksaan';

                    });

                    // Perbarui daftar diagnosa
                    await updateDiagnosaList();

                    // Tunggu hingga data pasien benar-benar diperbarui sebelum menampilkan modal
                    await refreshPatientData();

                    // Cek apakah ada data dalam tabel sebelum menampilkan modal
                    setTimeout(() => {
                        if ($('#patientTableBody tr').length > 0) {
                            // Tampilkan modal hanya setelah data pasien berhasil diperbarui
                            $('#modalPasienDokter').modal('show');
                        } else {
                            // console.warn("Data pasien belum ter-refresh.");
                        }
                    }, 500); // Delay 500ms untuk memastikan data sudah ter-load
                },
                error: function(xhr) {
                    console.error(xhr);
                    let errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                    Swal.fire({
                        title: 'Error!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

    });



    // Ubah function refreshPatientData agar mengembalikan Promise
    function refreshPatientData() {
        return new Promise((resolve, reject) => {
            const tipe = $('#tipe').val();
            $.ajax({
                url: `/get-patient-dokter/${tipe}`,
                type: 'GET',
                success: function(response) {
                    $('#patientTableBody').html('');

                    // Cek apakah ada pasien
                    if (response.patients && response.patients.length > 0) {
                        response.patients.forEach(patient => {
                            $('#patientTableBody').append(`
                            <tr>
                                <td>${patient.nik}</td>
                                <td>${patient.name}</td>
                                <td>${patient.age}</td>
                                <td>${patient.phone}</td>
                                <td>
                                    <button class="btn btn-primary pilih-pasien" data-id="${patient.id}">Pilih</button>
                                </td>
                            </tr>
                        `);
                        });
                        resolve(); // Selesai, lanjut ke modal
                    } else {
                        console.warn("Tidak ada pasien ditemukan.");
                        reject(); // Jika gagal, modal tidak akan muncul
                    }
                },
                error: function() {
                    console.error('Gagal memuat data pasien.');
                    reject(); // Jika gagal, modal tidak akan muncul
                }
            });
        });
    }

    // Perbarui daftar diagnosa
    function updateDiagnosaList() {
        $.ajax({
            url: '/get-diagnosa',
            type: 'GET',
            success: function(response) {
                if (response.diagnosa && response.diagnosa.length > 0) {
                    let diagnosaOptions = response.diagnosa.map(item =>
                        `<option value="${item.id}">${item.name} - ${item.icd10}</option>`
                    ).join('');
                    $('#diagnosa').html(diagnosaOptions);
                } else {
                    $('#diagnosa').html('<option value="">Tidak ada diagnosa tersedia</option>');
                }
            },
            error: function() {
                $('#diagnosa').html('<option value="">Gagal memuat diagnosa</option>');
            }
        });
    }
</script>
{{-- <script>
    $(document).ready(function() {
        $('#addPatientForm').submit(async function(e) {
            e.preventDefault();
            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let actionId = $('#action_id').val() ?? null;

            // Tentukan URL berdasarkan ada tidaknya actionId
            let url = actionId ? `/tindakan-dokter/${actionId}` : '/tindakan';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    // Notifikasi sukses
                    Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil diproses!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Sembunyikan detail pasien & reset form
                    $('#patientDetails').hide();
                    $('#displayNIK, #displayName, #displayAge, #displayPhone, #displayAddress, #displayBlood, #displayRmNumber, #diagnosa')
                        .text('');
                    $('#addPatientForm')[0].reset();
                    table.ajax.reload(null, false);
                    // Perbarui daftar diagnosa
                    updateDiagnosaList();

                    // Tunggu hingga data pasien benar-benar diperbarui sebelum menampilkan modal
                    await refreshPatientData();
                    // Pastikan data sudah dimuat sebelum menampilkan modal
                    if ($('#patientTableBody tr').length > 0) {
                        $('#modalPasienDokter').modal('show');
                    } else {
                        console.warn("Data pasien belum ter-refresh.");
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    let errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
                    Swal.fire({
                        title: 'Error!',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });

    // Ubah function refreshPatientData agar mengembalikan Promise
    function refreshPatientData() {
        return new Promise((resolve, reject) => {
            const tipe = $('#tipe').val();
            $.ajax({
                url: `/get-patient-dokter/${tipe}`,
                type: 'GET',
                success: function(response) {
                    $('#patientTableBody').html('');

                    // Cek apakah ada pasien
                    if (response.patients && response.patients.length > 0) {
                        response.patients.forEach(patient => {
                            $('#patientTableBody').append(`
                            <tr>
                                <td>${patient.nik}</td>
                                <td>${patient.name}</td>
                                <td>${patient.age}</td>
                                <td>${patient.phone}</td>
                                <td>
                                    <button class="btn btn-primary pilih-pasien" data-id="${patient.id}">Pilih</button>
                                </td>
                            </tr>
                        `);
                        });
                        resolve(); // Selesai, lanjut ke modal
                    } else {
                        console.warn("Tidak ada pasien ditemukan.");
                        reject(); // Jika gagal, modal tidak akan muncul
                    }
                },
                error: function() {
                    console.error('Gagal memuat data pasien.');
                    reject(); // Jika gagal, modal tidak akan muncul
                }
            });
        });
    }

    // Perbarui daftar diagnosa
    function updateDiagnosaList() {
        $.ajax({
            url: '/get-diagnosa',
            type: 'GET',
            success: function(response) {
                if (response.diagnosa && response.diagnosa.length > 0) {
                    let diagnosaOptions = response.diagnosa.map(item =>
                        `<option value="${item.id}">${item.name} - ${item.icd10}</option>`
                    ).join('');
                    $('#diagnosa').html(diagnosaOptions);
                } else {
                    $('#diagnosa').html('<option value="">Tidak ada diagnosa tersedia</option>');
                }
            },
            error: function() {
                $('#diagnosa').html('<option value="">Gagal memuat diagnosa</option>');
            }
        });
    }
</script> --}}
