<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nexora Global Supply Chain Intelligence</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* ── PALETTE ── */
            --navy-bg: #101c36;
            --navy-text: #0d1e3d;
            --navy-button: #112240;
            --navy-accent: #3b82f6;
            
            --cream-card: #f4f3ed;
            --cream-icon-bg: #e6e5dd;
            --input-bg: #e2e8f0;
            --input-focus-bg: #eff6ff;
            
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--navy-bg);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Top Glow Effect */
        body::before {
            content: '';
            position: absolute;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 400px;
            background: radial-gradient(ellipse at center, rgba(167,204,255,0.2) 0%, rgba(16,28,54,0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-card {
            background-color: var(--cream-card);
            border-radius: 16px;
            width: 100%;
            padding: 3.5rem 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* Branding */
        .brand-icon-wrapper {
            width: 70px;
            height: 70px;
            background-color: var(--cream-icon-bg);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--navy-accent);
            margin-bottom: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(255,255,255,0.5), 0 4px 6px rgba(0,0,0,0.05);
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.7rem;
            color: var(--navy-text);
            margin-bottom: 0.2rem;
        }
        
        .brand-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 2.5rem;
        }

        /* Form Elements */
        .form-group {
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--navy-text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group {
            border-radius: 10px;
            overflow: hidden;
            background-color: var(--input-bg);
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        
        .input-group:focus-within {
            background-color: var(--input-focus-bg);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--navy-text);
            padding-left: 1.2rem;
            padding-right: 0.5rem;
        }

        .form-control {
            background: transparent;
            border: none;
            padding: 0.8rem 1rem 0.8rem 0;
            font-size: 0.95rem;
            color: var(--navy-text);
            font-weight: 500;
        }
        
        .form-control:focus {
            background: transparent;
            box-shadow: none;
            outline: none;
        }

        .btn-login {
            background-color: var(--navy-button);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 0.9rem;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s ease;
            margin-top: 1rem;
        }
        
        .btn-login:hover {
            background-color: #0b172d;
            color: #ffffff;
        }

        .alert-custom {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 10px;
            font-size: 0.85rem;
            text-align: left;
            padding: 0.8rem 1rem;
            margin-bottom: 1.5rem;
        }

        /* Footer */
        .login-footer {
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        
        <div class="brand-icon-wrapper">
            <i class="fa-solid fa-ship"></i>
        </div>
        <h2 class="brand-title">Nexora Global</h2>
        <p class="brand-subtitle">Supply Chain Risk Intelligence</p>

        @if($errors->any())
            <div class="alert alert-custom">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login">
                Masuk ke Sistem <i class="fa-solid fa-arrow-right ms-2"></i>
            </button>
        </form>
        
    </div>
    
    <div class="login-footer">
        &copy; 2026 Nexora Global. Secure Enterprise Platform.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>