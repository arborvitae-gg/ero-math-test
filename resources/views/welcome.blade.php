<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <title>Ero-Math Competition</title>
    @vite(['resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a2b3c;
            background: #f8fafc;
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, rgba(0, 0, 139, 0.95), rgba(0, 0, 139, 0.85));
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .logo img {
            height: 45px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        nav {
            display: flex;
            gap: 1.5rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-bg-carousel {
            margin-top: 76px;
            height: calc(100vh - 76px);
            min-height: 600px;
            position: relative;
            overflow: hidden;
        }

        .carousel-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease;
        }

        .carousel-image.active {
            opacity: 1;
        }

        .hero-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            max-width: 800px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.25rem;
            max-width: 600px;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .hero-btn {
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .hero-btn-primary {
            background: #3b82f6;
            color: #fff;
        }

        .hero-btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .hero-btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #1a2b3c;
        }

        .hero-btn-secondary:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            max-width: 1200px;
            margin: -100px auto 0;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #3b82f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon svg {
            width: 32px;
            height: 32px;
            color: #fff;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1a2b3c;
        }

        .feature-description {
            color: #64748b;
            line-height: 1.6;
        }

        /* About Section */
        .about-section {
            background: #fff;
            padding: 6rem 0;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a2b3c;
        }

        .about-content p {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Contact Section */
        .contact-section {
            background: #f8fafc;
            padding: 6rem 0;
        }

        .contact-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .contact-container h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a2b3c;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 4rem;
            margin-top: 3rem;
        }

        .contact-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .contact-icon {
            width: 48px;
            height: 48px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .contact-icon svg {
            width: 24px;
            height: 24px;
            color: #fff;
        }

        .contact-text {
            color: #64748b;
        }

        .contact-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .contact-text a:hover {
            text-decoration: underline;
        }

        /* Carousel Navigation */
        .carousel-dots {
            position: absolute;
            bottom: 2rem;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: #fff;
            transform: scale(1.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .about-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .contact-info {
                flex-direction: column;
                gap: 2rem;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            nav {
                flex-direction: column;
                width: 100%;
            }

            nav a {
                text-align: center;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-cta {
                flex-direction: column;
            }

            .features {
                margin-top: -50px;
            }
        }
    </style>
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
        <div class="carousel-image" style="background-image: url('{{ asset('images/bg-home6.jpg') }}');"></div>

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
                <h3 class="feature-title">Compete Globally</h3>
                <p class="feature-description">Join students from around the world, climb the leaderboard, and see how
                    your math skills stack up against the best.</p>
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
                    <li>Explore a vast library of math problems by topic or difficulty</li>
                    <li>Test your speed and accuracy under time pressure</li>
                    <li>Achievement certificates</li>
                    <li>Comprehensive learning resources</li>
                </ul>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/bg-home-5.jpg') }}" alt="Students solving math problems">
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
                        <a href="mailto:erovoutika@gmail.com">erovoutika@gmail.com</a>
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
                        <a href="tel:074 423 1557">074 423 1557</a>
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
