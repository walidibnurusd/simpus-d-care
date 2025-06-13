<div class="modal fade" id="addObatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="createObatForm">
        @csrf
        <div class="modal-header"><h5>Buat Data Obat</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" id="add-obat-name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kode <span class="text-danger">*</span></label>
                    <input type="text" id="add-obat-code" name="code" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Bentuk <span class="text-danger">*</span></label>
                    <select name="shape" id="add-obat-shape" class="form-control" required>
                        <option value="">-- Pilih Bentuk</option>
                        <option value="1">Tablet</option>
                        <option value="2">Botol</option>
                        <option value="3">Pcs</option>
                        <option value="4">Suppositoria</option>
                        <option value="5">Ovula</option>
                        <option value="6">Drop</option>
                        <option value="7">Tube</option>
                        <option value="8">Pot</option>
                        <option value="9">Injeksi</option>
                        <option value="10">Kapsul</option>
                        <option value="11">Ampul</option>
                        <option value="12">Sachet</option>
                        <option value="13">Paket</option>
                        <option value="14">Vial</option>
                        <option value="15">Bungkus</option>
                        <option value="16">Strip</option>
                        <option value="17">Test</option>
                        <option value="18">Lbr</option>
                        <option value="19">Tabung</option>
                        <option value="20">Buah</option>
                        <option value="21">Lembar</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Amount <span class="text-danger">*</span></label>
                    <input type="text" id="add-obat-amount" name="amount" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>