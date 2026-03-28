<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Delivery Receipt') }}</title>

    <style>
        /* @font-face {
            font-family: 'Inter';
            src: url('/assets/pdf-fonts/Inter/Inter-VariableFont_slnt_wght_1.woff') format('woff2'),
            url('/assets/pdf-fonts/Inter/Inter-VariableFont_slnt,wght.woff2') format('woff'),
            url('/assets/pdf-fonts/Inter/Inter-VariableFont_slnt,wght.ttf') format('truetype');
        }
        @font-face {
            font-family: 'Kalpurush';
            src: url('/assets/pdf-fonts/Kalpurush/Kalpurush.woff') format('woff2'),
            url('/assets/pdf-fonts/Kalpurush/Kalpurush.woff2') format('woff'),
            url('/assets/pdf-fonts/Kalpurush/Kalpurush.ttf') format('truetype');
        } */
        body {
            font-family: 'Kalpurush', sans-serif;
        }
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px 80px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            font-size: 20px !important;
            color: #000;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            /*left: 350px;*/
            right: 0;
            height: 80px;
            font-size: 14px !important;
            color: #000;
            text-align: center;

        }

        header>div {
            width: 50%;
            display: inline-block;
            float: left;
        }
        .top-content {
            display: block;
            overflow: hidden;
            width: 100%;
            /* height: 50px; */
            margin-bottom: 15px;
        }
        /* .top-content .tc-left {
            width: 40%;
            display: inline-block;
            float: left;
        }
        .top-content .tc-right {
            width: 60%;
            display: inline-block;
            float: left;
        }
        .tc-right {

        }
        .tc-right .tcr-bg {
            background-color: #d6d6d6;
            
            padding: 5px 10px 0px 10px;
            text-align: right;
        }
        .tc-right .tcr-bg span {
            display: inline-block;
            color: #000;
            text-align: right;
        } */

        .top-company-info {
            display: block;
            /*overflow: hidden;*/
            width: 100%;
            height: 130px;
        }
        .top-company-info .invoice-to {
            width: 50%;
            display: inline-block;
            float: left;
        }
        .top-company-info .invoice-from {
            width: 50%;
            display: inline-block;
            float: left;
            text-align: right;
        }

        .it-info .invoice-to-text {
            color: #a99c9c;
            margin: 0;
        }
        .it-info .customer-company-name {
            font-weight: bold;
            color: #666;
            margin: 0;
        }
        .it-info .itinfo-text {
            color: #666;
            margin: 0;
        }
        .if-info .ifinfo-company-name {
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        .if-info .ifinfo-text {
            color: #666;
            margin: 0;
        }

        .inv-table {
            width: 100%;
            border-collapse: collapse;
        }
        .inv-table thead  {
            /* background-color: #000; */
            color: #000;
        }
        .inv-table thead tr th{
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
        }
        .inv-table .invt-item {
            width: 25%;
        }
        .inv-table .invt-description {
            width: 30%;
        }
        .inv-table .invt-description p {
            margin: 0 0 4px 0;
        }
        .inv-table .invt-description .extra-invt-description-info {
            padding: 4px 15px;
            font-size: 11px;
            background-color: #838383 !important;
            border-radius: 2px;
            margin-right: 4px;
            color: white;
        }
        .inv-table .invt-price {
            width: 16%;
            text-align: center;
        }
        .inv-table .invt-vat {
            width: 8%;
            text-align: center;
        }
        .inv-table .invt-qty {
            width: 8%;
            text-align: center;
        }
        .inv-table .invt-total {
            text-align: right;
        }
        .inv-table tbody td {
            padding: 5px 8px 10px 8px;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }
        .invfr-left {
            text-align: right;
        }
        .invfr-right {
            text-align: right;
        }
        .inv-table tfoot td {
            padding: 5px 8px 7px 8px;
            font-size: 14px;
        }
        .inv-table tfoot .subtotal-tr td {
            padding-top: 10px;
        }
        .inv-table tfoot .total-tr td {
            /*border-top: 1px solid #ddd;*/
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding-bottom: 25px;
            margin-bottom: 25px;
        }
        .inv-table tfoot .amount-due-tr td {
            font-weight: bold;
            font-size: 15px;
        }
        .invoice-note h6 {
            font-size: 16px;
            margin: 0 0 5px 0;
        }
        .invoice-note p {
            font-size: 13px;
            margin: 0;
        }
        .invoice-return-wrapper {
            margin-top: 30px;
        }
        .return-on-text {
            font-size: 20px;
            margin: 0 0 10px 0;
        }
        .invoice-note {
            margin-top: 20px;
        }
        .invoice-return-init-2{
            padding: 1px 10px;
            font-size: 10px;
            color: #fff;
            border-radius: 3px;
            background-color:#04005a !important;
        }

        thead { display: table-header-group }
        tfoot { display: table-row-group }
        tr { page-break-inside: avoid }


        .img-wrapper .img-item {
            width: 31%;
            display: inline-block;
            float: left;
            margin: 4px 1%;
        }
        .img-wrapper .img-item img{
            width: 100%;
            height: 200px;
        }

        .hr-element {
            border-top: 1px dashed #999;
            margin: 5px 0;
        }

    </style>
</head>
<body>

<!-- Define header and footer blocks before your content -->


{{-- <footer>
    <br>
    <p>{{ __('Powered By') }} {{config('app.name')}}</p>
</footer> --}}

<div class="main-content" >
    <div>
        <div class="h-left" style="text-align: left;float:left;">
            <img src="{{ asset('assets/img/logo-pdf.png') }}" alt="{{ config('app.name') }}" style="max-width: 250px;">
        </div>
        <div class="h-right" style="text-align: right;float:right;">
            <h1 style="margin-top: 15px; margin-bottom:0px !important;">Delivery Receipt</h1>
        </div>
    </div>
    {{-- <div class="top-content">
        
        <div class="tc-left">
            <strong>{{ __('Ref No') }}</strong> #{{$invoice->invoice_no}} <br>
            <span style="font-size: 10px">
                {{ __('Created At') }} : {{ getFormattedDateTime($invoice->created_at,'Y d, M H:i:s A') }}</span>
        </div>
        <div class="tc-right">
            <div class="tcr-bg">
                <span>{{ __('Date') }}: <strong>{{date('d M Y',strtotime($invoice->invoice_date))}}</strong></span>
            </div>
        </div>
    </div> --}}
    <div class="top-content">
        <table class="table" style="width: 100%">
            <tr>
                <td>
                    <strong>{{ __('Ref No') }}</strong> #{{$invoice->invoice_no}} <br>
                    <span style="font-size: 12px">
                        {{ __('Created At') }} : {{ getFormattedDateTime($invoice->created_at,'Y d, M H:i:s A') }}
                    </span>
                </td>
                <td style="text-align: right;">
                    <span>{{ __('Date') }}: <strong>{{date('d M Y',strtotime($invoice->invoice_date))}}</strong></span>
                    <br>
                    <span>{{ __('Payment Date') }}: <strong>{{date('d M Y',strtotime($invoice->payment_date))}}</strong></span>
                </td>
            </tr>
        </table>
    </div>

    <div class="top-company-info">
        <div class="invoice-to">
            <div class="it-info">
                <p class="invoice-to-text">{{ __('Invoice To') }}:</p>
                <p class="customer-company-name">{{$customer->business_name}}</p>
                <p class="itinfo-text">{{$customer->full_name}}</p>
                <p class="itinfo-text">{{$customer->address}}</p>
                @if($customer->phone != '')
                    <p class="itinfo-text">{{$customer->phone}}</p>
                @endif
                <p class="itinfo-text">{{$customer->email}}</p>
            </div>
        </div>
        <div class="invoice-from">
            <div class="if-info">
                <p class="ifinfo-company-name"> AjaxERP</p>
                <p class="ifinfo-text"> 281 Purok 6 Santisimo Road Brgy Soledad San Pablo City</p>
                <p class="ifinfo-text">{{ __('Email') }}:sales@sterk.ph</p>
                <p class="ifinfo-text">{{ __('Mobile') }}:+639943648519</p>
            </div>
        </div>
    </div>

    <div class="hr-element"></div>
    <br>

    <div class="invoice-content-wrapper">
        <table class="inv-table">
            <thead>
            <tr>
                <th class="invt-item" style="text-align: left;">{{ __('Item') }}</th>
                <th class="invt-description" style="text-align: left;">{{ __('Description') }}</th>
                <th class="invt-qty">{{ __('Qty') }}</th>
            </tr>
            </thead>
            <tbody>
            {{--{{dd($invoice)}}--}}

            @foreach($invoiceDetails as $productInfo)
                <tr>
                    <td class="tm_width_3">
                        {{ $productInfo->itemName() }}
                    </td>
                    <td class="tm_width_4 invt-description" style="text-align: left;">
                        {{$productInfo->description}}
                        <br>
                    </td>
                    <td class="tm_width_1" style="text-align: center;">{{ $productInfo->quantity }}</td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>


    
    {{-- <div class="payment-info" style="overflow: hidden;">
        <div class="left-pi-side" style="width:50%;float: left;">
            <h4 style="margin-bottom: 0px;"><span style="font-weight: bold;">Payment Method and Terms</span></h4>
            <div>
                <p>
                    <span style="width:90px;display:inline-block;font-weight:600;">Bank</span> <span style="margin-right: 5px;">:</span> <span>UnionBank</span>
                </p>
                <p>
                    <span style="width:90px;display:inline-block;font-weight:600;">Bank Name</span> <span style="margin-right: 5px;">:</span> <span> AJAX TRADING CORP.</span>
                </p>
                <p>
                    <span style="width:90px;display:inline-block;font-weight:600;">Account No</span> <span style="margin-right: 5px;">:</span> <span> 0023 4001 3295</span>
                </p>
            </div>
        </div>
        <div class="right-pi-side" style="width: 50%;float:right;text-align:right;">
            <div>
                <p>
                    <span>Unloading and installation</span> <span style="width:100px;display:inline-block;text-align:right;"> {{ formatNumber($quotation->unloading_cost) }}</span>
                </p>
                <p>
                    <span>{{ formatNumber($quotation->first_down_payment_percent) }}% Down payment</span> <span style="width:100px;display:inline-block;text-align:right;"> {{ formatNumber($quotation->first_down_payment_amount) }}</span>
                </p>
                <p>
                    <span>Total 1st Down payment</span> <span style="width:100px;display:inline-block;text-align:right;"> {{ formatNumber($quotation->total_first_down_payment_amount) }}</span>
                </p>
                <p>
                    <span>{{ formatNumber(100 - $quotation->first_down_payment_percent) }}% Upon Completion</span> <span style="width:100px;display:inline-block;text-align:right;"> {{ formatNumber($quotation->completion_payment_amount) }}</span>
                </p>

            </div>
        </div>
        
    </div> --}}
        
    <div class="hr-element"></div>


@if($invoice->notes)
    <div class="invoice-note">
        <h6>
            {{ __('Notes') }} / {{ __('Terms') }}
        </h6>
        <p style="white-space: pre-line;">{{$invoice->notes}}</p>
    </div>

@endif

</div>

<script type="text/php">
if ( isset($pdf) ) {
    $pdf->page_script('
        if ($PAGE_COUNT > 0) {
            $font = $fontMetrics->get_font("Inter, sans-serif", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT . " #" . $GLOBALS["invNo"];
            $y = 15;
            $x = 475;
            $pdf->text($x, $y, $pageText, $font, $size);
        }
    ');
}
</script>
</body>
</html>
