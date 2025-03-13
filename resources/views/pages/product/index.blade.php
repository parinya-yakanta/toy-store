@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">รายการสินค้า</h4>

                <div class="page-title-right">
                    @if (auth()->user()?->role == 'admin')
                        <a href="{{ route('products.create') }}">
                            <button class="btn btn-sm btn-primary">
                                <i class="ri-add-line align-middle fs-15"></i>
                                เพิ่มสินค้า
                            </button>
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <table id="products-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัส</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา/ส่วนลด</th>
                            <th class="text-end">สต็อกสินค้า</th>
                            <th class="text-center">หมวดหมู่</th>
                            <th class="text-center">แบรนด์</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-end">กระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Arr::get($product, 'code') }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ Arr::get($product, 'image', asset('assets/images/product-dummy.png')) }}" alt="" class="avatar-xs rounded-circle" />
                                        </div>
                                        <div class="flex-grow-1">
                                            {{ Arr::get($product, 'name') }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Arr::get($product, 'price') }} <small>.-</small> / {{ Arr::get($product, 'discount') }} <small>%</small> </td>
                                <td class="text-end">{{ Arr::get($product, 'stock') }} <small>ชิ้น</small></td>
                                <td class="text-center">{{ Arr::get($product->category, 'name') }}</td>
                                <td class="text-center">{{ Arr::get($product->brand, 'name') }}</td>
                                <td class="text-center">
                                    @if (Arr::get($product, 'stock') <= 0)
                                        <span class="badge bg-danger">สินค้าหมด</span>
                                    @elseif (Arr::get($product, 'stock') <= 10)
                                        <span class="badge bg-warning">สินค้าใกล้หมด</span>
                                    @else
                                        <span class="badge bg-success">สินค้าพร้อมขาย</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('invoices.create-invoice', ['selectedProducts' => [Arr::get($product, 'id')]]) }}">
                                        <button class="btn btn-sm btn-soft-success">ขาย</button>
                                    </a>
                                    @if (auth()->user()?->role == 'admin')
                                    <a href="{{ route('products.edit', ['ref' => Arr::get($product, 'code')]) }}">
                                        <button class="btn btn-sm btn-soft-info">แก้ไขรายละเอียด</button>
                                    </a>
                                        <form action="{{ route('products.destroy', ['ref' => $product->code]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้าคนนี้?');">ลบ</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    ไม่มีข้อมูลสินค้า
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
        $('#products-table').DataTable();
    });
    </script>
@endsection
