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
            margin-bottom: 0;
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

{{--<div class="header-wrapper">
    <h5>{{ $product->name }} Barcode</h5>
</div>--}}
<div class="barcode-wrapper">
    @for($i = 0; $i < $production->estimated_production_qty; $i++)
        <div class="single-code">
            <p>AJAX ERP</p>
            <p>{{$production->finishedGoods->name}}</p>
            <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($production->pre_production_no, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
            <p>{{ $production->pre_production_no }}</p>
            {{-- <p><strong>MRP: {{ $global_currency_info['symbol'] }} {{ $pd->sell_price }}</strong></p> --}}
        </div>
    @endfor
</div>

</body>
</html>
