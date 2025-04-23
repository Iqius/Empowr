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
                <a href="#" class="text-sm text-[#1F4482] font-medium hover:underline">View More</a>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Task Card -->
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="https://via.placeholder.com/40" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            Andi Santoso
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Looking for Backend Programmer</h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Lórem ipsum åskade spesad eurobel liksom posevis även om intrasm gsast ren bidårade ren...
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">IDR 500.000</p>
                            <p class="text-xs text-gray-400">Non-Negotiable</p>
                        </div>
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            View
                        </button>
                    </div>
                </div>

                <!-- Duplikat card sesuai kebutuhan -->
                <!-- ... -->
            </div>
        </div>

    </div>

    <div class="text-center mt-8">
        <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Join Affiliate</button>
    </div>
</div>
</div>

@include('General.footer')