<?php

namespace App\Http\Controllers;

use App\Exports\ProductOrderSummaryExport;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $totalOrders = Order::whereBetween('order_date', [$startDate, $endDate])
            ->count();

        $totalRevenue = Order::whereBetween('order_date', [$startDate, $endDate])
            ->sum('total_amount');

        $topProducts = OrderItem::selectRaw(
                'products.name as product_name, SUM(order_items.quantity) as total_qty'
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->get();

        $averageOrderValue = Order::whereBetween('order_date', [$startDate, $endDate])
            ->avg('total_amount');

        return view('report.index', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'totalRevenue',
            'topProducts',
            'averageOrderValue'
        ));
    }

    public function data(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $query = OrderItem::selectRaw('
                orders.order_date,
                customers.name as customer_name,
                customers.state,
                categories.name as category_name,
                products.name as product_name,
                order_items.quantity,
                order_items.unit_price,
                order_items.subtotal
            ')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.order_date', [$startDate, $endDate]);

        return DataTables::of($query)
            ->editColumn('order_date', function ($row) {
                return Carbon::parse($row->order_date)->format('Y-m-d');
            })
            ->editColumn('unit_price', function ($row) {
                return number_format($row->unit_price, 2);
            })
            ->editColumn('subtotal', function ($row) {
                return number_format($row->subtotal, 2);
            })
            ->make(true);
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        return Excel::download(
            new ProductOrderSummaryExport($startDate, $endDate),
            "product-order-summary-{$startDate}-to-{$endDate}.xlsx"
        );
    }

}
