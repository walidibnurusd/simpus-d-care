@php
    $master = new App\Http\Controllers\DependentDropDownController();
    $provinces = $master->provinces();
    $cities = [];
    $marritals = $master->marritalStatusData();
    $occupations = $master->occupationData();
    $educations = $master->educationData();
    $genders = $master->genderData();
    $defaultProvinceId = $provinces->firstWhere('name', 'SULAWESI SELATAN')->id; // Assuming this gets the correct ID
    $cities = $master->citiesData($defaultProvinceId);
    $defaultCityId = $cities->firstWhere('name', 'KOTA MAKASSAR')->id;

@endphp

<div class="modal fade" style="z-index: 1050;" id="addPatientModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('patient.store') }}" method="POST" class="px-3">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">Cari Pasien</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="nikAdd" name="nik"
                                        placeholder="NIK" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btnCariNIK"
                                            data-bs-toggle="modal" data-bs-target="#modalPasien">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Pasien</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nama Pasien" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="no_family_folder">Nomor Family Folder</label>
                                    <input type="text" class="form-control" id="no_family_folder"
                                        name="no_family_folder" placeholder="Nomor Family Folder" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telpon/WA</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    placeholder="Telpon/WA">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="marriage_status">Status Menikah</label>
                                <select class="form-control" id="marriage_status" name="marriage_status" required>
                                    <option value="">Pilih</option>
                                    @foreach ($marritals as $marrital)
                                        <option value="{{ $marrital->id }}"
                                            {{ old('id_marrital') == $marrital->id ? 'selected' : '' }}>
                                            {{ $marrital->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="blood_type">Golongan Darah</label>
                                <select class="form-control" id="blood_type" name="blood_type" required>
                                    <option value="">Pilih</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="Tidak Diketahui">Tidak Diketahui</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="education">Pendidikan</label>
                                <select class="form-control" id="education" name="education" required>
                                    <option value="">Pilih</option>
                                    @foreach ($educations as $education)
                                        <option value="{{ $education->id }}"
                                            {{ old('id_education') == $education->id ? 'selected' : '' }}>
                                            {{ $education->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occupation">Pekerjaan</label>
                                <select class="form-control" id="occupation" name="occupation" required>
                                    <option value="">Pilih</option>
                                    @foreach ($occupations as $occupation)
                                        <option value="{{ $occupation->id }}"
                                            {{ old('id_occupation') == $occupation->id ? 'selected' : '' }}>
                                            {{ $occupation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Pilih</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ old('id_gender') == $gender->id ? 'selected' : '' }}>
                                            {{ $gender->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row g-2">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kartu">Jenis Kartu</label>
                                <select class="form-control" id="jenis_kartu" name="jenis_kartu" required>
                                    <option value="" disabled selected>Pilih Jenis Kartu</option>
                                    <option value="pbi">PBI (KIS)</option>
                                    <option value="askes">AKSES</option>
                                    <option value="jkn_mandiri">JKN Mandiri</option>
                                    <option value="umum">Umum</option>
                                    <option value="jkd">JKD</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor">Nomor Kartu</label>
                                <input type="text" class="form-control" id="nomor_kartu" name="nomor_kartu"
                                    placeholder="Masukkan Nomor" required>
                            </div>
                        </div>

                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place_birth">Tempat Lahir</label>
                                <input type="text" class="form-control" id="place_birth" name="place_birth"
                                    placeholder="Tempat lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="province">Provinsi Asal</label>
                                <select class="form-control" id="province" name="province" disabled>
                                    <option value=""></option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province', $defaultProvinceId) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Kabupaten/Kota</label>
                                <select class="form-control" id="city" name="city" disabled>
                                    <option value=""></option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city', $defaultCityId) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district">Kecamatan</label>
                                <select class="form-control" id="district" name="district" required
                                    onchange="updateVillage()">
                                    <option value="Manggala">Manggala</option>
                                    <option value="Luar Wilayah">Luar Wilayah</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="village">Kelurahan/Desa</label>
                                <select class="form-control" id="village" name="village" required>
                                    <option value="Tamangapa">Tamangapa</option>
                                    <option value="Luar Wilayah">Luar Wilayah</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <select class="form-control" id="rw" name="rw">
                                    <option value="">Pilih</option>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    <option value="4A">4A</option>
                                    <option value="4B">4B (TPA)</option>
                                    <option value="luar-wilayah">Luar Wilayah</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="address">Alamat/Jalan</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Jalan" required>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kunjungan">Kunjungan</label>
                                <select class="form-control" id="kunjungan" name="kunjungan">
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Baru </option>
                                    <option value="0">Lama </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wilayah_faskes">Wilayah Faskes</label>
                                <select class="form-control" id="wilayah_faskes" name="wilayah_faskes">
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kunjungan</h5>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <label for="poli">Poli Tujuan Berobat</label>
                                <select class="form-control" id="poli_berobat" name="poli_berobat" required>
                                    <option value="">Pilih</option>
                                    <option value="poli-umum">Poli Umum</option>
                                    <option value="poli-gigi">Poli Gigi</option>
                                    <option value="ruang-tindakan">UGD</option>
                                    <option value="poli-kia">Poli KIA</option>
                                    <option value="poli-kb">Poli KB</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <label for="hamil">Hamil?</label>
                                <select class="form-control" id="hamil" name="hamil" required>
                                    <option value="">Pilih</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="klaster">Klaster</label>
                                <input type="text" class="form-control" id="klaster" name="klaster"
                                    placeholder="Klaster" readonly>
                            </div>
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
@include('component.modal-add-table-pasien')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .select2-dropdown {
        z-index: 9999 !important;
    }
</style>
<script>
    function updateVillage() {
        const district = document.getElementById('district').value;
        const village = document.getElementById('village');

        if (district === 'Luar Wilayah') {
            village.value = 'Luar Wilayah';
        } else if (district === 'Manggala') {
            village.value = 'Tamangapa';
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.getElementById('dob');
        const klasterSelect = document.getElementById('klaster');
        const hamilInput = document.getElementById('hamil');

        function calculateAge(dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        function updateKlaster() {
            const dob = dobInput.value;
            const hamil = hamilInput.value;

            if (dob) {
                const age = calculateAge(dob);

                let klaster = null;
                if (age > 18 && hamil == 0) {
                    klaster = 3;
                } else if (hamil == 1) {
                    klaster = 2;
                } else {
                    klaster = 2;
                }


                klasterSelect.value = klaster;



            }
        }

        dobInput.addEventListener('change', function() {
            updateKlaster();
        });


        hamilInput.addEventListener('change', function() {
            updateKlaster();
        });

        if (dobInput.value) {
            updateKlaster();
        }
        // Success notification using SweetAlert2
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Validation error handling
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
