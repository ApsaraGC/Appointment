<x-app-layout>
    <form method="GET" action="{{ route('appointment.create') }}">
        @csrf

        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department_id" :value="__('Department')" />
            <select id="department_id" name="department_id" class="block mt-1 w-full">
                <option value="" {{ old('department_id') ? 'selected' : '' }}>Select a Department</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}"
                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>

        <!-- Doctor -->
        <div class="mt-4">
            <x-input-label for="doctor_id" :value="__('Doctor')" />
            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full">
                <option value="" {{ old('doctor_id') ? 'selected' : '' }}>Select a Doctor</option>
                @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}"
                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
        </div>

        <!-- Status -->
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" class="block mt-1 w-full">
                <option value="open">Open</option>
                <option value="close">Close</option>
                <option value="pending">Pending</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <!-- Date -->
        <div class="mt-4">
            <x-input-label for="date_time" :value="__('Date')" />
            <x-text-input id="date_time" class="block mt-1 w-full" type="date" name="date_time"
                :value="old('date_time')" />
            <x-input-error :messages="$errors->get('date_time')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                Schedule appointment
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
