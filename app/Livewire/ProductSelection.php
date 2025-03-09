<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSelection extends Component
{
    public $selectedProducts = [];
    public $products;
    public $pagination;
    public $nextPage = false;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts($page = 1)
    {
        $paginatedProducts = Product::paginate(10, ['*'], 'page', $page);

        $this->products = $paginatedProducts->items();
        $this->pagination = [
            'total' => $paginatedProducts->total(),
            'perPage' => $paginatedProducts->perPage(),
            'currentPage' => $paginatedProducts->currentPage(),
            'lastPage' => $paginatedProducts->lastPage(),
            'nextPageUrl' => $paginatedProducts->nextPageUrl(),
            'previousPageUrl' => $paginatedProducts->previousPageUrl(),
        ];
    }

    public function submitSelection()
    {
        if (empty($this->selectedProducts)) {
            flash('Please select at least one product', 'error');
            return redirect()->back()->with('error', 'Please select at least one product');
        }

        return redirect()->route('invoices.create-invoice', ['selectedProducts' => $this->selectedProducts]);
    }

    public function render()
    {
        return view('livewire.product-selection');
    }
}
