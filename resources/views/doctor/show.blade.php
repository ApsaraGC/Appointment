<x-app-layout>

<div class="container">
    <h1>Doctor Details</h1>
    <div>

        <h2>{{ $doctor->doctor_name }}</h2>
        <p><strong>Position:</strong> {{ $doctor->doctor_position }}</p>
        <p><strong>Gender:</strong> {{ $doctor->gender }}</p>
        <p><strong>Shift:</strong> {{ $doctor->shift }}</p>
        <p><strong>Experience:</strong> {{ $doctor->experience }} years</p>
        <p><strong>Phone Number:</strong> {{ $doctor->phone_number }}</p>
        <img src="{{ asset('images/' . $doctor->image) }}" alt="Doctor Image" height="100px" width="100px">

        <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('doctor.index') }}" class="btn btn-primary">Back to List</a>
    </div>
</div>

</x-app-layout>
