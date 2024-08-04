@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Bank</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  supplierdatanew">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Bank</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $keydata => $bankdata)
                                        <tr>
                                            <td>{{ ++$keydata }}</td>
                                            <td>{{ $bankdata->name }}</td>
                                            <td>{!! $bankdata->details !!}</td>
                                            <td>
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <li>
                                                        <a href="#edit{{ $bankdata->unique_key }}" data-bs-toggle="modal"
                                                            data-id="{{ $bankdata->unique_key }}"
                                                            data-bs-target=".bankedit-modal-xl{{ $bankdata->unique_key }}"
                                                            class="badges bg-lightyellow" style="color: white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#delete{{ $bankdata->unique_key }}" data-bs-toggle="modal"
                                                            data-id="{{ $bankdata->unique_key }}"
                                                            data-bs-target=".bankdelete-modal-xl{{ $bankdata->unique_key }}"
                                                            class="badges bg-lightgrey" style="color: white; background-color:brown">Del</a>
                                                    </li>
                                                </ul>

                                            </td>

                                        </tr>
                                        <div class="modal fade bankedit-modal-xl{{ $bankdata->unique_key }}" tabindex="-1"
                                            role="dialog" data-bs-backdrop="static"
                                            aria-labelledby="bankeditLargeModalLabel{{ $bankdata->unique_key }}"
                                            aria-hidden="true">
                                            @include('page.backend.bank.edit')
                                        </div>
                                        <div class="modal fade bankdelete-modal-xl{{ $bankdata->unique_key }}"
                                            tabindex="-1" role="dialog"data-bs-backdrop="static"
                                            aria-labelledby="bankdeleteLargeModalLabel{{ $bankdata->unique_key }}"
                                            aria-hidden="true">
                                            @include('page.backend.bank.delete')
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                @include('page.backend.bank.create')
            </div>
        </div>
    </div>
@endsection
