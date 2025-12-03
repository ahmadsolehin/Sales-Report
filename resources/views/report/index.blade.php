@extends('layouts.app')

@section('content')
<style>
    :root{
        --rp-bg:#f3f4f6;
        --rp-card:#ffffff;
        --rp-soft:#f9fafb;
        --rp-primary:#2563eb;
        --rp-primary-soft:rgba(37,99,235,.06);
        --rp-border:#e5e7eb;
        --rp-text:#111827;
    }

    body{
        background:
          radial-gradient(circle at top left,#e0f2fe 0,#f9fafb 45%,#eef2ff 100%);
        color: var(--rp-text);
    }

    .report-page{
        min-height: calc(100vh - 80px);
        display:flex;
        align-items:flex-start;
        justify-content:center;
        padding:2.5rem 0 3.5rem;
    }

    .report-shell{
        width:100%;
        max-width:1200px;
        background:var(--rp-card);
        border-radius:24px;
        padding:2.5rem 2.25rem 2.75rem;
        box-shadow:
            0 18px 40px rgba(148,163,184,.35),
            0 0 0 1px rgba(209,213,219,.8);
        position:relative;
        overflow:hidden;
    }

    .report-shell::before{
        content:"";
        position:absolute;
        inset:-40%;
        background:
          radial-gradient(circle at 0% 0%, rgba(59,130,246,.12), transparent 55%),
          radial-gradient(circle at 100% 100%, rgba(45,212,191,.12), transparent 55%);
        opacity:.6;
        z-index:0;
        pointer-events:none;
    }

    .report-shell-inner{
        position:relative;
        z-index:1;
    }

    .report-heading{
        display:flex;
        flex-wrap:wrap;
        gap:.75rem .5rem;
        align-items:flex-end;
        justify-content:space-between;
        margin-bottom:1.75rem;
    }

    .report-title{
        font-size:1.9rem;
        font-weight:700;
        letter-spacing:.01em;
        color:#0f172a;
    }

    .report-subtitle{
        font-size:.9rem;
        color:#6b7280;
    }

    .chip{
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        padding:.35rem .9rem;
        border-radius:999px;
        font-size:.75rem;
        background:rgba(248,250,252,.9);
        border:1px solid #e5e7eb;
        color:#374151;
        backdrop-filter:blur(10px);
    }
    .chip-dot{
        width:8px;height:8px;border-radius:999px;
        background:radial-gradient(circle at 30% 30%, #16a34a, #22c55e);
        box-shadow:0 0 0 6px rgba(34,197,94,.2);
    }

    .filter-card{
        border-radius:18px;
        background:var(--rp-soft);
        border:1px solid #e5e7eb;
        padding:1rem 1.25rem 1.1rem;
        margin-bottom:1.5rem;
    }

    .filter-card label{
        font-size:.8rem;
        text-transform:uppercase;
        letter-spacing:.04em;
        color:#6b7280;
        margin-bottom:.2rem;
    }

    .filter-card input[type="date"]{
        background-color:#ffffff;
        border-radius:999px;
        border:1px solid #d1d5db;
        color:#111827;
        font-size:.85rem;
        padding:.45rem .9rem;
    }
    .filter-card input[type="date"]:focus{
        box-shadow:0 0 0 2px rgba(37,99,235,.2);
        border-color:var(--rp-primary);
        outline:0;
    }

    .btn-pill{
        border-radius:999px;
        font-size:.86rem;
        padding:.45rem 1.25rem;
        display:inline-flex;
        align-items:center;
        gap:.35rem;
        border:none;
        font-weight:500;
    }
    .btn-filter{
        background:linear-gradient(135deg,#2563eb,#4f46e5);
        color:#f9fafb;
        box-shadow:0 10px 20px rgba(37,99,235,.45);
    }
    .btn-filter:hover{
        opacity:.98;
        transform:translateY(-1px);
    }
    .btn-export{
        background:linear-gradient(135deg,#16a34a,#22c55e);
        color:#f0fdf4;
        box-shadow:0 10px 20px rgba(22,163,74,.35);
    }
    .btn-export:hover{
        opacity:.98;
        transform:translateY(-1px);
    }

    .dash-cards{
        margin-bottom:2rem;
    }
    .dash-card{
        position:relative;
        background:#ffffff;
        border-radius:20px;
        border:1px solid #e5e7eb;
        padding:1.15rem 1.3rem 1.1rem;
        height:100%;
        box-shadow:0 14px 28px rgba(148,163,184,.25);
        overflow:hidden;
    }
    .dash-card::before{
        content:"";
        position:absolute;
        inset:0;
        border-radius:inherit;
        border-top:3px solid transparent;
        pointer-events:none;
    }
    .dash-card.orders::before  { border-top-color:#4f46e5; }
    .dash-card.revenue::before { border-top-color:#16a34a; }
    .dash-card.avg::before     { border-top-color:#f97316; }
    .dash-card.top::before     { border-top-color:#0ea5e9; }

    .dash-pill{
        display:inline-flex;
        align-items:center;
        gap:.35rem;
        padding:.18rem .7rem;
        border-radius:999px;
        font-size:.72rem;
        font-weight:600;
        background:rgba(37,99,235,.06);
        color:#1d4ed8;
        margin-bottom:.45rem;
    }
    .dash-pill-dot{
        width:7px;height:7px;border-radius:999px;
        background:#2563eb;
    }

    .dash-label{
        font-size:.78rem;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#9ca3af;
        margin-bottom:.15rem;
    }
    .dash-value{
        font-size:1.7rem;
        font-weight:700;
        color:#111827;
        line-height:1.2;
    }
    .dash-chip{
        font-size:.8rem;
        color:#6b7280;
        margin-top:.4rem;
    }

    .table-card{
        background:#ffffff;
        border-radius:18px;
        border:1px solid #e5e7eb;
        box-shadow:0 16px 30px rgba(148,163,184,.30);
    }
    .table-card h5{
        font-size:.95rem;
        letter-spacing:.08em;
        text-transform:uppercase;
        color:#6b7280;
        margin-bottom:.9rem;
    }

    .table thead{
        background:linear-gradient(135deg,#eff6ff,#e5edff);
        border-bottom:1px solid #d1d5db;
    }
    .table thead th{
        border:none;
        font-size:.78rem;
        letter-spacing:.06em;
        text-transform:uppercase;
        color:#6b7280;
        padding-top:.7rem;
        padding-bottom:.6rem;
    }
    .table tbody tr{
        border-color:#e5e7eb;
    }
    .table tbody td{
        color:#111827;
        font-size:.85rem;
    }
    .table-striped tbody tr:nth-of-type(odd){
        background-color:#f9fafb;
    }
    .table-striped tbody tr:nth-of-type(even){
        background-color:#ffffff;
    }

    .badge-pill-soft{
        display:inline-flex;
        align-items:center;
        padding:.18rem .7rem;
        border-radius:999px;
        font-size:.72rem;
        background:#eff6ff;
        border:1px solid #dbeafe;
        color:#1d4ed8;
    }

    @media (max-width: 768px){
        .report-shell{
            padding:1.6rem 1.1rem 2.2rem;
            border-radius:18px;
        }
        .report-heading{
            align-items:flex-start;
        }
        .report-title{
            font-size:1.4rem;
        }
    }
</style>

<div class="report-page">
    <div class="report-shell">
        <div class="report-shell-inner">

            <div class="report-heading">
                <div>
                    <div class="report-title">Product Order Summary Report</div>
                    <div class="report-subtitle">
                        Insight for your selected period — orders, revenue and top performing products.
                    </div>
                </div>
                <div class="chip">
                    <span class="chip-dot"></span>
                    <span>Live demo data • Laravel</span>
                </div>
            </div>

            <div class="filter-card">
                <form method="GET" action="{{ route('report.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3 col-6">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                               class="form-control"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3 col-6">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                               class="form-control"
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2 mt-2 mt-md-0">
                        <button type="submit" class="btn btn-pill btn-filter">
                            Filter
                        </button>
                        <a href="{{ route('report.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                           class="btn btn-pill btn-export">
                            Download Excel
                        </a>
                    </div>
                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                        <span class="badge-pill-soft">
                            Showing data from {{ $startDate }} to {{ $endDate }}
                        </span>
                    </div>
                </form>
            </div>

            {{-- Summary cards --}}
            <div class="row g-3 dash-cards">
                <div class="col-md-3">
                    <div class="dash-card orders h-100">
                        <div class="dash-pill">
                            <span class="dash-pill-dot"></span>
                            Orders
                        </div>
                        <div class="dash-label">Total Orders</div>
                        <div class="dash-value">{{ $totalOrders }}</div>
                        <div class="dash-chip">All successful orders in range.</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-card revenue h-100">
                        <div class="dash-pill" style="background:rgba(22,163,74,.06);color:#15803d;">
                            <span class="dash-pill-dot" style="background:#16a34a;"></span>
                            Revenue
                        </div>
                        <div class="dash-label">Total Revenue</div>
                        <div class="dash-value">RM {{ number_format($totalRevenue, 2) }}</div>
                        <div class="dash-chip">Gross sales (MYR) for this period.</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-card avg h-100">
                        <div class="dash-pill" style="background:rgba(249,115,22,.06);color:#c2410c;">
                            <span class="dash-pill-dot" style="background:#f97316;"></span>
                            Order value
                        </div>
                        <div class="dash-label">Average Order Value</div>
                        <div class="dash-value">RM {{ number_format($averageOrderValue ?? 0, 2) }}</div>
                        <div class="dash-chip">Revenue ÷ total orders.</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-card top h-100">
                        <div class="dash-pill" style="background:rgba(14,165,233,.06);color:#0369a1;">
                            <span class="dash-pill-dot" style="background:#0ea5e9;"></span>
                            Top products
                        </div>
                        <div class="dash-label">Top 3 Products</div>
                        @forelse ($topProducts as $p)
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:.86rem;">{{ $p->product_name }}</span>
                                <span class="text-end" style="font-size:.82rem;">x{{ $p->total_qty }}</span>
                            </div>
                        @empty
                            <small>No data.</small>
                        @endforelse
                        <small class="d-block mt-2 text-muted">Ranked by total quantity sold.</small>
                    </div>
                </div>
            </div>

            <div class="table-card mt-2">
                <div class="card-body p-3 p-md-4">
                    <h5>Detailed Orders</h5>
                    <div class="table-responsive">
                        <table id="orders-table" class="table table-sm table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>State</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th class="text-end">Quantity</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthChange: false,
            ajax: {
                url: '{{ route('report.data') }}',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date   = $('#end_date').val();
                }
            },
            columns: [
                { data: 'order_date',   name: 'orders.order_date' },
                { data: 'customer_name',name: 'customer_name' },
                { data: 'state',        name: 'customers.state' },
                { data: 'category_name',name: 'category_name' },
                { data: 'product_name', name: 'product_name' },
                { data: 'quantity',     name: 'order_items.quantity', className: 'text-end' },
                { data: 'unit_price',   name: 'order_items.unit_price', className: 'text-end' },
                { data: 'subtotal',     name: 'order_items.subtotal', className: 'text-end' },
            ],
            order: [[0, 'asc']],
            language: {
                search: "Search orders:",
                info: "Showing _START_ to _END_ of _TOTAL_ orders",
                infoEmpty: "No orders",
                emptyTable: "No orders found for this date range."
            }
        });
    });
</script>
@endpush
