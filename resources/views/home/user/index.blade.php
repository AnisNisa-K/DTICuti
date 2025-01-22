@extends('layouts.master')
@section('title', 'User')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="/"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Admin</li>
            </ol>
        </nav>
        <h2 class="h4">Data Admin</h2>
        {{-- <p class="mb-0">User yang telah tersimpan.</p> --}}
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/user/tambah" class="btn btn-secondary btn-sm me-2">
            <span class="fas fa-plus me-2"></span>Tambah Admin
        </a>
    </div>
</div>
<div class="card card-body shadow-sm table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                {{-- <th>Password</th> --}}
                <th>Posisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>   <img src="{{ asset('assets/images/user.png') }}" alt="User Image" class="rounded-circle" width="50"></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                {{-- <td>{{ $user->password }}</td> --}}
                <td>{{ $user->posisi }}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu py-0">
                            <a class="dropdown-item text-danger rounded-bottom" href="#" onclick="confirmDelete('{{ $user->id }}')">
                                <span class="fas fa-trash-alt me-2"></span>Hapus
                            </a>
                            <form id="delete-form-{{ $user->id }}" action="/user/{{ $user->id }}/delete" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
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
@endsection

