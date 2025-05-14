@include('General.header')

<div class="p-4 ">
  <div class="p-4 mt-14">
  <a href="{{ route('add-job-view') }}"
        class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6">
        Add New Job
    </a>
    <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
      Your Tasks
      <span class="text-gray-400 text-base">
        <i class="fas fa-info-circle"></i>
      </span>
    </h2>

    <div class="grid grid-cols-3 gap-4">
      <div class="flex flex-col items-center justify-center h-32 bg-white p-6 rounded border border-gray-300">
        <p class="text-3xl font-bold" style="color: #1F4482;">1</p>
        <p class="text-base font-medium text-gray-600">Jobs Post</p>
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

    <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 gap-6">
      <div class="hidden sm:block"></div>
      <div class="bg-white border rounded p-4 shadow-sm col-span-1 sm:col-span-3">
        <!-- Chart  -->
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-semibold text-lg">Requests by Status</h3>
          <span class="text-sm text-gray-500">2025 </span>
        </div>
        <div class="w-full h-64 relative">
          <canvas id="statusChart" class="absolute left-0 top-0 w-full h-full"></canvas>
        </div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Jobs -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Jobs</h2>
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
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 16 items</div>
          <nav class="inline-flex gap-1">
            <button class="border px-3 py-1 text-sm rounded">1</button>
            <button class="border px-3 py-1 text-sm rounded">2</button>
            <button class="border px-3 py-1 text-sm rounded">3</button>
            <button class="border px-3 py-1 text-sm rounded">4</button>
          </nav>
        </div>
      </div>
      <!-- On Going Jobs -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">On Going Jobs</h2>
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
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 2 of 2 items</div>
        </div>
      </div>

      <!-- Worker Applications -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Worker Applications</h2>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applier Fadel Alif</p>
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
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applier Dede Rahmat</p>
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
                <p class="text-gray-400 text-xs">Applier Risky Farhan</p>
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
                <p class="text-gray-400 text-xs">Applier David Rahmadana</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
        </ul>

        <!-- Pagination -->
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 16 items</div>
          <nav class="inline-flex gap-1">
            <button class="border px-3 py-1 text-sm rounded">1</button>
            <button class="border px-3 py-1 text-sm rounded">2</button>
            <button class="border px-3 py-1 text-sm rounded">3</button>
            <button class="border px-3 py-1 text-sm rounded">4</button>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="jobModal"
  class="fixed inset-0 z-50 flex justify-center items-start overflow-y-auto py-10 bg-gray-800 bg-opacity-50 hidden transition-opacity duration-300 opacity-0">
  <div class="bg-white p-6 rounded shadow-md w-full max-w-lg mx-4">
    <h1 class="text-2xl font-semibold mb-4">Add New Job</h1>
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-3 gap-4">
        <!-- Title -->
        <div class="col-span-2">
          <label class="block text-gray-700">Title</label>
          <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <!-- Price -->
        <div class="col-span-1">
          <label class="block text-gray-700">Price (Rp)</label>
          <input type="number" name="price" class="w-full p-2 border rounded" required>
        </div>

        <!-- Description -->
        <div class="col-span-3">
          <label class="block text-gray-700">Description</label>
          <textarea name="description" class="w-full p-2 border rounded" required></textarea>
        </div>

        <!-- Revisions -->
        <div class="col-span-1">
          <label class="block text-gray-700">Revisions</label>
          <input type="number" name="revisions" class="w-full p-2 border rounded" required>
        </div>

        <!-- Deadline -->
        <div class="col-span-1">
          <label class="block text-gray-700">Deadline</label>
          <input type="date" name="deadline" class="w-full p-2 border rounded" required>
        </div>

        <!-- Deadline Promotion -->
        <div class="col-span-1">
          <label class="block text-gray-700">Deadline Promotion</label>
          <input type="date" name="deadline_promotion" class="w-full p-2 border rounded" required>
        </div>

        <!-- Task Type -->
        <div class="col-span-1">
            <label class="block text-gray-700">Task Type</label>
                <select name="taskType" class="w-full p-2 border rounded" required>
                    <option value="web_development">Web Development</option>
                    <option value="mobile_development">Mobile Development</option>
                    <option value="game_development">Game Development</option>
                    <option value="software_engineering">Software Engineering</option>
                    <option value="frontend_development">Frontend Development</option>
                    <option value="backend_development">Backend Development</option>
                    <option value="full_stack_development">Full Stack Development</option>
                    <option value="devops">DevOps</option>
                    <option value="qa_testing">QA Testing</option>
                    <option value="automation_testing">Automation Testing</option>
                    <option value="api_integration">API Integration</option>
                    <option value="wordpress_development">WordPress Development</option>
                    <option value="data_science">Data Science</option>
                    <option value="machine_learning">Machine Learning</option>
                    <option value="ai_development">AI Development</option>
                    <option value="data_engineering">Data Engineering</option>
                    <option value="data_entry">Data Entry</option>
                    <option value="seo">SEO</option>
                    <option value="content_writing">Content Writing</option>
                    <option value="technical_writing">Technical Writing</option>
                    <option value="blog_writing">Blog Writing</option>
                    <option value="copywriting">Copywriting</option>
                    <option value="scriptwriting">Scriptwriting</option>
                    <option value="proofreading">Proofreading</option>
                    <option value="translation">Translation</option>
                    <option value="transcription">Transcription</option>
                    <option value="resume_writing">Resume Writing</option>
                    <option value="ghostwriting">Ghostwriting</option>
                    <option value="creative_writing">Creative Writing</option>
                    <option value="social_media_management">Social Media Management</option>
                    <option value="digital_marketing">Digital Marketing</option>
                    <option value="email_marketing">Email Marketing</option>
                    <option value="affiliate_marketing">Affiliate Marketing</option>
                    <option value="influencer_marketing">Influencer Marketing</option>
                    <option value="community_management">Community Management</option>
                    <option value="search_engine_marketing">Search Engine Marketing</option>
                    <option value="branding">Branding</option>
                    <option value="graphic_design">Graphic Design</option>
                    <option value="ui_ux_design">UI/UX Design</option>
                    <option value="logo_design">Logo Design</option>
                    <option value="motion_graphics">Motion Graphics</option>
                    <option value="illustration">Illustration</option>
                    <option value="video_editing">Video Editing</option>
                    <option value="video_production">Video Production</option>
                    <option value="animation">Animation</option>
                    <option value="3d_modeling">3D Modeling</option>
                    <option value="video_game_design">Video Game Design</option>
                    <option value="audio_editing">Audio Editing</option>
                    <option value="photography">Photography</option>
                    <option value="photo_editing">Photo Editing</option>
                    <option value="presentation_design">Presentation Design</option>
                    <option value="project_management">Project Management</option>
                    <option value="virtual_assistant">Virtual Assistant</option>
                    <option value="customer_service">Customer Service</option>
                    <option value="lead_generation">Lead Generation</option>
                    <option value="market_research">Market Research</option>
                    <option value="business_analysis">Business Analysis</option>
                    <option value="human_resources">Human Resources</option>
                    <option value="event_planning">Event Planning</option>
                    <option value="bookkeeping">Bookkeeping</option>
                    <option value="accounting">Accounting</option>
                    <option value="tax_preparation">Tax Preparation</option>
                    <option value="financial_analysis">Financial Analysis</option>
                    <option value="legal_advice">Legal Advice</option>
                    <option value="contract_drafting">Contract Drafting</option>
                    <option value="startup_consulting">Startup Consulting</option>
                    <option value="investment_research">Investment Research</option>
                    <option value="real_estate_consulting">Real Estate Consulting</option>
                    <option value="personal_assistant">Personal Assistant</option>
                    <option value="clerical_work">Clerical Work</option>
                    <option value="data_analysis">Data Analysis</option>
                    <option value="business_coaching">Business Coaching</option>
                    <option value="career_coaching">Career Coaching</option>
                    <option value="life_coaching">Life Coaching</option>
                    <option value="consulting">Consulting</option>
                    <option value="other">Other</option>
                </select>
            </div>

        <!-- Provisions -->
        <div class="col-span-3">
          <label class="block text-gray-700">Provisions</label>
          <textarea name="provisions" class="w-full p-2 border rounded"></textarea>
        </div>

        <!-- File Upload -->
        <div class="col-span-3">
          <label class="block text-gray-700">Upload File</label>
          <div id="drop-area-job" class="border-2 border-dashed p-4 text-center cursor-pointer">
            <p id="drop-text-job">Drag & Drop file here or click to select</p>
            <input type="file" name="job_file" id="fileInputJob" class="hidden">
            <p id="file-name-job" class="text-gray-500 text-sm mt-2"></p>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" id="closeModalBtn" class="bg-gray-400 text-white p-2 rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded">Post</button>
      </div>
    </form>
  </div>
</div>


@include('General.footer')

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const jobModal = document.getElementById("jobModal");
    const dropAreaJob = document.getElementById("drop-area-job");
    const fileInputJob = document.getElementById("fileInputJob");
    const fileNameDisplayJob = document.getElementById("file-name-job");
    const sortSelect = document.getElementById("sortSelect");
    const jobContainer = document.getElementById("jobContainer");

    // 🟦 Modal Open/Close
    openModalBtn?.addEventListener("click", () => {
      jobModal?.classList.remove("hidden");

      // ⏫ Tambahkan animasi buka
      setTimeout(() => {
        jobModal?.classList.replace("opacity-0", "opacity-100");
        jobModal?.classList.replace("scale-95", "scale-100");
      }, 10);
    });

    closeModalBtn?.addEventListener("click", () => {
      // ⏬ Tambahkan animasi tutup
      jobModal?.classList.replace("opacity-100", "opacity-0");
      jobModal?.classList.replace("scale-100", "scale-95");

      setTimeout(() => {
        jobModal?.classList.add("hidden");
      }, 300);
    });

    jobModal?.addEventListener("click", (e) => {
      if (e.target === jobModal) {
        // ⏬ Tutup saat klik luar modal + animasi
        jobModal?.classList.replace("opacity-100", "opacity-0");
        jobModal?.classList.replace("scale-100", "scale-95");

        setTimeout(() => {
          jobModal.classList.add("hidden");
        }, 300);
      }
    });

    // 🟩 Drag & Drop File Upload
    dropAreaJob?.addEventListener("click", () => {
      fileInputJob.click();
    });

    fileInputJob?.addEventListener("change", () => {
      if (fileInputJob.files.length > 0) {
        fileNameDisplayJob.textContent = fileInputJob.files[0].name;
      }
    });

    dropAreaJob?.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropAreaJob.classList.add("bg-gray-100");
    });

    dropAreaJob?.addEventListener("dragleave", () => {
      dropAreaJob.classList.remove("bg-gray-100");
    });

    dropAreaJob?.addEventListener("drop", (e) => {
      e.preventDefault();
      dropAreaJob.classList.remove("bg-gray-100");

      const files = e.dataTransfer.files;
      if (files.length > 0) {
        fileInputJob.files = files;
        fileNameDisplayJob.textContent = files[0].name;
      }
    });

    // 🟨 Sort Jobs by Price
    sortSelect?.addEventListener("change", function () {
      const value = this.value;
      if (!jobContainer) return;

      const cards = Array.from(jobContainer.children);
      const sorted = cards.sort((a, b) => {
        const priceA = parseInt(a.dataset.price || "0");
        const priceB = parseInt(b.dataset.price || "0");
        return value === "price-asc" ? priceA - priceB : priceB - priceA;
      });

      jobContainer.innerHTML = "";
      sorted.forEach(card => jobContainer.appendChild(card));
    });

    // ✅ SweetAlert for Success Message
    @if (session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil Login!',
      text: "{{ session('success') }}",
      confirmButtonColor: '#2563EB',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = window.location.href;
    });
  @endif
    });
</script>

<script>

  const statusCtx = document.getElementById('statusChart').getContext('2d');
  new Chart(statusCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [
        {
          label: 'Ongoing',
          data: [10, 20, 15, 25, 30, 45, 40, 15, 25, 30, 45, 40],
          borderColor: '#3b82f6',
          fill: false,
          tension: 0.4,
          pointBackgroundColor: '#3b82f6'
        },
        {
          label: 'Completed',
          data: [5, 15, 10, 20, 25, 30, 35, 12, 23, 10, 25, 10],
          borderColor: '#10b981',
          fill: false,
          tension: 0.4,
          pointBackgroundColor: '#10b981'
        },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,

      plugins: {
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>