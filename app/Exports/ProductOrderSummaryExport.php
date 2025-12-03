<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductOrderSummaryExport implements FromView, ShouldAutoSize
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function view(): View
    {
        $totalOrders = Order::whereBetween('order_date', [$this->startDate, $this->endDate])
            ->count();

        $totalRevenue = Order::whereBetween('order_date', [$this->startDate, $this->endDate])
            ->sum('total_amount');

        $averageOrderValue = Order::whereBetween('order_date', [$this->startDate, $this->endDate])
            ->avg('total_amount');

        $topProducts = OrderItem::selectRaw(
                'products.name as product_name, SUM(order_items.quantity) as total_qty'
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.order_date', [$this->startDate, $this->endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->get();

        $topProductNames = $topProducts->pluck('product_name')->implode(', ');

        $details = OrderItem::selectRaw('
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
            ->whereBetween('orders.order_date', [$this->startDate, $this->endDate])
            ->orderBy('orders.order_date')
            ->get();

        return view('exports.product_order_summary', [
            'startDate'         => $this->startDate,
            'endDate'           => $this->endDate,
            'totalOrders'       => $totalOrders,
            'totalRevenue'      => $totalRevenue,
            'averageOrderValue' => $averageOrderValue,
            'topProductNames'   => $topProductNames,
            'details'           => $details,
        ]);
    }
}
