<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<div class="flex justify-center items-center h-screen">

    <!-- Buttons -->
    <div class="">
        <button id="btn_add" class="m-2 text-white bg-gray-400 rounded p-2">+</button>
        <button id="btn_remove" class="m-2 bg-gray-300 rounded p-2">-</button>
    </div>

    <!-- Form -->
    <form action="add_muliple.php" method="post" class="bg-white p-8 rounded-lg shadow-lg" enctype="multipart/form-data">
        <input type="submit" value="Submit" class="btn-submit p-2 rounded hover:opacity" name="btn">

        <div class="mt-4">
            <div class="grid grid-cols-1">
                <!-- Initial Inputs -->
                <div>
                    <input type="text" placeholder="Username" class="input-field" required name="firstname-0">
                    <input type="text" placeholder="Username" class="input-field" required name="lastname-0">
                    <input type="text" placeholder="Username" class="input-field" required name="username-0">
                    <input type="email" placeholder="Email" class="input-field" required name="email-0">
                    <input type="password" placeholder="Password" class="input-field" required name="password-0">
                    <input type="file" class="input-field" accept="image/*" required name="avatar-0">
                    <select name="is_admin-0" class="input-field">
                        <option value="admin">Admin</option>
                        <option value="announcer">Announcer</option>
                    </select>
                </div>

                <!-- Additional Inputs -->
                <div id="forms" class="col-span-2 my-2">
                    <!-- Add inputs dynamically here after pressing + -->
                </div>
            </div>
        </div>

        <!-- Hidden Input for Count -->
        <input type="hidden" value="" id="i" name="i">
    </form>

</div>
<script src="ino_js.js"></script>
</body>

</html>
