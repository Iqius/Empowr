@include('client.header')

<section class="p-4 mt-16 lg:ml-64">
    <!-- Tabs -->
    <div class="flex flex-wrap gap-4 border-b pb-2 text-sm sm:text-base overflow-x-auto">
        <button class="tab-button text-blue-600 font-semibold" data-tab="info">Informasi Lengkap</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="applicants">Lamaran Worker</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="chat">Chat</button>
    </div>

    <!-- Tab 1: Informasi Lengkap -->
    <div id="info" class="tab-content space-y-4 mt-4">
        <h1 class="text-2xl font-bold text-blue-600">{{ $job->title ?? '[Judul belum diisi]' }}</h1>
        <p class="text-black font-bold text-xl">
            Rp {{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
        </p>
        <p class="text-gray-500 text-sm">By {{ $job->user->name ?? 'Unknown' }}</p>
        <hr>

        @foreach([
            'Deskripsi' => 'description',
            'Jumlah Revisi' => 'revisions',
            'Tanggal Berakhir' => 'end_date',
            'Tipe Pekerjaan' => 'type',
            'Ketentuan' => 'provisions'
        ] as $label => $field)
            <div>
                <h2 class="text-lg font-semibold text-gray-700">{{ $label }}</h2>
                <p class="text-gray-600 mt-1">{{ $job->$field ?? '[Belum ditentukan]' }}</p>
            </div>
        @endforeach

        <div>
            <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>
            <p class="text-gray-600 mt-1">[Belum ada file yang diunggah]</p>
        </div>
    </div>


  <!-- Tab 2: Lamaran Worker -->
  <div id="applicants" class="tab-content hidden mt-4">
      <h2 class="text-xl font-bold mb-4">Lamaran Worker</h2>

      <!-- Filter -->
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
        <label for="sortBy" class="font-semibold">Urutkan Berdasarkan:</label>
        <select id="sortBy" onchange="sortApplicants()" class="p-2 border rounded">
          <option value="default">Default</option>
          <option value="price">Harga</option>
          <option value="experience">Pengalaman</option>
          <option value="rating">Rating</option>
        </select>
      </div>

      <!-- List Pelamar -->
      <div id="applicants-list" class="space-y-4"></div>
  </div>

  <!-- Tab 3: Chat -->
  <div id="chat" class="tab-content hidden mt-4">
      <h2 class="text-xl font-bold mb-4">Chat</h2>
      <iframe src="{{ route('chat') }}" class="w-full h-[500px] border rounded shadow"></iframe>
  </div>

  <!-- Actions -->
  <div class="flex justify-end gap-2 mt-6">
      <button class="bg-yellow-500 text-white px-4 py-2 rounded">Ganti Status</button>
      <button class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
  </div>
<!-- Modal Detail Worker -->
<div id="workerDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
  <div class="relative bg-white rounded-lg shadow-lg w-[95vw] max-w-md sm:max-w-2xl max-h-[90vh] overflow-hidden">

    <!-- Tombol Close -->
    <button onclick="document.getElementById('workerDetailModal').classList.add('hidden')"
      class="absolute top-2 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold z-50">
      &times;
    </button>

    <!-- Kontainer isi -->
    <div class="flex flex-col h-full">

      <!-- Konten scrollable -->
      <div class="overflow-y-auto px-4 py-6 sm:px-6 sm:py-8 space-y-6 max-h-[90vh]">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left">
          <img id="worker-avatar" src="assets/images/avatar.png" alt="Worker Avatar"
            class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
          <div>
            <h2 id="worker-name" class="text-2xl font-bold">Worker Dummy</h2>
            <span id="worker-status" class="text-blue-500">✔ Verified</span>
          </div>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center border-b overflow-x-auto">
          <button onclick="showWorkerTab('keahlianTab')"
            class="worker-tab-button px-4 py-2 text-gray-600 hover:text-blue-600 whitespace-nowrap">Keahlian</button>
          <button onclick="showWorkerTab('ratingTab')"
            class="worker-tab-button px-4 py-2 text-gray-600 hover:text-blue-600 whitespace-nowrap">Rating</button>
        </div>

        <!-- Tab Konten -->
        <div id="keahlianTab" class="worker-tab-content space-y-4">
<!-- Keahlian -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">Keahlian:</label>
    <p class="text-sm text-gray-500">Keahlian yang dimiliki</p>
  </div>
  <div class="col-span-2">
    <p id="worker-skills-value" class="p-2 border rounded w-full bg-gray-100"></p>
  </div>
</div>

<!-- Empowr Label -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">Empowr Label :</label>
    <p class="text-sm text-gray-500">Label yang dimiliki</p>
  </div>
  <div class="col-span-2">
    <p id="worker-label" class="p-2 border rounded w-full bg-gray-100"></p>
  </div>
</div>

<!-- Empowr Affiliate -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">Empowr Affiliate :</label>
    <p class="text-sm text-gray-500">Affiliasi dengan empowr</p>
  </div>
  <div class="col-span-2">
    <p id="worker-affiliate" class="p-2 border rounded w-full bg-gray-100"></p>
  </div>
</div>

<!-- Pendidikan -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">Pendidikan :</label>
    <p class="text-sm text-gray-500">Pendidikan Terakhir</p>
  </div>
  <div class="col-span-2">
    <p id="worker-education" class="p-2 border rounded w-full bg-gray-100"></p>
  </div>
</div>

<!-- Pengalaman Kerja -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">Pengalaman Kerja:</label>
    <p class="text-sm text-gray-500">Lama pengalaman kerja</p>
  </div>
  <div class="col-span-2">
    <p id="worker-experience" class="p-2 border rounded w-full bg-gray-100"></p>
  </div>
</div>

<!-- CV -->
<div class="grid grid-cols-3 items-center gap-4">
  <div>
    <label class="font-semibold">CV :</label>
    <p class="text-sm text-gray-500">CV Worker</p>
  </div>
  <div class="col-span-2">
    <a id="worker-cv" href="#" target="_blank" class="p-2 border rounded w-full bg-gray-100 block">Lihat CV</a>
  </div>
</div>

<!-- Dropdown Sertifikat -->
<div class="grid grid-cols-3 items-start gap-4">
  <div>
    <label class="font-semibold">Pilih Sertifikat:</label>
    <p class="text-sm text-gray-500">Lihat sertifikat yang telah ditambahkan</p>
  </div>
  <div class="col-span-2">
    <select id="certSelect" class="p-2 border rounded w-full">
      <option disabled selected>Lihat Sertifikasi</option>
    </select>
  </div>
</div>

<!-- Preview Sertifikat -->
<div id="certPreview" class="grid grid-cols-3 items-start gap-4 mt-4 hidden">
  <div>
    <label class="font-semibold">Preview Sertifikat:</label>
    <p class="text-sm text-gray-500">Klik caption untuk membuka gambar penuh</p>
  </div>
  <div class="col-span-2 space-y-2">
    <img id="certImage" src="" alt="Preview Sertifikat" class="w-40 h-40 object-cover rounded border">
    <p>
      <a id="certCaptionLink" href="#" target="_blank" class="text-blue-600 hover:underline">Lihat Sertifikat</a>
    </p>
  </div>
</div>

<!-- Dropdown Portofolio -->
<div class="grid grid-cols-3 items-start gap-4 mt-4">
  <div>
    <label class="font-semibold">Pilih Portofolio:</label>
    <p class="text-sm text-gray-500">Lihat portofolio yang telah ditambahkan</p>
  </div>
  <div class="col-span-2">
    <select id="portfolioSelect" class="p-2 border rounded w-full">
      <option disabled selected>Lihat Portofolio</option>
    </select>
  </div>
</div>

<!-- Preview Portofolio -->
<div id="portfolioPreview" class="grid grid-cols-3 items-start gap-4 mt-4 hidden">
  <div>
    <label class="font-semibold">Preview Portofolio:</label>
    <p class="text-sm text-gray-500">Klik caption untuk membuka gambar penuh</p>
  </div>
  <div class="col-span-2 space-y-2">
    <img id="portfolioImage" src="" alt="Preview Portofolio" class="w-40 h-40 object-cover rounded border">
    <p>
      <a id="portfolioCaptionLink" href="#" target="_blank" class="text-blue-600 hover:underline">Lihat Portofolio</a>
    </p>
  </div>
</div>
        </div>
            <!-- Rating -->
        <div id="ratingTab" class="worker-tab-content hidden space-y-4">
          <div id="worker-rating-summary" class="text-center"></div>
          <div id="worker-rating-distribution"></div>
          <div id="worker-rating-reviews"></div>
        </div>

      </div>
    </div>

  </div>
</div>


</section>

@include('client.footer')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chat-form');
    if (chatForm) {
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const msg = input.value.trim();
            if (msg && currentWorker) {
                const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                chatData[currentWorker].push({ sender: 'client', message: msg, time: timeNow });
                input.value = '';
                renderChat(currentWorker);
                renderWorkerList();
            }
        });
    }

    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('text-blue-600', 'font-semibold'));
            button.classList.add('text-blue-600', 'font-semibold');
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(button.dataset.tab)?.classList.remove('hidden');
        });
    });

    renderWorkerList();

    document.querySelectorAll('.btn-worker-info').forEach(btn => {
        btn.addEventListener('click', () => {
            renderWorkerModal(workerData);
            showWorkerTab('keahlianTab');
            document.getElementById('workerDetailModal').classList.remove('hidden');
        });
    });
  });
  const applicants = [
    {
    name: "Worker A",
    note: "Saya memiliki pengalaman 3 tahun di bidang ini.",
    price: 500000,
    experience: 3,
    skills: ["Web Development", "UI/UX Design"],
    education: "S1 Informatika",
    cv: "worker-a-cv.pdf",
    empowrLabel: true,
    empowrAffiliate: false,
    reviews: [
      { name: "Fadli H.", rating: 5, comment: "Kerja cepat dan komunikatif!" },
      { name: "Laras N.", rating: 4, comment: "Desain bagus, revisi oke." },
      { name: "Joni W.", rating: 3, comment: "Butuh lebih responsif saat weekend." }
    ],

    // Sertifikat untuk dropdown + preview
    certImages: [
      {
        caption: "10km Berkuda",
        image: "/assets/images/11.jpg"
    },
      {
        caption: "Dicoding Frontend Developer",
        image: "/assets/images/portfolio2.jpg"
    }
    ],
    portfolios: [
      {
        caption: "Mengalahkan mino exp",
        image: "/assets/images/12.jpg"
    },
      {
        caption: "Website Company Profile",
        image: "/assets/images/portfolio2.jpg"
    }
    ]
  },
  {
    name: "Worker B",
    note: "Saya ahli di bidang pemasaran digital selama 5 tahun.",
    price: 650000,
    experience: 5,
    skills: ["Marketing", "Data Science"],
    education: "S2 Marketing",
    cv: "worker-b-cv.pdf",
    empowrLabel: false,
    empowrAffiliate: true,
    reviews: [
      { name: "Dina M.", rating: 5, comment: "Strategi marketing-nya keren banget!" },
      { name: "Andi L.", rating: 5, comment: "Terbukti naikin traffic & engagement." },
      { name: "Sinta Q.", rating: 4, comment: "Detail & tepat waktu." }
    ]
  },
  {
    name: "Worker C",
    note: "Fresh graduate tapi punya banyak proyek freelance.",
    price: 300000,
    experience: 1,
    skills: ["Mobile Development"],
    education: "S1 Teknik Informatika",
    cv: "worker-c-cv.pdf",
    empowrLabel: false,
    empowrAffiliate: false,
    reviews: [
      { name: "Reza A.", rating: 4, comment: "Responsif & punya banyak ide!" },
      { name: "Nina T.", rating: 3, comment: "Masih perlu belajar soal timeline." },
      { name: "Kevin J.", rating: 4, comment: "Sudah oke untuk pemula." }
    ]
  }
];

function calculateAverageRating(reviews) {
  if (!reviews || reviews.length === 0) return 0;
  const total = reviews.reduce((sum, r) => sum + r.rating, 0);
  return total / reviews.length;
}
function calculateRatingDistribution(reviews) {
  const distribution = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
  reviews.forEach(r => {
    distribution[r.rating] = (distribution[r.rating] || 0) + 1;
  });
  return distribution;
}

// Fungsi untuk render list pelamar
function renderApplicants(list) {
  const container = document.getElementById("applicants-list");
  container.innerHTML = "";

  list.forEach((worker, i) => {
    const div = document.createElement("div");
    div.className = "border p-4 rounded";

    div.innerHTML = `
      <p><strong>${worker.name}</strong> - Rp${worker.price.toLocaleString()}</p>
      <p class="text-gray-600 text-sm">Catatan: ${worker.note}</p>
      <p class="text-sm text-gray-500">Pengalaman: ${worker.experience} tahun | Rating: ${worker.rating}</p>
      <div class="flex gap-2 mt-2">
        <button class="bg-blue-500 text-white px-3 py-1 rounded">Chat</button>
        <button class="bg-green-600 text-white px-3 py-1 rounded">Terima</button>
        <button class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
        <button onclick="openWorkerModal(${i})" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
          Lihat Profil Worker
        </button>
      </div>
    `;
    container.appendChild(div);
  });
}

function sortApplicants() {
  const sortBy = document.getElementById("sortBy").value;
  let sorted = [...applicants];

  if (sortBy === "price") {
    sorted.sort((a, b) => a.price - b.price);
  } else if (sortBy === "experience") {
    sorted.sort((a, b) => b.experience - a.experience);
  } else if (sortBy === "rating") {
    sorted.sort((a, b) => calculateAverageRating(b.reviews) - calculateAverageRating(a.reviews));
  }

  renderApplicants(sorted);
}

function renderApplicants(list) {
  const container = document.getElementById("applicants-list");
  container.innerHTML = "";

  list.forEach((worker, i) => {
    const avgRating = calculateAverageRating(worker.reviews);

document.getElementById("worker-rating-summary").innerHTML = `
  <p class="text-lg font-semibold">Rata-rata Rating: ${avgRating.toFixed(1)}</p>
`;

    const div = document.createElement("div");
    div.className = "border p-4 rounded";

    div.innerHTML = `
      <p><strong>${worker.name}</strong> - Rp${worker.price.toLocaleString()}</p>
      <p class="text-gray-600 text-sm">Catatan: ${worker.note}</p>
      <p class="text-sm text-gray-500">
        Pengalaman: ${worker.experience} tahun | Rating: ${avgRating.toFixed(1)}
      </p>
      <div class="flex gap-2 mt-2">
        <button class="bg-blue-500 text-white px-3 py-1 rounded">Chat</button>
        <button class="bg-green-600 text-white px-3 py-1 rounded">Terima</button>
        <button class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
        <button onclick="openWorkerModal(${i})" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
          Lihat Profil Worker
        </button>
      </div>
    `;
    container.appendChild(div);
  });
}



// Modal Worker
function openWorkerModal(index) {
  const worker = applicants[index];
  document.getElementById("worker-name").textContent = worker.name;
document.getElementById("worker-skills-value").textContent = worker.skills.join(", ");
document.getElementById("worker-label").textContent = worker.empowrLabel ? "Ya" : "Tidak";
document.getElementById("worker-affiliate").textContent = worker.empowrAffiliate ? "Ya" : "Tidak";
document.getElementById("worker-education").textContent = worker.education;
document.getElementById("worker-experience").textContent = `${worker.experience} tahun`;
document.getElementById("worker-cv").href = worker.cv || "#";

// Summary
const avgRating = calculateAverageRating(worker.reviews);
document.getElementById("worker-rating-summary").innerHTML = `
  <h3 class="text-2xl font-semibold">${avgRating.toFixed(1)}</h3>
  <p class="text-yellow-500 text-xl">${"⭐".repeat(Math.floor(avgRating))}${avgRating % 1 >= 0.5 ? "✩" : ""}</p>
  <p class="text-sm text-gray-500">Berdasarkan ${worker.reviews.length} rating</p>
`;


// Distribusi
const dist = calculateRatingDistribution(worker.reviews);
const distEl = document.getElementById("worker-rating-distribution");
distEl.innerHTML = "";
for (let i = 5; i >= 1; i--) {
  const count = dist[i];
  const percent = (count / worker.reviews.length) * 100;
  distEl.innerHTML += `
    <div class="flex items-center space-x-2">
      <span class="w-6 text-sm">${i}★</span>
      <div class="w-full bg-gray-200 h-3 rounded">
        <div class="bg-yellow-400 h-3 rounded" style="width: ${percent}%;"></div>
      </div>
      <span class="w-10 text-sm text-gray-600 text-right">${count}</span>
    </div>
  `;
}

// Reviews
const reviewEl = document.getElementById("worker-rating-reviews");
reviewEl.innerHTML = "";
worker.reviews.forEach(r => {
  reviewEl.innerHTML += `
    <div class="border rounded p-4">
      <div class="flex justify-between items-center mb-2">
        <span class="font-semibold">${r.name}</span>
        <span class="text-yellow-500">${"⭐".repeat(r.rating)}</span>
      </div>
      <p class="text-sm text-gray-700">“${r.comment}”</p>
    </div>
  `;
});

// Sertifikat Dropdown
const certSelect = document.getElementById("certSelect");
const certPreview = document.getElementById("certPreview");
certSelect.innerHTML = `<option disabled selected>Lihat Sertifikasi</option>`;

// Cek apakah worker punya sertifikat
if (worker.certImages && worker.certImages.length > 0) {
  worker.certImages.forEach((cert, i) => {
    const option = document.createElement("option");
    option.value = i;
    option.textContent = cert.caption;
    certSelect.appendChild(option);
  });

  certSelect.onchange = () => {
    const selected = worker.certImages[certSelect.value];
    document.getElementById("certImage").src = selected.image;
    document.getElementById("certCaptionLink").href = selected.image;
    document.getElementById("certCaptionLink").textContent = selected.caption;
    certPreview.classList.remove("hidden");
  };
} else {
  certPreview.classList.add("hidden");
}

// Portofolio Dropdown
const portfolioSelect = document.getElementById("portfolioSelect");
const portfolioPreview = document.getElementById("portfolioPreview");

portfolioSelect.innerHTML = `<option disabled selected>Lihat Portofolio</option>`;

if (worker.portfolios && worker.portfolios.length > 0) {
  worker.portfolios.forEach((item, i) => {
    const option = document.createElement("option");
    option.value = i;
    option.textContent = item.caption;
    portfolioSelect.appendChild(option);
  });

  portfolioSelect.onchange = () => {
    const selected = worker.portfolios[portfolioSelect.value];
    document.getElementById("portfolioImage").src = selected.image;
    document.getElementById("portfolioCaptionLink").href = selected.image;
    document.getElementById("portfolioCaptionLink").textContent = selected.caption;
    portfolioPreview.classList.remove("hidden");
  };
} else {
  portfolioPreview.classList.add("hidden");
}
 
showWorkerTab('keahlianTab');
document.getElementById('workerDetailModal').classList.remove('hidden');
}

// Tab Switch Modal
function showWorkerTab(tabId) {
  document.querySelectorAll(".worker-tab-content").forEach(el => el.classList.add("hidden"));
  document.getElementById(tabId).classList.remove("hidden");
}
  
// Inisialisasi awal
renderApplicants(applicants);
</script>

