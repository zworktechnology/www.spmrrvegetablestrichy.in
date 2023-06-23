@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Expense Report</h4>
            </div>
        </div>

        <form autocomplete="off" method="POST" action="{{ route('expence.report_view') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="expencereport_fromdate" id="expencereport_fromdate">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="expencereport_todate" id="expencereport_todate">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="select expencereport_branch" name="expencereport_branch"
                                    id="expencereport_branch">
                                    <option value=""  selected >Select Branch</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-6 col-12">
                            <div class="form-group">
                                <label style="color: white">Action</label>
                                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                    @foreach ($expense_data as $keydata => $expense_datas)
                        @if ($expense_datas['unique_key'] != '')

                        @if($keydata == 0)
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>From Date <span style="color: red">{{ $expense_datas['fromdateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>To Date <span style="color: red">{{ $expense_datas['todateheading'] }}</span></label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Branch <span style="color: red">{{ $expense_datas['branchheading'] }}</span></label>
                            </div>
                        </div>
                        
                        @endif
                        @endif
                    @endforeach
                    </div>
                </div>
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
                            @if ($expenceData['unique_key'] != '')
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $expenceData['branch_name'] }}</td>
                                    <td>{{ date('d M Y', strtotime($expenceData['date'])) }} - {{ date('h:i A', strtotime($expenceData['time'])) }}</td>
                                    <td>{{ $expenceData['amount'] }}</td>
                                    <td>{!! $expenceData['note'] !!}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $expenceData['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData['unique_key'] }}"
                                                    data-bs-target=".expenceedit-modal-xl{{ $expenceData['unique_key'] }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $expenceData['unique_key'] }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData['unique_key'] }}"
                                                    data-bs-target=".expencedelete-modal-xl{{ $expenceData['unique_key'] }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade expenceedit-modal-xl{{ $expenceData['unique_key'] }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static" aria-labelledby="expenceeditLargeModalLabel{{ $expenceData['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expence.edit')
                                </div>

                                <div class="modal fade expencedelete-modal-xl{{ $expenceData['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="expencedeleteLargeModalLabel{{ $expenceData['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expence.delete')
                                </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

            </div>
        </div>

        </form>
    </div>
@endsection
