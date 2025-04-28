<!-- Create User Details Modal -->
<div class="modal fade" id="createUserDetailsModal" tabindex="-1" aria-labelledby="createUserDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserDetailsModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required
                                    placeholder="NIP">
                            </div>
                            <div class="form-group">
                                <label for="employee_name">Nama Pegawai</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name"
                                    required placeholder="Nama Pegawai">
                            </div>
                            <div class="form-group">
                                <label for="phone_wa">Telepon/WA</label>
                                <input type="text" class="form-control" id="phone_wa" name="phone_wa" required
                                    placeholder="Telepon/WA">
                            </div>
                            <div class="form-group">
                                <label for="place_of_birth">Tempat Lahir</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                                    required placeholder="Tempat Lahir">
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="current_address">Alamat Sekarang</label>
                                <input type="text" class="form-control" id="current_address" name="current_address"
                                    required placeholder="Alamat Sekarang">
                            </div>
                            <div class="form-group">
                                <label for="education">Pendidikan</label>
                                <select class="form-control" id="education" name="education" required>
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach ($educations as $education)
                                        <option value="{{ $education->id }}">{{ $education->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="profession">Profesi</label>
                                <select class="form-control" id="profession" name="profession" required>
                                    <option value="">Pilih Profesi</option>
                                    @foreach ($professions as $profession)
                                        <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="photo">Foto</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="religion">Agama</label>
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marrital_status">Status Pernikahan</label>
                                <select class="form-control" id="marrital_status" name="marrital_status" required>
                                    <option value="">Pilih Status Pernikahan</option>
                                    @foreach ($maritalStatuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employee_status">Status Pegawai</label>
                                <select class="form-control" id="employee_status" name="employee_status" required>
                                    <option value="">Pilih Status Pegawai</option>
                                    @foreach ($employeeStatuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position">Jabatan</label>
                                <select class="form-control" id="position" name="position" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rank">Pangkat</label>
                                <select class="form-control" id="rank" name="rank" required>
                                    <option value="">Pilih Pangkat</option>
                                    @foreach ($ranks as $rank)
                                        <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="tmt_pangkat">TMT Pangkat</label>
                                    <input type="date" class="form-control" id="tmt_pangkat" name="tmt_pangkat"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="group">Golongan</label>
                                    <select class="form-control" id="group" name="group" required>
                                        <option value="">Pilih Golongan</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="tmt_golongan">TMT Golongan</label>
                                    <input type="date" class="form-control" id="tmt_golongan" name="tmt_golongan"
                                        required>
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
