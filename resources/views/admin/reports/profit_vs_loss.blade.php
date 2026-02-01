@extends('admin.layout.app')

@section('title', 'Profit & Loss Report')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Profit & Loss Report</h5>
            </div>

            {{-- Filter Form --}}
            <div class="p-3 pb-0">
                <form method="GET" class="row">
                    <div class="col-md-4">
                        <label for="account_id" class="form-label">Select Account</label>
                        <select name="account_id" id="account_id" class="form-select">
                            <option value="">All Accounts</option>
                            @foreach ($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ $selected_account == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From</label>
                        <input type="date" name="from_date" class="form-control" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To</label>
                        <input type="date" name="to_date" class="form-control" value="{{ $end_date }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <a href="{{ url()->current() }}" class="btn btn-light w-100">Reset</a>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>

            {{-- Summary by Category --}}
            <div class="mt-4 p-3">
                <h6 class="mb-2">Summary by Category</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Expense (Debit)</th>
                            <th>Total Income (Credit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summary as $catName => $s)
                            <tr>
                                <td>{{ $catName }}</td>
                                <td>
                                    {{ $transactions[0]->currency->symbol_native ?? '' }}
                                    {{ number_format($s['total_debit'], 2) }}
                                </td>
                                <td>
                                    {{ $transactions[0]->currency->symbol_native ?? '' }}
                                    {{ number_format($s['total_credit'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td>Total</td>
                            <td>
                                {{ $transactions[0]->currency->symbol_native ?? '' }}
                                {{ number_format($totalExpense, 2) }}
                            </td>
                            <td>
                                {{ $transactions[0]->currency->symbol_native ?? '' }}
                                {{ number_format($totalIncome, 2) }}
                            </td>
                        </tr>
                        <tr class="fw-bold text-success">
                            <td colspan="2">Net Profit / Loss</td>
                            <td>
                                {{ $transactions[0]->currency->symbol_native ?? '' }}
                                {{ number_format($netProfit, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@endsection
