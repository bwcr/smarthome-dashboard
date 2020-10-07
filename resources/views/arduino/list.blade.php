@extends('layouts.app')

@section('content')
<div id="title">
    <h1 id="heading">Arduino</h1>
    <div class="align-self-center">
        <p class="m-0 text-secondary">Data diperbarui baru saja</p>
        <div class="d-md-inline-flex">
            <p class="m-0">Perangkat Aktif: 2</p>
            <p class="m-0 ml-md-3">Perangkat Tidak Aktif: 2</p>
        </div>
    </div>
</div>
<div id="content" class="row mt-3">
    <div class="col-12 mb-3 d-inline-block">
        <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#tambahPerangkatId"
            aria-expanded="false" aria-controls="tambahPerangkatId">
            + Tambah Perangkat
        </button>
        <a name="refresh" id="refresh" class="float-sm-right btn btn-info btn-sm" href="#refresh" role="button"><svg
                width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                <path
                    d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
            </svg> Refresh</a>
    </div>
    <div class="collapse col-12 col-md-8 mb-3" id="tambahPerangkatId">
        <div id="content-body">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-title">
                        <h4 id="heading" class="d-inline-flex small card-title">
                            {{ __('Tambah Perangkat') }}</h4>
                    </div>
                    <div class="d-inline-block">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                                <span>Buka halaman <a href="bantuan.html">bantuan</a> untuk instruksi
                                    tambah perangkat Arduino</span>
                            </div>
                        </div>
                        <script>
                            $(".alert").alert();

                        </script>
                    </div>
                    <form action="{{ route('arduino.create') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-7 col-lg-6 col-12">
                                <label for="device_name">Device Name</label>
                                <input type="text" name="device_name" id="device_name"
                                    class="form-control @error('device_name') is-invalid @enderror" placeholder=""
                                    aria-describedby="deviceNameId">
                                @error('device_name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-5 col-lg-6 col-12">
                                <label for="device_type">Device Type</label>
                                <select class="form-control" name="device_type" id="device_type">
                                    <option value="Garden">Garden</option>
                                    <option value="Lamp">Lamp</option>
                                    <option value="Temp">Temp</option>
                                    <option value="Door">Door</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ip_address">
                                IP Address
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text" class="form-control @error('ip_address') is-invalid @enderror"
                                name="ip_address" id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                            @error('ip_address')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="wifi_ssid">
                                    SSID Wifi
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                    </svg>
                                </label>
                                <input type="text" class="form-control" name="wifi_ssid" id="wifi_ssid"
                                    aria-describedby="ssidWifiId" placeholder="">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="wifi_password">Password Wifi</label>
                                <input type="password" class="form-control @error('wifi_password') is-invalid @enderror"
                                    name="wifi_password" id="wifi_password" placeholder="">
                                @error('wifi_password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-sm btn-info" type="submit">Add Device</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-3 d-inline-block">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                </svg>
                <span>File untuk Perangkat <b>Pintu 3</b> akan segera diunduh, jika tidak muncul <a
                        href="#unduhPerangkat">Klik Disini</a>. Buka halaman <a href="bantuan.html">bantuan</a> untuk
                    instruksi
                    pemasangan ke perangkat Arduino</span>
            </div>
        </div>
        <script>
            $(".alert").alert();

        </script>
    </div>
    @if($garden)
        <div class="col-12 my-3">
            <h4 id="heading" class="small">{{ __('Garden') }}</h4>
        </div>
    @endif
    @foreach($garden as $snapshot)
        <div id="content-body" class="col-12 col-sm-5 col-lg-4 col-xl-3 mb-3">
            <div id="device" class="card shadow-sm">
                <div class="card-body">
                    <div class="card-title">
                        <h4 id="heading" class="d-inline-flex small card-title">
                            {{ $snapshot['device_name'] }}</h4>
                        <!-- <span class="badge badge-danger align-self-center text-uppercase">baru</span> -->
                    </div>
                    <div class="d-inline-flex">
                        <div class="align-self-center d-inline-block text-primary">
                            <svg width="5em" height="6em" viewBox="0 0 16 16" class="bi bi-phone" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                                <path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            </svg>
                        </div>
                        <div class="d-inline-block">
                            <h6 class="text-success font-weight-bold text-uppercase">• Aktif</h6>
                            <label for="serialNumber">{{__('Last Updated')}}</label>
                            <h6 class="font-weight-bold">29/07/20 16:00</h6>
                        </div>
                    </div>
                    <a href="{{ route('arduino.read', $snapshot->id()) }}"
                        class="stretched-link"></a>
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-12 my-3">
        <h4 id="heading" class="small">{{ __('Rumah') }}</h4>
    </div>
    @foreach($lamp as $snapshot)
        <div id="content-body" class="col-12 col-md-6 col-lg-4 col-xl-4 mb-3">
            <div id="device" class="card shadow-sm">
                <div class="card-body">
                    <div class="card-title">
                        <h4 id="heading" class="d-inline-flex small card-title">
                            {{ $snapshot['device_name'] }}</h4>
                        <!-- <span class="badge badge-danger align-self-center text-uppercase">baru</span> -->
                    </div>
                    <div class="d-inline-flex">
                        <div class="align-self-center d-inline-block text-primary">
                            <svg width="6em" height="7em" viewBox="0 0 16 16" class="bi bi-lamp" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M13 3H3v4h10V3zM3 2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zm4.5-1l.276-.553a.25.25 0 0 1 .448 0L8.5 1h-1zm-.012 9c-.337.646-.677 1.33-.95 1.949-.176.396-.318.75-.413 1.042a3.904 3.904 0 0 0-.102.36c-.01.047-.016.083-.02.11L6 13.5c0 .665.717 1.5 2 1.5s2-.835 2-1.5c0 0 0-.013-.004-.039a1.347 1.347 0 0 0-.02-.11 3.696 3.696 0 0 0-.1-.36 11.747 11.747 0 0 0-.413-1.042A34.827 34.827 0 0 0 8.513 10H7.487zm1.627-1h-2.23C6.032 10.595 5 12.69 5 13.5 5 14.88 6.343 16 8 16s3-1.12 3-2.5c0-.81-1.032-2.905-1.885-4.5z" />
                            </svg>
                        </div>
                        <div class="d-inline-block">
                            <h6 class="text-success font-weight-bold text-uppercase">• Aktif</h6>
                            <label for="serialNumber">{{__('Last Updated')}}</label>
                            <h6 class="font-weight-bold">29/07/20 16:00</h6>
                        </div>
                    </div>
                    <a href="{{ route('arduino.read', $snapshot->id()) }}"
                        class="stretched-link"></a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
