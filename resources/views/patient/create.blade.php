<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor</title>
    <style>
        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
</div>
    <x-app-layout>
        <div class="container">
            <h2>Patient</h2>
            <div>

        Name : {{ Auth::user()->name }} <br>
        Email: {{ Auth::user()->email }} <br>
        Role: {{ Auth::user()->role }} <br>
    </div>
            <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <div>
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('doctor_position')" autofocus autocomplete="doctor_position" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>
                <div class="form-group">
                    <x-input-label for="number" :value="__('Phone Number')" />
                    <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')" autofocus autocomplete="number" />
                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                    <!-- <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="123-456-7890"> -->
                </div>
                <div class="form-group">
                    <div>
                        <x-input-label for="age" :value="__('Age')" />
                        <x-text-input id="age" class="block mt-1 w-full" type="text" name="age" :value="old('age')" autofocus autocomplete="age" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <x-input-label for="birth_date" :value="__('Age')" />
                        <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" autofocus autocomplete="birth_date" />
                        <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                    </div>
                </div>
                <div class="form-group">

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-control">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </select>
                </div>


                <div class="form-group">
                    <!-- <label for="experience">Experience (years)</label>
            <input type="number" id="experience" name="experience" class="form-control" >
            <x-input-error :messages="$errors->get('email')" class="mt-2" /> -->
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" autofocus autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <form action="{{route('patient.store')}}" method="POST">
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                </form>
            </form>
        </div>
        <!-- <x-primary-button class="ms-4">
                Add Patient
            </x-primary-button>
        <button> -->
            <a href="{{route('patient.index')}}">List</a>
        </button>
    </x-app-layout>
</body>

</html>
