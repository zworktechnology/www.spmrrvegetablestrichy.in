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
        $data = Expence::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.expence.index', compact('data', 'branch', 'today', 'timenow'));
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
}
