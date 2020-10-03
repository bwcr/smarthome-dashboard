@extends('layouts.app')

@section('content')

<div id="title">
    <h1 id="heading">{{ __('profile') }}</h1>
    <div class="d-inline-flex">
        <div class="rounded-circle bg-info py-2 px-3">
            <span class="text-monospace align-middle text-primary font-weight-bold">{{ $initial }}</span>
        </div>
        <div class="d-inline-block ml-2 align-self-center">
            <p class="m-0 font-weight-bold text-primary">{{ $snapshot['first_name'] }}
                {{ $snapshot['last_name'] }}</p>
            <p class="m-0">{{ $snapshot['email'] }}</p>
        </div>
    </div>
</div>
@if(Session::has('success'))
    <div class="mt-3 alert alert-success" role="alert">
        <strong>{{ Session::get('success') }}</strong>
    </div>
@endif
<div id="content" class="mt-3 card-columns profile-card">
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Edit Profile') }}</h4>
            <form id="editProfileForm" method="POST" action="{{ route('user.update') }}">
                @csrf

                <div class="form-group">
                    <label for="first_name">{{ __('First Name') }}</label>
                    <input type="text" name="first_name" id="firstName"
                        class="form-control @error('first_name') is-invalid @enderror"
                        value="" placeholder=""
                        autocomplete="given-name" autofocus aria-describedby="firstNameId">

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">{{ __('Last Name') }}</label>
                    <input type="text" name="last_name" id="lastName"
                        class="form-control @error('last_name') is-invalid @enderror"
                        value="" placeholder=""
                        autocomplete="family-name" autofocus aria-describedby="lastNameId">

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-info">{{ __('Update Profile') }}</button>
            </form>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Edit Email') }}</h4>
            <form id="editProfileForm" method="POST" action="{{ route('email.update') }}" class="row">
                @csrf

                <div class="form-group col-12">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="" placeholder=""
                        aria-describedby="emailId" autocomplete="email">
                    <small id="emailId" class="text-muted">{{ __('Updating email address redirects you to authenticate your login credentials and verify your
                            email again.') }}</small>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder=""
                        aria-describedby="passwordId">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-info">{{ __('Update Email') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Update Password') }}</h4>
            <form id="updatePasswordForm" method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-group">
                    <label for="current_password">{{ __('Current Password') }}</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" required
                        autocomplete="current-password" name="current_password" id="password" placeholder="">
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
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">Hapus Akun</h4>
            <form action="{{ route('user.delete') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="password_delete">Password</label>
                    <input type="password" class="form-control @error('password_delete') is-invalid @enderror"
                        name="password_delete" required id="password_delete" placeholder="">
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
    <!-- <div id="empty" class="mx-auto d-block text-center d-none">
                            <img src="assets/undraw_no_data_qbuo.svg" class="img-fluid m-3 w-25 d-none d-sm-inline-flex">
                <img src="assets/undraw_no_data_qbuo.svg" class="img-fluid m-3 w-50 d-sm-none d-inline-flex">
                <p class="d-block text-secondary">Tidak ada data yang ditampilkan</p>
                <button type="button" class="btn d-block mx-auto btn-info">+ Tambah Perangkat</button>
            </div> -->
</div>
</section>
@endsection
