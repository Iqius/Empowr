const jobs = [
    { title: "Poster Designer", desc: "Desain suatu poster", price: 200000, client: "Jim" },
    { title: "Tester", desc: "Test web yang telah dibangun", price: 1000000, client: "Jack" },
    { title: "Back-End Engineer", desc: "Menjadi backend startup", price: 7500000, client: "Felix" },
    { title: "Data Labeller", desc: "Ngelabel data", price: 90000, client: "Jim" },
];

document.addEventListener("DOMContentLoaded", function () {
    const jobContainer = document.getElementById("jobContainer");
    const jobTemplate = document.querySelector(".job-card");

    jobs.forEach(job => {
        const jobClone = jobTemplate.cloneNode(true);
        jobClone.classList.remove("hidden"); 

        jobClone.querySelector(".job-title").textContent = job.title;
        jobClone.querySelector(".job-desc").textContent = job.desc.substring(0, 40) + "...";
        jobClone.querySelector(".job-price").textContent = `Rp ${job.price}`;
        jobClone.querySelector(".job-client").textContent = `By ${job.client}`;

        jobContainer.appendChild(jobClone);
    });
});

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