<!-- resources/views/errors/419.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 419</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .error-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 36px;
            margin: 0;
        }

        p {
            font-size: 18px;
            margin: 15px 0;
        }

        .error-icon {
            font-size: 80px;
            color: #e74c3c;
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .login-button {
            background-color: #3498db;
        }

        .login-button:hover {
            background-color: #2980b9;
        }

        .home-button {
            background-color: #e74c3c;
        }

        .home-button:hover {
            background-color: #c0392b;
        }

        img.logo {
            max-width: 100px; /* Adjust the size of the logo */
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
    </div>
    <h1>Error 419</h1>
    <p>Token has expired.</p>
    <p>Go Home</p>
    <a href="{{ route('home.index') }}" class="button home-button">Home</a>
</div>
</body>
</html>
