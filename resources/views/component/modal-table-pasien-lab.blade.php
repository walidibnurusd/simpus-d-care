<div class="modal fade" id="modalPasienLab" tabindex="-1" aria-labelledby="modalPasienLabLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100">
                    <h5 class="modal-title" id="modalPasienLabLabel">Cari Pasien</h5>
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
                <table class="table table-striped" id="pasienLab">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Kajian Awal</th>
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
            const tipe = $('#tipe').val(); // Ambil route name
            const url = `/get-patients-lab/${tipe}`;
            const filterDate = $('#filterDate').val();
            table = $('#pasienLab').DataTable({
                ajax: {
                    url: url, // Endpoint untuk mengambil data
                    type: 'GET',
                    data: function(d) {
                        d.filterDate = filterDate; // Kirim tanggal sebagai parameter tambahan
                    }

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
                        data: 'created_at',
                        name: 'created_at',
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
                data-pemeriksaanpenunjang="${row.pemeriksaan_penunjang}"    
              data-hasillab="${row.hasil_lab && row.hasil_lab.jenis_pemeriksaan ? JSON.parse(row.hasil_lab.jenis_pemeriksaan) : null}"


            >
                Pilih
            </button>
        `;
                        }
                    }

                ],
                destroy: true, // Mengizinkan inisialisasi ulang
                processing: true,
                serverSide: true,
            });
        }
        $('#filterDate').on('change', function() {
            if ($.fn.DataTable.isDataTable('#pasienLab')) {
                table.destroy(); // Hancurkan DataTables yang ada
            }
            initializeTable(); // Inisialisasi ulang dengan filter baru
        });


        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();
            console.log("Data Pasien:", data);
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
            // Tampilkan data pasienLab di elemen luar modal
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
            const actionUrl = "{{ route('action.update.lab', '__ID__') }}".replace('__ID__',
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

            // $('#hasillab').val(data.hasillab);
            $('#pemeriksaan_penunjang').val(data.pemeriksaanpenunjang || '').trigger('change');
            $('#riwayat_penyakit_keluarga').val(data.riwayatpenyakitkeluarga).trigger('change');

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
            let hasilLab = [];
            if (data.hasillab) {
                if (typeof data.hasillab === "string") {
                    hasilLab = data.hasillab.split(","); // Ubah string jadi array
                } else if (Array.isArray(data.hasillab)) {
                    hasilLab = data.hasillab; // Jika sudah array, gunakan langsung
                }
            }

            console.log("Parsed hasilLab:", hasilLab);

            if (!Array.isArray(hasilLab)) {
                console.warn("Data hasil lab tidak ditemukan atau bukan array.");
                return;
            }


            // Mapping pemeriksaan ke elemen input dan label
            const pemeriksaanMapping = [{
                    name: "GDS",
                    label: "label-gds",
                    input: "gds",
                    section: "pd"
                },
                {
                    name: "GDP",
                    label: "label-gdp",
                    input: "gdp",
                    section: "pd"
                },
                {
                    name: "GDP 2 Jam pp",
                    label: "label-gdp_2_jam_pp",
                    input: "gdp_2_jam_pp",
                    section: "pd"
                },
                {
                    name: "Cholesterol",
                    label: "label-cholesterol",
                    input: "cholesterol",
                    section: "pd"
                },
                {
                    name: "Asam Urat",
                    label: "label-asam_urat",
                    input: "asam_urat",
                    section: "pd"
                },
                {
                    name: "Leukosit",
                    label: "label-leukosit",
                    input: "leukosit",
                    section: "pd"
                },
                {
                    name: "Eritrosit",
                    label: "label-eritrosit",
                    input: "eritrosit",
                    section: "pd"
                },
                {
                    name: "Trombosit",
                    label: "label-trombosit",
                    input: "trombosit",
                    section: "pd"
                },
                {
                    name: "Hemoglobin",
                    label: "label-hemoglobin",
                    input: "hemoglobin",
                    section: "pd"
                },
                {
                    name: "Sifilis",
                    label: "label-sifilis",
                    input: "sifilis",
                    section: "pd"
                },
                {
                    name: "HIV",
                    label: "label-hiv",
                    input: "hiv",
                    section: "pd"
                },
                {
                    name: "Golongan Darah",
                    label: "label-golongan_darah",
                    input: "golongan_darah",
                    section: "pd"
                },
                {
                    name: "Widal",
                    label: "label-widal",
                    input: "widal",
                    section: "pd"
                },
                {
                    name: "Malaria",
                    label: "label-malaria",
                    input: "malaria",
                    section: "pd"
                },
                {
                    name: "Albumin",
                    label: "label-albumin",
                    input: "albumin",
                    section: "pu"
                },
                {
                    name: "Reduksi",
                    label: "label-reduksi",
                    input: "reduksi",
                    section: "pu"
                },
                {
                    name: "Urinalisa",
                    label: "label-urinalisa",
                    input: "urinalisa",
                    section: "pu"
                },
                {
                    name: "Tes Kehamilan",
                    label: "label-tes_kehamilan",
                    input: "tes_kehamilan",
                    section: "pu"
                },
                {
                    name: "Telur Cacing",
                    label: "label-telur_cacing",
                    input: "telur_cacing",
                    section: "pf"
                },
                {
                    name: "BTA",
                    label: "label-bta",
                    input: "bta",
                    section: "pf"
                },
                {
                    name: "IgM DBD",
                    label: "label-igm_dbd",
                    input: "igm_dbd",
                    section: "pi"
                },
                {
                    name: "IgM Typhoid",
                    label: "label-igm_typhoid",
                    input: "igm_typhoid",
                    section: "pi"
                },
                {
                    name: "TCM",
                    label: "label-tcm",
                    input: "tcm",
                    section: "pa"
                },
                // {
                //     name: "BTA",
                //     label: "label-bta",
                //     input: "bta",
                //     section: "pa"
                // },
            ];

            // Loop melalui pemeriksaan dan aktifkan elemen yang sesuai
            pemeriksaanMapping.forEach(({
                name,
                label,
                input,
                section
            }) => {
                if (hasilLab.includes(name)) {
                    document.getElementById(label).style.display = "block";
                    document.getElementById(input).style.display = "block";
                    document.getElementById(section).style.display = "flex";
                }
            });


            // Tutup modal
            $('#modalPasienLab').modal('hide');
        });

        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienLab').on('shown.bs.modal', function() {
            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });
    });
</script>
