@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">รายการขาย</h4>

                <div class="page-title-right">
                    <a href="{{ route('invoices.create') }}">
                        <button class="btn btn-sm btn-primary">
                            <i class="ri-add-line align-middle fs-15"></i>
                            สร้างใบขาย
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- end page title -->
    <div class="row pb-3">
    @php
        use Carbon\Carbon;
        $currentYear = Carbon::now()->year;
        $defaultStartDate = Carbon::create($currentYear, 1, 1)->toDateString(); // 01-01-ปีปัจจุบัน
        $defaultEndDate = Carbon::create($currentYear, 12, 31)->toDateString(); // 31-12-ปีปัจจุบัน
    @endphp

    <form method="GET" action="{{ route('invoices.index') }}">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">วันที่เริ่มต้น:</label>
                <input type="date" id="start_date" name="start_date" class="form-control"
                    value="{{ request('start_date', $defaultStartDate) }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">วันที่สิ้นสุด:</label>
                <input type="date" id="end_date" name="end_date" class="form-control"
                    value="{{ request('end_date', $defaultEndDate) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
                <button type="button" class="btn btn-secondary ml-2" id="clearBtn" style="margin-left: 10px;">เคลียร์</button>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('clearBtn').addEventListener('click', function () {
            // รีเซ็ตค่า input date ให้เป็นวันที่เริ่มต้น (ต้นปีและสิ้นปี)
            document.getElementById('start_date').value = '{{ $defaultStartDate }}';
            document.getElementById('end_date').value = '{{ $defaultEndDate }}';

            // ส่งค่าใหม่ไปยัง URL โดยการ submit form
            this.closest('form').submit();
        });
    </script>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <table id="invoices-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th>รหัสใบขาย</th>
                            <th>จำนวน/รายการ</th>
                            <th class="text-end">ยอดชำระเงิน</th>
                            <th>ผู้ขาย</th>
                            <th>วันที่สร้าง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-end">กระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + $invoices->firstItem() - 1 }}</td>
                                <td>{{ Arr::get($invoice, 'code') }}</td>
                                <td>{{ Arr::get($invoice, 'items')?->count() ?? 0 }} รายการ</td>
                                <td class="text-end">{{ Arr::get($invoice, 'total') }} <small>฿</small></td>
                                <td>{{ Arr::get($invoice->user, 'name') }}</td>
                                <td>{{ Arr::get($invoice, 'created_at') }}</td>
                                <td class="text-center">
                                    @if (Arr::get($invoice, 'payment') == 'paid')
                                        <span class="badge bg-success">ชำระเงินแล้ว</span>
                                    @elseif (Arr::get($invoice, 'payment') == 'unpaid')
                                        <span class="badge bg-warning">ยังไม่ชำระเงิน</span>
                                    @elseif (Arr::get($invoice, 'payment') == 'cancel')
                                        <span class="badge bg-danger">ยกเลิก</span>
                                    @else
                                        <span class="badge bg-info">ไม่มีสถานะ</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('invoices.show', ['ref' => Arr::get($invoice, 'code')]) }}">
                                        <button class="btn btn-sm btn-soft-success">ดูใบขาย</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    ไม่มีข้อมูลการขาย
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#invoices-table').DataTable();
    });
    </script>
@endsection
