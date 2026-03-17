<div class="col-lg-6 login-form-section">
    <div class="form-wrapper">
        <div class="brand-icon">
            <!-- <center><img src="images/<?= $logo ?>" width="100"></center> -->
        </div>
        <div class='text-center'>
            <h2 class="fw-bold text-dark mb-2">Masuk ke Akun</h2>
            <p class="text-muted mb-4">Selamat datang kembali! Silakan masukkan detail Anda</p>
        </div>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Username</label>
                <input type="text" class="form-control" name="user">
            </div>
            
            <div class="mb-3">  
                    <label class="form-label small fw-bold text-secondary">Password</label>
                <input type="password" class="form-control" name="pwd">
            </div>

            <input type="submit" class="btn btn-login w-100" value="Sign in" name="tombol" />
        </form>
        
    </div>
</div>