@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">รายการหมวดหมู่</h4>

                <div class="page-title-right">
                    @if (auth()->user()?->role == 'admin')
                        <a href="{{ route('masters.categories.create') }}">
                            <button class="btn btn-sm btn-primary">
                                <i class="ri-add-line align-middle fs-15"></i>
                                เพิ่มหมวดหมู่
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
                <table id="categories-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            @if (auth()->user()?->role == 'admin')
                            <th class="text-end">กระทำ</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + $categories->firstItem() - 1 }}</td>
                                <td>{{ Arr::get($category, 'code') }}</td>
                                <td>{{ Arr::get($category, 'name') }}</td>
                                @if (auth()->user()?->role == 'admin')
                                <td class="text-end">
                                    <a href="{{ route('masters.categories.edit', ['ref' => Arr::get($category, 'code')]) }}">
                                        <button class="btn btn-sm btn-soft-info">แก้ไขรายละเอียด</button>
                                    </a>
                                    <form action="{{ route('masters.categories.destroy', ['ref' => $category->code]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหมวดหมู่คนนี้?');">ลบ</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    ไม่มีข้อมูลหมวดหมู่
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
        $('#categories-table').DataTable();
    });
    </script>
@endsection
