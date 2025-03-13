<?php

namespace App\Http\Controllers;

use App\Helpers\GoToHelper;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query();

        if ($request->filled('start_date')) {
            $invoices->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $invoices->whereDate('created_at', '<=', $request->end_date);
        }

        $invoices = $invoices->paginate(10);
        return view('pages.invoice.index', compact('invoices'));
    }

    public function create()
    {
        $products = Product::paginate(1);
        return view('pages.invoice.create', compact('products'));
    }

    public function createInvoice(Request $request)
    {
        $selectedProducts = $request->query('selectedProducts', []);
        $products = Product::whereIn('id', $selectedProducts)->get();
        $company = Company::first();

        return view('pages.invoice.create-invoice', compact('products', 'company'));
    }

    public function show(Request $request)
    {
        $code = $request->query('ref', 0);
        $invoice = Invoice::with([
            'items' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->withTrashed();
                }]);
            },
        ])->where('code', $code)->first();

        if (!$invoice) {
            return GoToHelper::error('Invoice not found');
        }

        return view('pages.invoice.edit', compact('invoice'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment' => 'required',
        ]);

        if ($validator->fails()) {
            return GoToHelper::error('Payment is required');
        }

        $code = $request->query('ref', 0);
        $invoice = Invoice::with([
            'items' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->withTrashed();
                }]);
            },
        ])->where('code', $code)->first();

        if (!$invoice) {
            return GoToHelper::error('Invoice not found');
        }

        DB::beginTransaction();
        try {
            if ($invoice->payment == 'paid') {
                foreach ($invoice->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->update(['stock' => (int) $product->stock - (int) $item->quantity]);
                }
            }

            if ($request->payment == 'cancel') {
                foreach ($invoice->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->update(['stock' => (int) $product->stock + (int) $item->quantity]);
                }
            }

            $invoice->update(['payment' => $request->payment]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while updating the invoice');
        }

        return GoToHelper::success('Invoice updated successfully', 'invoices.show', ['ref' => $invoice->code]);
    }

    public function preview(Request $request)
    {
        $code = $request->query('ref', 0);
        $invoice = Invoice::with([
            'items' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->withTrashed();
                }]);
            },
        ])->where('code', $code)->firstOrFail();

        $pdf = Pdf::loadView('pages.invoice.pdf', compact('invoice'));

        return $pdf->stream('pages.invoice.pdf');
    }
}
