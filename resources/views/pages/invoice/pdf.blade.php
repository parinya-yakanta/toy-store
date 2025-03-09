<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ใบแจ้งหนี้</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew", sans-serif;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th.border,
        td.border {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h1 class="text-center">ใบแจ้งหนี้</h1>
    <table>
        <thead>
            <tr>
                <th style="text-align: left; vertical-align: top; width: 50%; padding-right: 10; padding-left: 10;">
                    <p style="margin: 0;"><strong>เลขที่:</strong> {{ $invoice->code }}</p>
                    <p style="margin: 0;"><strong>วันที่:</strong> {{ $invoice->created_at }}</p>
                    <h3 style="margin-top: 5;">
                        @switch($invoice->payment)
                            @case('paid')
                                ชำระเงินแล้ว
                                @break
                            @case('unpaid')
                                ยังไม่ชำระเงิน
                                @break
                            @case('cancel')
                                ยกเลิก
                                @break
                            @default
                                ไม่มีสถานะ
                        @endswitch
                    </h3>
                </th>
                <th style="text-align: right; vertical-align: top; width: 50%; padding-right: 10; padding-left: 10;">
                    <p style="margin: 0;"><strong>ชื่อบริษัท:</strong> {{ $invoice->company->name }}</p>
                    <p style="margin: 0;"><strong>ที่อยู่:</strong> {{ $invoice->company->address }}</p>
                    <p style="margin: 0;"><strong>เบอร์โทร:</strong> {{ $invoice->company->phone }} <strong>อีเมล:</strong> {{ $invoice->company->email }}</p>
                </th>
            </tr>
        </thead>
    </table>

    <hr>

    <table>
        <thead>
            <tr>
                <th class="border text-center" style="width: 5%;">#</th>
                <th class="border" style="width: 15%;">รหัสสินค้า</th>
                <th class="border" style="width: 40%;">ชื่อสินค้า</th>
                <th class="border text-end" style="width: 15%;">ราคา</th>
                <th class="border text-center" style="width: 5%;">จำนวน</th>
                <th class="border text-end" style="width: 20%;">รวม</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($invoice->items as $index => $product)
                @php
                    $subtotal = $product->price * $product->quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td class="border text-center">{{ $index + 1 }}</td>
                    <td class="border">{{ $product->product?->code }}</td>
                    <td class="border">{{ $product->product?->name }}</td>
                    <td class="border text-end">{{ number_format($product->price, 2) }} ฿</td>
                    <td class="border text-center">{{ $product->quantity }}</td>
                    <td class="border text-end">{{ number_format($subtotal, 2) }} ฿</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end border">ยอดรวม</th>
                <th class="text-end border">{{ number_format($total, 2) }} ฿</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
