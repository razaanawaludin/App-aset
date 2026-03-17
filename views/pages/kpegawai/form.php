<?php

    PageHeader(
        "Pegawai",
        ($ak=="tambah")?"Tambahkan data baru pegawai":"Ubah data pegawai",
       buttonhref("?pg=$pg&fl=list","Kembali","primary","circle-chevron-left",$attbr="")
    );

    $BtnSimpan = button("btn","Simpan","primary","save","");

    if($ak == "tambah"){
        $passwordFieldHTML = <<<html
            <input type="password" name="password" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Masukan Password" style="border-radius: 10px;" required>
html;
    } else {
        $passwordFieldHTML = <<<html
            <div class="input-group">
                <input type="password" id="inputPassword" name="password" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Kosongkan jika tidak diubah" style="border-radius: 10px 0 0 10px;">
                <button type="button" class="btn btn-warning fw-bold text-white px-4" style="border-radius: 0 10px 10px 0;" onclick="generatePassword()">
                    <i data-lucide="refresh-cw" style="width: 18px; margin-right: 4px; margin-top: -2px;"></i>Reset
                </button>
            </div>
html;
    }

    PageContentForm(
        <<<a1
            <form method="POST"> 
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Username</label>
                        <input type="text" name="username" value="{$username_val}" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Masukan Username" style="border-radius: 10px;" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Nama Lengkap</label>
                        <input type="text" name="nama" value="{$nama_val}" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Nama sesuai KTP" style="border-radius: 10px;" required>
                    </div>
                </div>
                <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Password</label>
                        $passwordFieldHTML
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary mb-3" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Jenis Kelamin</label>
                    <div class="row g-3">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="gender" id="genderL" value="L" {$CGenderL}>
                            <label class="btn btn-outline-light bg-light border-0 text-start w-100 p-3 d-flex align-items-center justify-content-between text-dark" for="genderL" style="border-radius: 12px; transition: all 0.2s;">
                                <span class="d-flex align-items-center gap-2 fw-medium">
                                    <i data-lucide="user" class="text-primary" style="width: 18px;"></i> Laki-laki
                                </span>
                                <i data-lucide="check-circle-2" class="text-primary check-icon" style="width: 18px;"></i>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="gender" id="genderP" value="P" {$CGenderP}>
                            <label class="btn btn-outline-light bg-light border-0 text-start w-100 p-3 d-flex align-items-center justify-content-between text-dark" for="genderP" style="border-radius: 12px; transition: all 0.2s;">
                                <span class="d-flex align-items-center gap-2 fw-medium">
                                    <i data-lucide="user-circle-2" class="text-danger" style="width: 18px;"></i> Perempuan
                                </span>
                                <i data-lucide="check-circle-2" class="text-danger check-icon" style="width: 18px;"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="gap-2 pb-3">
                    $BtnSimpan
                </div>

            </form>
        a1
    );

?>

      
<style>
    /* Membuat efek border ketika radio button dipilih */
    .btn-check:checked + .btn {
        background-color: #eef2ff !important; /* Biru sangat muda */
        border: 1px solid #4f46e5 !important;
        color: #4f46e5 !important;
    }
    .btn-check:not(:checked) + .btn .check-icon {
        display: none;
    }
</style>

<script>
    function generatePassword() {
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        var passwordLength = 8;
        var password = "";
        for (var i = 0; i < passwordLength; i++) {
            var randomNumber = Math.floor(Math.random() * chars.length);
            password += chars.substring(randomNumber, randomNumber + 1);
        }
        var passwordField = document.getElementById("inputPassword");
        if(passwordField) {
            passwordField.value = password;
            passwordField.type = "text"; // Show the generated password to the user
        }
    }
</script>