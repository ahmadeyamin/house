<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeCost - Construction Finance Made Simple</title>

    <!-- Google Fonts for a modern look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link rel="manifest" href="{{asset('manifest.json')}}">

    <meta name="theme-color" content="#FACC15">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="HomeCost">
    <link rel="apple-touch-icon" href="{{asset('icon.png')}}">

    <style>
        /* CSS Variables for easy theme management */
        :root {
            --primary-color: #FFC107; /* Construction Yellow */
            --dark-color: #1F2937;    /* Dark Blue/Gray */
            --medium-color: #374151;  /* Lighter Dark */
            --light-color: #F9FAFB;   /* Off-White */
            --text-color: #E5E7EB;    /* Light Gray Text */
        }

        /* --- Global Styles & Reset --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background-color: var(--dark-color);
            color: var(--text-color);
        }

        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 30px;
        }

        /* --- Header & Navigation --- */
        .navbar {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            color: var(--light-color);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .navbar .logo span {
            color: var(--primary-color);
        }

        .navbar nav ul {
            display: flex;
            align-items: center;
        }

        .navbar nav li {
            margin-left: 25px;
        }

        .navbar nav a {
            color: var(--light-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar nav a:hover {
            color: var(--primary-color);
        }

        /* --- Buttons --- */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--dark-color);
        }

        .btn-primary:hover {
            background-color: #ffca2c;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        /* --- Hero Section --- */
        .hero {
            padding: 180px 0 100px 0;
            text-align: center;
            background: linear-gradient(rgba(31, 41, 55, 0.9), rgba(31, 41, 55, 0.9)), url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80') no-repeat center center/cover;
            animation: fadeIn 1s ease-in-out;
        }

        .hero h1 {
            font-size: 3.5rem;
            color: var(--light-color);
            margin-bottom: 1rem;
        }

        .hero h1 span {
            color: var(--primary-color);
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2.5rem auto; /* Increased bottom margin */
            color: var(--text-color);
        }

        /* --- Features Section --- */
        .features {
            padding: 80px 0;
            background: var(--medium-color);
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--dark-color);
            padding: 2.5rem 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .feature-card .icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--light-color);
        }

        /* --- Footer --- */
        footer {
            padding: 40px 0;
            text-align: center;
            background-color: var(--medium-color);
            margin-top: -1px; /* To smoothly connect with features section */
        }

        footer p {
            color: #9ca3af;
        }

        /* --- Animations --- */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .navbar .container {
                flex-direction: column;
            }
            .navbar nav ul {
                margin-top: 1rem;
                padding: 1rem;
                background: var(--medium-color);
                border-radius: 5px;
            }

            .hero {
                padding-top: 150px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .features h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header & Navigation -->
    <header class="navbar">
        <div class="container">
            <div class="logo">HomeCost<span>.</span></div>
            <nav>
                <ul>
                    <li><a href="//fb.com/ahmadeyamin">Contact to use</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Keep Your Construction <span>Budget</span> Safe</h1>
                <p>
                    The all-in-one platform to track expenses, manage worker logs, and monitor rental equipment for any construction site. Stop juggling spreadsheets and start building with confidence.
                </p>
                <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-primary">Open Dashboard</a>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features">
            <div class="container">
                <h2>Everything You Need, All In One Place</h2>
                <div class="features-grid">
                    <!-- Feature 1 -->
                    <div class="feature-card">
                        <div class="icon">📈</div>
                        <h3>Expense Tracking</h3>
                        <p>Log materials, labor costs, and subcontractor payments in real-time. Never lose a receipt again.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="feature-card">
                        <div class="icon">👷‍♂️</div>
                        <h3>Daily Worker Logs</h3>
                        <p>Easily manage your crew, track hours, and maintain a digital logbook for compliance and payroll.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="feature-card">
                        <div class="icon">🚚</div>
                        <h3>Rental Equipment Tracking</h3>
                        <p>Keep a detailed inventory of all rental items, from heavy machinery to small tools. Avoid late fees and losses.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 HomeCost. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
