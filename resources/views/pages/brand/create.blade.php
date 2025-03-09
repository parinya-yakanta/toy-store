@extends('layouts.default-layout')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">เพิ่มแบรนด์</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <form action="{{ route('masters.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row container">
                <div class="col-md-12 container">
                    <div class="row">
                        <div class="col-md-12 container">
                            <div class="mb-3">
                                <label class="form-label" for="name">ชื่อแบรนด์</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name') }}" placeholder="กรอกชื่อแบรนด์" autocomplete="off">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                        <div class="text-end container">
                            <a href="{{ route('masters.brands.index') }}">
                                <button class="btn btn-light" type="button">กลับไปหน้ารายการ</button>
                            </a>
                            <button class="btn btn-primary" type="submit">บันทึกรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
