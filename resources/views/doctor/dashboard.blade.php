<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Doctor Dashboard') }}
            </h2>
        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Doctor Information -->
                    <div class="mb-8 border-b border-gray-300 dark:border-gray-600 pb-4">
                        <h3 class="text-3xl font-bold mb-2">Welcome, Dr. {{ $doctor->user->name }}</h3>
                    </div>

                    <!-- Appointments Sections -->
                    <div class="space-y-10">

                        <!-- Today's Appointments -->
                        <div>
                            <h2 class="text-2xl font-semibold mb-5 text-blue-600 dark:text-blue-400">Today's Appointments:</h2>
                            @if (empty($todayAppointments))
                                <p class="text-gray-500">You have no appointments for today.</p>
                            @else
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($todayAppointments as $appointment)
                                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                                            <div class="p-5">
                                                <div class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                                                    Patient: {{ $appointment->patient->user->name }}
                                                </div>
                                                <p class="text-gray-700 dark:text-gray-300">Date: {{ $appointment->date->format('Y-m-d') }}</p>
                                                <p class="text-gray-800 dark:text-gray-200 mt-3">{{ $appointment->details }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Previous Appointments -->
                        <div class="mt-8">
                            <h2 class="text-2xl font-semibold mb-5 text-gray-700 dark:text-gray-300">Previous Appointments:</h2>
                            <div class="mb-4">
                                <p class="text-gray-800 dark:text-gray-200">Total: {{ count($previousAppointments) }}</p>
                            </div>
                            @if (empty($previousAppointments))
                                <p class="text-gray-500">No previous appointments.</p>
                            @else
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($previousAppointments as $appointment)
                                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                                            <div class="p-5">
                                                <div class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                                                    Patient: {{ $appointment->patient->user->name }}
                                                </div>
                                                <p class="text-gray-700 dark:text-gray-300">Date: {{ $appointment->date->format('Y-m-d') }}</p>
                                                <p class="text-gray-800 dark:text-gray-200 mt-3">{{ $appointment->details }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
