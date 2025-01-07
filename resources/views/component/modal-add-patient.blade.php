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

<div class="modal fade" style="z-index: 9999;" id="addPatientModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    placeholder="NIK" required>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telpon/WA</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Telpon/WA" required>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="klaster">Klaster</label>
                                <select class="form-control" id="klaster" name="klaster">
                                    <option value="">Pilih</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="poli">Poli</label>
                                <select class="form-control" id="poli" name="poli" required>
                                    <option value="" disabled selected>Pilih</option>
                                    {{-- <option value="kia">KIA</option>
                                    <option value="mtbs">MTBS</option>
                                    <option value="lansia">Lansia</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                                <select class="form-control" id="province" name="province" required>
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
                                <select class="form-control" id="city" name="city" required>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="no_rm">NOMOR RM</label>
                                <input type="text" class="form-control" id="no_rm" name="no_rm"
                                    placeholder="Nomor RM" required>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    var $j = jQuery.noConflict();
    $j(document).ready(function() {
        $j('#province').change(function() {
            var provinceId = $j(this).val();
            var citySelect = $j('#city');

            if (provinceId) {
                $j.ajax({
                    url: "{{ url('/cities') }}/" + provinceId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        citySelect.empty();
                        citySelect.append('<option value="">Pilih</option>');
                        $j.each(data, function(key, value) {
                            citySelect.append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                        $j('#district').empty().append('<option value="">Pilih</option>');
                        $j('#village').empty().append('<option value="">Pilih</option>');
                    },
                    error: function() {
                        alert('Gagal mengambil data kota/kabupaten');
                    }
                });
            } else {
                citySelect.empty();
                citySelect.append('<option value="">Pilih</option>');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const klasterSelect = document.getElementById('klaster'); // Dropdown klaster
        const poliSelect = document.getElementById('poli'); // Dropdown poli

        // Fungsi untuk memperbarui opsi poli berdasarkan klaster yang dipilih
        function updatePoliOptions() {
            const selectedKlaster = klasterSelect.value; // Ambil nilai klaster yang dipilih

            // Kosongkan semua opsi di poli
            poliSelect.innerHTML = '';

            // Logika untuk memperbarui dropdown poli berdasarkan klaster
            if (selectedKlaster === '2') {
                // Opsi untuk Klaster 2
                poliSelect.innerHTML += '<option value="kia">KIA</option>';
                poliSelect.innerHTML += '<option value="mtbs">MTBS</option>';
            } else if (selectedKlaster === '3') {
                // Opsi untuk Klaster 3
                poliSelect.innerHTML += '<option value="lansia">Lansia</option>';
            } else {
                // Jika tidak ada klaster dipilih, tambahkan placeholder
                poliSelect.innerHTML = '<option value="" disabled selected>Pilih</option>';
            }
        }

        // Event listener untuk perubahan pada dropdown klaster
        klasterSelect.addEventListener('change', updatePoliOptions);

        // Panggil fungsi saat halaman dimuat (untuk mengatur nilai awal dropdown poli)
        updatePoliOptions();

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
