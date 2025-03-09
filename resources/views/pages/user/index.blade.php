@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">รายการพนักงาน</h4>

                <div class="page-title-right">
                    <a href="{{ route('users.create') }}">
                        <button class="btn btn-sm btn-primary">
                            <i class="ri-add-line align-middle fs-15"></i>
                            เพิ่มพนักงาน
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
                <table id="users-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th>เบอร์โทร</th>
                            <th>เข้าระบบล่าสุดเมื่อ</th>
                            <th class="text-end">กระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                <td>{{ Arr::get($user, 'code') }}</td>
                                <td>
                                    <div class="d-flex align-items-center fw-medium">
                                        <img src="{{ Arr::get($user, 'avatar', asset('assets/images/avatar-dumy.png')) }}" alt="" class="avatar-xxs me-2">
                                        <span class="currency_name">{{ Arr::get($user, 'name') }}</span>
                                    </div>
                                </td>
                                <td>{{ Arr::get($user, 'phone') }}</td>
                                <td>{{ Arr::get($user, 'last_login')?->format('d/m/Y H:i') ?? 'ยังไม่เคยเข้าระบบ' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('my.profile', ['ref' => Arr::get($user, 'code')]) }}">
                                        <button class="btn btn-sm btn-soft-info">ดูรายละเอียด</button>
                                    </a>
                                    <form action="{{ route('users.destroy', ['ref' => $user->code]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบพนักงานคนนี้?');">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    ไม่มีข้อมูลพนักงาน
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
        $('#users-table').DataTable();
    });
    </script>
@endsection
