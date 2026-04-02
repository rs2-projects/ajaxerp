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
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        .inv-table .invt-sl {
            width: 6%;
            text-align: center;
        }
        .inv-table .invt-item {
            width: 28%;
            text-align: left;
        }
        .inv-table .invt-unit {
            width: 10%;
            text-align: center;
        }
        .inv-table .invt-description {
            width: 30%;
            vertical-align: top;
        }
        .inv-table .invt-description p {
            margin: 0 0 4px 0;
        }
        .inv-table .invt-description .item-description-html {
            white-space: normal;
        }
        .inv-table .invt-description .item-description-html p {
            margin: 0 0 4px 0;
        }
        .inv-table .invt-description .item-description-html img {
            max-width: 100%;
            height: auto;
            display: inline-block;
            vertical-align: top;
            margin: 4px 1% 0 0;
        }
        .inv-table .invt-description .item-description-html figure {
            display: inline-block;
            vertical-align: top;
            margin: 4px 1% 0 0;
            max-width: 100%;
        }
        .inv-table .invt-description .item-description-html figure img {
            width: 100%;
        }
        .inv-table .item-description-row td {
            padding-top: 36px;
            padding-bottom: 30px;
            vertical-align: top;
        }
        .inv-table .item-description-row.media-only td {
            padding-top: 34px;
            padding-bottom: 24px;
            line-height: normal;
            vertical-align: top;
        }
        .inv-table .item-description-row.media-only .item-description-html {
            font-size: 0;
            line-height: normal;
            margin: 0;
        }
        .inv-table .item-description-row.media-only .item-description-html p {
            margin: 0 0 12px 0;
            line-height: normal;
        }
        .inv-table .item-description-row.media-only .item-description-html img,
        .inv-table .item-description-row.media-only .item-description-html figure {
            margin-top: 12px;
            margin-bottom: 12px;
        }
        .inv-table .invt-item-description-full {
            border-bottom: none;
            white-space: normal;
        }
        .inv-table .invt-item-description-full .item-description-label {
            font-weight: 600;
            margin: 6px 0 10px 0;
            display: block;
        }
        .inv-table .invt-item-description-full .item-description-html {
            display: block;
            width: 100%;
            margin: 16px 0;
        }
        .inv-table .invt-item-description-full .item-description-html p {
            margin: 0 0 12px 0;
        }
        .inv-table .invt-item-description-full .item-description-html > *:first-child {
            margin-top: 0 !important;
        }
        .inv-table .invt-item-description-full .item-description-html > *:last-child {
            margin-bottom: 0 !important;
        }
        .inv-table .invt-item-description-full .item-description-html img {
            max-width: 100%;
            height: auto;
            display: inline-block;
            vertical-align: top;
            margin: 4px 1% 0 0;
        }
        .inv-table .invt-item-description-full .item-description-html figure {
            display: inline-block;
            vertical-align: top;
            margin: 4px 1% 0 0;
            max-width: 100%;
        }
        .inv-table .invt-item-description-full .item-description-html figure img {
            width: 100%;
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
            width: 13%;
            text-align: right;
        }
        .inv-table .invt-vat {
            width: 10%;
            text-align: right;
        }
        .inv-table .invt-qty {
            width: 8%;
            text-align: center;
        }
        .inv-table .invt-total {
            width: 15%;
            text-align: right;
        }
        .inv-table tbody td {
            padding: 20px 8px;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        .inv-table .item-row-with-description td {
            border-bottom: none;
        }
        .invfr-left {
            text-align: right;
        }
        .invfr-right {
            text-align: right;
        }
        .inv-table .invt-footer-row td {
            padding: 14px 8px;
            font-size: 14px;
        }
        .inv-table .subtotal-tr td {
            padding-top: 10px;
        }
        .inv-table .total-tr td {
            /*border-top: 1px solid #ddd;*/
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding-bottom: 25px;
            margin-bottom: 25px;
        }
        .inv-table .amount-due-tr td {
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
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 18px 0 26px 0;
        }
        .signature-table tr + tr td {
            padding-top: 34px;
        }
        .signature-table .signature-left {
            padding-right: 26px;
        }
        .signature-table .signature-right {
            padding-left: 26px;
        }
        .signature-title {
            margin: 0 0 34px 0;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .signature-line {
            height: 52px;
            border-bottom: 1px solid #222;
            margin: 0 0 8px 0;
        }
        .signature-line-with-name {
            position: relative;
        }
        .signature-name-on-line {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 6px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }
        .signature-caption {
            margin: 0;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .invoice-return-init-2{
            padding: 1px 10px;
            font-size: 10px;
            color: #fff;
            border-radius: 3px;
            background-color:#04005a !important;
        }

        thead { display: table-row-group }
        .inv-table tbody tr { page-break-inside: auto; }
        .inv-table tbody tr.invt-footer-row { page-break-inside: avoid; }
        .inv-table tbody tr.item-description-row,
        .inv-table tbody tr.item-description-row td,
        .inv-table tbody tr.item-description-row .item-description-html,
        .inv-table tbody tr.item-description-row .item-description-html p {
            page-break-inside: auto !important;
        }


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
    @php
        $company = $company ?? null;
    @endphp
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
                <p class="ifinfo-company-name">{{ $company->company_name ?? 'AjaxERP' }}</p>
                <p class="ifinfo-text">{{ $company->address ?? '281 Purok 6 Santisimo Road Brgy Soledad San Pablo City' }}</p>
                <p class="ifinfo-text">{{ __('Email') }}: {{ $company->email ?? 'sales@sterk.ph' }}</p>
                <p class="ifinfo-text">{{ __('Mobile') }}: {{ $company->phone ?? '+639943648519' }}</p>
            </div>
        </div>
    </div>

    <div class="hr-element"></div>
    <div class="project-info">
        <h4 style="margin-bottom: 0px;"><span style="font-weight: bold;">Project Name : </span> <span style="font-weight:normal;">{{ $quotation->project_name }}</span></h4>
        <p style="margin: 20px 0;text-align:justify;">
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
                <th class="invt-sl">{{ __('Sl') }}</th>
                <th class="invt-item" style="text-align: left;">{{ __('Item') }}</th>
                <th class="invt-unit">{{ __('Unit') }}</th>
                <th class="invt-qty">{{ __('Qty') }}</th>
                <th class="invt-price">{{ __('Price') }}</th>
                <th class="invt-vat">{{ __('Vat') }}</th>
                <th class="invt-total" style="width: 120px;">{{ __('Total') }} (PHP)</th>
            </tr>
            </thead>
            <tbody>
            {{--{{dd($invoice)}}--}}
            @php
                $resolvePdfImagePath = function ($src, $cacheDirRelativePath) {
                    $src = trim((string) $src);
                    $srcPath = parse_url($src, PHP_URL_PATH);

                    if ($srcPath == null || $srcPath == '') {
                        $srcPath = $src;
                    }

                    if (str_starts_with($srcPath, '/storage/')) {
                        $absolutePath = public_path(ltrim($srcPath, '/'));
                    } elseif (str_starts_with($srcPath, 'storage/')) {
                        $absolutePath = public_path($srcPath);
                    } else {
                        return null;
                    }

                    if (!file_exists($absolutePath)) {
                        return null;
                    }

                    $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
                    if ($extension === 'webp' && function_exists('imagecreatefromwebp') && function_exists('imagepng')) {
                        $cacheDir = storage_path('app/public/' . trim($cacheDirRelativePath, '/'));
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
                            return $cacheFilePath;
                        }
                    }

                    return $absolutePath;
                };

                $replaceImageSourcesForPdf = function ($html, $cacheDirRelativePath) use ($resolvePdfImagePath) {
                    return preg_replace_callback(
                        '/(<img[^>]+src=["\'])([^"\']+)(["\'])/i',
                        function ($matches) use ($resolvePdfImagePath, $cacheDirRelativePath) {
                            $resolvedPath = $resolvePdfImagePath($matches[2], $cacheDirRelativePath);
                            if ($resolvedPath == null || $resolvedPath === '') {
                                return $matches[0];
                            }

                            return $matches[1] . $resolvedPath . $matches[3];
                        },
                        (string) $html
                    );
                };

                $normalizeImageOnlyParagraphsForPdf = function ($html) {
                    $html = (string) $html;
                    $html = preg_replace('/<p>(?:\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $html);
                    $html = preg_replace('/<p>\s*((?:<img\b[^>]*>\s*)+)<\/p>/i', '$1', $html);
                    $html = preg_replace('/<p>\s*((?:<figure\b[^>]*>.*?<\/figure>\s*)+)<\/p>/is', '$1', $html);

                    return $html;
                };

                $formatItemDescriptionHtmlForPdf = function ($description) use ($replaceImageSourcesForPdf) {
                    $description = (string) $description;
                    $hasHtml = $description !== strip_tags($description);
                    if (!$hasHtml) {
                        return [
                            'has_html' => false,
                            'html' => $description,
                        ];
                    }

                    $formattedHtml = $description;

                    if (class_exists('DOMDocument')) {
                        libxml_use_internal_errors(true);
                        $dom = new \DOMDocument();
                        $loaded = $dom->loadHTML(
                            '<?xml encoding="utf-8" ?><div id="item-desc-root">' . $formattedHtml . '</div>',
                            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                        );

                        if ($loaded) {
                            $appendStyle = function ($element, $styleToAdd) {
                                $existingStyle = trim((string) $element->getAttribute('style'));
                                if ($existingStyle !== '' && !str_ends_with($existingStyle, ';')) {
                                    $existingStyle .= ';';
                                }
                                $element->setAttribute('style', $existingStyle . $styleToAdd);
                            };

                            $xpath = new \DOMXPath($dom);
                            $paragraphNodes = $xpath->query('//p');

                            if ($paragraphNodes !== false) {
                                foreach ($paragraphNodes as $paragraphNode) {
                                    $imageNodes = $paragraphNode->getElementsByTagName('img');
                                    $imageCount = $imageNodes->length;

                                    if ($imageCount <= 0) {
                                        continue;
                                    }

                                    $textContent = html_entity_decode((string) $paragraphNode->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $textContent = str_replace("\xc2\xa0", ' ', $textContent);
                                    $textContent = trim(preg_replace('/\s+/u', ' ', $textContent));
                                    if ($textContent !== '') {
                                        continue;
                                    }

                                    $hasExplicitImageSizing = false;
                                    foreach ($imageNodes as $imageNode) {
                                        $styleAttr = strtolower((string) $imageNode->getAttribute('style'));
                                        if ($imageNode->hasAttribute('width') || str_contains($styleAttr, 'width:')) {
                                            $hasExplicitImageSizing = true;
                                            break;
                                        }
                                    }

                                    // Remove extra text nodes (spaces/&nbsp;) between images so they do not wrap unexpectedly.
                                    $childNodes = [];
                                    foreach ($paragraphNode->childNodes as $childNode) {
                                        $childNodes[] = $childNode;
                                    }
                                    foreach ($childNodes as $childNode) {
                                        if ($childNode->nodeType !== XML_TEXT_NODE) {
                                            continue;
                                        }

                                        $nodeText = html_entity_decode((string) $childNode->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        $nodeText = str_replace("\xc2\xa0", ' ', $nodeText);
                                        $nodeText = trim(preg_replace('/\s+/u', ' ', $nodeText));
                                        if ($nodeText === '') {
                                            $paragraphNode->removeChild($childNode);
                                        }
                                    }
                                    $appendStyle($paragraphNode, 'margin:0 0 8px 0;');

                                    // Keep inserted image format when width/style was explicitly set in editor.
                                    if ($hasExplicitImageSizing) {
                                        foreach ($imageNodes as $imageNode) {
                                            // Keep style-based sizing, but remove HTML dimensions to prevent oversized blank layout in wkhtmltopdf.
                                            $imageNode->removeAttribute('width');
                                            $imageNode->removeAttribute('height');
                                            $appendStyle($imageNode, 'max-width:100%;height:auto;vertical-align:top;float:none;');
                                        }
                                        continue;
                                    }

                                    if ($imageCount === 1) {
                                        $styleSuffix = 'width:100%;max-width:100%;height:auto;display:block;vertical-align:top;float:none;';
                                    } elseif ($imageCount === 2) {
                                        $styleSuffix = 'width:49%;max-width:49%;height:auto;display:inline-block;vertical-align:top;float:none;';
                                    } elseif ($imageCount === 3) {
                                        $styleSuffix = 'width:32%;max-width:32%;height:auto;display:inline-block;vertical-align:top;float:none;';
                                    } else {
                                        $styleSuffix = 'width:24%;max-width:24%;height:auto;display:inline-block;vertical-align:top;float:none;';
                                    }

                                    foreach ($imageNodes as $imageNode) {
                                        // Remove HTML dimension attributes to avoid wkhtmltopdf reserving oversized blank space.
                                        $imageNode->removeAttribute('width');
                                        $imageNode->removeAttribute('height');
                                        $appendStyle($imageNode, $styleSuffix);
                                    }

                                }
                            }

                            $rootNode = $dom->getElementById('item-desc-root');
                            if ($rootNode) {
                                $normalizedHtml = '';
                                foreach ($rootNode->childNodes as $childNode) {
                                    $normalizedHtml .= $dom->saveHTML($childNode);
                                }
                                $formattedHtml = $normalizedHtml;
                            }
                        }
                        libxml_clear_errors();
                    }

                    $formattedHtml = $replaceImageSourcesForPdf($formattedHtml, 'quotation/item-description/pdf-cache');

                    return [
                        'has_html' => true,
                        'html' => $formattedHtml,
                    ];
                };

                $splitDescriptionHtmlBlocksForPdf = function ($html) {
                    $html = (string) $html;
                    if (trim($html) === '') {
                        return [];
                    }

                    $blocks = [];
                    if (class_exists('DOMDocument')) {
                        libxml_use_internal_errors(true);
                        $dom = new \DOMDocument();
                        $loaded = $dom->loadHTML(
                            '<?xml encoding="utf-8" ?><div id="item-desc-split-root">' . $html . '</div>',
                            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                        );

                        if ($loaded) {
                            $rootNode = $dom->getElementById('item-desc-split-root');
                            if ($rootNode) {
                                foreach ($rootNode->childNodes as $childNode) {
                                    if ($childNode->nodeType === XML_TEXT_NODE) {
                                        $plainText = html_entity_decode((string) $childNode->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        $plainText = str_replace("\xc2\xa0", ' ', $plainText);
                                        $plainText = trim(preg_replace('/\s+/u', ' ', $plainText));
                                        if ($plainText !== '') {
                                            $blocks[] = [
                                                'html' => nl2br(htmlspecialchars($plainText, ENT_QUOTES, 'UTF-8')),
                                                'is_media_only' => false,
                                            ];
                                        }
                                        continue;
                                    }

                                    $chunkHtml = trim((string) $dom->saveHTML($childNode));
                                    if ($chunkHtml === '') {
                                        continue;
                                    }

                                    $chunkText = html_entity_decode(strip_tags($chunkHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $chunkText = str_replace("\xc2\xa0", ' ', $chunkText);
                                    $chunkText = trim(preg_replace('/\s+/u', ' ', $chunkText));
                                    $hasMedia = (preg_match('/<img\b/i', $chunkHtml) === 1) || (preg_match('/<table\b/i', $chunkHtml) === 1);
                                    if ($chunkText === '' && !$hasMedia) {
                                        continue;
                                    }

                                    $blocks[] = [
                                        'html' => $chunkHtml,
                                        'is_media_only' => ($chunkText === '' && $hasMedia),
                                    ];
                                }
                            }
                        }
                        libxml_clear_errors();
                    }

                    if (count($blocks) <= 0) {
                        $fallbackText = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $fallbackText = str_replace("\xc2\xa0", ' ', $fallbackText);
                        $fallbackText = trim(preg_replace('/\s+/u', ' ', $fallbackText));
                        $fallbackHasMedia = (preg_match('/<img\b/i', $html) === 1) || (preg_match('/<table\b/i', $html) === 1);
                        $blocks[] = [
                            'html' => $html,
                            'is_media_only' => ($fallbackText === '' && $fallbackHasMedia),
                        ];
                    }

                    return $blocks;
                };

                $resolveItemUnitLabel = function ($item) {
                    if ($item == null) {
                        return '-';
                    }

                    if ($item->item_type == \App\Models\Sales\QuotationDetails::TYPE_RAW_MATERIAL
                        || $item->item_type == \App\Models\Sales\QuotationDetails::TYPE_RAW_BOARD
                        || $item->item_type == \App\Models\Sales\QuotationDetails::TYPE_PAPER) {
                        $unitType = $item->product_material?->unit_type ?? null;
                        return \App\Models\Products\ProductMaterial::UNIT_TYPES[$unitType] ?? '-';
                    }

                    if ($item->item_type == \App\Models\Sales\QuotationDetails::TYPE_FINISHED_GOODS
                        || $item->item_type == \App\Models\Sales\QuotationDetails::TYPE_FINISHED_BOARD) {
                        $unitType = $item->finishedGood?->unit_type ?? null;
                        return \App\Models\Products\FinishedGoods::UNIT_TYPES[$unitType] ?? '-';
                    }

                    if ($item->item_type == \App\Models\Sales\QuotationDetails::TYPE_SET_ITEM) {
                        return 'SET';
                    }

                    return '-';
                };
            @endphp

            @foreach($quotationDetails as $productInfo)
                @php
                    $formattedDescription = $formatItemDescriptionHtmlForPdf($productInfo->description);
                    $rawDescription = (string) $productInfo->description;
                    $descriptionHasContent = (preg_match('/<img\b/i', $rawDescription) === 1)
                        || (trim(html_entity_decode(strip_tags($rawDescription), ENT_QUOTES | ENT_HTML5)) !== '');
                    $descriptionHtmlBlocks = [];
                    if ($formattedDescription['has_html']) {
                        $descriptionHtmlBlocks = $splitDescriptionHtmlBlocksForPdf($formattedDescription['html']);
                    }
                @endphp
                <tr class="{{ $descriptionHasContent ? 'item-row-with-description' : '' }}">
                    <td style="text-align: center;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="tm_width_3">
                        {{ $productInfo->itemName() }}
                    </td>
                    <td style="text-align: center;">
                        {{ $resolveItemUnitLabel($productInfo) }}
                    </td>
                    <td class="tm_width_1" style="text-align: center;">{{ $productInfo->quantity }}</td>
                    <td class="tm_width_2" style="text-align: right;">{{ formatNumber($productInfo->unit_price) }}</td>
                    <td class="tm_width_1" style="text-align: right;">{{ formatNumber($productInfo->tax_amount) }}</td>
                    <td class="tm_width_2 tm_text_right" style="text-align: right;">{{ formatNumber($productInfo->net_total) }}</td>

                </tr>
                @if($descriptionHasContent)
                    @if($formattedDescription['has_html'])
                        @foreach($descriptionHtmlBlocks as $descriptionBlock)
                            @php
                                $blockHtml = is_array($descriptionBlock) ? ((string) ($descriptionBlock['html'] ?? '')) : (string) $descriptionBlock;
                                $isMediaOnlyBlock = is_array($descriptionBlock) ? ((bool) ($descriptionBlock['is_media_only'] ?? false)) : false;
                            @endphp
                            @if(trim($blockHtml) === '')
                                @continue
                            @endif
                            <tr class="item-description-row{{ $isMediaOnlyBlock ? ' media-only' : '' }}">
                                <td colspan="7" class="invt-item-description-full">
                                    <div class="item-description-html">{!! $blockHtml !!}</div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="item-description-row">
                            <td colspan="7" class="invt-item-description-full">
                                <div class="item-description-html">{{ $productInfo->description }}</div>
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach

            
            <tr class="invt-footer-row subtotal-tr">
                <td colspan="5" class="invfr-left invt-subtotal">
                    {{ __('Subtotal') }}:
                </td>
                <td colspan="2" class="invfr-right invt-subtotal-amount">
                     {{ formatNumber($quotation->subtotal_amount) }}
                </td>
            </tr>

            <tr class="invt-footer-row">
                <td colspan="5" class="invfr-left">

                    {{ __('Vat') }}
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->vat_amount) }}
                </td>
            </tr>

            <tr class="invt-footer-row">
                <td colspan="5" class="invfr-left">
                    {{ __('Discount') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->discount_amount) }}
                </td>
            </tr>

            {{-- <tr class="invt-footer-row">
                <td colspan="3" class="invfr-left">
                    {{ __('Unloading Cost') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    {{ formatNumber($quotation->unloading_cost) }}
                </td>
            </tr> --}}

            <tr class="invt-footer-row total-tr">
                <td colspan="5" class="invfr-left">
                    {{ __('Total') }}:
                </td>
                <td colspan="2" class="invfr-right">
                    PHP {{ formatNumber($quotation->payable_amount) }}
                </td>
            </tr>

            </tbody>
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
                $notesHtmlForPdf = $normalizeImageOnlyParagraphsForPdf($notesHtmlForPdf);
                $notesHtmlForPdf = $replaceImageSourcesForPdf($notesHtmlForPdf, 'quotation/notes/pdf-cache');
            }
        @endphp

        @if($hasHtmlContent)
            <div class="terms-html">{!! $notesHtmlForPdf !!}</div>
        @else
            <p style="white-space: pre-line;">{{ $quotation->notes }}</p>
        @endif
    </div>

@endif

@php
    $signatureCustomerName = trim((string) ($customer->business_name ?? ''));
    if ($signatureCustomerName === '') {
        $signatureCustomerName = 'Customer';
    }
@endphp

<div class="signature-section">
    <table class="signature-table">
        <tr>
            <td class="signature-left">
                <p class="signature-title">Approved By:</p>
                <div class="signature-line"></div>
                <p class="signature-caption">Management</p>
            </td>
            <td class="signature-right">
                <p class="signature-title">Submitted By:</p>
                <div class="signature-line"></div>
                <p class="signature-caption">Sales Associate</p>
            </td>
        </tr>
        <tr>
            <td class="signature-left">
                <p class="signature-title">Conformed By:</p>
                <div class="signature-line signature-line-with-name">
                    <span class="signature-name-on-line">{{ $signatureCustomerName }}</span>
                </div>
                <p class="signature-caption">Customer Signature</p>
            </td>
            <td class="signature-right">
                <p class="signature-title">Approval For AOS Upload:</p>
                <div class="signature-line"></div>
                <p class="signature-caption">Management</p>
            </td>
        </tr>
    </table>
</div>
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
