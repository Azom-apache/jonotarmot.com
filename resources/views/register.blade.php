<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/apps/favicon.ico') }}">
    <title>Registration Form</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 md:p-10 w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Register</h2>
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="grid gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required minlength="8"
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="country" id="country" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                        <input type="text" name="language" id="language" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                        <input type="text" name="age" id="age" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Gender</label>
                        <input type="text" name="gender" id="age" required
                            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
