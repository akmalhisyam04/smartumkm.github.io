@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Tambah User</h5>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                           value="{{ old('username') }}" placeholder="Masukkan username" required>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Username harus unik, minimal 3 karakter.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-mail"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Email harus valid dan unik.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Masukkan password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Password minimal 6 karakter.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-lock"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                           placeholder="Konfirmasi password" required>
                                </div>
                                <div class="form-text">Ketik ulang password yang sama.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        <i class="ti ti-shield"></i> Admin - Akses penuh ke semua fitur
                                    </option>
                                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                                        <i class="ti ti-user-check"></i> Kasir - Akses transaksi dan pelanggan
                                    </option>
                                    <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>
                                        <i class="ti ti-crown"></i> Pemilik - Akses laporan dan monitoring
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Informasi Role:</strong>
                        <ul class="mb-0 mt-2">
                            <li><span class="badge bg-danger">Admin</span> - Memiliki akses penuh ke semua fitur termasuk manajemen user</li>
                            <li><span class="badge bg-success">Kasir</span> - Hanya dapat mengakses transaksi dan detail transaksi</li>
                            <li><span class="badge bg-warning">Pemilik</span> - Dapat melihat laporan dan monitoring data</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ route('user.index') }}" class="btn btn-danger">
                            <i class="ti ti-x me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('ti-eye');
            this.querySelector('i').classList.toggle('ti-eye-off');
        });
    }

    // Password confirmation validation
    const passwordConfirmation = document.getElementById('password_confirmation');
    if (password && passwordConfirmation) {
        function validatePasswordMatch() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Password tidak cocok!');
                passwordConfirmation.classList.add('is-invalid');
            } else {
                passwordConfirmation.setCustomValidity('');
                passwordConfirmation.classList.remove('is-invalid');
            }
        }
        
        password.addEventListener('change', validatePasswordMatch);
        passwordConfirmation.addEventListener('keyup', validatePasswordMatch);
    }
</script>
@endpush