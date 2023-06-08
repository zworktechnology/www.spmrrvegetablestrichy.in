@extends('layout.backend.auth')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>{{ $suppliername }} - ₹ {{$total_amount}}</h4>
            </div>
            <div class="page-btn">           
               
                <a href="{{ route('supplier.index') }}"><button type="button" class="btn btn-success waves-effect waves-light btn-added">Back</button></a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  supplierdatanew">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Branch</th>
                                <th>Balance Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplier_output as $keydata => $suppliertdata)
                                <tr>
                                    <td>{{ ++$keydata }}</td>
                                    <td>{{ $suppliertdata['branch'] }}</td>
                                    <td>₹{{ $suppliertdata['total'] }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

       

    </div>
@endsection



