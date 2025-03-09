<div>
    <form wire:submit.prevent="submitSelection">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <input type="checkbox" wire:model="selectedProducts" value="{{ $product['id'] }}">
                        </td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['price'] }} บาท</td>
                        <td>{{ $product['stock'] }} ชิ้น</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            @if($pagination['currentPage'] > 1)
                <a href="{{ $pagination['previousPageUrl'] }}" class="btn btn-secondary">Previous</a>
            @endif
            <span>Page {{ $pagination['currentPage'] }} of {{ $pagination['lastPage'] }}</span>
            @if($pagination['currentPage'] < $pagination['lastPage'])
                <a href="{{ $pagination['nextPageUrl'] }}" class="btn btn-secondary">Next</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">ดำเนินการต่อ</button>
    </form>
</div>
