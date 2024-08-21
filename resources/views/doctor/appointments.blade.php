<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-purple-900 leading-tight">
                {{ __('Doctor') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-purple-900 dark:text-purple-200">
                    <h1 class="text-3xl font-bold mb-4">Appointments</h1>

                    <table class="min-w-full bg-white dark:bg-pink-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Patient Name</th>
                                <th class="py-2 px-4 border-b">Department</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Date and Time</th>
                                <th class="py-2 px-4 border-b">Edit Time</th>
                                {{-- <th class="py-2 px-4 border-b">Description</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $appointment->patient->user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $appointment->department->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $appointment->status }}</td>
                                    <td class="py-2 px-4 border-b">{{ $appointment->date_time }}</td>

                                     <td>
                                        <a href="{{ route('appointment.reschedule', $appointment->id) }}" class="btn btn-primary">Reschedule</a>
                                     </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <!-- Back to Dashboard Button -->
    <a href="{{ route('doctor.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <style>
       .btn {
            display: inline-block;
            padding: 9px 17px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin:5px 15px;
            border-radius: 8px;
            cursor: pointer;
       }

        .btn-primary {
            background-color: #ff8800;
            color: white;
        }
    </style>
</x-app-layout>
