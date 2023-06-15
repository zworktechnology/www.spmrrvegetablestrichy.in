<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Expence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExpenceController extends Controller
{
    public function index()
    {

        $today = Carbon::now()->format('Y-m-d');
        $branch = Branch::where('soft_delete', '!=', 1)->get();
        $timenow = Carbon::now()->format('H:i');


        $data = Expence::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        $expense_data = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);

            $expense_data[] = array(
                'branch_name' => $branch_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'amount' => $datas->amount,
                'note' => $datas->note,
                'unique_key' => $datas->unique_key,
                'id' => $datas->id,
                'branch_id' => $datas->branch_id,
            );
        }
        return view('page.backend.expence.index', compact('expense_data', 'branch', 'today', 'timenow'));
    }

    public function branchdata($branch_id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $branch = Branch::where('soft_delete', '!=', 1)->get();
        $timenow = Carbon::now()->format('H:i');


        $data = Expence::where('branch_id', '=', $branch_id)->where('soft_delete', '!=', 1)->get();
        $expense_data = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);

            $expense_data[] = array(
                'branch_name' => $branch_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'amount' => $datas->amount,
                'note' => $datas->note,
                'unique_key' => $datas->unique_key,
                'id' => $datas->id,
                'branch_id' => $datas->branch_id,
            );
        }

       

        return view('page.backend.expence.index', compact('expense_data', 'branch', 'today', 'timenow'));
    }




    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Expence();

        $data->unique_key = $randomkey;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->amount = $request->get('amount');
        $data->note = $request->get('note');
        $data->branch_id = $request->get('branch_id');

        $data->save();

        return redirect()->route('expence.index')->with('add', 'Expence Data added successfully!');
    }


    public function edit(Request $request, $unique_key)
    {
        $ExpenceData = Expence::where('unique_key', '=', $unique_key)->first();

        $ExpenceData->date = $request->get('date');
        $ExpenceData->time = $request->get('time');
        $ExpenceData->amount = $request->get('amount');
        $ExpenceData->note = $request->get('note');
        $ExpenceData->branch_id = $request->get('branch_id');

        $ExpenceData->update();

        return redirect()->route('expence.index')->with('update', 'Expence Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = Expence::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('expence.index')->with('soft_destroy', 'Successfully deleted the Expence !');
    }



    public function report() {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        $expense_data = [];
        $expense_data[] = array(
            'branch_name' => '',
            'date' => '',
            'time' => '',
            'amount' => '',
            'note' => '',
            'unique_key' => '',
            'id' => '',
            'branch_id' => '',
            'heading' => '',
        );
        return view('page.backend.expence.report', compact('branch', 'expense_data', 'today', 'timenow'));
    }



    public function report_view(Request $request) 
    {
        $expencereport_fromdate = $request->get('expencereport_fromdate');
        $expencereport_todate = $request->get('expencereport_todate');
        $expencereport_branch = $request->get('expencereport_branch');


        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');




        if($expencereport_branch != ""){

            $branchwise_report = Expence::where('branch_id', '=', $expencereport_branch)->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => 'Branch - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => '',
            );
        }



        if($expencereport_fromdate || $expencereport_todate){

            $branchwise_report = Expence::where('date', '=', $expencereport_fromdate)->orwhere('date', '=', $expencereport_todate)->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => 'Date - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => 'Date - Filter Data',
            );
        }



        if($expencereport_fromdate && $expencereport_branch){

            $branchwise_report = Expence::where('date', '=', $expencereport_fromdate)->where('branch_id', '=', $expencereport_branch)->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => '(Date & Branch) - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => '(Date & Branch) - Filter Data',
            );
        }



        if($expencereport_todate && $expencereport_branch){

            $branchwise_report = Expence::where('date', '=', $expencereport_todate)->where('branch_id', '=', $expencereport_branch)->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => '(Date & Branch) - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => '(Date & Branch) - Filter Data',
            );
        }



        if($expencereport_fromdate && $expencereport_todate && $expencereport_branch){

            $branchwise_report = Expence::whereBetween('date', [$expencereport_fromdate, $expencereport_todate])->where('branch_id', '=', $expencereport_branch)->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => '(From Date - To Date & Branch) - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => '(From Date - To Date & Branch) - Filter Data',
            );
        }



        if($expencereport_fromdate && $expencereport_todate){

            $branchwise_report = Expence::whereBetween('date', [$expencereport_fromdate, $expencereport_todate])->where('soft_delete', '!=', 1)->get();
            $expense_data = [];
            foreach ($branchwise_report as $key => $branchwise_datas) {
                $branch_name = Branch::findOrFail($branchwise_datas->branch_id);


                $expense_data[] = array(
                    'branch_name' => $branch_name->name,
                    'date' => $branchwise_datas->date,
                    'time' => $branchwise_datas->time,
                    'amount' => $branchwise_datas->amount,
                    'note' => $branchwise_datas->note,
                    'unique_key' => $branchwise_datas->unique_key,
                    'id' => $branchwise_datas->id,
                    'branch_id' => $branchwise_datas->branch_id,
                    'heading' => '(From Date - To Date) - Filter Data',
                );
            }
        }else{

            $expense_data[] = array(
                'branch_name' => '',
                'date' => '',
                'time' => '',
                'amount' => '',
                'note' => '',
                'unique_key' => '',
                'id' => '',
                'branch_id' => '',
                'heading' => '(From Date - To Date & Branch) - Filter Data',
            );
        }



        return view('page.backend.expence.report', compact('branch', 'expense_data', 'today', 'timenow'));
    }

    
}
