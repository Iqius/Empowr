@include('General.header')


<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 min-h-screen">
            <div class="p-4 rounded h-full">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col md:flex-row items-center justify-center p-4 gap-4">
                            <!-- Step 1 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step1'] == 'approved') bg-green-500 
                                    @elseif($steps['step1'] == 'rejected') bg-red-500 
                                    @else bg-blue-500 @endif">
                                    <span class="text-lg">
                                        @if($steps['step1'] == 'approved') ✅ 
                                        @elseif($steps['step1'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step1'] == 'approved') text-green-500 
                                    @elseif($steps['step1'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">One</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step1'] == 'approved') bg-green-500 
                                @elseif($steps['step1'] == 'rejected') bg-red-500 
                                @else bg-blue-500 @endif"></div>

                            <!-- Step 2 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step2'] == 'approved') bg-green-500 
                                    @elseif($steps['step2'] == 'rejected') bg-red-500 
                                    @else bg-blue-500 @endif">
                                    <span class="text-lg">
                                        @if($steps['step2'] == 'approved') ✅ 
                                        @elseif($steps['step2'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step2'] == 'approved') text-green-500 
                                    @elseif($steps['step2'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Two</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step2'] == 'approved') bg-green-500 
                                @elseif($steps['step2'] == 'rejected') bg-red-500 
                                @else bg-gray-300 @endif"></div>

                            <!-- Step 3 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step3'] == 'approved') bg-green-500 
                                    @elseif($steps['step3'] == 'rejected') bg-red-500 
                                    @else bg-gray-300 @endif">
                                    <span class="text-lg">
                                        @if($steps['step3'] == 'approved') ✅ 
                                        @elseif($steps['step3'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step3'] == 'approved') text-green-500 
                                    @elseif($steps['step3'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Three</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step3'] == 'approved') bg-green-500 
                                @elseif($steps['step3'] == 'rejected') bg-red-500 
                                @else bg-gray-300 @endif"></div>

                            <!-- Step 4 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step4'] == 'approved') bg-green-500 
                                    @elseif($steps['step4'] == 'rejected') bg-red-500 
                                    @else bg-gray-300 @endif">
                                    <span class="text-lg">
                                        @if($steps['step4'] == 'approved') ✅ 
                                        @elseif($steps['step4'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step4'] == 'approved') text-green-500 
                                    @elseif($steps['step4'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Complete</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card Section: selalu di bawah -->
                    <div class="flex flex-col md:grid md:grid-cols-4 gap-4 p-4"> <!-- Ini kalau mau satu aja buttonnya <div class="flex flex-col gap-4 p-4">-->
                        <!-- Card untuk Worker -->
                        @if(auth()->user()->role == 'worker')
                            <div class="bg-white rounded-lg p-4 shadow w-full">
                                <h2 class="font-bold text-lg">Submit Progression</h2>
                                <label for="file-upload" class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                                        📄
                                    </div>
                                    <p class="text-gray-700 font-medium">Inputkan file Progress</p>
                                </label>
                                <input id="file-upload" type="file" class="hidden">
                                <p class="pt-5">Tanggal di submit</p>
                                <button class="mt-2 w-full py-3 bg-blue-500 rounded text-white">Submit</button>
                            </div>
                        @endif

                        <!-- Card untuk Client -->
                        @if(auth()->user()->role == 'client')
                            <div class="bg-white rounded-lg p-4 shadow w-full md:w-1/3">
                                <h2 class="font-bold text-lg">Review Progression</h2>
                                <a for="file-upload" class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                                        📄
                                    </div>
                                    <p class="text-gray-700 font-medium">Progress.php</p>
                                </a>
                                <p class="pt-5">Tanggal submit</p>
                                <button @click="step3 = 'approved'; step4 = 'approved'" class="w-full py-3 bg-blue-500 rounded text-white">Approve</button>
                                <button @click="step3 = 'rejected'; step4 = 'rejected'" class="w-full py-3 bg-red-500 rounded text-white mt-2">Reject</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <h1 class="text-xl font-semibold text-gray-700 mt-6">Deskripsi</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus cumque perspiciatis hic? Reprehenderit quia corrupti, quae doloremque magni, quas quisquam hic recusandae reiciendis sunt nisi autem eius nesciunt. Eius nostrum provident, nihil omnis incidunt porro id error dicta dolorem veritatis asperiores necessitatibus distinctio mollitia veniam quia. Expedita exercitationem minima sunt facilis! Perferendis dolorum, sint velit sequi aut fugiat! Dolor, sequi quibusdam! Amet voluptatem consectetur iste similique, reprehenderit repellendus ducimus tempore tempora debitis voluptate quod, nulla iusto eaque quaerat sint repellat nisi, maiores illo. Id laborum a itaque quis minima nesciunt sequi reprehenderit ea modi quo, iure ullam, pariatur eos voluptatem!</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">Ketentuan</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, nisi a quae unde sit itaque impedit natus iste dolores voluptatibus, dolorum nemo debitis quas, obcaecati hic? Quaerat earum incidunt repellat ad itaque harum laboriosam? Vitae harum aliquid voluptatum? Corporis aperiam dolore non officiis nemo odio reprehenderit sunt dolor ipsam eligendi, dolores perferendis tenetur placeat at deserunt optio quia dolorum tempore veniam voluptates a eveniet necessitatibus. Perspiciatis labore adipisci veniam voluptates accusamus. Perferendis quae minus voluptates maiores magni maxime, earum placeat, harum quisquam labore obcaecati adipisci numquam excepturi rerum, sunt iure temporibus facere provident! Cum aspernatur sed aliquid quis, adipisci earum!</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">File Terkait tugas</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <div class="flex items-center justify-between">
                        <!-- Card Profile (Kiri) -->
                        <div class="flex items-center space-x-4">
                            <!-- Avatar -->
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <img src="https://via.placeholder.com/150" alt="" class="w-full h-full object-cover rounded-full">
                            </div>

                            <!-- User Info -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">John Doe</h3>
                                <p class="text-gray-600">Frontend Developer</p>
                            </div>
                        </div>

                        <!-- Action Buttons (Di sebelah kanan Profil) -->
                        <div class="flex flex-col gap-2">
                            <!-- Laporkan Button -->
                            <button class="w-32 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Laporkan
                            </button>

                            <!-- Chat Button -->
                            <button class="w-32 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Chat
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md mb-5">
                    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                        <h1 class="text-2xl font-semibold text-gray-700 mt-6">Log Aktivitas</h1>
                        <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search for users">
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-black bg-white">
                            <thead class="text-xs uppercase bg-gray-100 text-black border-b border-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-1/3">Name</th>
                                    <th scope="col" class="px-6 py-3 w-2/3">Note</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="border-b border-gray-300 hover:bg-gray-100">
                                    <th scope="row" class="flex items-center px-2 py-4 whitespace-nowrap w-1/3">
                                        <img class="w-10 h-10 ps-6 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="test">
                                        <div class="px-6">
                                            <div class="text-base font-semibold">Neil Sims</div>
                                            <div class="font-normal text-gray-600">neil.sims@flowbite.com</div>
                                        </div>  
                                    </th>
                                    <td class=" px-6 py-3 w-1/3">React Developer</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Form Submit-->
<div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden opacity-0 transition-opacity duration-500 ease-in-out">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-xl font-semibold mb-4">Enter Note</h2>
    <textarea id="noteInput" class="w-full p-2 border rounded mb-4" placeholder="Write your note here..."></textarea>
    <div class="flex justify-end">
      <button id="submitNote" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
      <button id="closeModal" class="ml-2 bg-gray-500 text-white py-2 px-4 rounded">Close</button>
    </div>
  </div>
</div>


<script>
  // Mendapatkan elemen-elemen modal dan tombol
  const approveButton = document.getElementById('approveButton');
  const modal = document.getElementById('modal');
  const closeModal = document.getElementById('closeModal');

  // Menampilkan modal saat tombol approve diklik dengan animasi fade-in
  approveButton.addEventListener('click', () => {
    modal.classList.remove('hidden');
    setTimeout(() => {
      modal.classList.remove('opacity-0');
    }, 10); // Menghapus opacity-0 setelah sedikit waktu agar animasi fade-in bisa terlihat
  });

  // Menutup modal jika tombol Close diklik dengan animasi fade-out
  closeModal.addEventListener('click', () => {
    modal.classList.add('opacity-0');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 500); // Menyembunyikan modal setelah animasi selesai
  });

</script>




@include('General.footer')
