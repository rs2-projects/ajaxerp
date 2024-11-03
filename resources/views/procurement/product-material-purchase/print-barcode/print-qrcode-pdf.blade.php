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
            width: 23%;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #bbb;
            padding-top: 10px;
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
    @foreach ($purchae_details as $data )
        <div>
            @for($i = 0; $i < $data->qty; $i++)
                <div class="single-code">
                    {{-- <p class="company-name">AJAX ERP</p> --}}
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(160)->generate($data->product_code)) !!} " alt="QrCode">
                    {{-- <p>{{ $data->barcode }}</p> --}}
                    <p>{{$data->name}}</p>
                    {{-- <p>MRP: {{getCurrencySymbol()}} {{ formatNumber($data->unit_price) }}</p> --}}
                    <p>B.N: {{ $data->batch_number }}</p>
                </div>
            @endfor
        </div>
    @endforeach
</div>

</body>
</html>
