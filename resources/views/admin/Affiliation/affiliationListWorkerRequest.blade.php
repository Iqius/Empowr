@include('General.header')

<div class="p-4 mt-14">
    <!-- TABEL STATIC BERISI PENGAJU, TAHAPAN, AKSI -->
    <div class="bg-white p-6 rounded-xl shadow-md border mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Tahapan</h2>
        <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
            <table class="min-w-full w-full table-fixed divide-y divide-gray-200 text-sm">
                <thead class="bg-[#1F4482] text-white text-left">
                    <tr>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Pengaju</th>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Tahapan</th>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($data as $item)
                        @php
                            $worker = $item->workerProfile;
                            $user = $worker->user;
                        @endphp
                        @if(($item->status != 'result' && strtolower(trim($item->status_decision)) != 'approve') || strtolower(trim($item->status_decision)) != 'rejected')
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-4 py-3 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . ($worker->profile_image ?? 'default.jpg')) }}"
                                        class="w-10 h-10 rounded-full object-cover">
                                    <span class="font-medium">{{ $user->nama_lengkap }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $item->status }}</td>
                                <td class="px-4 py-3 space-x-2">
                                    @if(strtolower(trim($item->status)) == 'pending')
                                        <form action="{{ route('List-pengajuan-worker-affiliate.pending-to-under-review', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereview worker ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="inline-block px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-full font-semibold transition">
                                                Ubah status menjadi under review
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                                            class="inline-block px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-full font-semibold transition">
                                            Lihat Worker
                                        </a>
                                        <a href="{{ route('progress-affiliate.view', ['id' => $worker->id]) }}"
                                            class="inline-block px-4 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs rounded-full font-semibold transition">
                                            Progress Tahapan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('General.footer')
