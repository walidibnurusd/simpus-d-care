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

            if (data.hasillab.includes("GDS")) {
                document.getElementById("label-gds").style.display = "block";
                document.getElementById("gds").style.display = "block";
                document.getElementById("pd").style.display = "flex";
            }
            if (data.hasillab.includes("GDP")) {
                document.getElementById("label-gdp").style.display = "block";
                document.getElementById("gdp").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("GDP 2 Jam pp")) {
                document.getElementById("label-gdp_2_jam_pp").style.display = "block";
                document.getElementById("gdp_2_jam_pp").style.display = "block";
                document.getElementById("pd").style.display = "flex"

            }
            if (data.hasillab.includes("Cholesterol")) {
                document.getElementById("label-cholesterol").style.display = "block";
                document.getElementById("cholesterol").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Asam Urat")) {
                document.getElementById("label-asam_urat").style.display = "block";
                document.getElementById("asam_urat").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Leukosit")) {
                document.getElementById("label-leukosit").style.display = "block";
                document.getElementById("leukosit").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Eritrosit")) {
                document.getElementById("label-eritrosit").style.display = "block";
                document.getElementById("eritrosit").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Trombosit")) {
                document.getElementById("label-trombosit").style.display = "block";
                document.getElementById("trombosit").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Hemoglobin")) {
                document.getElementById("label-hemoglobin").style.display = "block";
                document.getElementById("hemoglobin").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Sifilis")) {
                document.getElementById("label-sifilis").style.display = "block";
                document.getElementById("sifilis").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("HIV")) {
                document.getElementById("label-hiv").style.display = "block";
                document.getElementById("hiv").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Golongan Darah")) {
                document.getElementById("label-golongan_darah").style.display = "block";
                document.getElementById("golongan_darah").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Widal")) {
                document.getElementById("label-widal").style.display = "block";
                document.getElementById("widal").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Malaria")) {
                document.getElementById("label-malaria").style.display = "block";
                document.getElementById("malaria").style.display = "block";
                document.getElementById("pd").style.display = "flex"
            }
            if (data.hasillab.includes("Albumin")) {
                document.getElementById("label-albumin").style.display = "block";
                document.getElementById("albumin").style.display = "block";
                document.getElementById("pu").style.display = "flex"
            }
            if (data.hasillab.includes("Reduksi")) {
                document.getElementById("label-reduksi").style.display = "block";
                document.getElementById("reduksi").style.display = "block";
                document.getElementById("pu").style.display = "flex"
            }
            if (data.hasillab.includes("Urinalisa")) {
                document.getElementById("label-urinalisa").style.display = "block";
                document.getElementById("urinalisa").style.display = "block";
                document.getElementById("pu").style.display = "flex"
            }
            if (data.hasillab.includes("Tes Kehamilan")) {
                document.getElementById("label-tes_kehamilan").style.display = "block";
                document.getElementById("tes_kehamilan").style.display = "block";
                document.getElementById("pu").style.display = "flex"
            }
            if (data.hasillab.includes("Telur Cacing")) {
                document.getElementById("label-telur_cacing").style.display = "block";
                document.getElementById("telur_cacing").style.display = "block";
                document.getElementById("pf").style.display = "flex"
            }
            if (data.hasillab.includes("BTA")) {
                document.getElementById("label-bta").style.display = "block";
                document.getElementById("bta").style.display = "block";
                document.getElementById("pf").style.display = "flex"
            }
            if (data.hasillab.includes("IgM DBD")) {
                document.getElementById("label-igm_dbd").style.display = "block";
                document.getElementById("igm_dbd").style.display = "block";
                document.getElementById("pi").style.display = "flex"
            }
            if (data.hasillab.includes("IgM Typhoid")) {
                document.getElementById("label-igm_typhoid").style.display = "block";
                document.getElementById("igm_typhoid").style.display = "block";
                document.getElementById("pi").style.display = "flex"
            }



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
