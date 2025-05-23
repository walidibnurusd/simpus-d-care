<div class="modal fade" id="modalPasienApotik" tabindex="-1" aria-labelledby="modalPasienApotikLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100">
                    <h5 class="modal-title" id="modalPasienApotikLabel">Cari Pasien</h5>
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
                <table class="table table-striped" id="pasienApotik">
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JS Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let rowNumber = 1;

    // Fungsi untuk menghitung umur dari tanggal lahir
    function calculateAge(dob) {
        const birthDate = new Date(dob);
        const ageDifMs = Date.now() - birthDate.getTime();
        const ageDate = new Date(ageDifMs);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

    // Fungsi untuk menghapus baris
    window.removeRow = function(button) {
        $(button).closest('tr').remove();
        rowNumber = 1;
        $('#medicationTableBody tr').each(function() {
            $(this).find('td:first').text(rowNumber++);
        });
    };

    // Kosongkan tabel ketika tombol "Clear" diklik
    document.getElementById("clearTableBtn").addEventListener("click", function() {
        document.getElementById("medicationTableBody").innerHTML = '';
        rowNumber = 1;
    });

    // Tambah baris obat secara manual
    document.getElementById("addMedicationBtn").addEventListener("click", function() {
        const codeElement = document.getElementById("code_obat");
        const shape = document.getElementById("shape");

        const selectedOption = codeElement.options[codeElement.selectedIndex];
        const selectedOptionShape = shape.options[shape.selectedIndex];

        const medicationName = selectedOption.text;
        const medicationCode = selectedOption.value;
        const shapeName = selectedOptionShape.text;

        const alergi = document.getElementById("alergi").value;
        const jumlah = document.getElementById("jumlah").value;
        const stok = document.getElementById("stok").value;
        const gangguanGinjal = document.getElementById("gangguan_ginjal").value;
        const dosis = document.getElementById("dosis").value;
        const hamil = document.getElementById("hamil").value;
        const menyusui = document.getElementById("menyusui").value;

        // Validasi sederhana (opsional)
        if (!jumlah || !dosis || !medicationCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Harap lengkapi data obat sebelum menambahkan.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const tableBody = document.getElementById("medicationTableBody");
        const newRow = tableBody.insertRow();

        newRow.setAttribute("data-medication-code", medicationCode);
        newRow.innerHTML = `
            <td>${rowNumber}</td>
            <td>${medicationName}</td>
            <td>${dosis}</td>
            <td>${jumlah}</td>
            <td>${shapeName}</td>
            <td>${stok}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
            <td style="display: none;">${menyusui}</td>
            <td style="display: none;">${gangguanGinjal}</td>
            <td style="display: none;">${alergi}</td>
            <td style="display: none;">${hamil}</td>
        `;

        rowNumber++;
        document.getElementById("addActionObat").reset();
    });

    // Submit form utama

    function resetPatientDetails() {
        document.getElementById("displayNIK").textContent = "";
        document.getElementById("displayName").textContent = "";
        document.getElementById("displayAge").textContent = "";
        document.getElementById("displayPhone").textContent = "";
        document.getElementById("displayAddress").textContent = "";
        document.getElementById("displayBlood").textContent = "";
        document.getElementById("displayRmNumber").textContent = "";
        document.getElementById("patientDetails").style.display = "none";
    }
</script>
<script>
    $(document).ready(function() {



        let table;

        function initializeTable() {
            const tipe = $('#tipe').val();
            const url = `/get-patients-apotik/${tipe}`;
            const filterDate = $('#filterDate').val();
            table = $('#pasienApotik').DataTable({
                ajax: {
                    url: url,
                    type: 'GET',
                    data: function(d) {
                        d.filterDate = filterDate;
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
                            console.log(row);

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
    data-diagnosa='${JSON.stringify(row.diagnosa)}'
    data-tanggal="${row.tanggal}"
    data-doctor="${row.doctor}"
    data-kunjungan="${row.kunjungan}"
    data-obat="${row.obat}"
    data-updateobat="${row.update_obat}"
 data-action-obats='${JSON.stringify(row.action_obats)}'
data-bs-dismiss="modal">
    Pilih
</button>

                        `;
                        },
                    },
                ],
                destroy: true,
                processing: true,
                serverSide: true,
            });
        }
        $('#filterDate').on('change', function() {
            table.destroy();
            $('#pasienApotik tbody').empty();
            initializeTable();
        });



        $(document).on('click', '.btnPilihPasien', function(event) {
            const data = $(this).data();
            console.log(data);

            var dob = data.age;

            function calculateAge(dob) {
                var birthDate = new Date(dob);
                var ageDifMs = Date.now() - birthDate.getTime();
                var ageDate = new Date(ageDifMs);
                return Math.abs(ageDate.getUTCFullYear() - 1970);
            }

            if (event.target.classList.contains("btnPilihPasien")) {
                let actionObats = event.target.getAttribute("data-action-obats");

                if (actionObats) {
                    let parsedObats = JSON.parse(actionObats);
                    let tableBody = document.getElementById("medicationTableBody1");
                    tableBody.innerHTML = "";

                    let shapes = {
                        1: "Tablet",
                        2: "Botol",
                        3: "Pcs",
                        4: "Suppositoria",
                        5: "Ovula",
                        6: "Drop",
                        7: "Tube",
                        8: "Pot",
                        9: "Injeksi"
                    };

                    let rowNumber = 1;
                    let readonlyMode = true; // Ganti false kalau mau aktifin edit/hapus

                    parsedObats.forEach(obat => {
                        let newRow = tableBody.insertRow();
                        let totalAmount = Array.isArray(obat.obat.terima_obat) ?
                            obat.obat.terima_obat.reduce((total, item) => total + (item
                                .amount || 0), 0) :
                            0;

                        newRow.innerHTML = `
                    <td>${rowNumber}</td>
                    <td>${obat.obat.name}</td>
                    <td>${obat.dose}</td>
                    <td>${obat.amount}</td>
                    <td>${shapes[obat.shape] || "Tidak Diketahui"}</td>
                    <td>${totalAmount}</td>
                    <td>${readonlyMode ? '-' : `<button class="btn btn-danger btn-sm delete-row">Hapus</button>`}</td>
                `;
                        rowNumber++;
                    });

                    if (readonlyMode) {
                        // Disable semua interaksi di tabel
                        $('#medicationTableBody1').css('pointer-events', 'none');
                        // Optional: ubah style cursor biar kelihatan nonaktif
                        $('#medicationTableBody1').css('opacity', '0.7');
                    } else {
                        document.getElementById("medicationTableBody1").addEventListener("click",
                            function(e) {
                                if (e.target && e.target.classList.contains("delete-row")) {
                                    const row = e.target.closest("tr");
                                    if (row) row.remove();
                                }
                            });

                        document.getElementById("clearTableBtn").addEventListener("click", function() {
                            var tableBody = document.getElementById("medicationTableBody1");
                            tableBody.innerHTML = '';
                            rowNumber = 1;
                        });
                    }
                }
            }

            var age = calculateAge(dob);
            console.log(data.nik);

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
            $('#patientDetails').show();

            const actionId = data.id;
            const actionUrl = "{{ route('action.update.apotik', '__ID__') }}".replace('__ID__',
                actionId);
            $('#addPatientForm').attr('action', actionUrl);

            $('#nik').val(data.nik);
            $('#idAction').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#doctor').val(data.doctor);
            $('#nomor_kartu').val(data.nomor);
            $('#kunjungan').val(data.kunjungan);

            $('#obat').val(data.obat);
            $('#update_obat').val(data.updateobat);

            var diagnosaData = data.diagnosa;
            console.log(diagnosaData);

            var diagnosaArray = [];

            if (typeof diagnosaData === 'string') {
                if (diagnosaData.trim().startsWith('[')) {
                    try {
                        diagnosaArray = JSON.parse(diagnosaData);
                    } catch (e) {
                        console.error("Parsing error:", e);
                    }
                } else if (diagnosaData.includes(',')) {
                    diagnosaArray = diagnosaData.split(',').map(val => parseInt(val.trim()));
                } else {
                    diagnosaArray = [parseInt(diagnosaData)];
                }
            } else if (Array.isArray(diagnosaData)) {
                diagnosaArray = diagnosaData.map(val => parseInt(val));
            }

            console.log(diagnosaArray);

            if (diagnosaArray.length > 0) {
                $('#diagnosaEdit').val([]).trigger('change');

                $('#diagnosaEdit option').each(function() {
                    if (diagnosaArray.includes(parseInt($(this).val()))) {
                        $(this).prop('selected', true);
                    }
                });

                $('#diagnosaEdit').trigger('change');
            } else {
                $('#diagnosaEdit').val([]).trigger('change');
            }

            if (!$('#diagnosaEdit').hasClass('select2-hidden-accessible')) {
                $('#diagnosaEdit').select2();
            }

            $('#modalPasienApotik').modal('hide');
        });

        initializeTable();
        // Inisialisasi ulang DataTables saat modal ditampilkan
        $('#modalPasienApotik').on('shown.bs.modal', function() {
            initializeTable();
        });
        $('#refreshTable').on('click', function() {

            table.ajax.reload(null, false);
        });

        $('#addPatientForm').submit(function(e) {
            e.preventDefault();

            const rows = document.getElementById("medicationTableBody").rows;
            const medicationsData = [];

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                medicationsData.push({
                    number: row.cells[0].textContent.trim(),
                    name: row.cells[1].textContent.trim(),
                    dose: row.cells[2].textContent.trim(),
                    quantity: row.cells[3].textContent.trim(),
                    shape: row.cells[4].textContent.trim(),
                    stock: row.cells[5].textContent.trim(),
                    idObat: row.getAttribute("data-medication-code"),
                    menyusui: row.cells[7]?.textContent.trim() || '',
                    gangguan_ginjal: row.cells[8]?.textContent.trim() || '',
                    alergi: row.cells[9]?.textContent.trim() || '',
                    hamil: row.cells[10]?.textContent.trim() || '',
                });
            }

            let formData = $('#addPatientForm').serialize();
            formData += "&_token=" + $('meta[name="csrf-token"]').attr('content');
            formData += "&medications=" + encodeURIComponent(JSON.stringify(medicationsData));

            const actionId = $('#idAction').val() ?? null;
            const url = actionId ? `/tindakan-apotik/${actionId}` : '/tindakan';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: async function(response) {
                    await Swal.fire({
                        title: 'Success!',
                        text: response.success || 'Data berhasil disimpan!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Reset form dan elemen terkait
                    $('#addPatientForm')[0].reset(); // Reset form HTML
                    $('#medicationTableBody').empty(); // Kosongkan tabel obat
                     table.ajax.reload(null, false);
                    resetPatientDetails(); // Kosongkan dan sembunyikan detail pasien (fungsi harus sudah didefinisikan)
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.error || "Terjadi kesalahan!";
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
</script>
