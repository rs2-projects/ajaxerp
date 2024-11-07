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
    <h1 style="text-align: center;margin-bottom: 25px;">QRCode</h1>
    {{-- <table class="table">
        <tr>
            <td style="width:25%">Purchase ID</td>
            <td style="width:25%;text-align:center;">Date</td>
            <td style="width:25%;text-align:center;">Batch Number</td>
            <td style="width:25%;text-align:center;">Available QTY</td>
        </tr>
    </table> --}}
    @foreach ($product_materials as $product_material)
        <div style="width:100%;display:block;overflow:hidden;margin-bottom:20px;">
            <div class="item-info-wrapper" style="width: 20%;display:inline-block;float: left;">
                <div>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($product_material->code)) !!} " alt="QrCode">
                    <h4 style="margin-bottom: 5px;margin-top:0;">{{ $product_material->name }}</h4>
                </div>
            </div>
            <div style="width: 78%;display:inline-block;">
                <table class="table">
                    <tr>
                        <td style="width:20%">Purchase ID</td>
                        <td style="width:20%;text-align:center;">Available QTY</td>
                        <td style="width:20%;text-align:center;">Batch Number</td>
                        {{-- <td style="width:40%;text-align:center;">Barcode</td> --}}
                    </tr>
                    @foreach ($product_material->purchase_details as $purchase_detail)
                        <tr>
                            <td style="width:20%">
                                <strong style="display: block;">{{ $purchase_detail->materialPurchase->purchase_id }}</strong>
                                
                                {{ $purchase_detail->materialPurchase->purchase_date }}
                            </td>
                            <td style="width:20%;text-align:center;">{{ $purchase_detail->available_qty }}</td>
                            <td style="width:20%;text-align:center;">{{ $purchase_detail->materialPurchase->batch_number }}</td>
                            {{-- <td style="width:40%;text-align:center;">
                                <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($purchase_detail->barcode, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
                            </td> --}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    @endforeach
    
    @foreach ($finished_boards as $finished_board)
        <div style="width:100%;display:block;overflow:hidden;margin-bottom:20px;">
            <div class="item-info-wrapper" style="width: 20%;display:inline-block;float: left;">
                <div>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($finished_board->code)) !!} " alt="QrCode">
                    <h4 style="margin-bottom: 5px;margin-top:0;">{{ $finished_board->name }}</h4>
                </div>
            </div>
            <div style="width: 78%;display:inline-block;">
                <table class="table">
                    <tr>
                        <td style="width:20%">Production ID</td>
                        <td style="width:20%;text-align:center;">Available QTY</td>
                        <td style="width:20%;text-align:center;">Batch Number</td>
                        {{-- <td style="width:40%;text-align:center;">Barcode</td> --}}
                    </tr>
                    @foreach ($finished_board->purchase_details as $purchase_detail)
                        <tr>
                            <td style="width:20%">
                                <strong style="display: block;">{{ $purchase_detail->pre_production_no }}</strong>
                                
                                {{ $purchase_detail->date }}
                            </td>
                            <td style="width:20%;text-align:center;">{{ $purchase_detail->available_qty }}</td>
                            <td style="width:20%;text-align:center;">{{ $purchase_detail->pre_production_batch_no }}</td>
                            {{-- <td style="width:40%;text-align:center;">
                                <img src="data:image/png;base64,{{ base64_encode($code_generator->getBarcode($purchase_detail->barcode, $code_generator::TYPE_CODE_128)) }}" style="max-width: 90%;">
                            </td> --}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    @endforeach
</div>

</body>
</html>
