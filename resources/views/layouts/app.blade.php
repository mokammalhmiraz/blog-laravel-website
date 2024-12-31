<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="body">
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                                <a class="nav-link" href="{{ url("home")}}">Home</a>
                            </li>
                            @if ( ((Auth::user()->role)=='Admin') == true )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url("userlist")}}">User List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url("requestlist")}}">Request List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url("blogcategory")}}">Blog Category</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url("allauthor")}}">Author's</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url("bloglist")}}">Blogs</a>
                            </li>
                        </ul>
                    @endauth

                    <!-- Authentication Links -->
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if ( ((Auth::user()->role)=='Author' || (Auth::user()->role)=='Reader') == true )
                                        <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profile') }}</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,              // Show navigation dots
            infinite: true,          // Infinite looping
            speed: 300,              // Transition speed
            slidesToShow: 3,         // Number of slides to show
            slidesToScroll: 1,       // Number of slides to scroll at once
            autoplay: true,          // Enable autoplay
            autoplaySpeed: 1000,     // Autoplay speed (in milliseconds)
            arrows: false,            // Show next/prev arrows
            responsive: [            // Responsive settings
            {
                breakpoint: 768,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                }
            }
            ]
        });
    });
    // Function to count words in a string
    function countWords(str) {
        return str.trim().split(/\s+/).length;
    }

    // Get the 'intro' textarea and word count error message elements
    const introField = document.getElementById('intro');
    const wordCountError = document.getElementById('wordCountError');
    const form = document.getElementById('profileForm');

    // Function to validate word count on every input change
    function validateWordCount() {
        const wordCount = countWords(introField.value);

        // If word count exceeds 50, show error message and disable form submission
        if (wordCount > 50) {
            wordCountError.style.display = 'block'; // Show error message
            form.querySelector('button[type="submit"]').disabled = true; // Disable submit button
        } else {
            wordCountError.style.display = 'none'; // Hide error message
            form.querySelector('button[type="submit"]').disabled = false; // Enable submit button
        }
    }

    // Add event listener to track user input
    introField.addEventListener('input', validateWordCount);

    // Before submitting, check one last time for word count validation
    form.addEventListener('submit', function(event) {
        const wordCount = countWords(introField.value);
        if (wordCount > 50) {
            event.preventDefault(); // Prevent form submission
            alert('Intro must not exceed 50 words.'); // Alert user
        }
    });
</script>
<script>
</script>
</html>
