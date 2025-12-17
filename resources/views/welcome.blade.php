<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT. Smart</title>
    
    <!-- DM Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DM Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .container {
            display: flex;
            height: 100vh;
        }
        
        /* Left Side - Background Image */
        .left-side {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('{{ asset('images/bg.jpg') }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            gap: 8px;
        }
        
        .company-name {
            font-size: 64px;
            font-weight: 700;
            color: white;
            text-align: center;
            letter-spacing: 1px;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.3);
            margin: 0;
        }
        
        .company-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: white;
            text-align: center;
            letter-spacing: 0.5px;
            text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.3);
            margin: 0;
        }
        
        /* Right Side - Form */
        .right-side {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        
        .form-container {
            width: 100%;
            max-width: 400px;
        }
        
        .title-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 40px;
        }
        
        .form-title {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }
        
        .title-icon {
            width: 48px;
            height: 48px;
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-login {
            background: #1a1a1a;
            color: white;
        }
        
        .btn-login:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .btn-register {
            background: white;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
        }
        
        .btn-register:hover {
            background: #1a1a1a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: #666;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: #1a1a1a;
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-side {
                flex: 0 0 200px;
            }
            
            .company-name {
                font-size: 36px;
            }
            
            .company-subtitle {
                font-size: 14px;
            }
            
            .right-side {
                flex: 1;
            }
            
            .form-title {
                font-size: 24px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h1 class="company-name">PT. Smart</h1>
            <p class="company-subtitle">Internet Service Provider</p>
        </div>
        <div class="right-side">
            <div class="form-container">
                <div class="title-wrapper">
                    <h2 class="form-title">Selamat Datang</h2>
                    <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 430 430">
                        <path fill="#ffc738" d="M215 390c96.65 0 175-78.35 175-175S311.65 40 215 40 40 118.35 40 215s78.35 175 175 175"/>
                        <path fill="#ffc738" d="M345.349 331.767C317.919 349.624 285.171 360 250 360c-96.65 0-175-78.35-175-175 0-44.869 16.886-85.795 44.651-116.768C71.702 99.447 40 153.521 40 215c0 96.65 78.35 175 175 175 51.781 0 98.309-22.489 130.349-58.233" opacity=".5" style="mix-blend-mode:multiply"/>
                        <path stroke="#121331" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" d="M215 390c96.65 0 175-78.35 175-175S311.65 40 215 40 40 118.35 40 215s78.35 175 175 175"/>
                        <path stroke="#121331" stroke-linecap="round" stroke-linejoin="round" stroke-width="7" d="M113.439 153.76s25-26.36 55.2-20.6m149.44 20.6s-25-26.36-55.2-20.6M162.4 304.52s46.08 37.92 105.12 0"/>
                        <path fill="#121331" stroke="#121331" stroke-miterlimit="10" stroke-width="6" d="M150.76 178.11a13.25 13.25 0 0 0-12.249 8.173 13.25 13.25 0 0 0 2.866 14.443 13.253 13.253 0 0 0 20.389-2.003 13.25 13.25 0 0 0-1.647-16.732 13.25 13.25 0 0 0-9.369-3.881zm129.68 0a13.25 13.25 0 0 0-12.249 8.173 13.25 13.25 0 0 0 2.866 14.443 13.253 13.253 0 0 0 20.389-2.003 13.25 13.25 0 0 0-1.644-16.728 13.25 13.25 0 0 0-9.362-3.885Z"/>
                    </svg>
                </div>
                
                <div class="button-group">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-login">
                            Login
                        </a>
                    @endif
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-register">
                            Register
                        </a>
                    @endif
                </div>
                
                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
