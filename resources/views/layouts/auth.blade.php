<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Jornada da Liderança') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top left, rgba(88, 101, 242, 0.28), transparent 55%),
                radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.22), transparent 55%),
                linear-gradient(135deg, #020617 0%, #020617 40%, #020617 100%);
            padding: 1.5rem 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 2.25rem 2.2rem 2.1rem;
            border-radius: 24px;
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.24), transparent 60%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.3), transparent 60%),
                linear-gradient(140deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.98));
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(148, 163, 184, 0.6);
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.9);
            color: #e5e7eb;
        }

        .logo {
            text-align: center;
            margin-bottom: 2.2rem;
        }

        .logo img {
            height: 72px;
            max-width: 100%;
            object-fit: contain;
            border-radius: 999px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.9);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            color: #e5e7eb;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.8);
            background-color: rgba(15, 23, 42, 0.9);
            color: #e5e7eb;
            font-size: 0.92rem;
            transition: all 0.18s ease-out;
        }

        .form-input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .form-input:focus {
            outline: none;
            background-color: rgba(15, 23, 42, 0.98);
            border-color: rgba(59, 130, 246, 0.9);
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.9);
            color: #f9fafb;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.8rem 1rem;
            border: none;
            border-radius: 999px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            font-size: 0.94rem;
            transition: all 0.18s ease-out;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: #f9fafb;
            border: 1px solid rgba(191, 219, 254, 0.9);
            box-shadow: 0 14px 40px rgba(37, 99, 235, 0.75);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 55px rgba(37, 99, 235, 0.9);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.86rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(209, 213, 219, 0.9);
        }

        .remember-me input[type="checkbox"] {
            accent-color: #0ea5e9;
        }

        .forgot-password {
            color: #38bdf8;
            text-decoration: none;
            font-size: 0.86rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(209, 213, 219, 0.9);
            font-size: 0.9rem;
        }

        .register-link a {
            color: #f97316;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: rgba(148, 163, 184, 0.95);
        }

        .terms a {
            color: inherit;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        @media (max-width: 575.98px) {
            body {
                padding: 1.2rem 0.75rem;
            }

            .auth-container {
                padding: 1.8rem 1.5rem 1.7rem;
                border-radius: 20px;
            }

            .logo img {
                height: 64px;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html> 