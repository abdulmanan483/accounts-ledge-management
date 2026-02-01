@extends('admin.layout.app')

@section('title', 'Accounts Ledger')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">Accounts Ledger</span>
            </h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Ledger</h5>
            </div>

            {{-- Filter Form --}}
            <div class="p-3 pb-0">
                {{--                <form method="GET" class="row g-2">--}}
                <form action="{{ route('reports.accounts-ledger') }}" class="row">
                    @csrf
                    <div class="col-md-4">
                        <label for="account_id" class="form-label">Select Account</label>
                        <select name="account_id" id="account_id" class="form-select" required>
                            <option value="">All Accounts</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                               value="{{ request('to_date') }}">
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
                        <th>TXN Category</th>
                        <th>Person</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Running Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $key => $txn)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $txn->txn_id }}</td>
                            <td>{{ $txn->txn_date->format('d-m-Y') }}</td>
                            <td>{{ $txn->description }}</td>
                            <td>{{ $txn->transaction_category?->name ?? '-' }}</td>
                            <td>{{ $txn->person?->name?$txn->person?->name.' ('. $txn->person?->type.')' : '-' }}</td>
                            <td>{{ $txn->debit > 0 ? ($txn->currency->symbol_native ?? '').' '. number_format($txn->debit,2) : '' }}</td>
                            <td>{{ $txn->credit > 0 ? ($txn->currency->symbol_native ?? '').' '. number_format($txn->credit,2) : '' }}</td>
                            <td>{{ $txn->currency->symbol_native ?? '' }} {{ number_format($txn->running_balance,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="6">Totals</td>
                            <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($totalDebit,2) }}</td>
                            <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($totalCredit,2) }}</td>
                            <td>{{ $transactions[0]->currency->symbol_native ?? '' }} {{ number_format($finalBalance,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="p-3">
                    {{ $transactions->appends(request()->query())->links('vendor.pagination.flat-rounded') }}
                </div>
            @endif
        </div>
    </div>
@endsection
