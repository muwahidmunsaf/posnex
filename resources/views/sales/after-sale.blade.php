<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sale Completed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center p-5">

    <div class="container">
        <h3 class="mb-4">Sale Created Successfully!</h3>

        <a href="{{ route('sales.print', ['id' => $saleId]) }}" target="blank_" class="btn btn-primary btn-lg mb-3">
            <i class="bi bi-printer"></i> Open & Print Invoice
        </a>

        <br>

        <a href="{{ route('sales.create') }}" class="btn btn-outline-secondary">
            Create Another Sale
        </a>
    </div>

</body>
</html>
