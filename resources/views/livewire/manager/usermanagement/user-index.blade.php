<div>
    @section('title', 'Manajemen User')

    <section class="section">
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar User</h5>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Cari nama atau email">
                        @if($search)
                            <button class="btn btn-outline-danger" wire:click="$set('search', '')" type="button">
                                <i class="bi bi-x"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('manager.users.show', $user->id) }}"
                                           class="btn btn-primary btn-sm"
                                           wire:navigate><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        @if($search)
                                            Tidak ada hasil untuk "{{ $search }}"
                                        @else
                                            Belum ada user
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </section>

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }
    </style>
</div>
