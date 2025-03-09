@extends('layouts.default-layout')
@section('content')
@livewire('invoice-details', ['products' => $products, 'company' => $company])
@endsection
