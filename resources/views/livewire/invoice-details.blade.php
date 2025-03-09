<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box d-sm-flex align-items-start justify-content-between">
                <div>
                    <h5 class="mb-sm-0">รายละเอียดการสั่งซื้อ</h5>
                    <div class="mt-3">
                        <label for="paymentMethod" class="form-label">สถาานะชำระเงิน</label>
                        <select id="paymentMethod" wire:model="paymentMethod" class="form-select" required>
                            <option value="paid">ชำระเงินแล้ว</option>
                            <option value="unpaid">ยังไม่ชำระเงิน</option>
                        </select>
                    </div>
                </div>
                <div>
                    <h5 class="card-title">ข้อมูลบริษัท</h5>
                    <p class="card-text py-0 my-0"><strong class="text-muted">เลขประจำตัวผู้เสียภาษี:</strong> <span class="text-muted">{{ $company->tax_code }}</span> </p>
                    <p class="card-text py-0 my-0"><strong class="text-muted">ชื่อบริษัท:</strong> <span class="text-muted">{{ $company->name }}</span> <strong class="text-muted">ที่อยู่:</strong> <span class="text-muted">{{ $company->address }}</span></p>
                    <p class="card-text py-0 my-0"><strong class="text-muted">เบอร์โทร:</strong> <span class="text-muted">{{ $company->phone }}</span> <strong class="text-muted">อีเมล:</strong> <span class="text-muted">{{ $company->email }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form wire:submit.prevent="storeInvoice">
                <table id="invoice-create-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 15%;">รหัสสินค้า</th>
                            <th style="width: 35%;">ชื่อสินค้า</th>
                            <th class="text-end" style="width: 15%;">ราคา</th>
                            <th class="text-center" style="width: 10%;">จำนวน</th>
                            <th class="text-end" style="width: 20%;">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            @php
                                $subtotal = (float)$product->price * (int)$quantities[$product->id];
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td class="text-end">{{ number_format($product->price, 2) }} ฿</td>
                                <td class="text-center">
                                    <input
                                        type="number"
                                        wire:model.live="quantities.{{ $product->id }}"
                                        min="1"
                                        class="form-control"
                                        required
                                    />
                                </td>
                                <td class="text-end">{{ number_format($subtotal, 2) }} ฿</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">ยอดรวม</th>
                            <th class="text-end">{{ number_format($total, 2) }} ฿</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">สร้างและพิมพ์ใบเสร็จ</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">กลับ</a>
                </div>
            </form>
        </div>
    </div>
</div>
