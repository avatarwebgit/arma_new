{{-- resources/views/emails/contactForm.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        p {
            color: #555;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .highlight {
            color: #00A4D3;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>New Message from Contact Form</h1>
    <p><strong class="highlight">Name:</strong> {{ $name }}</p>
{{--    <p><strong class="highlight">Email:</strong> {{ $email }}</p>--}}
    <p><strong class="highlight">Message:</strong></p>
    <p>{{ nl2br(e($text)) }}</p>

    <div class="footer">
        <p>This is an automated email, please do not reply.</p>
        <p>Thank you!</p>
    </div>
</div>
</body>
</html>
