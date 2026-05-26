@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Data User</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah User
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Username</h6>
                                </th>
                                {{-- <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th> --}}
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Role</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Terdaftar</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-user-circle fs-5 text-primary"></i>
                                        <p class="mb-0 fw-normal">{{ $item->username }}</p>
                                    </div>
                                </td>
                                {{-- <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <i class="ti ti-mail me-1 text-muted"></i>
                                        {{ $item->email ?? '-' }}
                                    </p>
                                </td> --}}
                                <td class="border-bottom-0">
                                    @if($item->role == 'admin')
                                        <span class="badge bg-danger rounded-3 fw-semibold">
                                            <i class="ti ti-shield me-1"></i> Admin
                                        </span>
                                    @elseif($item->role == 'kasir')
                                        <span class="badge bg-success rounded-3 fw-semibold">
                                            <i class="ti ti-user-check me-1"></i> Kasir
                                        </span>
                                    @elseif($item->role == 'pemilik')
                                        <span class="badge bg-warning rounded-3 fw-semibold">
                                            <i class="ti ti-crown me-1"></i> Pemilik
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-3 fw-semibold">
                                            {{ $item->role }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-calendar text-muted"></i>
                                        <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        @if(session('id') != $item->id)
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus" 
                                                        onclick="return confirm('Yakin ingin menghapus user {{ $item->username }}?')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-info rounded-3 fw-semibold">
                                                <i class="ti ti-user me-1"></i> Anda sendiri
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-users-off fs-1 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Belum ada data user</p>
                                        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm mt-2">Tambah User Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($user, 'links'))
                    <div class="d-flex justify-content-end mt-4">
                        {{ $user->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush