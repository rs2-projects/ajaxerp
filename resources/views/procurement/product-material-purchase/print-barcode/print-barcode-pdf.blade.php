<!DOCTYPE html>
<html>
<head>
    <title>Ajax ERP</title>

    <style>
        .barcode-wrapper {
            width: 100%;
            padding-top: 50px;
        }

        .barcode-wrapper .single-code {
            display: inline-block;
            width: 24%;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #bbb;
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
    @foreach ($purchae_details as $data )
        @for($i = 0; $i < $data->qty; $i++)
            <div class="single-code">
                <p class="company-name">AJAX ERP</p>
                <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($data->barcode, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
                <p>{{ $data->barcode }}</p>
                <p>{{$data->name}}</p>
                <p>MRP: {{getCurrencySymbol()}} {{ formatNumber($data->unit_price) }}</p>
            </div>
        @endfor
    @endforeach
</div>

</body>
</html>
