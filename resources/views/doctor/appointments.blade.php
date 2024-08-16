<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
</head>
<body>
<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Doctor Dashboard') }}
            </h2>
        </div>

                   {{-- <a href="{{route('doctor.show')}}" class="btn btn-primary">Profileee</a> --}}

    </x-slot>

    <h1>Appointments</h1>

    <table border ='1'>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Department</th>
                <th>Status</th>
                <th>Date and Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->department->name }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->date_time }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
</x-app-layout>
