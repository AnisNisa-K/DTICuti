@extends('layouts.master')
@section('title', 'Cuti')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="/"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Cuti</li>
            </ol>
        </nav>
        <h2 class="h4">Data Cuti</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/cuti/tambah" class="btn btn-secondary btn-sm me-2">
            <span class="fas fa-plus me-2"></span>Tambah Cuti
        </a>
    </div>
</div>

<div class="card card-body shadow-sm table-wrapper table-responsive">
    <form id="bulk-delete-form" action="{{ route('cuti.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Admin</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuti as $item)
                <tr>
                    <td><input type="checkbox" name="selected[]" value="{{ $item->id }}"></td>
                    <td>{{ $item->id }}</td>
                    <td>{{ optional($item->user)->name }}</td>
                    <td>{{ optional($item->staff)->nama }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon icon-sm">
                                    <span class="fas fa-ellipsis-h icon-dark"></span>
                                </span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('cuti.detail', $item->id) }}">
                                    <span class="fas fa-eye me-2"></span>Lihat
                                </a>
                                <a class="dropdown-item text-danger" href="/cuti/{{ $item->id }}/delete" onclick="confirmSingleDelete(event)">
                                    <span class="fas fa-trash-alt me-2"></span>Hapus
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-danger mt-3" onclick="confirmDelete()">Hapus Terpilih</button>
    </form>
</div>

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

<script>
    // Select All Checkbox
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Bulk Delete Confirmation
    function confirmDelete() {
        const selected = [];
        document.querySelectorAll('input[name="selected[]"]:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });

        if (selected.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada item terpilih',
                text: 'Silakan pilih item yang ingin dihapus terlebih dahulu.',
            });
            return;
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua item yang dipilih akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-form').submit();
            }
        });
    }

    // Single Delete Confirmation
    function confirmSingleDelete(event) {
        event.preventDefault(); // Prevent direct navigation
        const url = event.currentTarget.href; // Get URL from link
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirect to URL if confirmed
            }
        });
    }
</script>

@endsection
