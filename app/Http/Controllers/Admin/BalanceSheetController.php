<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\SaleStock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function balance_sheet_report()
    {
        $from = Carbon::parse(date('Y-m-d'))->format('Y-m-d 00:00:00');
        $to = Carbon::parse(date('Y-m-d'))->format('Y-m-d 23:59:59');
        $title = "Balance Sheet";
        $sales = Order::where('status', '!=', 'Pending')->where('status', '!=', 'Canceled')->whereBetween('created_at',[$from,$to])->latest()->get();
        $sale_amount = $sales->sum('total');
        $purchase_price = 0;
        foreach($sales as $sale){
            $purchase_price += purchase_price($sale->order_code);
        }

        $expense = Expense::whereBetween('created_at',[$from,$to])->sum('amount');
        return view('admin.report.balance-sheet', compact('title', 'from', 'to', 'sales', 'sale_amount', 'purchase_price', 'expense'));
    }

    public function balance_sheet_report_search(Request $request)
    {
        $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
        $to = Carbon::parse($request->to)->format('Y-m-d 23:59:59');
        $title = "Balance Sheet";
        $sales = Order::where('status', '!=', 'Pending')->where('status', '!=', 'Canceled')->whereBetween('created_at',[$from,$to])->latest()->get();
        $sale_amount = $sales->sum('total');
        $purchase_price = 0;
        foreach($sales as $sale){
            $purchase_price += purchase_price($sale->order_code);
        }

        $expense = Expense::whereBetween('created_at',[$from,$to])->sum('amount');
        return view('admin.report.balance-sheet', compact('title', 'from', 'to', 'sales', 'sale_amount', 'purchase_price', 'expense'));
    }
}
