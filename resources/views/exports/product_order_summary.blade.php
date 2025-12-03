@php
    use Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .summary-table td,
        .summary-table th,
        .detail-table td,
        .detail-table th {
            border: 1px solid #000000;
            padding: 4px 6px;
            font-size: 11px;
        }
        .summary-header,
        .detail-header {
            font-weight: bold;
            text-align: left;
            background-color: #111827;
            color: #ffffff;
        }
        .summary-label {
            font-weight: bold;
            background-color: #1f2933;
            color: #ffffff;
        }
        .summary-value {
            background-color: #111827;
            color: #ffffff;
        }
        .detail-head-row th {
            background-color: #111827;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            font-size: 13px;
            background-color: #111827;
            color: #ffffff;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td colspan="8" style="font-weight:bold;font-size:14px;">
            Product Order Summary Report
        </td>
    </tr>
    <tr>
        <td colspan="8">
            Period: {{ $startDate }} to {{ $endDate }}
        </td>
    </tr>
</table>

<br>

<table class="summary-table">
    <tr>
        <th colspan="8" class="section-title">
            A. Summary Section
        </th>
    </tr>
    <tr>
        <th class="summary-label">Metric</th>
        <th colspan="7" class="summary-label">Value</th>
    </tr>
    <tr>
        <td class="summary-label">Total Orders</td>
        <td colspan="7" class="summary-value">{{ $totalOrders }}</td>
    </tr>
    <tr>
        <td class="summary-label">Total Revenue</td>
        <td colspan="7" class="summary-value">
            RM {{ number_format($totalRevenue, 2) }}
        </td>
    </tr>
    <tr>
        <td class="summary-label">Top 3 Products</td>
        <td colspan="7" class="summary-value">
            {{ $topProductNames ?: '-' }}
        </td>
    </tr>
    <tr>
        <td class="summary-label">Average Order Value</td>
        <td colspan="7" class="summary-value">
            RM {{ number_format($averageOrderValue ?? 0, 2) }}
        </td>
    </tr>
</table>

<br>

<table class="detail-table">
    <tr>
        <th colspan="8" class="section-title">
            B. Detailed Table
        </th>
    </tr>
    <tr class="detail-head-row">
        <th>Order Date</th>
        <th>Customer</th>
        <th>State</th>
        <th>Category</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Unit Price (RM)</th>
        <th>Subtotal (RM)</th>
    </tr>

    @foreach ($details as $row)
        <tr>
            <td>{{ Carbon::parse($row->order_date)->format('Y-m-d') }}</td>
            <td>{{ $row->customer_name }}</td>
            <td>{{ $row->state }}</td>
            <td>{{ $row->category_name }}</td>
            <td>{{ $row->product_name }}</td>
            <td style="text-align:right;">{{ (int) $row->quantity }}</td>
            <td style="text-align:right;">{{ number_format($row->unit_price, 2) }}</td>
            <td style="text-align:right;">{{ number_format($row->subtotal, 2) }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
