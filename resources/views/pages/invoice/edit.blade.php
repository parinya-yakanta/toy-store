@extends('layouts.default-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">เลขที่ {{ Arr::get($invoice, 'code') }}</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>ใบแจ้งหนี้</h4>
                    </div>
                    <div class="card-body">
                        <div class="row py-2 my-0">
                            <div class="col-md-6">
                                <h5 class="pb-2 my-0">ข้อมูลบริษัท</h5>
                                <p class="py-0 my-0"><strong>ชื่อบริษัท:</strong> {{ Arr::get($invoice->company, 'name') }}
                                </p>
                                <p class="py-0 my-0"><strong>ที่อยู่:</strong> {{ Arr::get($invoice->company, 'address') }}
                                </p>
                                <p class="py-0 my-0"><strong>เบอร์โทร:</strong> {{ Arr::get($invoice->company, 'phone') }}
                                </p>
                                <p class="py-0 my-0"><strong>อีเมล:</strong> {{ Arr::get($invoice->company, 'email') }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h5 class="pb-2 my-0">ข้อมูลใบแจ้งหนี้</h5>
                                <p class="py-0 my-0"><strong>เลขที่:</strong> {{ Arr::get($invoice, 'code') }}</p>
                                <p class="py-0 my-0"><strong>วันที่:</strong> {{ Arr::get($invoice, 'created_at') }}</p>
                                <div class="pt-2 mb-0 pb-0">
                                    <h4>สถานะ</h4>
                                    @if (Arr::get($invoice, 'payment') == 'unpaid')
                                        <form action="{{ route('invoices.update', ['ref' => Arr::get($invoice, 'code')]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <select class="form-select w-auto" name="payment">
                                                    <option value="paid"
                                                        {{ Arr::get($invoice, 'payment') == 'paid' ? 'selected' : '' }}>
                                                        ชำระเงินแล้ว</option>
                                                    <option value="unpaid"
                                                        {{ Arr::get($invoice, 'payment') == 'unpaid' ? 'selected' : '' }}>
                                                        ยังไม่ชำระเงิน</option>
                                                    <option value="cancel"
                                                        {{ Arr::get($invoice, 'payment') == 'cancel' ? 'selected' : '' }}>
                                                        ยกเลิก</option>
                                                </select>
                                                <button type="submit" class="btn btn-warning text-dark">อัพเดต</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <select class="form-select w-auto" disabled>
                                                <option value="paid"
                                                    {{ Arr::get($invoice, 'payment') == 'paid' ? 'selected' : '' }}>
                                                    ชำระเงินแล้ว</option>
                                                <option value="unpaid"
                                                    {{ Arr::get($invoice, 'payment') == 'unpaid' ? 'selected' : '' }}>
                                                    ยังไม่ชำระเงิน</option>
                                                <option value="cancel"
                                                    {{ Arr::get($invoice, 'payment') == 'cancel' ? 'selected' : '' }}>
                                                    ยกเลิก</option>
                                                <option value=""
                                                    {{ !in_array(Arr::get($invoice, 'payment'), ['paid', 'unpaid', 'cancel']) ? 'selected' : '' }}>
                                                    ไม่มีสถานะ</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Products Table -->
                        <h5 class="text-center">รายละเอียดสินค้า</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th class="text-end">ราคา</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-end">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @if (!is_null($invoice->items))
                                    @foreach ($invoice->items as $index => $product)
                                        @php
                                            $subtotal = $product->price * $product->quantity;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $product->product?->code }}</td>
                                            <td>{{ $product->product?->name }}</td>
                                            <td class="text-end">{{ number_format($product->price, 2) }} ฿</td>
                                            <td class="text-center">{{ $product->quantity }}</td>
                                            <td class="text-end">{{ number_format($subtotal, 2) }} ฿</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">ยอดรวม</th>
                                    <th class="text-end">{{ number_format($total, 2) }} ฿</th>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Footer Section -->
                        <div class="text-end mt-4">
                            <a href="{{ route('invoices.pdf-download', ['ref' => $invoice->code]) }}" target="_blank">
                                <button class="btn btn-primary">ดูตัวอย่าง PDF</button>
                            </a>
                            {{-- <button class="btn btn-success" onclick="window.print()">พิมพ์ใบแจ้งหนี้</button> --}}
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">กลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
