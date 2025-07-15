<!DOCTYPE html>
<html>
<head>
    <title>Distributor Product Assignment Receipt</title>
</head>
<body>
    <h1>Distributor Product Assignment Receipt</h1>
    @if(isset($product))
        <p>Assignment Number: {{ $product->assignment_number }}</p>
        <p>Distributor: {{ $product->distributor->name ?? 'N/A' }}</p>
        <p>Product: {{ $product->product_name ?? 'N/A' }}</p>
        <p>Quantity: {{ $product->quantity_assigned ?? 'N/A' }}</p>
        <p>Amount: {{ $product->total_value ?? 'N/A' }}</p>
    @endif
</body>
</html> 