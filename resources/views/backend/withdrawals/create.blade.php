@extends('backend.layouts.app')

@section('title', 'New Withdrawal Request')

@section('content')
    <h1 class="mt-4">
        New Withdrawal Request</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a></li>
        <li class="breadcrumb-item active">New Request</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><i class="fas fa-wallet me-1"></i> Create Withdrawal Request</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.withdrawals.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Member <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="">— Select Member —</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>
                                        {{ $u->name }} ({{ $u->email }}) — Wallet:
                                        ₹{{ number_format($u->wallet_balance ?? 0, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" min="1" step="0.01"
                                value="{{ old('amount') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" id="paymentMethod" class="form-select" required>
                                <option value="bank" @selected(old('payment_method', 'bank') == 'bank')>Bank Transfer</option>
                                <option value="upi" @selected(old('payment_method') == 'upi')>UPI</option>
                            </select>
                        </div>
                        <div id="bankFields">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Account Holder</label>
                                    <input type="text" name="account_holder" class="form-control"
                                        value="{{ old('account_holder') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control"
                                        value="{{ old('account_number') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" name="ifsc" class="form-control" value="{{ old('ifsc') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control"
                                        value="{{ old('bank_name') }}">
                                </div>
                            </div>
                        </div>
                        <div id="upiField" class="d-none">
                            <label class="form-label">UPI ID</label>
                            <input type="text" name="upi_id" class="form-control" value="{{ old('upi_id') }}">
                        </div>
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Request</button>
                            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('paymentMethod').addEventListener('change', function() {
                const isUpi = this.value === 'upi';
                document.getElementById('bankFields').classList.toggle('d-none', isUpi);
                document.getElementById('upiField').classList.toggle('d-none', !isUpi);
            });
        </script>
    @endpush
@endsection
