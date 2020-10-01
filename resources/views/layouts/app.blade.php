<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        .hidden {
            display: none;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
        $('html').addClass('hidden');
        $(window).on('load',
            function () { // EDIT: From Adam Zerner's comment below: Rather use load: $(window).on('load', function () {...});
                $('html').removeClass('hidden'); // EDIT: Can also use $('html').removeClass('hidden');
            });

    </script>

    <!-- Bootstrap CSS -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,700;1,900&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


</head>

<body>
    <main>
        <div class="bg-light">
            <div class="container-fluid">
                <section id="desktop" class="row">
                    @if(Session::has('user'))
                        <nav class="col-sm-2 sidebar d-lg-inline-block bg-white d-none border-right min-vh-100 pt-3">
                            <div class="sidebar-sticky container">
                                <ul class="nav flex-column">
                                    <div class="mb-3">
                                        <label id="heading" class="nav-link text-secondary">Dashboard</label>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-house-door-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z" />
                                                    <path fill-rule="evenodd"
                                                        d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                                </svg> Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if(Request::is('arduino')) active @endif"
                                                href="{{ route('arduino') }}">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-terminal-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm9.5 5.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm-6.354-.354L4.793 6.5 3.146 4.854a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708z" />
                                                </svg> {{ __('Arduino') }}
                                            </a>
                                        </li>
                                    </div>
                                    <div class="mb-3">
                                        <label id="heading" class="nav-link text-secondary">Lainnya</label>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-question-circle-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.57 6.033H5.25C5.22 4.147 6.68 3.5 8.006 3.5c1.397 0 2.673.73 2.673 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.355H7.117l-.007-.463c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.901 0-1.358.603-1.358 1.384zm1.251 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                                                </svg> Bantuan
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if(Request::is('profile')) active @endif"
                                                href="{{ route('profile') }}">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-person-square" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                                </svg> {{ __('Profil') }}
                                            </a>
                                        </li>
                                    </div>
                                    <a name="logout" id="logout" class="btn btn-info"
                                        href="{{ route('logout') }}" role="button">Logout</a>
                                </ul>
                            </div>
                        </nav>
                        <div class="container-md col-sm-10 py-3 px-md-5 px-sm-0 px-3">
                            @yield('content')
                        </div>
                    @else
                        @yield('content')
                    @endif
            </div>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    {{-- <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <!-- Insert this script at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Add the entire Firebase JavaScript SDK -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.21.0/firebase.js"></script>
    <script type="module" src="{{ asset('js/firebase.js') }}"></script>
    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>

</html>
