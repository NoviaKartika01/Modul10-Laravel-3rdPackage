@extends('layouts.app')
@section('content')
    {{-- untuk isi dari conten --}}
    <div class="container-sm mt-5">
        {{-- membuat form, dimana data akan dikirim ke route 'employee.store' menggunakan metode POST --}}
        <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
            {{-- menerapkan CSRF Protection --}}
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="p-5 bg-light rounded-3 border col-xl-6">

                    <div class="mb-3 text-center">
                        <i class="bi-person-circle fs-1"></i>
                        {{-- judul dari form --}}
                        <h4>Edit Employee</h4>
                    </div>
                    <hr>
                    <div class="row">
                        {{-- form untuk First Name --}}
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            {{-- input data Firs Name --}}
                            {{-- @error('age') is-invalid @enderror digunakan untuk menunjukkan terjadi kesalahan dan penanda pada inputan tyang tidak valid --}}
                            <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                name="firstName" id="firstName" value="{{ $errors->any() ? old('firstName') : $employee->firstname }}"
                                placeholder="Enter Last Name">
                            {{-- untuk menampilakan pesan kesalah inputan Firs Name --}}
                            @error('firstName')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- form untuk Last Name --}}
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            {{-- input data Last Name --}}
                            {{-- @error('age') is-invalid @enderror digunakan untuk menunjukkan terjadi kesalahan dan penanda pada inputan tyang tidak valid --}}
                            <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                name="lastName" id="lastName" value="{{ $errors->any() ? old('lastName') : $employee->lastname }}"
                                placeholder="Enter Last Name">
                            {{-- untuk menampilakan pesan kesalah inputan Last Name --}}
                            @error('lastName')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- form untuk Email --}}
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            {{-- input data Email --}}
                            {{-- @error('age') is-invalid @enderror digunakan untuk menunjukkan terjadi kesalahan dan penanda pada inputan tyang tidak valid --}}
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" id="email" value="{{ $errors->any() ? old('email') : $employee->email }}" placeholder="Enter Email">
                            {{-- untuk menampilakan pesan kesalah inputan Email --}}
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- form untuk Age --}}
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            {{-- input data Age --}}
                            {{-- @error('age') is-invalid @enderror digunakan untuk menunjukkan terjadi kesalahan dan penanda pada inputan tyang tidak valid --}}
                            <input type="text" class="form-control @error('age') is-invalid @enderror" name="age"
                                id="age" value="{{ $errors->any() ? old('age') : $employee->age }}" placeholder="Enter Age">
                            {{-- untuk menampilakan pesan kesalah inputan Age --}}
                            @error('age')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- untuk create employee bagian position --}}
                        <div class="col-md-12 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" id="position" class="form-select">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                        {{ $position->code . ' - ' . $position->name }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 d-grid">
                            {{-- memberikan tombol Cancel yang akan diarahkan ke route employees.index --}}
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                    class="bi-arrow-left-circle me-2"> Cancel</i></a>
                        </div>
                        <div class="col-md-6 d-grid">
                            {{-- memebero tombol Save yang menunjukkan bahwa data pada form akan di submit --}}
                            <button type="sumbit" class="btn btn-dark btn-lg mat-3"><i class="bi-check-circle me-2">
                                    Edit</i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
