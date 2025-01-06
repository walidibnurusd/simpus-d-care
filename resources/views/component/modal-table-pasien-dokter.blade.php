<div class="modal fade" id="modalPasien" tabindex="-1" aria-labelledby="modalPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienLabel">Cari Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="pasienDokter">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
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



<script>
    $(document).ready(function() {

        let table; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            // if ($.fn.DataTable.isDataTable('#pasien')) {
            //     $('#pasien').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            // }

            table = $('#pasienDokter').DataTable({
                ajax: {
                    url: '/get-patients-dokter', // Endpoint untuk mengambil data
                    type: 'GET',

                },
                columns: [{
                        data: 'patient.nik',
                        name: 'nik'
                    },
                    {
                        data: 'patient.name',
                        name: 'name'
                    },
                    {
                        data: 'patient.address',
                        name: 'address'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-success btnPilihPasien" 
    data-id-patient="${row.patient.id}" 
    data-id="${row.id}" 
    data-nik="${row.patient.nik}" 
    data-name="${row.patient.name}" 
    data-gender="${row.patient.gender}" 
    data-age="${row.patient.dob}" 
    data-phone="${row.patient.phone}" 
    data-address="${row.patient.address}" 
    data-blood="${row.patient.blood_type}" 
    data-education="${row.patient.education}" 
    data-job="${row.patient.occupation}" 
    data-rm="${row.patient.no_rm}" 
    data-tanggal="${row.tanggal}" 
    data-doctor="${row.doctor}" 
    data-kunjungan="${row.kunjungan}" 
    data-kartu="${row.patient.jenis_kartu}" 
    data-nomor="${row.patient.nomor_kartu}" 
    data-faskes="${row.faskes}" 
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
    data-riwayatpenyakitkeluarga='${JSON.stringify(row.riwayat_penyakit_keluarga)}' 
    data-riwayatpenyakittidakmenular='${JSON.stringify(row.riwayat_penyakit_tidak_menular)}' 
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
    data-hamil="${row.hamil}" 
    data-tipe="${row.tipe}" 
    data-icd10="${row.icd10}" 
    data-oralit="${row.oralit}" 
    data-zinc="${row.zinc}">
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

        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();
            // Assuming 'data.dob' contains the date of birth, e.g., "1990-01-01"
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
            console.log(data.tindakan);
            const actionId = data.id;
            const actionUrl = "{{ route('action.update.dokter', '__ID__') }}".replace('__ID__',
                actionId);
            $('#addPatientForm').attr('action', actionUrl);
            // Set nilai ID ke input form
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


            $('#kunjungan').val(data.kunjungan);
            $('#wilayah_faskes').val(data.faskes);
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
            $('#hasillab').val(data.hasillab);
            $('#riwayat_penyakit_keluarga').val(data.riwayatpenyakitkeluarga).trigger('change');
            console.log(data.riwayatpenyakittidakmenular);

            $('#riwayat_penyakit_tidak_menular').val(data.riwayatpenyakittidakmenular).trigger(
                'change');

            $('#keluhan').val(data.keluhan);
            $('#diagnosa').val(data.diagnosa).trigger('change');
            $('#icd10').val(data.icd10);
            $('#tindakan').val(data.tindakan).trigger('change');
            $('#rujuk_rs').val(data.rujukrs);
            $('#keterangan').val(data.keterangan);


            $('#patientDetails').show();
            const patientId = $(this).data('id-patient');
            // console.log($('#patientDetails').show());
            $('#btnCariskrining').data('id', patientId);
            console.log('id patient', patientId);


            // Tutup modal
            $('#modalPasien').modal('hide');
        });

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasien').on('shown.bs.modal', function() {
            initializeTable();
        });
    });
</script>
