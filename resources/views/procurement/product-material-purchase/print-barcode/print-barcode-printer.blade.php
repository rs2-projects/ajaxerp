<!DOCTYPE html>
<html>
<head>
    <title>Ajax ERP</title>

    <style>
        .barcode-wrapper {
            width: 125px;
            margin: 0 auto;
        }

        .barcode-wrapper .single-code {
            display: inline-block;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            border: 1px solid #bbb;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .barcode-wrapper .single-code p {
            margin-top: 2px;
            margin-bottom: 0;
            line-height: 1;
            font-size: 13px;
        }
        .header-wrapper {
            text-align: center;
        }
        .header-wrapper {
            font-size: 30px;
        }
        .company-name{
            margin-bottom: 10px !important;
        }
    </style>
</head>
<body>

{{--<div class="header-wrapper">
    <h5>{{ $product->name }} Barcode</h5>
</div>--}}
<div class="barcode-wrapper">
    @foreach ($purchae_details as $data )
        @for($i = 0; $i < $data->qty; $i++)
            <div class="single-code">
                <p class="company-name">AJAX ERP</p>
                <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($data->barcode, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
                <p>{{ $data->barcode }}</p>
                <p>{{$data->name}}</p>
                <p>MRP: {{getCurrencySymbol()}} {{ formatNumber($data->unit_price)}}</p>
            </div>
        @endfor
    @endforeach
</div>

</body>
<script>
    window.onload = function () {
        printAndClose();
    }
    function printAndClose() {
        // Trigger the print dialog
        window.print();

        // Close the tab after printing is done
        window.onafterprint = function() {
            window.close();
        };
    }
</script>
</html>
