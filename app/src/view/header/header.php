    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=BRAND ?>banquet-logo.png">

    <title><?= isset($title)?$title:'Banquet'?></title>

    <!-- Banquet Custom CSS  -->
    <style>
        /* ============================================
           RESET & BASE STYLES
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* ============================================
           GRID SYSTEM (Custom, No Bootstrap)
           ============================================ */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -15px;
        }

        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, 
        .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            padding: 15px;
            flex-grow: 0;
            flex-basis: auto;
        }

        .col-md-1 { flex-basis: 8.333333%; }
        .col-md-2 { flex-basis: 16.666667%; }
        .col-md-3 { flex-basis: 25%; }
        .col-md-4 { flex-basis: 33.333333%; }
        .col-md-5 { flex-basis: 41.666667%; }
        .col-md-6 { flex-basis: 50%; }
        .col-md-7 { flex-basis: 58.333333%; }
        .col-md-8 { flex-basis: 66.666667%; }
        .col-md-9 { flex-basis: 75%; }
        .col-md-10 { flex-basis: 83.333333%; }
        .col-md-11 { flex-basis: 91.666667%; }
        .col-md-12 { flex-basis: 100%; }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6,
            .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                flex-basis: 100%;
            }
        }

        /* ============================================
           NAVBAR
           ============================================ */
        .navbar-wrapper {
            margin-bottom: 80px;
        }

        .navbar {
            display: flex;
            align-items: center;
            background-color: #2c4d50;
            padding: 0;
            margin-bottom: 0;
            border-radius: 0;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar .container {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-header {
            display: flex;
            align-items: center;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 1px;
            color: #ecf0f1 !important;
            text-decoration: none;
            padding: 15px 0;
        }

        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        .icon-bar {
            display: block;
            width: 22px;
            height: 2px;
            background-color: #ecf0f1;
            margin: 4px 0;
            transition: 0.3s;
        }

        .navbar-collapse {
            display: flex !important;
            flex-basis: auto;
        }

        .nav {
            display: flex;
            list-style: none;
            gap: 0;
        }

        .nav > li {
            position: relative;
        }

        .nav > li > a {
            display: block;
            padding: 18px 15px;
            color: #ecf0f1 !important;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav > li > a:hover {
            color: #3498db !important;
            background-color: transparent;
        }

        /* Mobile navbar */
        @media (max-width: 768px) {
            .navbar-toggle {
                display: block;
            }

            .navbar-collapse {
                display: none !important;
                flex-basis: 100%;
                flex-direction: column;
                background-color: #34495e;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
            }

            .navbar-collapse.show {
                display: flex !important;
            }

            .nav {
                flex-direction: column;
                width: 100%;
            }

            .nav > li > a {
                padding: 12px 20px;
                border-bottom: 1px solid #2c3e50;
            }
        }

        /* ============================================
           WELCOME SECTION
           ============================================ */
        .welcome-section {
            text-align: center;
            padding: 60px 20px 40px;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            background: linear-gradient(179deg, #ffffff 0%, #1a473b 100%);
            color: white;
            border-radius: 8px;
            margin-bottom: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .banquet-logo {
            max-width: 150px;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .welcome-section h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .welcome-section .lead {
            font-size: 18px;
            opacity: 0.95;
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .features-section {
            margin-bottom: 60px;
            padding: 40px 0;
        }

        .feature-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .feature-box h3 {
            color: #02700b;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .feature-box p {
            color: #555;
            font-size: 14px;
            line-height: 1.8;
        }

        /* ============================================
           API EXAMPLES SECTION
           ============================================ */
        .api-examples-section {
            background: white;
            padding: 50px;
            border-radius: 8px;
            margin-bottom: 50px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .api-examples-section h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
            border-bottom: 1px solid #358702;
            padding-bottom: 15px;
        }

        .api-example {
            margin-bottom: 40px;
        }

        .api-example:last-child {
            margin-bottom: 0;
        }

        .api-example h4 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .api-example p {
            color: #333;
            margin-bottom: 10px;
        }

        .code-block {
            background: #2c4d50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 6px;
            overflow-x: auto;
            border-left: 0px solid #667eea;
        }

        .code-block pre {
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }

        .code-block code {
            color: #ecf0f1;
        }

        /* ============================================
           QUICK LINKS SECTION
           ============================================ */
        .quick-links-section {
            text-align: center;
            padding: 50px 20px;
            background: #ecf0f1;
            border-radius: 8px;
            margin-bottom: 40px;
        }

        .quick-links-section h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
        }

        /* ============================================
           BUTTONS
           ============================================ */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #079b66db 0%, #15543b 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(47, 240, 175, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-info {
            background: #007856;
            color: white;
        }

        .btn-info:hover {
            background: #018b64;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(47, 240, 175, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-lg {
            padding: 12px 30px;
            font-size: 16px;
            margin: 10px;
        }

        /* ============================================
           FOOTER
           ============================================ */
        footer {
            background: #2c4d50;
            color: #ecf0f1;
            padding: 30px 0;
            margin-top: 60px;
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        footer p {
            margin: 0;
        }

        footer a {
            color: #1da881;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #8ebb90;
            text-decoration: underline;
        }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */
        @media (max-width: 768px) {
            .welcome-section {
                padding: 40px 20px 30px;
            }

            .welcome-section h1 {
                font-size: 28px;
            }

            .welcome-section .lead {
                font-size: 16px;
            }

            .api-examples-section {
                padding: 30px 15px;
            }

            .api-example h4 {
                font-size: 14px;
            }

            .code-block {
                padding: 15px;
                font-size: 11px;
            }

            .banquet-logo {
                max-width: 100px;
            }

            .quick-links-section {
                padding: 30px 15px;
            }

            .btn {
                display: block;
                margin: 10px auto;
            }
        }

        /* ============================================
           TYPOGRAPHY
           ============================================ */
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            line-height: 1.2;
        }

        p {
            margin: 0;
        }

        a {
            color: #667eea;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

<!-- NAVBAR
================================================== -->