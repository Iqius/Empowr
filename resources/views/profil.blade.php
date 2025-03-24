@include('client.header')
<div class="p-4 sm:ml-60 mt-10">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <!-- Header Profil -->
        <div class="flex flex-col md:flex-row items-center gap-4">
            <label for="profile-pic" class="cursor-pointer">
            <img id="profile-image" src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" alt="Profile Picture" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
            </label>
            <input type="file" name="profile_image" id="profile-pic" accept="image/*" class="hidden" onchange="previewImage(event)">
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold">Username</h2>
                <span id="verificationBadge" class="text-blue-500 ">✔ Verified</span>
            </div>
        </div>
        
               <!-- Tabs -->
        <div class="flex justify-center md:justify-start mt-6 border-b">
            <button onclick="showTab('dataDiri')" class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600">Data Diri</button>
            <button onclick="showTab('keahlian')" class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600">Keahlian</button>
            <button onclick="showTab('rating')" class="tab-button px-4 py-2 text-gray-600 hover:text-blue-600">Rating</button>
        </div>

        <!-- Content -->
        <div id="dataDiri" class="tab-content p-4">
        <div class="space-y-4">
            <!-- Nama Lengkap -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Nama Lengkap:</label>
                    <p class="text-sm text-gray-500">Nama sesuai identitas</p>
                </div>
                <input type="text" value="{{ Auth::user()->name }}" class="col-span-2 p-2 border rounded w-full">
            </div>
            
            <!-- Email -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Email:</label>
                    <p class="text-sm text-gray-500">Gunakan email aktif</p>
                </div>
                <input type="email" value="{{ Auth::user()->email }}" class="col-span-2 p-2 border rounded w-full">
            </div>
            
            <!-- Role -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Role:</label>
                    <p class="text-sm text-gray-500">Role anda saat ini</p>
                </div>
                <input 
                    type="text" 
                    value="{{ Auth::user()->role }}" 
                    readonly
                    class="col-span-2 p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                >
            </div>

            
            <!-- No Telp -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">No Telp:</label>
                    <p class="text-sm text-gray-500">Nomor yang bisa dihubungi</p>
                </div>
                <input type="text" value="{{ Auth::user()->phone }}"class="col-span-2 p-2 border rounded w-full">
            </div>
            
            <!-- Alamat -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Alamat:</label>
                    <p class="text-sm text-gray-500">Alamat tempat tinggal</p>
                </div>
                <input type="text" value="Chang'an" class="col-span-2 p-2 border rounded w-full">
            </div>
            
            <!-- Negara -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Negara:</label>
                    <p class="text-sm text-gray-500">Domisili negara</p>
                </div>
                <input type="text" value="Indonesia" class="col-span-2 p-2 border rounded w-full">
            </div>
            
            <!-- Tanggal Bergabung -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Tgl Bergabung:</label>
                    <p class="text-sm text-gray-500">Tanggal bergabung</p>
                </div>
                <input type="date" value="2022-01-01" class="col-span-2 p-2 border rounded w-full">
            </div>

             <!-- Jenis Rekening -->
             <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Jenis Rekening:</label>
                    <p class="text-sm text-gray-500">Pilih jenis rekening</p>
                </div>
                <select id="rekeningType" class="col-span-2 p-2 border rounded w-full" onchange="updateRekeningFields()">
                    <option value="ewallet">E-Wallet</option>
                    <option value="bank">Bank</option>
                </select>
            </div>
            
            <!-- E-Wallet Fields -->
            <div id="ewalletFields" class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">No Telepon:</label>
                    <p class="text-sm text-gray-500">Nomor akun e-wallet</p>
                </div>
                <input type="text" value="+62 812 3456 7890" class="col-span-2 p-2 border rounded w-full">
                <div>
                    <label class="font-semibold">Nama Pengguna:</label>
                    <p class="text-sm text-gray-500">Nama di akun e-wallet</p>
                </div>
                <input type="text" value="yao ni ma" class="col-span-2 p-2 border rounded w-full">
            </div>
            
                <!-- Bank Fields -->
                <div id="bankDropdown" class="grid grid-cols-3 items-center gap-4" style="display: none;">
                <div>
                    <label class="font-semibold">Pilih Bank:</label>
                    <p class="text-sm text-gray-500">Bank yang digunakan</p>
                </div>
                <select class="col-span-2 p-2 border rounded w-full">
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="cimb">BSI</option>
                </select>
            </div>
            <div id="bankFields" class="grid grid-cols-3 items-center gap-4" style="display: none;">
                <div>
                    <label class="font-semibold">No Rekening:</label>
                    <p class="text-sm text-gray-500">Nomor rekening bank</p>
                </div>
                <input type="text" value="1234567890" class="col-span-2 p-2 border rounded w-full">
                <div>
                    <label class="font-semibold">Nama Pemilik:</label>
                    <p class="text-sm text-gray-500">Nama di rekening bank</p>
                </div>
                <input type="text" value="John Doe" class="col-span-2 p-2 border rounded w-full">
            </div>
        </div>
        </div>
        
        <div id="keahlian" class="tab-content p-4 hidden">
        <div class="space-y-4">
            <!-- Keahlian -->
            <div class="grid grid-cols-3 items-start gap-4">
                <div>
                    <label class="font-semibold">Keahlian:</label>
                    <p class="text-sm text-gray-500">Pilih keahlian yang dimiliki</p>
                </div>
                <div class="col-span-2">
                    <select id="keahlian-select" name="keahlian" multiple class="w-full p-2 border rounded">
                        <option value="web_dev">Web Development</option>
                        <option value="mobile_dev">Mobile Development</option>
                        <option value="uiux">UI/UX Design</option>
                        <option value="data_sci">Data Science</option>
                        <option value="marketing">Marketing</option>
                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                    </select>
                </div>
            </div>


            <!-- Empowr Label -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Empowr Label:</label>
                    <p class="text-sm text-gray-500">Tandai jika memiliki label</p>
                </div>
                <input type="checkbox" class="col-span-2 w-6 h-6">
            </div>

            <!-- Empowr Affiliate -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Empowr Affiliate:</label>
                    <p class="text-sm text-gray-500">Tandai jika bagian dari affiliate</p>
                </div>
                <input type="checkbox" class="col-span-2 w-6 h-6">
            </div>

            <!-- CV Upload -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Unggah CV:</label>
                    <p class="text-sm text-gray-500">Tarik dan letakkan file di sini</p>
                </div>
                <div class="col-span-2">
                    <div id="drop-area" class="border-2 border-dashed p-4 text-center cursor-pointer rounded">
                        <p id="drop-text">Drag & Drop file here or click to select</p>
                        <input type="file" name="cv_file" id="fileInput" class="hidden">
                        <p id="file-name" class="text-gray-500 text-sm mt-2"></p>
                    </div>
                </div>
            </div>

            <!-- Pengalaman Kerja -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Pengalaman Kerja:</label>
                    <p class="text-sm text-gray-500">Masukkan pengalaman kerja</p>
                </div>
                <input type="text" class="col-span-2 p-2 border rounded w-full">
            </div>

            <!-- Pendidikan -->
            <div class="grid grid-cols-3 items-center gap-4">
                <div>
                    <label class="font-semibold">Pendidikan:</label>
                    <p class="text-sm text-gray-500">Masukkan jenjang pendidikan terakhir</p>
                </div>
                <input type="text" class="col-span-2 p-2 border rounded w-full">
            </div>

            <div class="space-y-4 mt-6">
                <!-- Upload Sertifikasi -->
                <div class="grid grid-cols-3 items-start gap-4">
                    <div>
                    <label class="font-semibold">Sertifikasi:</label>
                    <p class="text-sm text-gray-500">Unggah gambar sertifikat dan beri caption</p>
                    </div>
                    <div class="col-span-2 space-y-2">
                    <input type="file" id="cert-upload" accept="image/*" class="w-full p-2 border rounded">
                    <input type="text" id="cert-caption" placeholder="Tuliskan caption sertifikat..." class="w-full p-2 border rounded">
                    <button type="button" onclick="addCertificate()" class="bg-blue-600 text-white px-3 py-1 rounded">
                        Tambahkan Sertifikat
                    </button>
                    </div>
                </div>

                <!-- Dropdown Pilihan Sertifikat -->
                <div class="grid grid-cols-3 items-start gap-4">
                <div>
                    <label class="font-semibold">Pilih Sertifikat:</label>
                    <p class="text-sm text-gray-500">Lihat sertifikat yang telah ditambahkan</p>
                </div>
                <div class="col-span-2">
                    <select id="certSelect" class="p-2 border rounded w-full">
                        <option disabled selected>Pilih Sertifikasi</option>
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
                <div class="space-y-4 mt-6">
                <!-- Upload Portofolio -->
                <div class="grid grid-cols-3 items-start gap-4">
                <div>
                    <label class="font-semibold">Portofolio:</label>
                    <p class="text-sm text-gray-500">Unggah gambar portofolio dan beri caption</p>
                </div>
                <div class="col-span-2 space-y-2">
                    <input type="file" id="portfolio-upload" accept="image/*" class="w-full p-2 border rounded">
                    <input type="text" id="portfolio-caption" placeholder="Tuliskan caption portofolio..." class="w-full p-2 border rounded">
                    <button type="button" onclick="addPortfolio()" class="bg-blue-600 text-white px-3 py-1 rounded">
                    Tambahkan Portofolio
                    </button>
                </div>
                </div>

                <!-- Dropdown Pilihan Portofolio -->
                <div class="grid grid-cols-3 items-start gap-4 mt-4">
                <div>
                    <label class="font-semibold">Pilih Portofolio:</label>
                    <p class="text-sm text-gray-500">Lihat portofolio yang telah ditambahkan</p>
                </div>
                <div class="col-span-2">
                    <select id="portfolioSelect" class="p-2 border rounded w-full">
                    <option disabled selected>Pilih Portofolio</option>
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
        </div>
        <div id="rating" class="tab-content p-4 hidden space-y-6">
            <!-- Container untuk rating summary -->
            <div id="rating-summary" class="text-center"></div>

            <!-- Container untuk distribusi rating -->
            <div id="rating-distribution" class="space-y-2"></div>

            <!-- Container untuk daftar ulasan -->
            <div id="rating-reviews" class="space-y-4"></div>
        </div>
    </div>
    <!-- Save Buttons -->
    <div class="flex flex-col sm:flex-row justify-center sm:justify-end items-center gap-3 mt-6 px-4">
        <button
            onclick="window.location.reload()"
            class="w-full sm:w-auto bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
            Cancel
        </button>
        <button
            onclick="saveChanges()"
            class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Save
        </button>
    </div>
</div>

<script>
    //norek
    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');
    }
    
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('profile-image').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function updateRekeningFields() {
            var rekeningType = document.getElementById("rekeningType").value;
            var ewalletFields = document.getElementById("ewalletFields");
            var bankFields = document.getElementById("bankFields");
            var bankDropdown = document.getElementById("bankDropdown");
            
            if (rekeningType === "ewallet") {
                ewalletFields.style.display = "grid";
                bankFields.style.display = "none";
                bankDropdown.style.display = "none";
            } else {
                ewalletFields.style.display = "none";
                bankFields.style.display = "grid";
                bankDropdown.style.display = "grid";
            }
        }
        new TomSelect('#keahlian-select', {
        plugins: ['remove_button'],
        placeholder: 'Pilih keahlian...',
        persist: false,
        create: false,
        maxItems: null
    });
        const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("fileInput");
    const fileNameDisplay = document.getElementById("file-name");

    // Handle click to open file dialog
    dropArea.addEventListener("click", () => {
        fileInput.click();
    });

    // Display selected file name
    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = fileInput.files[0].name;
        }
    });

    // Handle drag & drop
    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("bg-gray-100");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("bg-gray-100");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("bg-gray-100");

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileNameDisplay.textContent = files[0].name;
        }
    });
    // Data dummy rating
    const ratingData = {
            average: 4.5,
            totalVotes: 120,
            distribution: {
                5: 72,
                4: 30,
                3: 10,
                2: 6,
                1: 2
            },
            reviews: [
                {
                    name: "Rizky A.",
                    rating: 5,
                    comment: "Sangat profesional dan responsif!"
                },
                {
                    name: "Dina M.",
                    rating: 4,
                    comment: "Pekerjaan selesai tepat waktu dan hasil memuaskan."
                },
                {
                    name: "Andi S.",
                    rating: 3,
                    comment: "Masih bisa ditingkatkan, terutama dalam komunikasi."
                }
            ]
        };

    // Render Summary
    const summaryEl = document.getElementById("rating-summary");
    summaryEl.innerHTML = `
        <h3 class="text-2xl font-semibold">${ratingData.average.toFixed(1)}</h3>
        <p class="text-yellow-500 text-xl">${"⭐".repeat(Math.floor(ratingData.average))}☆</p>
        <p class="text-sm text-gray-500">Berdasarkan ${ratingData.totalVotes} rating</p>
    `;

    // Render Distribution
    const distributionEl = document.getElementById("rating-distribution");
    const total = ratingData.totalVotes;
    for (let i = 5; i >= 1; i--) {
        const count = ratingData.distribution[i] || 0;
        const percent = (count / total * 100).toFixed(1);
        distributionEl.innerHTML += `
            <div class="flex items-center space-x-2">
                <span class="w-6 text-sm">${i}★</span>
                <div class="w-full bg-gray-200 h-3 rounded">
                    <div class="bg-yellow-400 h-3 rounded" style="width: ${percent}%;"></div>
                </div>
                <span class="w-10 text-sm text-gray-600 text-right">${count}</span>
            </div>
        `;
    }

    // Render Reviews
    const reviewEl = document.getElementById("rating-reviews");
    ratingData.reviews.forEach(r => {
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
    // //save data + alert e
    // function saveChanges() {
    //     const data = {
    //         nama: document.querySelector('input[type="text"]').value,
    //         email: document.querySelector('input[type="email"]').value,
    //         // Tambahkan field lain jika perlu
    //     };

    //     fetch('/update-profile', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         body: JSON.stringify(data)
    //     })
    //     .then(res => {
    //         if (!res.ok) throw new Error('Gagal menyimpan');
    //         return res.json();
    //     })
    //     .then(() => {
    //         // ✅ SweetAlert muncul di tengah
    //         Swal.fire({
    //             icon: 'success',
    //             title: 'Data telah diperbarui!',
    //             showConfirmButton: true,
    //             confirmButtonText: 'OK',
    //             confirmButtonColor: '#2563EB', // Tailwind blue-600
    //             timer: 2500
    //         }).then(() => {
    //             window.location.reload();
    //         });
    //     })
    //     .catch(err => {
    //         console.error(err);
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Gagal menyimpan!',
    //             text: 'Pastikan data anda benar',
    //             confirmButtonColor: '#2563EB'

    //         });
    //     });
    // }
    //iki fe tok mas
    function saveChanges() {
        // Simulasi loading data
        Swal.fire({
            title: 'Menyimpan...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false
        });

        // Simulasi delay seolah-olah fetch berhasil
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Data telah diperbarui!',
                confirmButtonColor: '#2563EB',
                confirmButtonText: 'OK'
            }).then(() => {
                // Refresh atau aksi lain setelah user klik OK
                window.location.reload();
            });
        }, 1500); // 1.5 detik delay
    }
    const dummyCertificates = [
    {
      caption: "Sertifikasi Web Developer - Dicoding",
      image: "https://via.placeholder.com/300x200?text=Certificate+1"
    },
    {
      caption: "UI/UX Fundamental - Coursera",
      image: "https://via.placeholder.com/300x200?text=Certificate+2"
    },
    {
      caption: "Mobile legend exp lane",
      image: "/assets/images/12.jpg"
    }
  ];

  document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById("certSelect");
    const preview = document.getElementById("certPreview");
    const certImage = document.getElementById("certImage");
    const certLink = document.getElementById("certCaptionLink");

    // Isi dropdown
    dummyCertificates.forEach((cert, index) => {
      const option = document.createElement("option");
      option.value = index;
      option.textContent = cert.caption;
      select.appendChild(option);
    });

    // Saat memilih opsi
    select.addEventListener("change", function () {
      const selected = dummyCertificates[this.value];
      if (selected) {
        certImage.src = selected.image;
        certLink.href = selected.image;
        certLink.textContent = selected.caption;
        preview.classList.remove("hidden");
      }
    });
  });
  const portfolioData = [
    {
      caption: "Redesign UI App Travel",
      image: "/assets/images/portfolio1.jpg"
    },
    {
      caption: "Landing Page Produk UMKM",
      image: "/assets/images/portfolio2.jpg"
    },
    {
      caption: "Menjinakkan kuda",
      image: "/assets/images/11.jpg"
    }
  ];

  // Populate dummy saat halaman dibuka
  document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById("portfolioSelect");

    portfolioData.forEach((item, index) => {
      const option = document.createElement("option");
      option.value = index;
      option.textContent = item.caption;
      select.appendChild(option);
    });

    // Handle preview saat dipilih
    select.addEventListener("change", function () {
      const selected = portfolioData[this.value];
      if (selected) {
        document.getElementById("portfolioImage").src = selected.image;
        document.getElementById("portfolioCaptionLink").href = selected.image;
        document.getElementById("portfolioCaptionLink").textContent = selected.caption;
        document.getElementById("portfolioPreview").classList.remove("hidden");
      }
    });
  });

  // Fungsi tambah portofolio manual (upload lokal)
  function addPortfolio() {
    const fileInput = document.getElementById('portfolio-upload');
    const captionInput = document.getElementById('portfolio-caption');
    const select = document.getElementById('portfolioSelect');

    const file = fileInput.files[0];
    const caption = captionInput.value.trim();

    if (!file || !caption) {
      alert("Silakan unggah gambar dan isi caption.");
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      const url = e.target.result;

      portfolioData.push({ image: url, caption });

      const option = document.createElement("option");
      option.value = portfolioData.length - 1;
      option.textContent = caption;
      select.appendChild(option);

      fileInput.value = '';
      captionInput.value = '';
    };

    reader.readAsDataURL(file);
  }
</script>
@include('client.footer')
