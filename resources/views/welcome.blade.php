<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskTracker | Simple Task Tracking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #10B981;
            --dark: #1F2937;
            --light: #F9FAFB;
            --gray: #6B7280;
            --light-gray: #E5E7EB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            padding: 20px 0;
            border-bottom: 1px solid var(--light-gray);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-links a:hover {
            color: var(--light-gray);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero {
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 20px;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 40px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 50px;
        }

        .dashboard-preview {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--light-gray);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            padding: 30px;
            border-radius: 8px;
            background-color: var(--light);
            border: 1px solid var(--light-gray);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: var(--gray);
        }

        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background-color: var(--light);
        }

        .testimonial-card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial-text {
            font-size: 18px;
            font-style: italic;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--light-gray);
            margin-right: 15px;
            overflow: hidden;
        }

        .author-info h4 {
            font-weight: 600;
        }

        .author-info p {
            color: var(--gray);
            font-size: 14px;
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            text-align: center;
            background-color: var(--primary);
            color: white;
        }

        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .cta p {
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        .cta .btn {
            background-color: white;
            color: var(--primary);
            font-weight: 600;
        }

        .cta .btn:hover {
            background-color: var(--light);
        }

        /* Footer */
        footer {
            padding: 40px 0;
            background-color: var(--dark);
            color: white;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            margin-bottom: 15px;
            display: block;
        }

        .footer-about p {
            opacity: 0.8;
            max-width: 300px;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            color: white;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .social-links a:hover {
            opacity: 1;
        }

        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: white;
            opacity: 0.8;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .footer-links a:hover {
            opacity: 1;
        }

        .copyright {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 18px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .section-title h2 {
                font-size: 28px;
            }

            .cta h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <a href="/" class="logo">TaskTracker</a>
                <div class="nav-links justify-center align-middle">
                    <a href="#features">Features</a>
                    <a href="#testimonials">Testimonials</a>
                    <a href="#pricing">Pricing</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="color: white">Sign Up</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Organize Your Work, Simplify Your Life</h1>
            <p>TaskTracker helps you stay on top of your tasks and projects with a simple, intuitive interface that makes productivity effortless.</p>
            <div class="cta-buttons">
                <a href="#" class="btn btn-primary">Get Started for Free</a>
                <a href="#" class="btn btn-outline">See How It Works</a>
            </div>
            <img src="{{ asset('build/assets/images/dashboard.png') }}" alt="TaskTracker Dashboard Preview" class="dashboard-preview">
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features</h2>
                <p>Everything you need to manage your tasks effectively and boost your productivity</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3>Task Management</h3>
                    <p>Create, organize, and prioritize tasks with ease. Set due dates, reminders, and categories to stay on track.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Progress Tracking</h3>
                    <p>Visualize your progress with charts and reports. See what you've accomplished and what's left to do.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Sync Across Devices</h3>
                    <p>Access your tasks from anywhere. Our cloud sync keeps everything up to date on all your devices.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Team Collaboration</h3>
                    <p>Share tasks and projects with your team. Assign responsibilities and track progress together.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h3>Smart Reminders</h3>
                    <p>Never miss a deadline with customizable reminders via email, push notifications, or SMS.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Secure & Private</h3>
                    <p>Your data is encrypted and protected. We prioritize your privacy and security above all else.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Users Say</h2>
                <p>Join thousands of productive individuals and teams who trust TaskTracker</p>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-text">"TaskTracker has completely transformed how I organize my work. I went from constantly feeling overwhelmed to being in complete control of my tasks and deadlines."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://via.placeholder.com/50" alt="Sarah Johnson">
                    </div>
                    <div class="author-info">
                        <h4>Sarah Johnson</h4>
                        <p>Marketing Director, TechCorp</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Boost Your Productivity?</h2>
            <p>Join thousands of professionals who are getting more done with TaskTracker</p>
            <a href="#" class="btn">Start Your Free Trial</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <a href="#" class="footer-logo">TaskTracker</a>
                    <p>The simplest way to organize your tasks and projects. Designed for individuals and teams who want to get more done.</p>
                    <div class="social-links">
                        <a href="#">Twitter</a>
                        <a href="#">Facebook</a>
                        <a href="#">LinkedIn</a>
                    </div>
                </div>
                <div class="footer-links">
                    <h3>Product</h3>
                    <ul>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Integrations</a></li>
                        <li><a href="#">Updates</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Tutorials</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Webinars</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                &copy; 2025 TaskTracker. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
