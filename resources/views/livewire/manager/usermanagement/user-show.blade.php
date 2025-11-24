<div>
    @section('title', 'Detail User')

    <section class="section">
        <div class="row">

            {{-- Kolom kiri - Avatar --}}
            <div class="col-12 col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        @php
                            $avatar = $user->avatar
                                ? asset('storage/'.$user->avatar)  // ✅ tanpa /public
                                : asset('images/default-avatar.png');
                        @endphp

                        <div class="mx-auto mb-3" style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%;">
                            <img src="{{ $avatar }}" alt="Avatar" class="w-100 h-100 object-fit-cover border">
                        </div>

                        <h4 class="fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted text-capitalize">{{ $user->role }}</p>

                        <a href="{{ route('manager.users.index') }}" class="btn btn-secondary mt-2" wire:navigate>
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                    </div>
                </div>
            </div>

            {{-- Kolom kanan - Info Profil --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Informasi Akun</h5>

                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama Lengkap</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ ucfirst($user->role) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-body img {
            object-fit: cover;
        }
    </style>
</div>
