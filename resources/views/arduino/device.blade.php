@extends('layouts.app')

@section('content')

<div id="title">
    <h1 id="heading">{{ $data['device_type'] }}
        {{ $data['device_name'] }}
    </h1>
    <div class="align-self-center d-inline-flex">
        <p class="m-0 text-secondary">{{ __('Added on') }}
            {{ $data['date_created'] }}</p>
        <p class="mx-3 text-secondary"> IP Address: {{ $data['ip_address'] }} </p>
        <p class="mr-3 text-secondary"> Wifi Name: {{ $data['wifi_ssid'] }} </p>
    </div>
    <nav aria-label="breadcrumb" class="breadcrumb">
        <a class="breadcrumb-item"
            href="{{ route('arduino') }}">{{ __('Arduino') }}</a>
        <span aria-current="page" class="breadcrumb-item active">{{ $data['device_name'] }}</span>
    </nav>
</div>
<div id="content" class="mt-3">
    <div class="d-block">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Rerata Data') }}</h4>
            <nav>
                <div id="nav-tab" role="tablist" class="nav small justify-content-end">
                    <a aria-controls="table" id="nav-table-tab" data-toggle="tab" role="tab" aria-selected="true"
                        class="px-2 nav-link active" href="#table-view"><svg width="1em" height="1em"
                            viewBox="0 0 16 16" class="bi bi-table" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z" />
                        </svg> Tabel</a>
                    <a aria-selected="false" aria-controls="graph" data-toggle="tab" id="nav-graph-tab"
                        class="nav-link px-2" href="#graph-view"><svg width="1em" height="1em" viewBox="0 0 16 16"
                            class="bi bi-graph-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M0 0h1v15h15v1H0V0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5z" />
                        </svg> Grafik</a>
                </div>
            </nav>
            <div class="tab-content mt-3" id="nav-tabContent">
                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-table-tab" id="table-view">
                    <p class="text-right w-100">Export ke: <a href="#exportCSV" class="text-primary">CSV</a>, <a
                            href="#exportExcel" class="text-primary">Excel</a>
                    </p>
                    <div class="mb-md-0 mb-3">
                        <div class="form-group d-md-inline-flex pr-3">
                            <input type="date" class="form-control form-control-sm" name="date-start" id="date-start"
                                aria-describedby="dateStart" placeholder="yyyy/mm/dd">
                            <span class="px-3 text-center d-block">s/d</span>
                            <input type="date" class="form-control form-control-sm" name="date-end" id="date-end"
                                aria-describedby="dateEnd" placeholder="yyyy/mm/dd">
                        </div>
                        <button type="button" class="btn btn-info btn-sm px-3 h-25">Cari</button>
                    </div>
                    <table class="table table-striped table-responsive-sm small">
                        <thead>
                            <tr>
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('Jam') }}</th>
                                <th>{{ __('Soil') }}</th>
                                <th>{{ __('Suhu') }}</th>
                                <th>{{ __('Kelembapan') }}</th>
                                <th>{{ __('Relay') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sensor'] as $sensor)
                                <tr>
                                    <td>{{ $sensor['tanggal'] }}</td>
                                    <td>{{ $sensor['jam'] }}</td>
                                    <td>{{ $sensor['sm'] }}</td>
                                    <td>{{ $sensor['suhu'] }}</td>
                                    <td>{{ $sensor['lembap'] }}</td>
                                    <td>{{ $sensor['relay'] }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="nav-graph-tab" id="graph-view">
                    <div class="mb-md-0 mb-3">
                        <nav class="nav nav-pills font-weight-bold justify-content-center">
                            <a aria-selected="true" aria-controls="column" data-toggle="tab" id="nav-column-tab"
                                class="nav-link rounded-pill active" href="#column-view">Column</a>
                            <a aria-selected="false" aria-controls="line" data-toggle="tab" id="nav-line-tab"
                                class="nav-link rounded-pill" href="#line-view">Line</a>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-column-tab"
                                id="column-view">
                                <nav class="nav nav-pills small justify-content-end font-weight-bold">
                                    <a aria-selected="true" aria-controls="column-day" data-toggle="tab"
                                        id="nav-column-day-tab" class="nav-link rounded-pill active"
                                        href="#column-day-view">Hari</a>
                                    <a aria-selected="false" aria-controls="column-month" data-toggle="tab"
                                        id="nav-column-month-tab" class="nav-link rounded-pill"
                                        href="#column-month-view">Bulan</a>
                                    <a aria-selected="false" aria-controls="column-year" data-toggle="tab"
                                        id="nav-column-year-tab" class="nav-link rounded-pill"
                                        href="#column-year-view">Tahun</a>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" role="tabpanel"
                                        aria-labelledby="nav-column-day-tab" id="column-day-view">
                                        <canvas id="columnDayChart" width="400" height="200"></canvas>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="nav-column-month-tab"
                                        id="column-month-view">
                                        Bulan
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="nav-column-month-tab"
                                        id="column-year-view">
                                        Tahun
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" aria-labelledby="nav-line-tab" id="line-view">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content" class="mt-3 row">
    <div id="content-body" class="col-12 col-lg-7 col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="card-title small">{{ __('Edit Device') }}</h4>
                <form action="{{ route('arduino.update', $id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 col-12">
                            <label for="device_name">{{ __('Device Name') }}</label>
                            <div class="d-flex">
                                <span
                                    class="mr-3 align-self-center text-uppercase">{{ $data['device_type'] }}</span>
                                <input type="text" name="device_name" id="device_name"
                                    value="{{ $data['device_name'] }}"
                                    class="form-control @error('device_type') is-invalid @enderror" placeholder=""
                                    aria-describedby="device_nameId">
                                @error('device_name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="ip_address">
                                {{ __('IP Address') }}
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text" class="form-control @error('ip_address') is-invalid @enderror"
                                value="{{ $data['ip_address'] }}" name="ip_address"
                                id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                            @error('ip_address')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="wifi_ssid">
                                {{ __('SSID') }}
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text" value="{{ $data['wifi_ssid'] }}"
                                class="form-control @error('wifi_ssid') is-invalid @enderror" name="wifi_ssid"
                                id="wifi_ssid" aria-describedby="wifi_ssidId" placeholder="">
                            @error('wifi_ssid')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="wifi_password">{{ __('Wifi Password') }}</label>
                            <input type="password" value="{{ $data['wifi_password'] }}"
                                class="form-control @error('wifi_password') is-invalid @enderror" name="wifi_password"
                                id="wifi_password" placeholder="">
                            @error('wifi_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-sm btn-info"
                        type="submit">{{ __('Update Device') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div id="content-body" class="col-7 col-md-4 col-xl-3 mt-md-0 mt-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="small card-title text-center">{{ __('Delete Device') }}</h4>
                <div class="d-block text-center">
                    <form method="POST" action="{{ route('arduino.delete', $id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="password">{{__('Password')}}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Enter your current password">
                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
