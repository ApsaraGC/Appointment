<x-app-layout>
    <form method="POST" action="{{ route('appointment.store') }}">
        <input type="hidden" name="department_id" value="{{$department_id}}">
        @csrf
        <div class="mt-4">
            <x-input-label for="doctor_id" :value="__('Doctor')" />
            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full">
                <option value="" {{ old('doctor_id') ? 'selected' : '' }}>Select a Doctor</option>
                @foreach ($department_doctors as $doctor)
                <option value="{{ $doctor->id }}"
                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->user->name }}
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
