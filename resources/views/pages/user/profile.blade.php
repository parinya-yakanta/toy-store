@extends('layouts.default-layout')
@section('content')
<div class="container-fluid">

    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="{{ Arr::get($user, 'avatar', asset('assets/images/avatar-dumy.png')) }}" alt="user-img" class="img-thumbnail rounded-circle" />
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <p class="text-white" style="font-size: 22px;">
                        รหัส: {{ Arr::get($user, 'code') }}
                    </p>
                    <h3 class="text-white mb-1" style="font-size: 28px;">
                        ชื่อ: {{ Arr::get($user, 'name') }}
                    </h3>
                    <p class="text-white" style="font-size: 22px;">
                        ตำแหน่ง:
                        @if (Arr::get($user, 'role') == 'admin')
                        ผู้ดูแลระบบ
                        @else
                        พนักงาน
                        @endif
                    </p>
                    <div class="hstack text-white gap-1" style="font-size: 18px;">
                        <div class="me-2">
                            <i class="ri-phone-line"></i>
                            {{ Arr::get($user, 'phone') }}
                        </div>
                        <div>
                            <i class="ri-mail-line"></i>
                            {{ Arr::get($user, 'email') }}
                        </div>
                    </div>
                    <div class="hstack text-white gap-1" style="font-size: 18px;">
                        <div class="me-2">
                            <i class="ri-map-pin-line"></i>
                            {{ Arr::get($user, 'address') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route(Request::segment(1).'.edit', ['ref' => $user->code]) }}" class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i> แก้ไขโปรไฟล์</a>
                    </div>
                </div>
            </div>
            <!--end col-->

        </div>
        <!--end row-->
    </div>

</div>
@endsection
