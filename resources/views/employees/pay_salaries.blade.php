@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Bulk Salary Payment</h3>
    <form action="{{ route('employees.paySalaries.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label">Payment Date</label>
            <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', date('Y-m-d')) }}">
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Last Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td><input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}"></td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ number_format($employee->salary, 2) }}</td>
                        <td>{{ optional($employee->salaryPayments->sortByDesc('date')->first())->date ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success mt-2">Pay Selected</button>
    </form>
</div>
<script>
    document.getElementById('select_all').onclick = function() {
        var checkboxes = document.getElementsByName('employee_ids[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
@endsection 