@extends('layouts.master')
@section('title', 'User Edit')
@section('content')
    <style>
        .profile-edit {
            padding: 2rem; /* Sesuaikan padding sesuai kebutuhan */
        }

        .profile-picture {
            width: 120px; /* Ukuran lingkaran foto profil */
            height: 120px;
            margin: 0 auto 1rem;
            overflow: hidden;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-edit h4 {
            font-size: 1.5rem; /* Ukuran font judul */
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-edit p {
            font-size: 0.9rem; /* Ukuran font deskripsi */
            color: #6c757d;
        }

        .card {
            border-radius: 8px; /* Sudut kartu */
        }

        .btn {
            border-radius: 30px;
            font-size: 0.875rem; /* Ukuran font tombol */
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem; /* Jarak antar tombol */
        }
    </style>


    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Menggunakan col-md-8 untuk mengurangi lebar -->
            <div class="card border-light shadow-sm">
                <div class="card-body profile-edit">
                    <div class="text-center mb-4">
                        <!-- Foto Profil -->
                        <div class="profile-picture">
                            <img src="{{ asset('assets/images/user.png') }}" alt="User Image" class="rounded-circle">
                        </div>
                        <h4>{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->posisi }}</p>
                    </div>
                    <!-- Form Edit -->
                    <form action="/user/{{ $user->id }}/update" method="post">
                        @csrf
                        <!-- Edit Nama -->
                        <div class="mb-3">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
                        </div>
                        <!-- Edit Username -->
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                        </div>
                        <!-- Edit Email -->
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                            <small class="form-text text-muted">Kami tidak akan membagikan email Anda kepada orang lain.</small>
                        </div>
                        <!-- Edit Password -->
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="{{ $user->password}}">
                        </div>
                        <!-- Edit Posisi -->
                        <div class="mb-3">
                            <label for="posisi">Posisi</label>
                            <input type="text" class="form-control" name="posisi" id="posisi" value="{{ $user->posisi }}" required>
                        </div>
                        <!-- Tombol Kembali dan Simpan Update -->
                        <div class="action-buttons">
                            <a href="/user" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
