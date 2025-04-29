<!-- Create User Details Modal -->
<div class="modal fade" id="editEmployeeModal{{ $user->id }}" tabindex="-1"
    aria-labelledby="createUserDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserDetailsModalLabel">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employee.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required
                                    placeholder="NIP" value="{{ old('nip', $user->nip) }}">
                            </div>
                            <div class="form-group">
                                <label for="employee_name">Nama Pegawai</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name"
                                    required placeholder="Nama Pegawai"
                                    value="{{ old('employee_name', $user->detail->employee_name) }}">
                            </div>
                            <div class="form-group">
                                <label for="phone_wa">Telepon/WA</label>
                                <input type="text" class="form-control" id="phone_wa" name="phone_wa" required
                                    placeholder="Telepon/WA" value="{{ old('phone_wa', $user->detail->phone_wa) }}">
                            </div>
                            <div class="form-group">
                                <label for="place_of_birth">Tempat Lahir</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                                    required placeholder="Tempat Lahir"
                                    value="{{ old('place_of_birth', $user->detail->place_of_birth) }}">
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    required
                                    value="{{ old('date_of_birth', $user->detail->date_of_birth ? \Carbon\Carbon::parse($user->detail->date_of_birth)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="form-group">
                                <label for="current_address">Alamat Sekarang</label>
                                <input type="text" class="form-control" id="current_address" name="current_address"
                                    required placeholder="Alamat Sekarang"
                                    value="{{ old('current_address', $user->detail->current_address) }}">
                            </div>
                            <div class="form-group">
                                <label for="education">Pendidikan</label>
                                <select class="form-control" id="education" name="education" required>
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach ($educations as $education)
                                        <option value="{{ $education->id }}"
                                            {{ $user->detail->education == $education->id ? 'selected' : '' }}>
                                            {{ $education->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="profession">Profesi</label>
                                <select class="form-control" id="profession" name="profession" required>
                                    <option value="">Pilih Profesi</option>
                                    @foreach ($professions as $profession)
                                        <option value="{{ $profession->id }}"
                                            {{ $user->detail->profession == $profession->id ? 'selected' : '' }}>
                                            {{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="photo">Foto</label>
                                @if ($user->detail->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->detail->photo) }}" alt="Existing Photo"
                                            class="img-thumbnail" style="max-width: 50%; height: auto;">
                                    </div>
                                @endif

                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ $user->detail->gender == $gender->id ? 'selected' : '' }}>
                                            {{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="religion">Agama</label>
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}"
                                            {{ $user->detail->religion == $religion->id ? 'selected' : '' }}>
                                            {{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marrital_status">Status Pernikahan</label>
                                <select class="form-control" id="marrital_status" name="marrital_status" required>
                                    <option value="">Pilih Status Pernikahan</option>
                                    @foreach ($maritalStatuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $user->detail->marrital_status == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employee_status">Status Pegawai</label>
                                <select class="form-control" id="employee_status" name="employee_status" required>
                                    <option value="">Pilih Status Pegawai</option>
                                    @foreach ($employeeStatuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $user->detail->employee_status == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position">Jabatan</label>
                                <select class="form-control" id="position" name="position" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            {{ $user->detail->position == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rank">Pangkat</label>
                                <select class="form-control" id="rank" name="rank" required>
                                    <option value="">Pilih Pangkat</option>
                                    @foreach ($ranks as $rank)
                                        <option value="{{ $rank->id }}"
                                            {{ $user->detail->rank == $rank->id ? 'selected' : '' }}>
                                            {{ $rank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="tmt_pangkat">TMT Pangkat</label>
                                    <input type="date" class="form-control" id="tmt_pangkat" name="tmt_pangkat"
                                        required
                                        value="{{ old('tmt_pangkat', $user->detail->tmt_pangkat ? \Carbon\Carbon::parse($user->detail->tmt_pangkat)->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="group">Golongan</label>
                                    <select class="form-control" id="group" name="group" required>
                                        <option value="">Pilih Golongan</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}"
                                                {{ $user->detail->group == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="tmt_golongan">TMT Golongan</label>
                                    <input type="date" class="form-control" id="tmt_golongan" name="tmt_golongan"
                                        required
                                        value="{{ old('tmt_golongan', $user->detail->tmt_golongan ? \Carbon\Carbon::parse($user->detail->tmt_golongan)->format('Y-m-d') : '') }}">
                                </div>


                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
