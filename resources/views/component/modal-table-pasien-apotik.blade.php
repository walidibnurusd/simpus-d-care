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
        $('#medicationTableBody tr').each(function () {
            $(this).find('td:first').text(rowNumber++);
        });
    };

    // Kosongkan tabel ketika tombol "Clear" diklik
    document.getElementById("clearTableBtn").addEventListener("click", function () {
        document.getElementById("medicationTableBody").innerHTML = '';
        rowNumber = 1;
    });

    // Tambah baris obat secara manual
    document.getElementById("addMedicationBtn").addEventListener("click", function () {
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
    $('#addPatientForm').submit(function (e) {
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
            success: async function (response) {
                await Swal.fire({
                    title: 'Success!',
                    text: response.success || 'Data berhasil disimpan!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                location.reload();
            },
            error: function (xhr) {
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
                            console.log(row.action_obats);
                            
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
    data-obat="${row.obat}"    
    data-updateobat="${row.update_obat}" 
 data-action-obats='${JSON.stringify(row.action_obats)}'
 data-diagnosa='${JSON.stringify(row.diagnosa)}'
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



        $(document).on('click', '.btnPilihPasien', function() {

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
                let tableBody = document.getElementById("medicationTableBody");
                tableBody.innerHTML = ""; // Kosongkan tabel sebelum menambahkan data baru

                // Mapping bentuk obat (Shape ID ke Text)
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
                parsedObats.forEach(obat => {
                let newRow = tableBody.insertRow();
                let totalAmount = Array.isArray(obat.obat.terima_obat) 
                    ? obat.obat.terima_obat.reduce((total, item) => total + (item.amount || 0), 0) 
                    : 0; // Jika bukan array, kembalikan 0

                newRow.innerHTML = `
                    <td>${rowNumber}</td>
                    <td>${obat.obat.name}</td>
                    <td>${obat.dose}</td>
                    <td>${obat.amount}</td>
                    <td>${shapes[obat.shape] || "Tidak Diketahui"}</td>
                    <td>${totalAmount}</td> <!-- Menampilkan jumlah total amount -->
                    <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                `;
                rowNumber++;
                // newRow.setAttribute("data-medication-code", medicationCode);
                // document.getElementById("addActionObat").reset();
            });
            document.getElementById("medicationTableBody").addEventListener("click", function (e) {
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
            // Set nilai ID ke input form
            $('#nik').val(data.nik);
            $('#idAction').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#doctor').val(data.doctor);
            $('#nomor_kartu').val(data.nomor);
            $('#kunjungan').val(data.kunjungan);

            $('#obat').val(data.obat);
            $('#update_obat').val(data.updateobat);
            $('#diagnosa').select2();

           
            const diagnosaData = $(data.diagnosa); // Ambil dari data-diagnosa
            console.log(diagnosaData);
            
                if (Array.isArray(diagnosaData) && diagnosaData.length > 0) {
                    const stringValues = diagnosaData.map(String); // Konversi ke string (Select2 perlu string)
                    $('#diagnosa').val(stringValues).trigger('change');
                } else {
                    $('#diagnosa').val([]).trigger('change'); // Reset jika kosong
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

       
       
    });
</script>
