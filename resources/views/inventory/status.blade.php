@extends('layouts.pos')

@section('pos')
    <div class="container mt-4">
        <h3 class="">INVENTORY STATUS</h3>
<hr>
        <div class="table-responsive rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Unit</th>
                        @if (auth()->user()->company->type === 'retail')
                            <th>Retail Price</th>
                        @else
                            <th>Retail Price</th>
                            <th>Wholesale Price</th>
                        @endif

                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventories as $item)
                        @php
                            $status = 'In Stock';
                            $badge = 'success';

                            if ($item->unit <= 0) {
                                $status = 'Out of Stock';
                                $badge = 'danger';
                            } elseif ($item->unit < 10) {
                                $status = 'Low Stock';
                                $badge = 'warning';
                            }

                            if ($item->status === 'inactive') {
                                $status = 'Inactive';
                                $badge = 'secondary';
                            }
                        @endphp
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->unit }}</td>
                            @if (auth()->user()->company->type === 'retail')
                                <td>{{ $item->retail_amount }}</td>
                            @else
                                <td>{{ $item->retail_amount }}</td>
                                <td>{{ $item->wholesale_amount }}</td>
                            @endif
                            <td>{{ $item->category->category_name ?? '-' }}</td>
                            <td>{{ $item->supplier->supplier_name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No inventory items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
