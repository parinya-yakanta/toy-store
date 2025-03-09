@extends('layouts.default-layout')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">แก้ไขข้อมูลหมวดหมู่</h4>

                    <div class="page-title-right">
                        <a href="{{ route('masters.categories.index') }}" class="btn btn-sm btn-light">
                            <i class="ri-arrow-go-back-line align-middle fs-15"></i>
                            กลับไปหน้ารายการ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="{{ route('masters.categories.update', ['ref' => Arr::get($category, 'code')]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Laravel requires this for updating resources --}}

            <div class="row container">
                <div class="col-md-12 container">
                    <div class="row">
                        <div class="col-md-12 container">
                            <div class="mb-3">
                                <label class="form-label" for="name">ชื่อหมวดหมู่</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name', $category->name) }}" placeholder="Enter your name">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                        <div class="text-end container">
                            <a href="{{ route('masters.categories.index') }}" class="btn btn-light">กลับไปหน้ารายการ</a>
                            <button class="btn btn-primary" type="submit">อัปเดตข้อมูล</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
