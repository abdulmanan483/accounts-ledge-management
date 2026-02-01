@extends('admin.layout.app')

@section('title', 'Income vs Expense Report')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Reports - <span class="fw-normal">Income vs Expense</span>
            </h4>
        </div>
    </div>
@endsection

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Income vs Expense Ledger</h5>
        </div>

        {{-- Filter Form --}}
        <div class="p-3 pb-0">
            <form action="{{ route('reports.income-vs-expense') }}" method="GET" class="row g-2">
                <div class="col-md-3">
                    <label for="account_id" class="form-label">Select Account</label>
                    <select name="account_id" id="account_id" class="form-select">
                        <option value="">All Accounts</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}" {{ $selected_account == $acc->id ? 'selected' : '' }}>
                                {{ $acc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="category_id" class="form-label">Transaction Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $selected_category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="from_date" class="form-label">From</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $start_date }}">
                </div>

                <div class="col-md-2">
                    <label for="to_date" class="form-label">To</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $end_date }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <a href="{{ url()->current() }}" class="btn btn-light w-100">Reset</a>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>

        {{-- Ledger Table --}}
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>TXN ID</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Person</th>
                        <th>Debit (Expense)</th>
                        <th>Credit (Income)</th>
                        <th>Running Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $key => $txn)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $txn->txn_date->format('d-m-Y') }}</td>
                            <td>{{ $txn->txn_id }}</td>
                            <td>{{ $txn->description }}</td>
                            <td>{{ $txn->transaction_category?->name ?? '-' }}</td>
                            <td>{{ $txn->person?->name ? $txn->person->name.' ('.$txn->person->type.')' : '-' }}</td>
                            <td>{{ $txn->debit > 0 ? ($txn->currency->symbol_native ?? '').' '. number_format($txn->debit,2) : '' }}</td>
                            <td>{{ $txn->credit > 0 ? ($txn->currency->symbol_native ?? '').' '. number_format($txn->credit,2) : '' }}</td>
                            <td>{{ $txn->currency->symbol_native ?? '' }} {{ number_format($txn->running_balance,2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="6">Totals</td>
                        <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($totalExpense,2) }}</td>
                        <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($totalIncome,2) }}</td>
                        <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($finalBalance,2) }}</td>
                    </tr>
                    <tr class="fw-bold bg-light">
                        <td colspan="8" class="text-end">Net Profit / Loss</td>
                        <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($netProfitLoss,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Category Summary --}}
        @if(!empty($summary))
            <div class="mt-4 px-3 pb-2">
                <h6 class="mb-2">Summary by Category</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Debit (Expense)</th>
                            <th>Total Credit (Income)</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summary as $catName => $s)
                            @php
                                $balance = $s['total_credit'] - $s['total_debit'];
                            @endphp
                            <tr>
                                <td>{{ $catName }}</td>
                                <td>
                                    {{ $transactions[0]->currency->symbol_native ?? '' }}
                                    {{ number_format($s['total_debit'],2) }}</td>
                                <td>
                                    {{ $transactions[0]->currency->symbol_native ?? '' }}
                                    {{ number_format($s['total_credit'],2) }}</td>
                                <td>{{ $transactions[0]->currency->symbol_native ?? '' }}
                                    {{ number_format($balance,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
