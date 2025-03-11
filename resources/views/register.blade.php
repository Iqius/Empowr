<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-sm p-8 bg-white shadow-md rounded-md">
        <img src="assets/images/logo.png" alt="Logo" class="w-24 mx-auto mb-4">
        <h2 class="text-3xl font-semibold text-gray-700 text-center">Register</h2>
        <input type="text" placeholder="Username" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="email" placeholder="Email" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <select class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option>Client</option>
            <option>Worker</option>
        </select>
        <input type="password" placeholder="Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="date" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="text" placeholder="No HP" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Sign Up</button>
        <p class="text-sm text-gray-600 mt-3 text-center">Already have an account? <a href="/login" class="text-blue-500 hover:underline">Login</a></p>
    </div>
</body>
</html>