@extends('layouts.app')

@section('title', 'Profil Saya - Thomy Showroom')

@section('content')

<style>
    .profile-page {
        padding: 52px 0 80px;
        min-height: calc(100vh - 86px);
    }

    .profile-heading {
        margin-bottom: 28px;
    }

    .profile-kicker {
        color: #c98500;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.2px;
        margin-bottom: 6px;
    }

    .profile-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #17212c;
    }

    .profile-subtitle {
        color: #718096;
        margin-bottom: 0;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .profile-sidebar {
        background: #17212c;
        border-radius: 20px;
        padding: 24px;
        color: white;
        position: sticky;
        top: 105px;
    }

    .profile-avatar-large {
        width: 74px;
        height: 74px;
        border-radius: 22px;
        background: linear-gradient(
            135deg,
            #ffbf2f,
            #f5a900
        );
        color: #17212c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .profile-sidebar-name {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 4px;
        word-break: break-word;
    }

    .profile-sidebar-email {
        color: #aeb8c2;
        font-size: 13px;
        margin-bottom: 24px;
        word-break: break-word;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .profile-role i {
        color: #ffbf2f;
    }

    .profile-main {
        display: grid;
        gap: 22px;
    }

    .profile-card {
        background: white;
        border: 1px solid #e6e9ed;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 12px 35px rgba(15, 23, 42, .05);
    }

    .profile-card-danger {
        border-color: #fee2e2;
    }

    .profile-card-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 26px;
    }

    .profile-card-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 14px;
        background: #fff7df;
        color: #d99200;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .profile-card-icon.password {
        background: #eef6ff;
        color: #2774c7;
    }

    .profile-card-icon.danger {
        background: #fff1f2;
        color: #dc3545;
    }

    .profile-card-title {
        font-size: 18px;
        font-weight: 800;
        color: #17212c;
        margin: 0 0 4px;
    }

    .profile-card-description {
        color: #7b8794;
        font-size: 14px;
        margin: 0;
    }

    .profile-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .profile-form-group.full {
        grid-column: 1 / -1;
    }

    .profile-label {
        display: block;
        color: #344050;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .profile-input {
        width: 100%;
        height: 50px;
        border: 1px solid #dfe4ea !important;
        border-radius: 12px !important;
        background: #fff !important;
        color: #17212c !important;
        padding: 0 15px;
        outline: none;
        box-shadow: none !important;
    }

    .profile-input::placeholder {
        color: #a4adb8;
    }

    .profile-input:focus {
        border-color: #f5a900 !important;
        box-shadow: 0 0 0 4px rgba(245, 169, 0, .12) !important;
    }

    .profile-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 7px;
    }

    .profile-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 24px;
    }

    .profile-save-btn {
        border: 0;
        background: #f5a900;
        color: #17212c;
        font-weight: 800;
        padding: 12px 22px;
        border-radius: 12px;
        transition: .2s ease;
    }

    .profile-save-btn:hover {
        background: #ffbf2f;
        transform: translateY(-1px);
    }

    .profile-saved {
        color: #198754;
        font-size: 13px;
        font-weight: 700;
    }

    .profile-danger-text {
        color: #7b8794;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .profile-delete-btn {
        border: 1px solid #dc3545;
        background: white;
        color: #dc3545;
        font-weight: 700;
        padding: 11px 18px;
        border-radius: 12px;
    }

    .profile-delete-btn:hover {
        background: #dc3545;
        color: white;
    }

    @media (max-width: 991px) {

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            position: static;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .profile-avatar-large {
            margin-bottom: 0;
        }

        .profile-sidebar-email {
            margin-bottom: 12px;
        }

    }

    @media (max-width: 767px) {

        .profile-page {
            padding: 30px 0 100px;
        }

        .profile-title {
            font-size: 26px;
        }

        .profile-card {
            padding: 20px;
        }

        .profile-form-grid {
            grid-template-columns: 1fr;
        }

        .profile-form-group.full {
            grid-column: auto;
        }

        .profile-sidebar {
            display: block;
        }

        .profile-avatar-large {
            margin-bottom: 18px;
        }

        .profile-card-header {
            gap: 10px;
        }

    }
</style>


<section class="profile-page">

    <div class="container">

        <div class="profile-heading">

            <div class="profile-kicker">
                AKUN
            </div>

            <h1 class="profile-title">
                Profil Saya
            </h1>

            <p class="profile-subtitle">
                Kelola informasi akun dan keamanan Anda.
            </p>

        </div>


        <div class="profile-grid">


            <aside class="profile-sidebar">

                <div class="profile-avatar-large">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>


                <div>

                    <div class="profile-sidebar-name">
                        {{ auth()->user()->name }}
                    </div>


                    <div class="profile-sidebar-email">
                        {{ auth()->user()->email }}
                    </div>


                    <div class="profile-role">

                        <i class="fa-solid fa-shield-halved"></i>

                        {{ auth()->user()->role === 'admin'
                            ? 'Administrator'
                            : 'Pengguna' }}

                    </div>

                </div>

            </aside>


            <div class="profile-main">


                {{-- INFORMASI PROFIL --}}
                <div class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-card-icon">

                            <i class="fa-regular fa-user"></i>

                        </div>


                        <div>

                            <h2 class="profile-card-title">
                                Informasi Profil
                            </h2>

                            <p class="profile-card-description">
                                Perbarui nama dan alamat email akun Anda.
                            </p>

                        </div>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('profile.update') }}"
                    >

                        @csrf

                        @method('PATCH')


                        <div class="profile-form-grid">


                            <div class="profile-form-group">

                                <label
                                    for="name"
                                    class="profile-label"
                                >
                                    Nama Lengkap
                                </label>


                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="profile-input"
                                    value="{{ old(
                                        'name',
                                        auth()->user()->name
                                    ) }}"
                                    required
                                    autofocus
                                >


                                @error('name')

                                    <div class="profile-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="profile-form-group">

                                <label
                                    for="email"
                                    class="profile-label"
                                >
                                    Email
                                </label>


                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    class="profile-input"
                                    value="{{ old(
                                        'email',
                                        auth()->user()->email
                                    ) }}"
                                    required
                                >


                                @error('email')

                                    <div class="profile-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        <div class="profile-actions">

                            <button
                                type="submit"
                                class="profile-save-btn"
                            >

                                <i class="fa-solid fa-check me-2"></i>

                                Simpan Perubahan

                            </button>


                            @if(
                                session('status') ===
                                'profile-updated'
                            )

                                <span class="profile-saved">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Perubahan berhasil disimpan

                                </span>

                            @endif

                        </div>

                    </form>

                </div>


                {{-- UBAH PASSWORD --}}
                <div class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-card-icon password">

                            <i class="fa-solid fa-lock"></i>

                        </div>


                        <div>

                            <h2 class="profile-card-title">
                                Ubah Password
                            </h2>

                            <p class="profile-card-description">
                                Gunakan password yang kuat untuk menjaga
                                keamanan akun Anda.
                            </p>

                        </div>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('password.update') }}"
                    >

                        @csrf

                        @method('PUT')


                        <div class="profile-form-grid">


                            <div class="profile-form-group full">

                                <label
                                    for="current_password"
                                    class="profile-label"
                                >
                                    Password Saat Ini
                                </label>


                                <input
                                    id="current_password"
                                    name="current_password"
                                    type="password"
                                    class="profile-input"
                                    autocomplete="current-password"
                                >


                                @error(
                                    'current_password',
                                    'updatePassword'
                                )

                                    <div class="profile-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="profile-form-group">

                                <label
                                    for="password"
                                    class="profile-label"
                                >
                                    Password Baru
                                </label>


                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="profile-input"
                                    autocomplete="new-password"
                                >


                                @error(
                                    'password',
                                    'updatePassword'
                                )

                                    <div class="profile-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="profile-form-group">

                                <label
                                    for="password_confirmation"
                                    class="profile-label"
                                >
                                    Konfirmasi Password Baru
                                </label>


                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="profile-input"
                                    autocomplete="new-password"
                                >

                            </div>

                        </div>


                        <div class="profile-actions">

                            <button
                                type="submit"
                                class="profile-save-btn"
                            >

                                <i class="fa-solid fa-lock me-2"></i>

                                Ubah Password

                            </button>


                            @if(
                                session('status') ===
                                'password-updated'
                            )

                                <span class="profile-saved">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Password berhasil diperbarui

                                </span>

                            @endif

                        </div>

                    </form>

                </div>


                {{-- HAPUS AKUN --}}
                <div class="profile-card profile-card-danger">

                    <div class="profile-card-header">

                        <div class="profile-card-icon danger">

                            <i class="fa-solid fa-trash"></i>

                        </div>


                        <div>

                            <h2 class="profile-card-title">
                                Hapus Akun
                            </h2>

                            <p class="profile-card-description">
                                Tindakan ini tidak dapat dibatalkan.
                            </p>

                        </div>

                    </div>


                    <p class="profile-danger-text">

                        Setelah akun dihapus, seluruh data yang terkait
                        dengan akun Anda akan dihapus secara permanen.

                    </p>


                    <button
                        type="button"
                        class="profile-delete-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteProfileModal"
                    >

                        <i class="fa-solid fa-trash me-2"></i>

                        Hapus Akun

                    </button>

                </div>


            </div>

        </div>

    </div>

</section>


{{-- MODAL HAPUS AKUN --}}
<div
    class="modal fade"
    id="deleteProfileModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <form
                method="POST"
                action="{{ route('profile.destroy') }}"
            >

                @csrf

                @method('DELETE')


                <div class="modal-body p-4">

                    <h5 class="fw-bold mb-3">
                        Hapus akun?
                    </h5>


                    <p class="text-secondary">

                        Masukkan password Anda untuk mengonfirmasi
                        penghapusan akun.

                    </p>


                    <label
                        for="delete_password"
                        class="profile-label"
                    >
                        Password
                    </label>


                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        class="profile-input"
                        required
                    >


                    @error(
                        'password',
                        'userDeletion'
                    )

                        <div class="profile-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="modal-footer border-0 p-4 pt-0">

                    <button
                        type="button"
                        class="btn btn-light rounded-3"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger rounded-3"
                    >
                        Ya, Hapus Akun
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection