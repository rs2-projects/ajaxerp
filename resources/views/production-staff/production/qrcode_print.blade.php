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
        .table th {
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 5px;
            font-size: 18px;
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
        .batch-number, .available-qty {
            padding-bottom:10px;
            margin-bottom:10px;
            border-bottom: 1px solid #ddd;
        }
        .batch-number:last-child, .available-qty:last-child {
            border-bottom: none;
        } 
    </style>
</head>
<body>

<div class="barcode-wrapper">
    <h1 style="text-align: center;margin-bottom: 35px;">Product Receiving List</h1>

    <table class="table">
        <thead>
            <tr>
                <th style="width:20%;text-align:center;">QR Code</th>
                <th style="width:30%;text-align:left;">Product</th>
                <th style="width:20%;text-align:center;">Batch Number</th>
                <th style="width:15%;text-align:center;">Available Qty</th>
                <th style="width:15%;text-align:center;">Receive Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product_materials as $product_material)
                <tr>
                    <td style="width:20%;text-align:center;">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($product_material->code)) !!} " alt="QrCode">
                    </td>
                    <td style="width:30%;text-align:left;">
                        <div class="product-info">
                            <p><span class="title">Category</span> <span class="seperator">:</span> <span>{{ $product_material->category->name }}</span></p>
                            <p><span class="title">Name</span> <span class="seperator">:</span> <span>{{ $product_material->name }}</span></p>
                            <p><span class="title">Code</span> <span class="seperator">:</span> <span>{{ $product_material->code }}</span></p>
                        </div>
                    </td>
                    <td style="width:20%;text-align:center;">
                        @foreach ($product_material->purchase_details as $purchase_detail)
                            <p class="batch-number">{{ $purchase_detail->materialPurchase->batch_number }}</p>
                        @endforeach
                    </td>
                    <td style="width:15%;text-align:center;">
                        @foreach ($product_material->purchase_details as $purchase_detail)
                            <p class="available-qty">{{ $purchase_detail->available_qty }}</p>
                        @endforeach
                    </td>
                    <td style="width:15%;text-align:center;">
                        {{ $product_material->delivery_details->quantity - $product_material->delivery_details->received_qty }}
                    </td>
                </tr>
            @endforeach
            @foreach ($finished_boards as $finished_board)
                <tr>
                    <td style="width:20%;text-align:center;">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($finished_board->code)) !!} " alt="QrCode">
                    </td>
                    <td style="width:30%;text-align:left;">
                        <div class="product-info">
                            <p><span class="title">Category</span> <span class="seperator">:</span> <span>{{ $finished_board->finishedGoodsCategory->name }}</span></p>
                            <p><span class="title">Name</span> <span class="seperator">:</span> <span>{{ $finished_board->name }}</span></p>
                            <p><span class="title">Code</span> <span class="seperator">:</span> <span>{{ $finished_board->code }}</span></p>
                        </div>
                    </td>
                    <td style="width:20%;text-align:center;">
                        @foreach ($finished_board->purchase_details as $purchase_detail)
                            <p class="batch-number">{{ $purchase_detail->pre_production_batch_no }}</p>
                        @endforeach
                    </td>
                    <td style="width:15%;text-align:center;">
                        @foreach ($finished_board->purchase_details as $purchase_detail)
                            <p class="available-qty">{{ $purchase_detail->available_qty }}</p>
                        @endforeach
                    </td>
                    <td style="width:15%;text-align:center;">
                        {{ $finished_board->delivery_details->quantity - $finished_board->delivery_details->received_qty }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

    
</div>

</body>
</html>
