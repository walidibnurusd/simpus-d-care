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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>



<script>
    const isDokter = @json($routeName === 'action.dokter.index');
    $(document).ready(function() {
        // Initialize select2 for all relevant elements

        $('#diagnosa, #tindakan, #rujuk_rs, #tindakan_ruang_tindakan, #poli, #diagnosa_primer,#diagnosaEditPrimer')
            .select2({
                placeholder: "Pilih",
                allowClear: true,
                minimumResultsForSearch: 0
            });
    });
    $(document).ready(function() {
        let rowNumber = 1;

        // Function to add medication to the table
        document.getElementById("addMedicationBtn").addEventListener("click", function(e) {
            e.preventDefault(); // mencegah reload

            var codeElement = document.getElementById("code_obat");
            var shape = document.getElementById("shape");
            var alergi = document.getElementById("alergi").value;
            var jumlah = document.getElementById("jumlah").value;
            var stok = document.getElementById("stok").value;
            var gangguanGinjal = document.getElementById("gangguan_ginjal").value;
            var dosis = document.getElementById("dosis").value;
            var hamil = document.getElementById("hamil").value;
            var menyusui = document.getElementById("menyusui").value;

            var selectedOption = codeElement.options[codeElement.selectedIndex];
            var selectedOptionShape = shape.options[shape.selectedIndex];

            var medicationName = selectedOption.text;
            var medicationCode = selectedOption.value;
            var shapeName = selectedOptionShape.text;

            // Cek apakah sudah ada
            if (document.getElementById(`medication-${medicationCode}`)) {
                alert("Obat ini sudah ditambahkan.");
                return;
            }

            var tableBody = document.getElementById("medicationTableBody");
            var newRow = tableBody.insertRow();
            newRow.setAttribute("id", `medication-${medicationCode}`);

            newRow.innerHTML = `
                    <td>${rowNumber}</td>
                    <td>${medicationName}</td>
                    <td>${dosis}</td>
                    <td>${jumlah}</td>
                    <td>${shapeName}</td>
                    <td>${stok}</td>
                    <td style="display: none;">${menyusui}</td>
                    <td style="display: none;">${gangguanGinjal}</td>
                    <td style="display: none;">${alergi}</td>
                    <td style="display: none;">${hamil}</td>
                    <td><button class="btn btn-danger btn-sm delete-row">Hapus</button></td>
                `;

            rowNumber++;
            newRow.setAttribute("data-medication-code", medicationCode);
            document.getElementById("addActionObat").reset();
        });

        // Delegasi event untuk hapus baris
        document.getElementById("medicationTableBody").addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("delete-row")) {
                const row = e.target.closest("tr");
                if (row) row.remove();
            }
        });
        // Function to clear the entire table
        document.getElementById("clearTableBtn").addEventListener("click", function() {
            var tableBody = document.getElementById("medicationTableBody");
            tableBody.innerHTML = '';
            rowNumber = 1; // Reset row number when table is cleared
        });

        // Button to save data to the previous modal
        document.getElementById("saveToPreviousModalBtn").addEventListener("click", function() {
            // Get all table rows
            // var gangguanGinjal = document.getElementById("gangguan_ginjal").value;
            // var hamil = document.getElementById("hamil").value;
            // var menyusui = document.getElementById("menyusui").value;
            // var alergi = document.getElementById("alergi").value;
            var rows = document.getElementById("medicationTableBody").rows;
            var medicationsData = [];
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var medicationData = {
                    gangguan_ginjal: row.cells[7].textContent,
                    hamil: row.cells[9].textContent,
                    alergi: row.cells[8].textContent,
                    menyusui: row.cells[6].textContent,
                    number: row.cells[0].textContent,
                    name: row.cells[1].textContent,
                    dose: row.cells[2].textContent,
                    quantity: row.cells[3].textContent,
                    shape: row.cells[4].textContent,
                    stock: row.cells[5].textContent,
                    idObat: row.getAttribute(
                        "data-medication-code"
                    )
                };
                medicationsData.push(medicationData);
            }

            // Convert data to JSON and store it in a hidden input
            document.getElementById("medicationsData").value = JSON.stringify(medicationsData);
            var medicationsData = JSON.parse(document.getElementById("medicationsData").value);
            // Optionally, you can now pass this data to another modal or form field
            // For example, to another modal input or to a different part of your page
            console.log(medicationsData); // Output the medications data in the console

            // Optionally, hide the current modal after saving data
            $('#addActionObatModal').modal('hide');
        });
        let tablePasien; // Deklarasi variabel DataTable

        // Fungsi untuk menginisialisasi DataTable
        function initializeTable() {
            // if ($.fn.DataTable.isDataTable('#pasien')) {
            //     $('#pasien').DataTable().destroy(); // Hancurkan DataTables jika sudah ada
            // }
            const tipe = $('#tipe').val(); // Ambil route name
            // console.log(tipe);
            const url = `/get-patients-dokter/${tipe}`;
            const filterDate = $('#filterDate').val();
            tablePasien = $('#pasienDokter').DataTable({
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
                            if (!data)
                                return '-'; // Jika data kosong, tampilkan tanda "-"

                            // Konversi ke format dd-mm-yyyy hh:mm:ss
                            const dateObj = new Date(data);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2,
                                '0'); // Bulan dimulai dari 0
                            const year = dateObj.getFullYear();
                            const hours = String(dateObj.getHours()).padStart(2, '0');
                            const minutes = String(dateObj.getMinutes()).padStart(2,
                                '0');
                            const seconds = String(dateObj.getSeconds()).padStart(2,
                                '0');

                            return `${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            return `
                        <button class="btn btn-success btnPilihPasien"
                        data-idpatient="${row.patient_id}"
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
                    <button class="btn btn-danger btnDeletePasien"
                        data-id="${row.action_id ? row.action_id : null}"
                        data-tanggal="${row.tanggal}" data-idpasien="${row.patient_id}"  >
                        Hapus
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
            tablePasien.destroy();
            $('#pasienDokter tbody').empty();
            initializeTable();
        });


        // Handle tombol "Pilih" diklik
        $(document).on('click', '.btnPilihPasien', function() {

            const data = $(this).data();
            var dob = data.age;

            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime();
                var ageDate = new Date(ageDifMs);
                return Math.abs(ageDate.getUTCFullYear() - 1970);
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
                actionUrl = "{{ route('action.update.dokter.tindakan', '__ID__') }}".replace(
                    '__ID__',
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

            $('#riwayat_penyakit_sekarang').val(data.riwayatpenyakitsekarang).trigger('change');

            if (data.riwayatpenyakitlainnya) {
                $('#penyakit_lainnya_container').css('display', 'block');
            } else {
                $('#penyakit_lainnya_container').css('display', 'none');

            }

            $('#riwayat_penyakit_dulu').val(data.riwayatpenyakitdulu).trigger('change');
            $('#riwayat_penyakit_lainnya').val(data.riwayatpenyakitlainnya);
            $('#riwayat_penyakit_keluarga').val(data.riwayatpenyakitkeluarga).trigger('change');
            $('#riwayat_penyakit_lainnya_keluarga').val(data.riwayatpenyakitlainnyakeluarga);

            if (data.riwayatpenyakitlainnyakeluarga) {
                $('#penyakit_lainnya_keluarga_container').css('display',
                    'block');
            } else {
                $('#penyakit_lainnya_keluarga_container').css('display',
                    'none');
            }

            $('#pemeriksaan_penunjang').val(data.pemeriksaanpenunjang || '').trigger('change');
            $('#keluhan').val(data.keluhan);
            var diagnosaArray = JSON.parse(data.diagnosa);


            if (diagnosaArray && diagnosaArray.length > 0) {

                $('#diagnosaEdit').val([]).trigger('change');


                $('#diagnosaEdit').attr('multiple', 'multiple');

                $('#diagnosaEdit option').each(function() {
                    if (diagnosaArray.includes(parseInt($(this).val()))) {
                        $(this).prop('selected', true);
                    }
                });

                $('#diagnosaEdit').trigger('change');
            } else {
                $('#diagnosaEdit').val([]).trigger('change');
            }

            $('#diagnosaEdit').trigger('change');

            $('#diagnosaEdit').attr('multiple', 'multiple').select2({
                placeholder: 'Pilih Diagnosa',
                width: '100%'
            });
            console.log('diagnosa selected', $('#diagnosaEdit').val());
            $('#icd10').val(data.icd10);
            $('#tindakan').val(data.tindakan).trigger('change');
            $('#rujuk_rs').val(data.rujukrs);
            $('#keterangan').val(data.keterangan);
            $('#riwayat_pengobatan').val(data.riwayatpengobatan);
            $('#riwayat_alergi').val(data.riwayatalergi);


            $('#patientDetails').show();
            const patientId = data.idpatient;

            $('#btnCariSkrining').data('id', patientId);
            $('#btnCariRiwayatBerobat').data('id', patientId);


        });


        initializeTable();

      $(document).on('shown.bs.modal', '#modalPasienDokter', function () {
          console.log('Modal ditampilkan!');
          initializeTable();
        });
        $('#refreshTable').on('click', function() {

            tablePasien.ajax.reload(null, false);
        });
        $('#addPatientForm').submit(async function(e) {
            e.preventDefault();
            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            let medicationsData = document.getElementById("medicationsData")
                .value; // Get the JSON string from the hidden input
            formData += "&medications=" + encodeURIComponent(medicationsData);
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
                    // Reset Select2 fields
                    $('#addPatientForm').find('select').each(function() {
                        $(this).val(null).trigger('change');
                    });
                    $('#diagnosa').empty().trigger('change');

                    const select2Fields = [
                        '#diagnosa',
                        '#tindakan',
                        '#rujuk_rs',
                        '#tindakan_ruang_tindakan',
                        '#poli',
                        '#diagnosa_primer',
                        '#diagnosaEditPrimer'
                    ];

                    select2Fields.forEach(selector => {
                        const $el = $(selector);
                        $el.empty().trigger('change');

                    });
                    const tindakanOptions = isDokter ? [{
                            value: "Diberikan Obat",
                            text: "Diberikan Obat"
                        },
                        {
                            value: "Dirujuk",
                            text: "Dirujuk"
                        }
                    ] : [
                        "Gigi Sulung Tumpatan Sementara",
                        "Gigi Tetap Tumpatan Sementara",
                        "Gigi Tetap Tumpatan Tetap",
                        "Gigi Sulung Tumpatan Tetap",
                        "Perawatan Saluran Akar",
                        "Gigi Sulung Pencabutan",
                        "Gigi Tetap Pencabutan",
                        "Pembersihan Karang Gigi",
                        "Odontectomy",
                        "Sebagian Prothesa",
                        "Penuh Prothesa",
                        "Reparasi Prothesa",
                        "Premedikasi/Pengobatan",
                        "Tindakan Lain",
                        "Incici Abses Gigi"
                    ].map(text => ({
                        value: text,
                        text
                    }));

                    const rumahSakitList = @json($rs);
                    const tindakanRuangOptions = [
                        "Observasi Tanpa Tindakan Invasif",
                        "Observasi Dengan Tindakan Invasif",
                        "Tidak Ada",
                        "Corpus Alineum",
                        "Ekstraksi Kuku",
                        "Sircumsisi (Bedah Ringan)",
                        "Incisi Abses",
                        "Rawat Luka",
                        "Ganti Verban",
                        "Spooling",
                        "Toilet Telinga",
                        "Tetes Telinga",
                        "Aff Hecting",
                        "Hecting (Jahit Luka)",
                        "Tampon/Off Tampon"
                    ];
                    const poliOptions = @json($poli);
                    const diagnosaOptions = @json($diagnosa);

                    const $select = $('#tindakan');

                    // Tambahkan opsi baru
                    tindakanOptions.forEach(opt => {
                        $select.append(new Option(opt.text, opt.value));
                    });

                    $select.append(
                        '<option></option>');
                    const $selectRujukRS = $('#rujuk_rs');

                    $selectRujukRS.append(
                        '<option value="" disabled selected>pilih</option>');
                    rumahSakitList.forEach(item => {
                        $selectRujukRS.append(new Option(item.name, item.id));
                    });

                    const $selectTindakan = $('#tindakan_ruang_tindakan');
                   
                    tindakanRuangOptions.forEach(item => {
                        $selectTindakan.append(new Option(item, item));
                    });

                    const $poli = $('#poli');
                    $poli.append('<option value="" disabled selected>pilih</option>');

                    poliOptions.forEach(item => {
                        $poli.append(new Option(item.name, item.id));
                    });

                    const $diagnosa = $('#diagnosa_primer');
                    $diagnosa.append(
                        '<option value="" disabled selected>pilih</option>');
                    diagnosaOptions.forEach(item => {
                        $diagnosa.append(
                            $('<option>', {
                                value: item.id,
                                text: `${item.name} - ${item.icd10}`
                            })
                        );
                    });

                    const $diagnosaEditPrimer = $('#diagnosaEditPrimer');
                    $diagnosaEditPrimer.append(
                        '<option value="" disabled selected>pilih</option>');
                    diagnosaOptions.forEach(item => {
                        $diagnosaEditPrimer.append(
                            $('<option>', {
                                value: item.id,
                                text: `${item.name} - ${item.icd10}`
                            })
                        );
                    });



                    $('#displayNIK, #displayName, #displayAge, #displayPhone, #displayAddress, #displayBlood, #displayRmNumber')
                        .text('');
                    $('#addPatientForm')[0].reset();
                    var tableBody = document.getElementById("medicationTableBody");
                    tableBody.innerHTML = '';
                    rowNumber = 1; // Reset row number when table is cleared

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
        $(document).on('click', '.btnDeletePasien', function() {
            const data = $(this).data();
            const actionId = data.id;
            const tanggal = data.tanggal;
            const idPasien = data.idpasien;
            console.log(data);

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: `/patient/action`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: actionId,
                        tanggal: tanggal,
                        idPasien: idPasien
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Data berhasil dihapus!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            // Refresh the DataTable to reflect the deletion
                            tablePasien.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Terjadi kesalahan!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });


    });

    // Ubah function refreshPatientData agar mengembalikan Promise
    function refreshPatientData() {
        return new Promise((resolve, reject) => {
            const tipe = $('#tipe').val();
            $.ajax({
                url: `/get-patients-dokter/${tipe}`,
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
                                <td>
                                    <button class="btn btn-danger hapus-pasien" data-id="${patient.id}">Hapus</button>
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
