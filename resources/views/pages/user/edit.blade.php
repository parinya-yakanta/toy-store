@extends('layouts.default-layout')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">แก้ไขข้อมูลพนักงาน</h4>

                    <div class="page-title-right">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-light">
                            <i class="ri-arrow-go-back-line align-middle fs-15"></i>
                            กลับไปหน้ารายการ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="{{ route(Request::segment(1).'.update', ['ref' => Arr::get($user, 'code')]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Laravel requires this for updating resources --}}

            <div class="row container">
                <div class="col-md-3">
                    <label class="form-label">เลือกรูปโปรไฟล์</label>
                    <div class="d-flex justify-content-center">
                        <div class="p-2 text-center position-relative" style="width: 200px; height: 200px;">
                            <label for="image-upload" class="position-absolute top-0 start-0 w-100 h-100"
                                style="cursor: pointer;">
                                <img id="output-avatar"
                                    src="{{ $user->avatar ? $user->avatar : asset('assets/images/avatar-dumy.png') }}"
                                    class="border border-success rounded-circle img-thumbnail w-100 h-100"
                                    style="object-fit: cover;">
                            </label>
                            <div class="text-danger">{{ $errors->first('avatar') }}</div>
                            <input id="image-upload" class="form-control d-none" type="file" name="avatar"
                                accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>

                <div class="col-md-9 container">
                    <div class="row">
                        <div class="col-md-12 container">
                            <div class="mb-3">
                                <label class="form-label" for="name">ชื่อ - สกุล</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name', $user->name) }}" placeholder="Enter your name">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">อีเมล</label>
                                <input class="form-control" id="email" type="email" value="{{ Arr::get($user, 'email') }}" disabled>
                            </div>

                            <!-- รหัสผ่าน -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)</label>
                                        <div class="input-group">
                                            <input class="form-control" id="password" name="password" type="password"
                                                placeholder="Enter new password (optional)">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password', 'togglePasswordBtn1')">
                                                <i id="togglePasswordBtn1" class="ri-eye-close-line"></i>
                                            </button>
                                        </div>
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    </div>
                                </div>

                                <!-- ยืนยันรหัสผ่าน -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                        <div class="input-group">
                                            <input class="form-control" id="password_confirmation"
                                                name="password_confirmation" type="password"
                                                placeholder="Confirm new password">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password_confirmation', 'togglePasswordBtn2')">
                                                <i id="togglePasswordBtn2" class="ri-eye-close-line"></i>
                                            </button>
                                        </div>
                                        <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">เบอร์โทร</label>
                                <input class="form-control" id="phone" name="phone" type="text"
                                    value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone">
                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="address">ที่อยู่</label>
                                <textarea class="form-control" id="address" name="address" rows="3"
                                    placeholder="Enter your address">{{ old('address', $user->address) }}</textarea>
                                <div class="text-danger">{{ $errors->first('address') }}</div>
                            </div>
                        </div>
                        <div class="text-end container">
                            <a href="{{ route('users.index') }}" class="btn btn-light">กลับไปหน้ารายการ</a>
                            <button class="btn btn-primary" type="submit">อัปเดตข้อมูล</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- JavaScript -->
        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                const output = document.getElementById('output-avatar');

                if (file) {
                    output.src = URL.createObjectURL(file);
                    output.onload = () => URL.revokeObjectURL(output.src); // free memory
                }
            }

            function togglePassword(inputId, iconId) {
                let input = document.getElementById(inputId);
                let icon = document.getElementById(iconId);

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("ri-eye-close-line");
                    icon.classList.add("ri-eye-line");
                } else {
                    input.type = "password";
                    icon.classList.remove("ri-eye-line");
                    icon.classList.add("ri-eye-close-line");
                }
            }
        </script>

    </div>
@endsection
