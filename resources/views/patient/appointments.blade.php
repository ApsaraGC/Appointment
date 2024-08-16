<!-- resources/views/patient/appointments.blade.php -->

<x-app-layout>
<div class="container">
    <h1>Your Appointments</h1>

    @if($appointments->isEmpty())
        <p>You have no appointments.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->date->format('Y-m-d H:i') }}</td>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>{{ $appointment->department->name }}</td>
                        <td>
                            <a href="{{ route('patient.appointment.show', $appointment->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-app-layout>
