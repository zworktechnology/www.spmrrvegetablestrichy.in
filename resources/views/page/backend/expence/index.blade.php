@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Expense</h4>
            </div>
            <div class="page-btn">
                <div class="row">
                    <div style="display: flex;">
                        <form autocomplete="off" method="POST" action="{{ route('expence.datefilter') }}">
                            @method('PUT')
                            @csrf
                            <div style="display: flex">
                                <div style="margin-right: 10px;"><input type="date" name="from_date" required
                                        class="form-control from_date" value="{{ $today }}"></div>
                                <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                        value="Search" /></div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-added"
                            data-bs-toggle="modal" data-bs-target=".cusomer-modal-xl">Add Expense</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-2 col-sm-4 col-6">
                <a href="{{ route('expence.index') }}" style="color: black">
                    <div class="dash-widget">
                        <div class="dash-widgetcontent">
                            <h6 style="font-weight: bold;">All</h6>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($branch as $keydata => $allbranches)
                <div class="col-lg-2 col-sm-4 col-6">
                    <a href="{{ route('expence.branchdata', ['branch_id' => $allbranches->id]) }}" style="color: black">
                        <div class="dash-widget">
                            <div class="dash-widgetcontent">
                                <h6 style="font-weight: bold;">{{ $allbranches->shop_name }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table customerdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expense_data as $keydata => $expenceData)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $expenceData['branch_name'] }}</td>
                                    <td>{{ date('d M Y', strtotime($expenceData['date'])) }} -
                                        {{ date('h:i A', strtotime($expenceData['time'])) }}</td>
                                    <td>{{ $expenceData['amount'] }}</td>
                                    <td>{!! $expenceData['note'] !!}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $expenceData['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData['unique_key'] }}"
                                                    data-bs-target=".expenceedit-modal-xl{{ $expenceData['unique_key'] }}"
                                                    class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $expenceData['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData['unique_key'] }}"
                                                    data-bs-target=".expencedelete-modal-xl{{ $expenceData['unique_key'] }}"
                                                    class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade expenceedit-modal-xl{{ $expenceData['unique_key'] }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="expenceeditLargeModalLabel{{ $expenceData['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expence.edit')
                                </div>

                                <div class="modal fade expencedelete-modal-xl{{ $expenceData['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="expencedeleteLargeModalLabel{{ $expenceData['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expence.delete')
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade cusomer-modal-xl" tabindex="-1" role="dialog" aria-labelledby="customerLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.expence.create')
        </div>


    </div>
@endsection
