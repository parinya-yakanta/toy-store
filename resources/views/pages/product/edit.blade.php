@extends('layouts.default-layout')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">แก้ไขสินค้า</h4>
                </div>
            </div>
        </div>

        <form action="{{ route('products.update', ['ref' => $product->code]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row container">
                <div class="col-md-3">
                    <label class="form-label">เลือกรูปสินค้า</label>
                    <div class="d-flex justify-content-center">
                        <div class="p-2 text-center position-relative" style="width: 200px; height: 200px;">
                            <label for="image-upload" class="position-absolute top-0 start-0 w-100 h-100"
                                style="cursor: pointer;">
                                <img id="output-avatar"
                                    src="{{ Arr::get($product, 'image', asset('assets/images/product-dummy.png')) }}"
                                    class="border border-success rounded img-thumbnail w-100 h-100"
                                    style="object-fit: cover;">
                            </label>
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            <input id="image-upload" class="form-control d-none" type="file" name="image"
                                accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>

                    <script>
                        function previewImage(event) {
                            const file = event.target.files[0];
                            const output = document.getElementById('output-avatar');
                            if (file) {
                                output.src = URL.createObjectURL(file);
                                output.onload = () => URL.revokeObjectURL(output.src);
                            }
                        }
                    </script>
                </div>

                <div class="col-md-9 container">
                    <div class="row">
                        <div class="col-md-12 container">
                            <div class="mb-3">
                                <label class="form-label" for="name">ชื่อสินค้า</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    value="{{ old('name', $product->name) }}" placeholder="กรอกชื่อสินค้า">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">รายละเอียดสินค้า</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="กรอกรายละเอียดสินค้า">{{ old('description', $product->description) }}</textarea>
                                <div class="text-danger">{{ $errors->first('description') }}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="category_id">หมวดหมู่สินค้า</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">เลือกหมวดหมู่</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger">{{ $errors->first('category_id') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="brand_id">แบรนด์สินค้า</label>
                                        <select class="form-control" id="brand_id" name="brand_id">
                                            <option value="">เลือกแบรนด์สินค้า</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger">{{ $errors->first('brand_id') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- ราคา -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="original_price">ราคาทุน</label>
                                        <input class="form-control" id="original_price" name="original_price" type="number"
                                            value="{{ old('original_price', $product->original_price) }}" placeholder="ราคาทุน">
                                        <div class="text-danger">{{ $errors->first('original_price') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">ราคาขาย</label>
                                        <input class="form-control" id="price" name="price" type="number"
                                            value="{{ old('price', $product->price) }}" placeholder="ราคาขาย">
                                        <div class="text-danger">{{ $errors->first('price') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="discount">ส่วนลด (%)</label>
                                        <input class="form-control" id="discount" name="discount" type="number"
                                            value="{{ old('discount', $product->discount) }}" placeholder="ส่วนลด">
                                        <div class="text-danger">{{ $errors->first('discount') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- สต็อกสินค้า -->
                            <div class="mb-3">
                                <label class="form-label" for="stock">จำนวนสินค้าในสต็อก</label>
                                <input class="form-control" id="stock" name="stock" type="number"
                                    value="{{ old('stock', $product->stock) }}" placeholder="จำนวนสินค้า">
                                <div class="text-danger">{{ $errors->first('stock') }}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="weight">น้ำหนัก (กก.)</label>
                                        <input class="form-control" id="weight" name="weight" type="text"
                                            value="{{ old('weight', $product->weight) }}" placeholder="น้ำหนัก">
                                        <div class="text-danger">{{ $errors->first('weight') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="dimension">ขนาด (ซม.)</label>
                                        <input class="form-control" id="dimension" name="dimension" type="text"
                                            value="{{ old('dimension', $product->dimension) }}" placeholder="ขนาดสินค้า">
                                        <div class="text-danger">{{ $errors->first('dimension') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end container">
                            <a href="{{ route('products.index') }}">
                                <button class="btn btn-light" type="button">กลับไปหน้ารายการ</button>
                            </a>
                            <button class="btn btn-primary" type="submit">บันทึกการแก้ไข</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
