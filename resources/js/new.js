document.getElementById("newJobForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const title = document.getElementById("jobTitle").value;
    const description = document.getElementById("jobDescription").value;
    const price = document.getElementById("jobPrice").value;
    const dateEnd = document.getElementById("jobDateEnd").value;
    
    console.log("New Job Added:", { title, description, price, dateEnd });
    alert("Job successfully added!");
    
    this.reset();
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
