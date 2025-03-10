<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $monthlyProfit = $this->getMonthlyProfit($year);
        $dailySales = $this->getDailySales($year);

        return view('pages.dashboard', compact('year', 'monthlyProfit', 'dailySales'));
    }

    public function getMonthlyProfit($year)
    {
        $monthlyProfit = DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->join('products', 'invoice_items.product_id', '=', 'products.id')
            ->select(
                DB::raw('YEAR(invoices.created_at) as year'),
                DB::raw('MONTH(invoices.created_at) as month'),
                // Calculate total sales (quantity * sale price)
                DB::raw('SUM(invoice_items.quantity * invoice_items.price) as total_sales'),
                // Calculate total cost (quantity * cost price)
                DB::raw('SUM(invoice_items.quantity * products.original_price) as total_cost'),
                // Calculate total profit (total sales - total cost)
                DB::raw('SUM(invoice_items.quantity * (invoice_items.price - products.original_price)) as total_profit')
            )
            ->where('invoices.payment', 'paid')
            ->whereYear('invoices.created_at', $year)
            ->groupBy(DB::raw('YEAR(invoices.created_at)'), DB::raw('MONTH(invoices.created_at)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return $monthlyProfit;
    }

    public function getDailySales($year)
    {
        $dailySales = DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->join('products', 'invoice_items.product_id', '=', 'products.id')
            ->select(
                DB::raw('DAY(invoices.created_at) as day'),
                // คำนวณยอดขาย (จำนวน * ราคาขาย)
                DB::raw('SUM(invoice_items.quantity * invoice_items.price) as total_sales'),
                // คำนวณต้นทุน (จำนวน * ราคาต้นทุน)
                DB::raw('SUM(invoice_items.quantity * products.original_price) as total_cost'),
                // คำนวณกำไร (ยอดขาย - ต้นทุน)
                DB::raw('SUM(invoice_items.quantity * (invoice_items.price - products.original_price)) as total_profit')
            )
            ->where('invoices.payment', 'paid')
            ->whereYear('invoices.created_at', $year)
            ->whereMonth('invoices.created_at', date('m')) // กรองเฉพาะเดือนปัจจุบัน
            ->groupBy(DB::raw('DAY(invoices.created_at)'))
            ->orderBy('day', 'asc')
            ->get();

        return $dailySales;
    }
}
