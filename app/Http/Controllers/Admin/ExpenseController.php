<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Expense";
        $expenses = Expense::latest()->get();
        $exp_cats = ExpenseCategory::latest()->get();
        return view('admin.expense.index', compact('title', 'exp_cats', 'expenses'));
    }

    public function expense_report()
    {
        $from = Carbon::parse(date('Y-m-d'))->format('Y-m-d 00:00:00');
        $to = Carbon::parse(date('Y-m-d'))->format('Y-m-d 23:59:59');
        $title = "Expense Report";
        $expenses = Expense::whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.expense', compact('title', 'from', 'to', 'expenses'));
    }

    public function expense_report_search(Request $request)
    {
        $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
        $to = Carbon::parse($request->to)->format('Y-m-d 23:59:59');
        $title = "Expense Report";
        $expenses = Expense::whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.expense', compact('title', 'from', 'to', 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cat_id' => 'required',
        ]);

        $expense = new Expense();
        $expense->cat_id = $request->cat_id;
        $expense->amount = $request->amount;
        $expense->note = $request->note;
        $expense->user_id = Auth::user()->id;
        $expense->save();

        Toastr::success('Expense successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cat_id' => 'required',
        ]);

        $expense = Expense::find($id);
        $expense->cat_id = $request->cat_id;
        $expense->amount = $request->amount;
        $expense->note = $request->note;
        $expense->save();

        Toastr::success('Expense successfully deleted :-)','Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        Toastr::success('Expense successfully deleted :-)','Success');
        return redirect()->back();
    }
}
