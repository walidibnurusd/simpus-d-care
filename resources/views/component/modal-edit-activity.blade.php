@php
    $master = new App\Http\Controllers\DependentDropDownController();
    $programs = $master->programData();
    $services = $master->serviceData();
    $months = [
        'Januari' => 'Januari',
        'Februari' => 'Februari',
        'Maret' => 'Maret',
        'April' => 'April',
        'Mei' => 'Mei',
        'Juni' => 'Juni',
        'Juli' => 'Juli',
        'Agustus' => 'Agustus',
        'September' => 'September',
        'Oktober' => 'Oktober',
        'November' => 'November',
        'Desember' => 'Desember',
    ];
@endphp


<div class="modal fade" style="z-index: 9999;" id="editActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addActivityForm" action="{{ route('activity.update', $activity->id) }}" method="POST"
                    class="px-3">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="program">Program</label>
                                <select class="form-control" id="program" name="program" required>
                                    <option value="">Pilih</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}"
                                            {{ old('program', $activity->program) == $program->id ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Bulan</label>
                                <select class="form-control" id="month" name="month" required>
                                    <option value="">Pilih Bulan</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}"
                                            {{ old('month', $activity->month) == $key ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="year">Tahun</label>
                                <input type="text" class="form-control" id="year" name="year"
                                    placeholder="Tahun" value="{{ old('year', $activity->year) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service">Layanan</label>
                                <select class="form-control" id="service" name="service" required>
                                    <option value="">Pilih</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service', $activity->service) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Nama Kegiatan</label>
                                <div style="position: relative;">
                                    <textarea class="form-control" id="name" name="name" placeholder="Nama Kegiatan" required>{{ old('name', $activity->name) }}</textarea>
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
