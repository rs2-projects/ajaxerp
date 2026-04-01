<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Quotation') }}</title>

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
            height: 50px;
        }
        .top-content .tc-left {
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
            /* background-color: #000; */
            padding: 5px 10px 0px 10px;
            /*border-bottom-left-radius: 20px;*/
            text-align: right;
        }
        .tc-right .tcr-bg span {
            /* margin-right: 20px; */
            display: inline-block;
            color: #000;
            text-align: right;
        }

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
        .invoice-note .terms-html {
            font-size: 13px;
        }
        .invoice-note .terms-html img {
            max-width: 100%;
            height: auto;
            display: inline-block;
            vertical-align: top;
            margin: 0 8px 8px 0;
        }
        .invoice-note .terms-html figure {
            display: inline-block;
            vertical-align: top;
            margin: 0 8px 8px 0;
            max-width: 100%;
        }
        .invoice-note .terms-html figure img {
            width: 100%;
        }
        .invoice-note .terms-html table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-note .terms-html table th,
        .invoice-note .terms-html table td {
            border: 1px solid #ddd;
            padding: 4px;
            vertical-align: top;
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
            <h1 style="margin-top: 15px; margin-bottom:0px !important;">QUOTATION</h1>
        </div>
    </div>
    <div class="top-content">
        
        <div class="tc-left">
            <strong>{{ __('Ref No') }}</strong> #{{$quotation->ref_no}} <br>
            <span style="font-size: 10px">
                {{ __('Created At') }} : {{ getFormattedDateTime($quotation->created_at,'Y d, M H:i:s A') }}</span>
        </div>
        <div class="tc-right">
            <div class="tcr-bg">
                <span>{{ __('Date') }}: <strong>{{date('d M Y',strtotime($quotation->quotation_date))}}</strong></span>
            </div>
        </div>
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
    <div class="project-info">
        <h4 style="margin-bottom: 0px;"><span style="font-weight: bold;">Project Name : </span> <span style="font-weight:normal;">{{ $quotation->project_name }}</span></h4>
        <p style="margin-top: 10px;text-align:justify;">
            {!! $quotation->description !!}
        </p>
    </div>
    <div style="padding-bottom:10px;overflow:hidden;">
        <div class="img-wrapper">
            @foreach ($quotation->gallery as $img)
                <div class="img-item">
                    <img src="{{ public_path($img->image) }}" alt="Quotation" style="max-width: 100%;">
                </div>
            @endforeach
            
            
        </div>
    </div>

    <div class="hr-element"></div>
    <br>

    <div class="invoice-content-wrapper">
        <table class="inv-table">
            <thead>
            <tr>
                <th class="invt-item" style="text-align: left;">{{ __('Item') }}</th>
                <th class="invt-description">{{ __('Description') }}</th>
                <th class="invt-price">{{ __('Price') }}</th>
                <th class="invt-vat">{{ __('Vat') }}</th>
                <th class="invt-qty">{{ __('Qty') }}</th>
                <th class="invt-total" style="width: 120px;">{{ __('Total') }} (PHP)</th>
            </tr>
            </thead>
            <tbody>
            {{--{{dd($invoice)}}--}}

            @foreach($quotationDetails as $productInfo)
                <tr>
                    <td class="tm_width_3">
                        {{ $productInfo->itemName() }}
                    </td>
                    <td class="tm_width_4 invt-description">
                        {{$productInfo->description}}
                        <br>
                    </td>
                    <td class="tm_width_2" style="text-align: center;">{{ formatNumber($productInfo->unit_price) }}</td>
                    <td class="tm_width_1" style="text-align: center;">{{ formatNumber($productInfo->tax_amount) }}</td>
                    <td class="tm_width_1" style="text-align: center;">{{ $productInfo->quantity }}</td>
                    <td class="tm_width_2 tm_text_right" style="text-align: right;">{{ formatNumber($productInfo->net_total) }}</td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr class="invt-footer-row subtotal-tr">
                <td colspan="4" class="invfr-left invt-subtotal">
                    {{ __('Subtotal') }}:
                </td>
                <td colspan="2" class="invfr-right invt-subtotal-amount">
                     {{ formatNumber($quotation->subtotal_amount) }}
                </td>
            </tr>

            <tr class="invt-footer-row">
                <td colspan="4" class="invfr-left">

                    {{ __('Vat') }}
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->vat_amount) }}
                </td>
            </tr>

            <tr class="invt-footer-row">
                <td colspan="4" class="invfr-left">
                    {{ __('Discount') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->discount_amount) }}
                </td>
            </tr>

            {{-- <tr class="invt-footer-row">
                <td colspan="4" class="invfr-left">
                    {{ __('Unloading Cost') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->unloading_cost) }}
                </td>
            </tr> --}}

            <tr class="invt-footer-row total-tr">
                <td colspan="4" class="invfr-left">
                    {{ __('Total') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    PHP {{ formatNumber($quotation->payable_amount) }}
                </td>
            </tr>

            </tfoot>
        </table>
    </div>


    
    <div class="payment-info" style="overflow: hidden;">
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
        
    </div>
        
    <div class="hr-element"></div>


@if($quotation->notes)
    <div class="invoice-note">
        <h6>
            {{ __('Notes') }} / {{ __('Terms') }}
        </h6>
        @php
            $hasHtmlContent = $quotation->notes !== strip_tags($quotation->notes);
            $notesHtmlForPdf = $quotation->notes;

            if ($hasHtmlContent) {
                // Normalize editor HTML so image-only paragraphs don't force one-image-per-row in PDF.
                $notesHtmlForPdf = preg_replace('/<p>(?:\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $notesHtmlForPdf);
                $notesHtmlForPdf = preg_replace('/<p>\s*((?:<img\b[^>]*>\s*)+)<\/p>/i', '$1', $notesHtmlForPdf);
                $notesHtmlForPdf = preg_replace('/<p>\s*((?:<figure\b[^>]*>.*?<\/figure>\s*)+)<\/p>/is', '$1', $notesHtmlForPdf);

                $notesHtmlForPdf = preg_replace_callback(
                    '/(<img[^>]+src=["\'])([^"\']+)(["\'])/i',
                    function ($matches) {
                        $prefix = $matches[1];
                        $src = trim($matches[2]);
                        $suffix = $matches[3];
                        $srcPath = parse_url($src, PHP_URL_PATH);

                        if ($srcPath == null || $srcPath == '') {
                            $srcPath = $src;
                        }

                        if (str_starts_with($srcPath, '/storage/')) {
                            $absolutePath = public_path(ltrim($srcPath, '/'));
                        } elseif (str_starts_with($srcPath, 'storage/')) {
                            $absolutePath = public_path($srcPath);
                        } else {
                            return $matches[0];
                        }

                        if (!file_exists($absolutePath)) {
                            return $matches[0];
                        }

                        // wkhtmltopdf often fails with WebP; convert once to PNG for PDF rendering.
                        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
                        if ($extension === 'webp' && function_exists('imagecreatefromwebp') && function_exists('imagepng')) {
                            $cacheDir = storage_path('app/public/quotation/notes/pdf-cache');
                            if (!file_exists($cacheDir)) {
                                mkdir($cacheDir, 0777, true);
                            }

                            $cacheFilePath = $cacheDir . '/' . md5($absolutePath) . '.png';

                            if (!file_exists($cacheFilePath) || filemtime($cacheFilePath) < filemtime($absolutePath)) {
                                $image = @imagecreatefromwebp($absolutePath);
                                if ($image !== false) {
                                    imagepng($image, $cacheFilePath);
                                    imagedestroy($image);
                                }
                            }

                            if (file_exists($cacheFilePath)) {
                                return $prefix . $cacheFilePath . $suffix;
                            }
                        }

                        return $prefix . $absolutePath . $suffix;
                    },
                    $notesHtmlForPdf
                );
            }
        @endphp

        @if($hasHtmlContent)
            <div class="terms-html">{!! $notesHtmlForPdf !!}</div>
        @else
            <p style="white-space: pre-line;">{{ $quotation->notes }}</p>
        @endif
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
