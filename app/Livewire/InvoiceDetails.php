<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Livewire\Component;
use Illuminate\Support\Str;

class InvoiceDetails extends Component
{
    public $products;
    public $company;
    public $quantities = [];
    public $total = 0;
    public $paymentMethod = 'paid';

    public function mount($products, $company)
    {
        $this->products = $products;
        $this->company = $company;
        foreach ($this->products as $product) {
            $this->quantities[$product->id] = 1;
        }
        $this->recalculateTotal();
    }

    public function recalculateTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $price = is_numeric($product->price) ? (float) $product->price : 0;
            $quantity = isset($this->quantities[$product->id]) && is_numeric($this->quantities[$product->id]) ? (int) $this->quantities[$product->id] : 0;
            $subtotal = $price * $quantity;
            $product->subtotal = $subtotal;
            $total += $subtotal;
        }
        $this->total = $total;
    }

    public function updatedQuantities($value, $key)
    {
        $this->recalculateTotal();
    }

    public function storeInvoice()
    {
        $addInvoiceItem = Invoice::create([
            'user_id' => auth()->user()?->id,
            'company_id' => $this->company?->id,
            'code' => 'INV' . Str::upper(Str::random(3)) . time(),
            'total' => $this->total,
            'payment' => $this->paymentMethod,
        ]);

        if (!$addInvoiceItem) {
            flash('เกิดข้อผิดพลาดในการสร้างใบเสร็จ', 'error');
            return;
        }

        foreach ($this->quantities as $productId => $quantity) {
            $dataInvoiceItem = [
                'invoice_id' => $addInvoiceItem->id,
                'product_id' => $productId,
                'quantity' => (int) $quantity,
                'price' => $this->products->find($productId)->price,
                'discount' => $this->products->find($productId)->discount,
                'total' => $this->products->find($productId)->price * $quantity,
                'payment' => $this->paymentMethod,
            ];

            InvoiceItem::create($dataInvoiceItem);

            if ($this->paymentMethod == 'paid' || $this->paymentMethod == 'unpaid') {
                $product = $this->products->find($productId);
                $product->stock = $product->stock - $quantity;
                $product->save();
            }
        }

        flash('สร้างใบเสร็จเรียบร้อยแล้ว', 'success');
        return redirect()->route('invoices.index');
    }

    public function render()
    {
        return view('livewire.invoice-details');
    }
}
