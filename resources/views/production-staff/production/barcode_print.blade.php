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

        .table {
            width: 100%;
            border: 1px solid #ddd;
        }
        .table td {
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }
        .table td:last-child {
            border-right: none;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>
<body>

{{--<div class="header-wrapper">
    <h5>{{ $product->name }} Barcode</h5>
</div>--}}
<div class="barcode-wrapper">
    <h1 style="text-align: center;margin-bottom: 25px;">Barcode</h1>
    <table class="table">
        <tr>
            <td style="width:20%">Purchase ID</td>
            <td style="width:20%;text-align:center;">Available QTY</td>
            <td style="width:20%;text-align:center;">Barcode Number</td>
            <td style="width:40%;text-align:center;">Barcode</td>
        </tr>
    </table>
    @foreach ($product_materials as $product_material)
        <h4 style="margin-bottom: 5px;">{{ $product_material->name }}</h4>
        <table class="table">
            @foreach ($product_material->purchase_details as $purchase_detail)
                <tr>
                    <td style="width:20%">
                        <strong style="display: block;">{{ $purchase_detail->materialPurchase->purchase_id }}</strong>
                        
                        {{ $purchase_detail->materialPurchase->purchase_date }}
                    </td>
                    <td style="width:20%;text-align:center;">{{ $purchase_detail->available_qty }}</td>
                    <td style="width:20%;text-align:center;">{{ $purchase_detail->barcode }}</td>
                    <td style="width:40%;text-align:center;">
                        <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($purchase_detail->barcode, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
                    </td>
                </tr>
            @endforeach
        </table>
    @endforeach
</div>

</body>
</html>
