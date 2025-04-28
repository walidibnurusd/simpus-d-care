    @php
        $master = new App\Http\Controllers\DependentDropDownController();
        $provinces = $master->provinces();
        $cities = [];
        $marritals = $master->marritalStatusData();
        $occupations = $master->occupationData();
        $educations = $master->educationData();
        $genders = $master->genderData();
        $defaultProvinceId = $provinces->firstWhere('name', 'SULAWESI SELATAN')->id;
        $cities = $master->citiesData($defaultProvinceId);
        $defaultCityId = $cities->firstWhere('name', 'KOTA MAKASSAR')->id;
    @endphp

    <div class="modal fade" style="z-index: 9999;" id="editPatientModal{{ $patient->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Using modal-lg for a moderate width -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5> <!-- Updated the title -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('patient.update', $patient->id) }}" method="POST" class="px-3">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">


                        <div class="row g-2"> <!-- Reduced gutter space between columns -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        placeholder="NIK" value="{{ old('nik', $patient->nik) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Pasien</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama Pasien" value="{{ old('name', $patient->name) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="no_family_folder">Nomor Family Folder</label>
                                    <input type="text" class="form-control" id="no_family_folder"
                                        name="no_family_folder" placeholder="Nomor Family Folder"
                                        value="{{ old('no_family_folder', $patient->no_family_folder) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Telpon/WA</label>
                                    <input type="number" class="form-control" id="phone" name="phone"
                                        placeholder="Telpon/WA" value="{{ old('phone', $patient->phone) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="marriage_status">Status Menikah</label>
                                    <select class="form-control" id="marriage_status" name="marriage_status" required>
                                        <option value="">Pilih</option>
                                        @foreach ($marritals as $marrital)
                                            <option value="{{ $marrital->id }}"
                                                {{ old('marriage_status', $patient->marrital_status) == $marrital->id ? 'selected' : '' }}>
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
                                        <option value="A"
                                            {{ old('blood_type', $patient->blood_type) == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B"
                                            {{ old('blood_type', $patient->blood_type) == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="AB"
                                            {{ old('blood_type', $patient->blood_type) == 'AB' ? 'selected' : '' }}>AB
                                        </option>
                                        <option value="O"
                                            {{ old('blood_type', $patient->blood_type) == 'O' ? 'selected' : '' }}>O
                                        </option>
                                        <option value="Tidak Diketahui"
                                            {{ old('blood_type', $patient->blood_type) == 'Tidak Diketahui' ? 'selected' : '' }}>
                                            Tidak Diketahui</option>
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
                                                {{ old('education', $patient->education) == $education->id ? 'selected' : '' }}>
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
                                                {{ old('occupation', $patient->occupation) == $occupation->id ? 'selected' : '' }}>
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
                                                {{ old('gender', $patient->gender) == $gender->id ? 'selected' : '' }}>
                                                {{ $gender->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="klaster">Klaster</label>
                                    <select class="form-control" id="klaster" name="klaster">
                                        <option value="">Pilih</option>
                                        @for ($i = 2; $i <= 3; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('klaster', $patient->klaster) == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="poli">Poli</label>

                                    <select class="form-control" id="poli" name="poli" required>
                                        <option value="" disabled {{ empty($patient->poli) ? 'selected' : '' }}>
                                            Pilih</option>
                                        <option value="kia" {{ $patient->poli == 'kia' ? 'selected' : '' }}>KIA
                                        </option>
                                        <option value="mtbs" {{ $patient->poli == 'mtbs' ? 'selected' : '' }}>MTBS
                                        </option>
                                        <option value="lansia" {{ $patient->poli == 'lansia' ? 'selected' : '' }}>
                                            Lansia & Dewasa</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kartu">Jenis Kartu</label>
                                    <select class="form-control" id="jenis_kartu" name="jenis_kartu" required>
                                        <option value="" disabled
                                            {{ empty($patient->jenis_kartu) ? 'selected' : '' }}>
                                            Pilih Jenis Kartu
                                        </option>
                                        <option value="pbi" {{ $patient->jenis_kartu == 'pbi' ? 'selected' : '' }}>
                                            PBI (KIS)
                                        </option>
                                        <option value="askes"
                                            {{ $patient->jenis_kartu == 'askes' ? 'selected' : '' }}>
                                            ASKES
                                        </option>
                                        <option value="jkn_mandiri"
                                            {{ $patient->jenis_kartu == 'jkn_mandiri' ? 'selected' : '' }}>
                                            JKN Mandiri
                                        </option>
                                        <option value="umum"
                                            {{ $patient->jenis_kartu == 'umum' ? 'selected' : '' }}>
                                            Umum
                                        </option>
                                        <option value="jkd" {{ $patient->jenis_kartu == 'jkd' ? 'selected' : '' }}>
                                            JKD
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nomor">Nomor Kartu</label>
                                    <input type="text" class="form-control" id="nomor_kartu" name="nomor_kartu"
                                        placeholder="Masukkan Nomor" value="{{ $patient->nomor_kartu }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place_birth">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="place_birth" name="place_birth"
                                        placeholder="Tempat lahir"
                                        value="{{ old('place_birth', $patient->place_birth) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="dob" name="dob"
                                        value="{{ old('dob', $patient->dob) }}" required>
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
                                                {{ old('province', $patient->indonesia_province_id) == $province->id ? 'selected' : '' }}>
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
                                                {{ old('city', $patient->indonesia_city_id) == $city->id ? 'selected' : '' }}>
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
                                        onchange="updateVillageEdit()">
                                        <option value="Manggala"
                                            {{ old('district', $patient->indonesia_district) == 'Manggala' ? 'selected' : '' }}>
                                            Manggala</option>
                                        <option value="Luar Wilayah"
                                            {{ old('district', $patient->indonesia_district) == 'Luar Wilayah' ? 'selected' : '' }}>
                                            Luar Wilayah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="village">Kelurahan/Desa</label>
                                    <select class="form-control" id="village" name="village" required>
                                        <option value="Tamangapa"
                                            {{ old('village', $patient->indonesia_village) == 'Tamangapa' ? 'selected' : '' }}>
                                            Tamangapa</option>
                                        <option value="Luar Wilayah"
                                            {{ old('village', $patient->indonesia_village) == 'Luar Wilayah' ? 'selected' : '' }}>
                                            Luar Wilayah</option>
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
                                            <option value="{{ $i }}"
                                                {{ old('rw', $patient->rw) == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                        <option value="4A"
                                            {{ old('rw', $patient->rw) == '4A' ? 'selected' : '' }}>4A
                                        </option>
                                        <option value="4B"
                                            {{ old('rw', $patient->rw) == '4B' ? 'selected' : '' }}>4B
                                            (TPA)</option>
                                        <option value="luar-wilayah"
                                            {{ old('rw', $patient->rw) == 'luar-wilayah' ? 'selected' : '' }}>Luar
                                            Wilayah
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="address">Alamat/Jalan</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Jalan" value="{{ old('address', $patient->address) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kunjungan">Kunjungan</label>
                                    <select class="form-control" id="kunjungan" name="kunjungan">
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="1"
                                            {{ old('kunjungan', $patient->kunjungan) == 1 ? 'selected' : '' }}>
                                            Baru </option>
                                        <option value="0"
                                            {{ old('kunjungan', $patient->kunjungan) == 0 ? 'selected' : '' }}>Lama
                                        </option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wilayah_faskes">Wilayah Faskes</label>
                                    <select class="form-control" id="wilayah_faskes" name="wilayah_faskes">
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="1"
                                            {{ old('wilayah_faskes', $patient->wilayah_faskes) == 1 ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="0"
                                            {{ old('wilayah_faskes', $patient->wilayah_faskes) == 0 ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateVillageEdit() {
            const district = document.getElementById('district').value;
            const village = document.getElementById('village');

            if (district === 'Luar Wilayah') {
                village.value = 'Luar Wilayah';
            } else if (district === 'Manggala') {
                village.value = 'Tamangapa';
            } else {
                village.value = '';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Check for success message
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            // Check for validation errors
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
