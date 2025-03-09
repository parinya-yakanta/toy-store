@extends('layouts.default-layout')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">รายงาน</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-4">
            <h4 class="text-muted">รายงานยอดขายประจำวันในเดือน<span class="text-success">{{ \App\Helpers\CommonHelper::getMonthNameThai(date('m')) }}</span>  </h4>

            <!-- แสดงตารางยอดขายต่อวัน -->
            <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered"
                style="width:100%">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>ยอดขาย</th>
                        <th>ต้นทุน</th>
                        <th>กำไร</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailySales as $data)
                        <tr>
                            <td>{{ $data->day }}</td>
                            <td>{{ number_format($data->total_sales, 2) }}</td>
                            <td>{{ number_format($data->total_cost, 2) }}</td>
                            <td>{{ number_format($data->total_profit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <h4 class="text-muted">รายงานกำไรประจำเดือน ( ปี {{ $year }} )</h4>

            <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered"
                style="width:100%">
                <thead>
                    <tr>
                        <th>เดือน</th>
                        <th>ยอดขาย</th>
                        <th>ต้นทุน</th>
                        <th>กำไร</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyProfit as $data)
                        <tr>
                            <td>{{ \App\Helpers\CommonHelper::getMonthNameThai($data->month) }}</td>
                            <td>{{ number_format($data->total_sales, 2) }}</td>
                            <td>{{ number_format($data->total_cost, 2) }}</td>
                            <td>{{ number_format($data->total_profit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
