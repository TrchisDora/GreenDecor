<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài viết mới: {{ $post->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0d7e38;
            font-size: 24px;
            text-align: center;
        }
        .quote, .summary, .description {
            margin-top: 20px;
            font-size: 16px;
        }
        .quote strong, .summary strong, .description strong {
            color: #333;
            font-weight: bold;
        }
        .quote, .summary, .description {
            margin-bottom: 15px;
        }
        .post-image {
            width: 100%;
            height: auto;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .footer a {
            color: #1a73e8;
            text-decoration: none;
        }
        .footer p {
            margin: 10px 0;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $post->title }}</h1>

        <div class="quote">
            <strong></strong> {{ strip_tags($post->quote) }}
        </div>

        <div class="summary">
            <strong></strong> {{ strip_tags($post->summary) }}
        </div>
        <div class="footer">
            Bạn nhận được email này vì đã đăng ký nhận thông báo từ chúng tôi.<br>
            Nếu không muốn nhận thêm, vui lòng <a href="{{ url('/unsubscribe/' . $email) }}">hủy đăng ký tại đây</a>.
        </div>

        <p style="text-align: center; font-size: 14px; color: #555;">Cảm ơn bạn đã theo dõi!</p>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ url('/blog-detail/' . $post->slug) }}" style="background-color: #1a73e8; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Xem chi tiết bài viết</a>
        </div>
    </div>
</body>
</html>
