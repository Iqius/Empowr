@include('General.header')

<div class="p-4 ">
    <div class="p-4 mt-14">
        <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
            Your Tasks
            <span class="text-gray-400 text-base">
                <i class="fas fa-info-circle"></i>
            </span>
        </h2>

        <div class="grid grid-cols-3 gap-4">
            <div class="flex flex-col items-center justify-center h-32 bg-white p-6 rounded border border-gray-300">
                <p class="text-3xl font-bold" style="color: #1F4482;">1</p>
                <p class="text-base font-medium text-gray-600">Applied Jobs</p>
            </div>
            <div class="flex flex-col items-center justify-center h-32 bg-white p-6 rounded border border-gray-300">
                <p class="text-3xl font-bold" style="color: #1F4482;">0</p>
                <p class="text-base font-medium text-gray-600">On Going Jobs</p>
            </div>
            <div class="flex flex-col items-center justify-center h-32 bg-white p-6 rounded border border-gray-300">
                <p class="text-3xl font-bold" style="color: #1F4482;">1</p>
                <p class="text-base font-medium text-gray-600">Complete Jobs</p>
            </div>
        </div>


        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Applied Jobs -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Applied Jobs</h2>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Graphic Design for Billboard</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Logo Maker Non AI</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Designer for Content</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                </ul>

                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        <button class="border px-3 py-1 text-sm rounded">1</button>
                        <button class="border px-3 py-1 text-sm rounded">2</button>
                        <button class="border px-3 py-1 text-sm rounded">3</button>
                        <button class="border px-3 py-1 text-sm rounded">4</button>
                    </nav>
                </div>
            </div>

            <!-- Accept Jobs -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Accept Jobs</h2>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Graphic Design for Billboard</p>
                                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
                            </div>
                        </div>
                        <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
                    </li>
                </ul>
            </div>
        </div>


        <div class="mt-10">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Browse Tasks</h2>
                <a href="{{ route('jobs.index') }}" class="text-sm text-[#1F4482] font-medium hover:underline">View
                    More</a>
            </div>


            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Task Card -->
                <!-- Job Card -->
                @php
                    $task = \App\Models\Task::all();
                @endphp

                @foreach ($task as $job)
                    @if($job->status == 'open') <!-- Cek apakah statusnya 'open' -->
                        <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
                            data-price="{{ $job->price }}">
                            <!-- Save Button -->
                            <button class="absolute top-3 right-3 text-gray-400 hover:text-[#1F4482] transition">
                                <i class="fa-regular fa-bookmark text-lg"></i>
                            </button>

                            <!-- User Info -->
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="User"
                                    class="w-9 h-9 rounded-full object-cover" />
                                <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                                    {{ $job->user->nama_lengkap ?? 'Unknown' }}
                                    <span class="text-[#1F4482]">✔</span>
                                </p>
                            </div>

                            <!-- Job Title -->
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">
                                {{ $job->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                {{ Str::limit($job->description, 80, '...') }}
                            </p>

                            <!-- Bottom Row: Price + Button -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Rp
                                        {{ number_format($job->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">Non-Negotiable</p>
                                </div>
                                <a href="{{ route('jobs.show', $job->id) }}">
                                    <button
                                        class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                                        View
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    <div class="text-center mt-8">
        <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Join Affiliate</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ✅ SweetAlert for Success Message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1F4482',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href;
            });
        @endif
    });
</script>

@include('General.footer')