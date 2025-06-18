@include('General.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<div class="p-4 mt-14">

    <div id="progres" class=" tab-content p-4 rounded h-full">
        @if($affiliation->status_decision == 'rejected' && auth()->user()->role === 'worker' && auth()->user()->workerProfile->empowr_affiliation == true)
            <form id="formAjukanUlang" method="POST" action="{{route('progress-affiliate.submited-ulang', ['id' => $affiliation])}}">
                @csrf
                <a 
                    onclick="confirmAjukanUlang(event)"
                    class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6 cursor-pointer">
                    Ajukan Ulang
                </a>
            </form>
        @endif
        <div class="bg-white rounded-xl shadow-sm border flex flex-col h-full space-y-6">
            <div class="flex flex-col gap-4 py-6 px-4">
                <div class="flex justify-between items-center relative">
                    @php
                        $stepsData = [
                            ['label' => 'Pending', 'key' => 'pending'],
                            ['label' => 'Review', 'key' => 'reviewed'],
                            ['label' => 'Interview', 'key' => 'interview'],
                            ['label' => 'Result', 'key' => 'result']
                        ];

                        // Gunakan data dari controller
                        $steps = $stepsStatus ?? [];
                        
                        // Cari tahapan yang ditolak
                        $rejectedStepIndex = null;
                        $currentActiveStep = -1;

                        foreach ($stepsData as $index => $step) {
                            $stepStatus = $steps[$step['key']] ?? null;
                            
                            if ($stepStatus === 'rejected') {
                                $rejectedStepIndex = $index;
                                $currentActiveStep = $index;
                                break;
                            } elseif ($stepStatus === 'approved') {
                                $currentActiveStep = $index;
                            } elseif ($stepStatus === null && $currentActiveStep >= 0) {
                                // Step berikutnya yang belum diproses setelah ada yang approved
                                $currentActiveStep = $index;
                                break;
                            }
                        }

                        // Jika tidak ada yang approved/rejected, mulai dari step pertama
                        if ($currentActiveStep === -1) {
                            $currentActiveStep = 0;
                        }
                    @endphp

                    @foreach ($stepsData as $index => $step)
                        @php
                            $stepStatus = $steps[$step['key']] ?? null;
                            $circleColor = 'bg-gray-300 text-gray-600';
                            $statusText = 'Menunggu';
                            $statusColor = 'text-gray-500';
                            $icon = '<i class="fas fa-clock"></i>';

                            // Logika penentuan status visual
                            if ($stepStatus === 'approved') {
                                $circleColor = 'bg-green-500 text-white';
                                $statusText = 'Disetujui';
                                $statusColor = 'text-green-600';
                                $icon = '<i class="fas fa-check"></i>';
                            } elseif ($stepStatus === 'rejected') {
                                $circleColor = 'bg-red-600 text-white';
                                $statusText = 'Ditolak';
                                $statusColor = 'text-red-700';
                                $icon = '<i class="fas fa-times"></i>';
                            } elseif ($stepStatus === 'auto-rejected') {
                                $circleColor = 'bg-red-400 text-white';
                                $statusText = 'Dihentikan';
                                $statusColor = 'text-red-600';
                                $icon = '<i class="fas fa-ban"></i>';
                            } elseif ($rejectedStepIndex === null && $index === $currentActiveStep && $stepStatus === null) {
                                // Step yang sedang aktif (belum ada rejection)
                                $circleColor = 'bg-blue-500 text-white animate-pulse';
                                $statusText = 'Sedang Diproses';
                                $statusColor = 'text-blue-600';
                                $icon = '<i class="fas fa-spinner fa-spin"></i>';
                            }

                            // Jika ada data log spesifik untuk step ini, ambil tanggalnya
                            $stepLog = $logs->filter(function($log) use ($step) {
                                return strtolower($log->status) === strtolower($step['key']);
                            })->last();
                            
                            $logDate = $stepLog ? $stepLog->created_at->format('d/m/Y') : null;
                        @endphp

                        <div class="flex-1 flex flex-col items-center z-10 relative">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {!! $circleColor !!} shadow-md transition-all duration-300">
                                {!! $icon !!}
                            </div>
                            <p class="mt-2 text-sm font-semibold text-center {{ $statusColor }}">
                                {{ $step['label'] }}
                            </p>
                            <p class="text-xs mt-1 font-medium {{ $statusColor }}">
                                {{ $statusText }}
                            </p>
                            @if($logDate)
                                <p class="text-xs mt-1 text-gray-400">
                                    {{ $logDate }}
                                </p>
                            @endif
                        </div>

                        @if($index < count($stepsData) - 1)
                            @php
                                $connectorColor = 'bg-gray-300';
                                
                                if ($rejectedStepIndex !== null) {
                                    // Ada tahapan yang ditolak
                                    if ($index < $rejectedStepIndex) {
                                        $connectorColor = 'bg-green-500'; // Hijau untuk yang sudah approved sebelum rejection
                                    } else {
                                        $connectorColor = 'bg-red-500'; // Merah dari tahapan rejection hingga akhir
                                    }
                                } else {
                                    // Tidak ada rejection
                                    $currentStepStatus = $steps[$step['key']] ?? null;
                                    $nextStepStatus = $steps[$stepsData[$index + 1]['key']] ?? null;
                                    
                                    if ($currentStepStatus === 'approved') {
                                        if ($nextStepStatus === 'approved') {
                                            $connectorColor = 'bg-green-500'; // Hijau jika kedua step sudah approved
                                        } elseif ($nextStepStatus === null) {
                                            $connectorColor = 'bg-blue-500'; // Biru jika step berikutnya sedang proses
                                        }
                                    }
                                }
                            @endphp
                            <div class="flex-1 h-1 {{ $connectorColor }} transition-all duration-300"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>



        <!-- Progress section -->
        <div class="bg-white rounded-xl shadow-sm border flex flex-col h-full space-y-6 my-2">
            <div class="flex flex-col gap-4 py-6 px-4">
                <div class="flex justify-between items-center relative">
                    <div class="mx-5 my-5">
                        <h2 class="font-bold text-lg mb-2">Status tahapan</h2>
                        <div class="border-b pb-3 mb-3">
                            <p class="text-gray-700">Tahap saat ini:
                                <span class="text-red-600 font-semibold">
                                    {{ ucfirst($affiliation->status) }}
                                </span>
                            </p>
                        </div>
                        @php
                            // Ambil log terakhir status_decision dari logs untuk affiliation ini
                            $lastLog = $affiliation->logs()->latest('created_at')->first();
                        @endphp
                        <div class="border-b pb-3 mb-3">
                            <p>Hasil tahapan
                                <span class="text-red-600 font-semibold">
                                    {{ $lastLog ? $lastLog->status_decision : 'Belum ada status' }}
                                </span>
                            </p>
                        </div>
                        @if(strtolower(trim($affiliation->status)) === 'interview' && $affiliation->link_meet != null)
                            <div class="border-b pb-3 mb-3">
                                <p>Meet pertemuan: 
                                    <span class="text-red-600 font-semibold">
                                        <a href="{{ $affiliation->link_meet }}" target="_blank" rel="noopener noreferrer" class="underline text-blue-600 hover:text-blue-800">
                                            {{ $affiliation->link_meet }}
                                        </a>
                                    </span>
                                </p>
                            </div>
                            <div class="border-b pb-3 mb-3">
                                <p>Terjadwal: 
                                    <span class="text-red-600 font-semibold">
                                        {{ $affiliation->jadwal_interview }} 
                                    </span>
                                    <p id="countdown" class="text-sm text-indigo-600 font-semibold"></p>
                                </p>
                            </div>
                        @endif

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            @if ($lastLog)
                                @php
                                    $status_decision = $lastLog->status_decision;
                                    $status = $lastLog->status;
                                @endphp

                                @if ($status_decision === 'rejected')
                                    <div class="bg-red-100 text-red-800 p-4 rounded-lg text-center font-semibold">
                                        Ditolak
                                    </div>
                                @elseif($status === 'result' && $status_decision === 'approved')
                                    Berhasil menambahkan worker menjadi affiliate
                                @else
                                    <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center font-semibold">
                                        Diterima
                                    </div>
                                    <div class="flex gap-4 mt-4">
                                    <form action="{{ route('List-pengajuan-worker-affiliate.pending-to-under-review', $affiliation->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('rejected.affiliate', $affiliation->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                            Tolak
                                        </button>
                                    </form>

                                    @if(strtolower(trim($affiliation->status)) === 'interview' && $affiliation->link_meet === null)
                                        <button class="bg-indigo-600 text-white px-5 py-2 rounded-xl hover:bg-indigo-700 transition" onclick="toggleModal(true)">
                                            Atur Interview
                                        </button>
                                    @endif  
                                @endif                                 
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>





        <!-- TABEL SECTION -->
        <div class="bg-white p-6 rounded-xl shadow-md border mb-5">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas</h1>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-[#1F4482] text-white text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium tracking-wider">Nama</th>
                            <th class="px-6 py-3 font-medium tracking-wider">Tahapan</th>
                            <th class="px-6 py-3 font-medium tracking-wider">Aksi</th>
                            <th class="px-6 py-3 font-medium tracking-wider">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($logs as $item)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-3 flex items-center gap-3">
                                    <img src="#"
                                        alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                    <span class="font-medium">{{$item->admin->nama_lengkap}}</span>
                                </td>
                                <td class="px-6 py-3 font-medium">{{$item->status}}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">
                                        {{$item->status_decision}}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y h:i a') }}</td>
                            </tr>
                        @endforeach
                            

                            {{--@if($progress->action_by_client)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-3 flex items-center gap-3">
                                        <img src="{{ asset('storage/' . ($progress->client->profile_image ?? 'default.jpg')) }}"
                                            alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                        <span class="font-medium">{{ $progress->client->nama_lengkap ?? 'Unknown' }}</span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                            @if($progress->status_approve === 'approved') bg-green-100 text-green-700
                                            @elseif($progress->status_approve === 'rejected') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($progress->status_approve) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-gray-800">{{ $progress->note ?? '-' }}</td>
                                    <td class="px-6 py-3 font-medium">{{ $progress->progression_ke }}</td>
                                    <td class="px-6 py-3 text-gray-600">
                                        {{ $progress->date_approve?->format('d M Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @endif--}}
                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="interviewModal" 
        class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 hidden"
        style="backdrop-filter: blur(4px);">
    <div id="modalContent"
            class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6 transform transition-transform duration-300 scale-90 opacity-0">
        
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Jadwal Interview</h2>
            <button onclick="toggleModal(false)" class="text-gray-500 hover:text-red-500 text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="{{route('interview-date.submit', $affiliation->id)}}" method="POST">
            @csrf
            <!-- Link -->
            <div class="mb-4">
                <label for="meeting_link" class="block text-sm font-medium text-gray-700">Link Meeting</label>
                <input type="url" name="meeting_link" id="meeting_link" required
                    placeholder="https://meet.google.com/xyz-abc-def"
                    class="w-full mt-1 px-4 py-2 border rounded-xl focus:outline-none focus:ring focus:border-indigo-500">
            </div>

            <!-- Jadwal -->
            <div class="mb-4">
                <label for="schedule" class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
                <input type="datetime-local" name="schedule" id="schedule" required
                    class="w-full mt-1 px-4 py-2 border rounded-xl focus:outline-none focus:ring focus:border-indigo-500">
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" 
                        onclick="toggleModal(false)"
                        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script animasi modal -->
<script>
    function toggleModal(show) {
        const modal = document.getElementById('interviewModal');
        const content = document.getElementById('modalContent');

        if (show) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }
</script>

<!-- AJUKAN ULANG -->
 <script>
    function confirmAjukanUlang(e) {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin mengajukan ulang?')) {
            document.getElementById('formAjukanUlang').submit();
        }
    }
</script>

<!-- HITUNG MUNDUR JADWAL INTERVIEW -->
 <script>
    const targetTime = new Date("{{ \Carbon\Carbon::parse($affiliation->jadwal_interview)->toIso8601String() }}").getTime();

    const countdownEl = document.getElementById("countdown");

    const countdownInterval = setInterval(() => {
        const now = new Date().getTime();
        const distance = targetTime - now;

        if (distance < 0) {
            countdownEl.innerText = "Interview sedang berlangsung atau telah selesai.";
            clearInterval(countdownInterval);
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownEl.innerText = `Interview dimulai dalam ${days}h ${hours}j ${minutes}m ${seconds}d`;
    }, 1000);
</script>


@include('General.footer')
