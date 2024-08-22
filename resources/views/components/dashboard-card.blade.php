<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white dark:bg-purple-800 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $title }}
        </h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-pink-400">
            {{ $content }}
        </p>
        <a href="{{ $route }}" class="text-blue-500 hover:text-blue-700">
            View Details
        </a>
    </div>
</div>
