function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const imgElement = document.getElementById("profile-image");
        imgElement.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function togglePassword() {
    const passwordField = document.getElementById("password");
    const eyeIcon = document.getElementById("eye-icon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.innerHTML = '<path d="M10 3C4 3 0 10 0 10s4 7 10 7 10-7 10-7-4-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>';
    } else {
        passwordField.type = "password";
        eyeIcon.innerHTML = '<path d="M10 3C4 3 0 10 0 10s4 7 10 7 10-7 10-7-4-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10zM10 7a3 3 0 100 6 3 3 0 000-6z"/>';
    }
}

document.getElementById("profile-form").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Perubahan tersimpan!");
    window.location.href = "/jobs";
});
