@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Expence</h4>
            </div>
            <div class="page-btn">
                <button type="button" class="btn btn-primary waves-effect waves-light btn-added" data-bs-toggle="modal"
                    data-bs-target=".cusomer-modal-xl">Add Expence</button>
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
                            @foreach ($data as $keydata => $expenceData)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $expenceData->branch->name }}</td>
                                    <td>{{ date('d M Y', strtotime($expenceData->date)) }} - {{ date('h:i A', strtotime($expenceData->date)) }}</td>
                                    <td>{{ $expenceData->amount }}</td>
                                    <td>{!! $expenceData->note !!}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="#edit{{ $expenceData->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData->unique_key }}"
                                                    data-bs-target=".expenceedit-modal-xl{{ $expenceData->unique_key }}" class="badges bg-lightyellow" style="color: white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#delete{{ $expenceData->unique_key }}" data-bs-toggle="modal"
                                                    data-id="{{ $expenceData->unique_key }}"
                                                    data-bs-target=".expencedelete-modal-xl{{ $expenceData->unique_key }}" class="badges bg-lightgrey" style="color: white">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade expenceedit-modal-xl{{ $expenceData->unique_key }}" tabindex="-1"
                                    role="dialog" data-bs-backdrop="static" aria-labelledby="expenceeditLargeModalLabel{{ $expenceData->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.expence.edit')
                                </div>

                                <div class="modal fade expencedelete-modal-xl{{ $expenceData->unique_key }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="expencedeleteLargeModalLabel{{ $expenceData->unique_key }}"
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
