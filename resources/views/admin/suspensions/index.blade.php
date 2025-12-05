@extends('layouts.app')

@section('title', 'Kelola Suspend - Admin SIPINJAM')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-ban text-red-600"></i>
                Kelola Suspend User
            </h1>
            <p class="text-gray-600 mt-2">Pantau dan kelola semua suspend user yang aktif</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Suspend Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $suspensions->where('status', 'active')->count() }}
                    </p>
                </div>
                <i class="fas fa-exclamation-circle text-red-600 text-4xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Suspend Berakhir Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $suspensions->where('suspended_until', '<=', now()->addDay())->where('suspended_until', '>', now())->count() }}
                    </p>
                </div>
                <i class="fas fa-hourglass-end text-yellow-500 text-4xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Suspend Sudah Berakhir</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $suspensions->where('status', 'expired')->count() }}
                    </p>
                </div>
                <i class="fas fa-check-circle text-green-600 text-4xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Daftar Suspend</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No.</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Alasan Suspend</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Dimulai</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Berakhir</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($suspensions as $key => $suspension)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($suspension->user->name) }}&background=random" 
                                         alt="Avatar" class="w-8 h-8 rounded-full">
                                    <span class="font-medium text-gray-900">{{ $suspension->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $suspension->user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="line-clamp-2">{{ $suspension->reason }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $suspension->suspended_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                {{ $suspension->suspended_until->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($suspension->status === 'active')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">
                                        <i class="fas fa-circle text-red-500 text-xs"></i>
                                        AKTIF
                                    </span>
                                @elseif($suspension->status === 'expired')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                        BERAKHIR
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold">
                                        <i class="fas fa-circle text-gray-500 text-xs"></i>
                                        TIDAK AKTIF
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($suspension->status === 'active')
                                    <button onclick="unlockSuspension({{ $suspension->id }}, '{{ $suspension->user->name }}')" 
                                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-xs font-semibold transition-colors">
                                        <i class="fas fa-unlock mr-1"></i>
                                        Unlock
                                    </button>
                                @else
                                    <span class="text-gray-500 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                                    <p class="text-gray-600 font-medium">Tidak ada data suspend</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($suspensions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $suspensions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function unlockSuspension(suspensionId, userName) {
        Swal.fire({
            title: 'Unlock Suspend?',
            html: `Yakin ingin membuka suspend <strong>${userName}</strong>?<br><small class="text-gray-600">Mereka akan langsung bisa meminjam barang lagi.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Unlock',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/suspensions/${suspensionId}/unlock`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Suspend berhasil di-unlock. User akan menerima email notifikasi.',
                            icon: 'success',
                            confirmButtonColor: '#3b82f6'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Terjadi kesalahan saat unlock.', 'error');
                });
            }
        });
    }
</script>
@endsection
