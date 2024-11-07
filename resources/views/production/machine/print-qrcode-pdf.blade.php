<!DOCTYPE html>
<html>
<head>
    <title>Ajax ERP</title>

    <style>
        .barcode-wrapper {
            width: 100%;
            padding-top: 50px;
            text-align: center;
        }

        .barcode-wrapper .single-code {
            display: inline-block;
            /* width: 23%; */
            text-align: center;
            margin: 0 auto;
            margin-bottom: 20px;
            /* border: 1px solid #bbb; */
            /* padding-top: 10px; */
            margin-right: 12.5px;
        }
        .barcode-wrapper .single-code p {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .header-wrapper {
            text-align: center;
        }
        .header-wrapper {
            font-size: 30px;
        }
    </style>
</head>
<body>

<div class="barcode-wrapper">
    <div class="single-code">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(480)->generate($machine->machine_code)) !!} " alt="QrCode">
        <p style="font-size: 26px;margin-top:20px;">{{$machine->name}}</p>
    </div>
</div>

</body>
</html>
