<!DOCTYPE html>
<html>
<head>
    <title>Print QR Codes</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .qr-box {
            display: inline-block;
            width: 23.5%;
            margin: 0 0.5% 10px 0.5%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .qr-box img {
            max-width: 100%;
            height: auto;
        }
        .qr-name {
            margin-top: 8px;
            font-weight: bold;
        }
        .qr-code {
            font-size: 10px;
            margin-top: 2px;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div>
        <h1>Asset Products</h1>
        @foreach($data as $item)
            <div class="qr-box">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($item['code'])) !!}" alt="QrCode">
                <div class="qr-name">{{ $item['name'] }}</div>
                <div class="qr-code">{{ $item['code'] }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
