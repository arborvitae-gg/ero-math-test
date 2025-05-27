<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <title>Ero-Math Competition</title>
    @vite(['resources/css/app.css'])
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
            <h1>Welcome to Ero-Math Competition</h1>
            <p>Challenge yourself with engaging math problems and compete with students across different grade levels.
                Join now and showcase your mathematical prowess!</p>
            <div class="hero-cta">
                @guest
                    <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="hero-btn hero-btn-secondary">Sign In</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="hero-btn hero-btn-primary">Go to Dashboard</a>
                @endguest
            </div>
        </div>

        <div class="carousel-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <section class="features">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="feature-title">Adaptive Quizzes</h3>
                <p class="feature-description">Take part in quizzes tailored to your grade level, with questions that
                    challenge and help you grow.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="feature-title">Track Progress</h3>
                <p class="feature-description">Monitor your performance with detailed statistics and see how you rank
                    among your peers.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h3 class="feature-title">Earn Certificates</h3>
                <p class="feature-description">Receive certificates for your achievements and showcase your mathematical
                    excellence.</p>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="about-container">
            <div class="about-content">
                <h2>About the Competition</h2>
                <p>The Ero-Math Competition is designed to inspire students to excel in mathematics through fun and
                    challenging quizzes. Our platform offers:</p>
                <ul>
                    <li>Grade-specific mathematical challenges</li>
                    <li>Real-time performance tracking</li>
                    <li>Competitive leaderboards</li>
                    <li>Achievement certificates</li>
                    <li>Comprehensive learning resources</li>
                </ul>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/bg-home2.png') }}" alt="Students solving math problems">
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="contact-container">
            <h2>Get in Touch</h2>
            <p>Have questions about the competition? We're here to help!</p>

            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="contact-text">
                        <strong>Email</strong><br>
                        <a href="mailto:info@eromath.com">info@eromath.com</a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div class="contact-text">
                        <strong>Phone</strong><br>
                        <a href="tel:+1234567890">(123) 456-7890</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const images = document.querySelectorAll('.carousel-image');
        const dots = document.querySelectorAll('.carousel-dots .dot');
        let current = 0;
        const total = images.length;
        let interval = setInterval(nextSlide, 5000);

        function showSlide(idx) {
            images.forEach((img, i) => {
                img.classList.toggle('active', i === idx);
                dots[i].classList.toggle('active', i === idx);
            });
            current = idx;
        }

        function nextSlide() {
            showSlide((current + 1) % total);
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                showSlide(idx);
                clearInterval(interval);
                interval = setInterval(nextSlide, 5000);
            });
        });

        // Add smooth scroll behavior for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
