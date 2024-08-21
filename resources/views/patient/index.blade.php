<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
</head>
<body>
    <h1>My Appointments</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Department</th>
                <th>Status</th>
                <th>Date and Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->department->name }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->date_time }}</td>
                    
                    <td>
                        {{-- <!-- <form action="{{ route('patient.cancelAppointment', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Cancel</button>
                        </form> --> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <a href="{{ route('patient.create') }}">Book a New Appointment</a> -->
</body>
</html>
