<!DOCTYPE html>
<html>
<head>
    <style>
        .header {
            text-align: left;
            margin-bottom: 20px;
        }
        .content {
            margin-top: 20px;
        }
        .image-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%; /* 画像の幅を適切に調整 */
        }
    </style>
</head>
<body>
    <div class="header">
        <p>{{ $surname }} {{$given_name}} 様</p>
        <H1 class="image-center">Thank You!</h1>
        <img src="{{ asset('images/icon/track.svg') }}" alt="Header Image" class="image-center">
    </div>

    <div class="content">
        <H1>{{ $body }}</h1>
    </div>

</body>
</html>
