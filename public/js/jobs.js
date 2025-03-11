const jobs = [
    { title: "Poster Designer", desc: "Desain suatu poster", price: 200000, client: "Jim" },
    { title: "Tester", desc: "Test web yang telah dibangun", price: 1000000, client: "Jack" },
    { title: "Back-End Engineer", desc: "Menjadi backend startup", price: 7500000, client: "Felix" },
    { title: "Data Labeller", desc: "Ngelabel data", price: 90000, client: "Jim" },
];

function renderJobs() {
    const jobContainer = document.getElementById("jobContainer");
    jobContainer.innerHTML = "";
    jobs.forEach(job => {
        jobContainer.innerHTML += `
            <div class='bg-white p-4 rounded shadow hover:shadow-lg cursor-pointer'>
                <h2 class='text-lg font-semibold text-blue-600'>${job.title}</h2>
                <p class='text-gray-600 text-sm'>${job.desc.substring(0, 40)}...</p>
                <p class='font-bold'>Rp ${job.price}</p>
                <p class='text-sm text-gray-500'>By ${job.client}</p>
            </div>`;
    });
}
renderJobs();

document.getElementById("clientMenuBtn").addEventListener("click", () => {
    document.getElementById("clientMenu").classList.toggle("hidden");
});

document.getElementById("menuBtn").addEventListener("click", () => {
    document.getElementById("menu").classList.toggle("hidden");
});

document.getElementById("logoutBtn").addEventListener("click", () => {
    document.getElementById("logoutModal").classList.remove("hidden");
});

document.getElementById("cancelLogout").addEventListener("click", () => {
    document.getElementById("logoutModal").classList.add("hidden");
});

document.getElementById("confirmLogout").addEventListener("click", () => {
    alert("Logged out successfully!");
    window.location.href = "/login";
});