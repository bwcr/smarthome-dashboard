@extends('layouts.app')

@section('content')

<div id="title">
    <h1 id="heading">{{ __('profile') }}</h1>
    <div class="d-inline-flex">
        <div class="rounded-circle bg-info py-2 px-3">
        <span class="text-monospace align-middle text-primary font-weight-bold">{{ $initial }}</span>
        </div>
        <div class="d-inline-block ml-2 align-self-center">
        <p class="m-0 font-weight-bold text-primary">{{ $snapshot['first_name'] }} {{ $snapshot['last_name'] }}</p>
            <p class="m-0">{{ $snapshot['email'] }}</p>
        </div>
    </div>
</div>
<div id="content" class="row mt-3">
    <div class="col-12">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
    </div>
    <div id="content-body" class="col-md-6 col-xl-4 col-12">
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="small card-title">{{ __('Edit Profile') }}</h4>
                <form id="editProfileForm" method="POST" action="{{ route('user.update') }}"
                    class="row">
                    @csrf

                    <div class="form-group col-md-6 col-12">
                        <label for="first_name">{{ __('First Name') }}</label>
                        <input type="text" name="first_name" id="firstName"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ $snapshot['first_name'] }}" placeholder=""
                            autocomplete="given-name" autofocus aria-describedby="firstNameId">

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label for="last_name">{{ __('Last Name') }}</label>
                        <input type="text" name="last_name" id="lastName"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ $snapshot['last_name'] }}" placeholder=""
                            autocomplete="family-name" autofocus aria-describedby="lastNameId">

                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ $snapshot['email'] }}" placeholder=""
                            aria-describedby="emailId" autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col">
                        <button type="submit"
                            class="btn btn-info">{{ __('Update Profile') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="content-body" class="col-md-6 col-xl-4 col-12">
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="small card-title">{{ __('Update Password') }}</h4>
                <form id="updatePasswordForm" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">{{ __('Current Password') }}</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                            required autocomplete="current-password" name="current_password" id="password"
                            placeholder="">
                        @error('current_password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('New Password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" required
                            autocomplete="new-password" name="password" id="password" placeholder="">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm New Password') }}</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" id="password-confirm" required autocomplete="new-password"
                            placeholder="">
                        @error('password_confirmation')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info">{{ __('Update Password') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div id="content-body" class="col-md-6 col-xl-5 col-12">
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="small card-title">Hapus Akun</h4>
                <form action="{{ route('user.delete') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="password_delete">Password</label>
                        <input type="password" class="form-control @error('password_delete') is-invalid @enderror"
                            name="password_delete" id="password_delete" placeholder="">
                        @error('password_delete')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <p class="small text-secondary">
                        {{ __('By entering the password in the field above, you will delete all data associated with your account. It cannot be undone.') }}
                    </p>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
    <!-- <div id="empty" class="mx-auto d-block text-center d-none">
                            <img src="assets/undraw_no_data_qbuo.svg" class="img-fluid m-3 w-25 d-none d-sm-inline-flex">
                <img src="assets/undraw_no_data_qbuo.svg" class="img-fluid m-3 w-50 d-sm-none d-inline-flex">
                <p class="d-block text-secondary">Tidak ada data yang ditampilkan</p>
                <button type="button" class="btn d-block mx-auto btn-info">+ Tambah Perangkat</button>
            </div> -->
</div>
</section>
@endsection
