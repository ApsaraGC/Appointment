<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Patient Dashboard') }}
            </h2>
            <a href="{{ route('appointment.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Add Appointment
            </a>
        </div>
    </x-slot>



    <div class="py-16">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <!-- Profile Section -->
            <h1 class="text-2xl font-bold mb-6">Hello, {{ Auth::user()->name }}.Your appointments</h1>

            <!-- Appointments Section -->
            <div class="bg-gray-50 dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden">
                @if ($appointments->isEmpty())
                    <p class="text-center text-gray-600 dark:text-gray-400 py-6">No upcoming appointments</p>
                @else
                    <ul class="divide-y divide-gray-300 dark:divide-gray-700">
                        @foreach ($appointments as $appointment)
                            @php
                                $date = \Carbon\Carbon::parse($appointment->date);
                            @endphp
                            <li class="px-6 py-5 hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                            {{ $appointment->description }}
                                        </p>

                                    </div>
                                    <div>
                                        <a href="{{ route('appointment.show', $appointment->id) }}"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
