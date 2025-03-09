@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">รายการแบรนด์</h4>

                <div class="page-title-right">
                    <a href="{{ route('masters.brands.create') }}">
                        <button class="btn btn-sm btn-primary">
                            <i class="ri-add-line align-middle fs-15"></i>
                            เพิ่มแบรนด์
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <table id="brands-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th class="text-end">กระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td>{{ $loop->iteration + $brands->firstItem() - 1 }}</td>
                                <td>{{ Arr::get($brand, 'code') }}</td>
                                <td>{{ Arr::get($brand, 'name') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('masters.brands.edit', ['ref' => Arr::get($brand, 'code')]) }}">
                                        <button class="btn btn-sm btn-soft-info">แก้ไขรายละเอียด</button>
                                    </a>
                                    <form action="{{ route('masters.brands.destroy', ['ref' => $brand->code]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบแบรนด์คนนี้?');">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    ไม่มีข้อมูลแบรนด์
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
        $('#brands-table').DataTable();
    });
    </script>
@endsection
