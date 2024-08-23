<x-app-layout >
    <x-slot name="header">
        <div class="flex justify-between items-center ">
            <h2 class="font-semibold text-2xl text-purple-800 dark:text-purple-800 leading-tight">
                {{ __('Doctor') }}
            </h2>
            <a href="{{ route('doctor.appointments') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                View All Appointments
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-doctor-image" >
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-brown-100 dark:bg-orange-900 overflow-hidden shadow-lg sm:rounded-lg bg-doctor-image">
                <div class="p-6 text-green-9000 dark:text-green-1000">
                    <!-- Doctor Information -->
                    <div class="mb-20 border-b border-purple-300 dark:border-purple-600 pb-4">
                        <h3 class="text-3xl font-bold mb-2">Welcome, Dr. {{ $doctor->user->name }}</h3>
                    </div>
                    <button>
                        <a href="{{ route('doctor.index') }}">Doctor List</a>
                    </button>
                    <br>
                    <button>
                        <a href="{{ route('doctor.schedules') }}">Schedule</a>
                    </button>
                    <br>

                    <!-- Appointments Sections -->
                    <div class="space-y-10">
                        <!-- Content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bg-doctor-image {
    background-image: url('/images/Doctor.jpg');
    background-size: cover;
    background-position: center;
}

    </style>
</x-app-layout>
