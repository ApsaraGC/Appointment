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
            <h2>Add New Doctor</h2>
            <div class="form-group">
        Name : {{ Auth::user()->name }} <br>
        Email: {{ Auth::user()->email }} <br>
        Role: {{ Auth::user()->role }} <br>
    </div>
            <form action="{{ route('doctor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                   <div>
                        <x-input-label for="name" :value="__('Position')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="position" :value="old('position')" autofocus autocomplete="position" />
                        <x-input-error :messages="$errors->get('position')" class="mt-2" />
                    </div>
                </div>
                <div class="form-group">

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                <div class="form-group">

                    <label for="department">Department</label>
                    <select id="department" name="department" class="form-control">
                        <!-- <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option> -->

                        @foreach ($departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <x-input-label for="shift" :value="__('Shift')" />
                    <x-text-input id="shift" class="block mt-1 w-full" type="text" name="shift" :value="old('shift')" autofocus autocomplete="shift" />
                    <x-input-error :messages="$errors->get('shift')" class="mt-2" />
                    <!-- <label for="shift">Shift</label>
            <input type="text" id="shift" name="shift" class="form-control" > -->
                </div>
                <div class="form-group">
                    <!-- <x-input-label for="name" :value="__('Image')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" /> -->
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />

                </div>
                <div class="form-group">
                    <!-- <label for="experience">Experience (years)</label>
            <input type="number" id="experience" name="experience" class="form-control" >
            <x-input-error :messages="$errors->get('email')" class="mt-2" /> -->
                    <x-input-label for="name" :value="__('Experience')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="experience" :value="old('experience')" autofocus autocomplete="experience" />
                    <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-input-label for="name" :value="__('Phone Number')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" autofocus autocomplete="phone_number" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    <!-- <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="123-456-7890"> -->
                </div>

                <form action="{{route('doctor.store')}}" method="POST">
                    <button type="submit" class="btn btn-primary">Save Doctor</button>
                </form>

                <div class="flex items-center justify-end">
            <x-primary-button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm">
                Add Doctor
            </x-primary-button>
        </div>
            </form>
        </div>
        <button>
            <a href="{{route('doctor.index')}}">List</a>
        </button>
    </x-app-layout>
</body>

</html>
