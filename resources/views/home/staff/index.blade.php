@extends('layouts.master')
@section('title', 'Staff')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="/"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Staff</li>
            </ol>
        </nav>
        <h2 class="h4">Data Staff</h2>
        {{-- <p class="mb-0">Staff yang telah tersimpan.</p> --}}
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/staff/tambah" class="btn btn-secondary btn-sm me-2">
            <span class="fas fa-plus me-2"></span>Tambah Staff
        </a>
    </div>
</div>
<div class="card card-body shadow-sm table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Kuota Cuti</th>
                <th>Sisa Cuti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $staff)
            <tr>
                <td>{{ $staff->id }}</td>
                <td>{{ $staff->nama }}</td>
                <td>{{ $staff->posisi }}</td>
                <td>{{ $staff->kuota_cuti }}</td>
                <td>{{ $staff->sisa_cuti }}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                        </button>
                        <div class="dropdown-menu" style="min-width: 120px; max-width: 150px; font-size: 0.85rem; padding: 0.3rem;">
                            <a class="dropdown-item" href="/staff/{{ $staff->id }}/show" style="padding: 0.2rem 0.4rem;">
                                <span class="fas fa-edit me-1"></span>Edit
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ $staff->id }}')" style="padding: 0.2rem 0.4rem;">
                                <span class="fas fa-trash-alt me-1"></span>Hapus
                            </a>
                            <form id="delete-form-{{ $staff->id }}" action="/staff/{{ $staff->id }}/delete" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
        });
    </script>
    @endif

</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endsection
