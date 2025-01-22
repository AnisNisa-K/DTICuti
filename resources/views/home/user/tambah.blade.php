@extends('layouts.master')

@section('title', 'User    Tambah')

@section('content')
    <h2 class="card-title"> Halaman Tambah Data Admin</h2>
    <a href="/user" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    <br> <br>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <form action="/user/simpan" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Form Username -->
                        <div class="mb-4">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <small id="emailHelp" class="form-text text-muted">Kami tidak akan pernah membagikan email Anda kepada orang lain.</small>
                        </div>
                        <!-- Edit Password -->
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                <span class="input-group-text" id="basic-addon3"><i class="fas fa-unlock-alt"></i></span> <!-- Ikon kunci -->
                            </div>
                        </div>
                        <!-- Posisi -->
                        <div class="mb-4">
                            <label for="posisi">Posisi</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" required>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
