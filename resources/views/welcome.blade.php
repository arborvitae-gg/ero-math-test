<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <title>
        Ero-Math Competition
    </title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #222;
            background: #fff;
        }

        header {
            background: rgba(0, 0, 139, 0.85);
            /* semi-transparent dark blue */
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            position: sticky;
            /* changed from relative */
            top: 0;
            /* stick to top */
            z-index: 100;
            /* ensure it stays above other content */
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo img {
            height: 40px;
            width: auto;
            display: block;
            padding-left: 20px;
        }

        nav {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            max-width: 900px;
            padding: 0 3rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        nav a:hover {
            background: #1a2533;
        }

        .hero-bg {
            position: relative;
            width: 100%;
            height: 70vh;
            min-height: 350px;
            background: url('{{ asset('images/bg-home.png') }}') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        .hero-bg-carousel {
            position: relative;
            width: 100%;
            height: 90vh;
            /* Increased from 80vh to 90vh */
            min-height: 600px;
            /* Increased min-height for larger screens */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Center vertically */
            align-items: center;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            padding: 0;
            pointer-events: none;
            /* Prevents accidental overlay blocking, optional */
        }

        .hero-content h1,
        .hero-content p {
            pointer-events: auto;
            /* Allow interaction with text if needed */
        }

        .hero-content h1 {
            color: #fff;
            font-size: 2.5rem;
        }

        .hero-content p {
            color: #fff;
            font-size: 1.2rem;
        }

        .carousel-image {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s;
            z-index: 0;
        }

        .carousel-image.active {
            opacity: 1;
            z-index: 1;
        }

        .carousel-dots {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 40px;
            margin: 0 auto;
            text-align: center;
            z-index: 3;
            pointer-events: auto;
        }

        .carousel-dots .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 4px;
            background: #fff;
            border-radius: 50%;
            opacity: 0.5;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .carousel-dots .dot.active {
            opacity: 1;
            background: #fff;
        }

        .below-carousel {
            max-width: 900px;
            margin: 2rem auto 0 auto;
            padding: 2rem;
            background: #f6f9ff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(44, 62, 80, 0.06);
        }

        .below-carousel h2 {
            font-size: 2rem;
            color: #0d1a4d;
            margin-bottom: 1rem;
            text-align: center;
        }

        .below-carousel ul {
            margin-top: 1rem;
            margin-left: 1.5rem;
        }

        @media (max-width: 600px) {
            .nav-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            nav {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }

            .hero-bg {
                min-height: 220px;
                height: 40vh;
            }

            .hero-content h1 {
                font-size: 1.3rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            main {
                margin-top: -30px;
                padding: 1rem;
            }

            .below-carousel {
                padding: 1rem;
            }

            .below-carousel h2 {
                font-size: 1.2rem;
            }
        }

        .carousel-gradient-blend {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 120px;
            pointer-events: none;
            z-index: 5;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0) 0%,
                #d8d8ff 100%
            );
        }
    </style>
    {{-- Styles / Scripts --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Classless CSS script, remove or comment out if you want to start styling --}}
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/digitallytailored/classless@latest/classless.min.css"> --}}
    @endif
</head>

<body>
    <header>
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
            </a>
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>
    <div class="hero-bg-carousel">
        <div class="carousel-image active" style="background-image: url('{{ asset('images/bg-home1.png') }}');"></div>
        <div class="carousel-image" style="background-image: url('{{ asset('images/bg-home2.png') }}');"></div>
        <div class="carousel-image" style="background-image: url('{{ asset('images/bg-home3.png') }}');"></div>
        <div class="carousel-image" style="background-image: url('{{ asset('images/bg-home4.png') }}');"></div>
        <div class="hero-content">
            <h1>Lorem ipsum dolor sit amet,<br>consectetur adipiscing elit</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ...</p>
            <div class="carousel-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
        <div class="carousel-gradient-blend"></div>
    </div>

    <main class="below-carousel">
        <section>
            <h2>Welcome to Ero-Math Competition!</h2>
            <p>
                This is a sample content area below the hero carousel.  
                Add your features, announcements, or other homepage content here.<br>
                <br>
                <strong>Features:</strong>
                <ul>
                    <li>Online Math Quizzes</li>
                    <li>Leaderboard &amp; Certificates</li>
                    <li>Accessible for all grade levels</li>
                </ul>
            </p>
        </section>
    </main>

    <!-- Additional content below the main section -->
    <section style="max-width:900px;margin:2rem auto 0 auto;padding:2rem;background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(44,62,80,0.04);">
        <h2 style="color:#0d1a4d;text-align:center;">About the Competition</h2>
        <p>
            The Ero-Math Competition is designed to inspire students to excel in mathematics through fun and challenging quizzes. 
            Participants from all grade levels can join and compete for top spots on the leaderboard and earn certificates.
        </p>
    </section>

    <section style="max-width:900px;margin:2rem auto 2rem auto;padding:2rem;background:#f6f9ff;border-radius:16px;box-shadow:0 2px 12px rgba(44,62,80,0.04);">
        <h2 style="color:#0d1a4d;text-align:center;">Contact Us</h2>
        <p style="text-align:center;">
            Have questions? Email us at <a href="mailto:info@eromath.com">info@eromath.com</a> or call (123) 456-7890.
        </p>
    </section>

    <script>
        const images = document.querySelectorAll('.carousel-image');
        const dots = document.querySelectorAll('.carousel-dots .dot');
        let current = 0;
        const total = images.length;
        let interval = setInterval(nextSlide, 4000);

        function showSlide(idx) {
            images.forEach((img, i) => {
                img.classList.toggle('active', i === idx);
                dots[i].classList.toggle('active', i === idx);
            });
            current = idx;
        }

        function nextSlide() {
            let next = (current + 1) % total;
            showSlide(next);
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                showSlide(idx);
                clearInterval(interval);
                interval = setInterval(nextSlide, 4000);
            });
        });
    </script>
</body>

</html>
