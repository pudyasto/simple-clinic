<style>
.form-control:disabled, .form-control[readonly] {
    background-color: #fff;
}
</style>
<input type="hidden" name="riwayat_pasien_id" id="riwayat_pasien_id" value="{{ isset($pasien->id) ? $pasien->id : '' }}">
<input type="hidden" name="riwayat_registrasi_id" id="riwayat_registrasi_id" value="{{ isset($registrasi_id) ? $registrasi_id : '' }}">

<div class="table-responsive">
    <table id="tableRiwayat" class="display">
        <thead>
            <tr>
                <th style="width: 90px;">Tanggal</th>
                <th style="width: 90px;">No. Reg</th>
                <th style="width: 90px;">No. RM</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Keluhan</th>
                <th style="width: 120px;text-align: center;">Preview</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tanggal</th>
                <th>No. Reg</th>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Keluhan</th>
                <th>ID</th>
            </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
</div>
<div class="riwayat-pasien" style="display: none;">
    <hr>
    <div class="media">
        <div class="media-body">
            <p>
                No. RM : <span class="pasien-norm"></span>
                / Gol Darah : <span class="pasien-goldarah"></span>
                / <span class="pasien-kelamin"></span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-6 alert-alergi" style="display: none;">
            <div class="alert alert-info">
                Riwayat Alergi :<br>
                <span class="pasien-alergi"></span>
            </div>
        </div>
        <div class="col-6 alert-penyakit" style="display: none;">
            <div class="alert alert-info">
                Riwayat Penyakit :<br>
                <span class="pasien-penyakit"></span>
            </div>
        </div>

        <div class="col-12">
            <div class="alert alert-primary alert-keluhan">
                Keluhan / Keperluan :<br>
                <strong>
                    <span class="pasien-keluhan"></span>
                </strong>
            </div>
        </div>
    </div>

    <div class="job-description">
        <h6 class="mb-1">Pemeriksaan Fisik</h6>
        <div class="row">
            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_td_mm">Tekanan Darah :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_td_mm" id="riwayat_fisik_td_mm" readonly>
                        <span class="input-group-text">/</span>
                        <input class="form-control" type="text" name="riwayat_fisik_td_hg" id="riwayat_fisik_td_hg" readonly>
                        <span class="input-group-text">mmHg</span>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_nadi">Denyut Nadi :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_nadi" id="riwayat_fisik_nadi" readonly>
                        <span class="input-group-text">x/menit</span>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_nafas">Pernafasan :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_nafas" id="riwayat_fisik_nafas" readonly>
                        <span class="input-group-text">x/menit</span>
                    </div>
                </div>
            </div>


            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_suhu">Suhu Tubuh :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_suhu" id="riwayat_fisik_suhu" readonly>
                        <span class="input-group-text">°C</span>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_tb">Tinggi Badan :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_tb" id="riwayat_fisik_tb" readonly>
                        <span class="input-group-text">cm</span>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-4">
                    <label class="form-label" for="fisik_bb">Berat Badan :</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="riwayat_fisik_bb" id="riwayat_fisik_bb" readonly>
                        <span class="input-group-text">Kg</span>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-4">
                    <label class="form-label" for="diagnosa_utama">Diagnosa Primer :</label>
                    <input class="form-control" type="text" name="riwayat_diagnosa_utama" id="riwayat_diagnosa_utama" readonly>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label" for="diagnosa_sekunder_1">Diagnosa Sekunder 1 :</label>
                            <input class="form-control" type="text" name="riwayat_diagnosa_sekunder_1" id="riwayat_diagnosa_sekunder_1" readonly>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label" for="diagnosa_sekunder_2">Diagnosa Sekunder 2 :</label>
                            <input class="form-control" type="text" name="riwayat_diagnosa_sekunder_2" id="riwayat_diagnosa_sekunder_2" readonly>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="mb-4">
                    <label class="form-label" for="ringkasan">Ringkasan riwayat penyakit dan pemeriksaan fisik :</label>
                    <textarea rows="3" name="riwayat_ringkasan" id="riwayat_ringkasan" class="form-control " readonly></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-4">
                    <label class="form-label" for="ket_diagnosa_sekunder">Keterangan Diagnosa Sekunder :</label>
                    <textarea rows="3" name="riwayat_ket_diagnosa_sekunder" id="riwayat_ket_diagnosa_sekunder" class="form-control " readonly></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive mb-4">
                    <table id="tableRiwayatTindakan" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No.</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="daftar-tindakan">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive mb-4">
                    <table id="tableRiwayatBarang" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No.</th>
                                <th>Nama Obat</th>
                                <th style="width: 90px;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="daftar-resep">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive mb-4">
                    <table id="tableRiwayatPenunjang" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No.</th>
                                <th>File Pendukung</th>
                            </tr>
                        </thead>
                        <tbody class="daftar-penunjang">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
    Tutup
</button>
<script src="{{ asset('/js/registrasi-formRiwayat.js?v='.rand(1,999)) }}"></script>