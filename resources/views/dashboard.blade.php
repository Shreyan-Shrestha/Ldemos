<!-- resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error Tracking Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <div class="container mx-auto px-6 py-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Error Tracking Dashboard</h1>

        <!-- Error Card -->
        <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-red-600">Latest Error</h2>
                <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700">
                    {{ $data->log_name }}
                </span>
            </div>

            <!-- Exception Info -->
            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">ID:</span> {{ $data->id }}</p>
                    <p><span class="font-semibold text-gray-700">Description:</span> {{ $data->description }}</p>
                    <p><span class="font-semibold text-gray-700">Message:</span> 
                        <span class="text-red-700">{{ $data->properties['exception_message'] }}</span>
                    </p>
                    <p><span class="font-semibold text-gray-700">File:</span> {{ $data->properties['exception_file'] }}</p>
                    <p><span class="font-semibold text-gray-700">Line:</span> {{ $data->properties['exception_line'] }}</p>
                    <p><span class="font-semibold text-gray-700">Code:</span> {{ $data->properties['exception_code'] }}</p>
                </div>

                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">URL:</span> {{ $data->properties['url'] }}</p>
                    <p><span class="font-semibold text-gray-700">Route:</span> {{ $data->properties['route'] }}</p>
                    <p><span class="font-semibold text-gray-700">Route Name:</span> {{ $data->properties['route_name'] }}</p>
                    <p><span class="font-semibold text-gray-700">Method:</span> {{ $data->properties['method'] }}</p>
                    <p><span class="font-semibold text-gray-700">Session ID:</span> {{ $data->properties['session_id'] }}</p>
                    <p><span class="font-semibold text-gray-700">User Agent:</span> 
                        <span class="text-blue-700">{{ $data->properties['user_agent'] }}</span>
                    </p>
                    <p><span class="font-semibold text-gray-700">Referer:</span> {{ $data->properties['referer'] ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Headers -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Headers</h3>
                <div class="bg-gray-100 rounded-lg p-4 overflow-x-auto text-sm font-mono text-gray-700">
                    {{ $data->properties['headers'] }}
                </div>
            </div>

            <!-- Cookies -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Cookies</h3>
                <div class="bg-gray-100 rounded-lg p-4 overflow-x-auto text-sm font-mono text-gray-700">
                    {{ json_encode($data->properties['cookies'], JSON_PRETTY_PRINT) }}
                </div>
            </div>

            <!-- Timestamps -->
            <div class="mt-8 grid grid-cols-3 gap-6 text-sm text-gray-600">
                <p><span class="font-semibold">Timestamp:</span> {{ $data->properties['timestamp'] }}</p>
                <p><span class="font-semibold">Created At:</span> {{ $data->created_at }}</p>
                <p><span class="font-semibold">Updated At:</span> {{ $data->updated_at }}</p>
            </div>
        </div>
    </div>

</body>
</html>
