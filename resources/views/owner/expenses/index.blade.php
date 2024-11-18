@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manage Expenses</h5>
                    <a href="{{ route('owner.expenses.create') }}" class="btn btn-primary">Add New Expense</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                        <td>{{ $expense->description }}</td>
                                        <td>{{ $expense->category ?? 'N/A' }}</td>
                                        <td>Rp {{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('owner.expenses.edit', $expense) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('owner.expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
