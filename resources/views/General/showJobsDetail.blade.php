@include('General.header')

<div class="p-6 mt-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Task Title -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h1>
                    </div>

                    <!-- Apply Now, Save and Share Buttons -->
                    <div class="flex items-center gap-3 flex-wrap">
                        @auth
                            @if (Auth::user()->role === 'worker')
                                <form id="applyForm" action="{{ route('task.apply', $job->id) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    <button type="button" id="applyBtn"
                                        class="bg-[#1F4482] text-white text-sm px-8 py-2 rounded-md hover:bg-[#18346a] focus:outline-none">
                                        Apply Now
                                    </button>
                                    <input type="hidden" name="bidPrice" id="formBidPrice">
                                    <input type="hidden" name="catatan" id="formCatatan">
                                </form>
                            @endif
                        @endauth

                        <!-- Save Button -->
                        <button
                            class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                            <i class="fa-regular fa-bookmark text-gray-600 text-lg"></i>
                        </button>

                        <!-- Share Button -->
                        <button
                            class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                            <i class="fa-solid fa-share-nodes text-gray-600 text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- User Info and Budget Info Section -->
                <div class="flex justify-between items-center mb-6">
                    <!-- User Info -->
                    <div class="flex items-center gap-4">
                        <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                            alt="User" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover">
                        <!-- Avatar diperbesar -->
                        <div>
                            <p class="font-semibold text-gray-800 flex items-center gap-1">
                                {{ $job->user->nama_lengkap }}
                                <span class="text-[#1F4482]">&#10004;</span>
                            </p>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-gray-400"></i> {{ $job->location ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="fa-solid fa-pen text-gray-400"></i> <!-- Icon pencil -->
                                Task Posted {{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Budget Info -->
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Budget</p>
                        <p class="text-lg font-semibold text-gray-800">IDR {{ number_format($job->price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $job->is_negotiable ? 'Negotiable' : 'Non-Negotiable' }}</p>
                    </div>
                </div>


                <!-- About Task -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">About Task</h2>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            {!! $job->description ?? '-' !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Qualification</h2>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            {!! $job->qualification ?? '-' !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Rules Task</h2>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            {!! $job->rules ?? '-' !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Attachment Files</h2>
                        @if ($job->job_file)
                            <a href="{{ asset('storage/' . $job->job_file) }}" download
                                class="inline-block mt-2 px-4 py-2 bg-[#1F4482] text-white text-sm rounded-md hover:bg-[#18346a]">
                                Download File
                            </a>
                        @else
                            <p class="text-sm text-gray-500">No attachment available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div>
            <div class="bg-white p-6 rounded-xl shadow-sm border space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Task Details</h2>
                <div>
                    <p class="text-gray-400">Task Period (Deadline)</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($job->start_date)->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}
                    </p>
                    <p class="font-semibold">
                        ({{ \Carbon\Carbon::parse($job->start_date)->diffInDays($job->deadline) }} Days)
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Task Closed</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($job->deadline_promotion)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Task Type</p>
                    <p class="font-semibold capitalize">{{ str_replace('_', ' ', $job->taskType) }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Task Model</p>
                    <p class="font-semibold capitalize">{{ str_replace('_', ' ', $job->taskModel) }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Category</p>
                    <p class="font-semibold">{{ $job->category ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Location</p>
                    <p class="font-semibold">{{ $job->location ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('General.footer')

<!-- Sweetalert for Apply -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("applyForm");

        document.getElementById("applyBtn")?.addEventListener("click", function () {
            Swal.fire({
                title: 'Apply for this Job',
                html: `
                    <div class="text-left space-y-4">
                        <label class="block text-sm mb-1">Bid Price (IDR)</label>
                        <input id="negoHarga" type="number" class="swal2-input" value="{{ $job->price }}">

                        <label class="block text-sm mb-1 mt-4">Notes (Optional)</label>
                        <textarea id="noteField" class="swal2-textarea"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1F4482',
                preConfirm: () => {
                    return {
                        nego: document.getElementById('negoHarga').value,
                        note: document.getElementById('noteField').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formBidPrice").value = result.value.nego;
                    document.getElementById("formCatatan").value = result.value.note;

                    Swal.fire({
                        icon: 'success',
                        title: 'Applied!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => form.submit(), 1000);
                }
            });
        });
    });
</script>