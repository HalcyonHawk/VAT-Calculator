@extends('layouts.default')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h2>Add Calculation</h2>

            <!--Form to add new vat calculation-->
            <form method="POST" action="{{ route('price.store') }}">
                {{-- Token to protect from XSS and SQL injection --}}
                @csrf

                <!--Total price before VAT added/removed-->
                <div class="form-group row">
                    <div class="col-md-12">
                        <input name="gross_sum" type="text" placeholder="Amount"
                        class="form-control" value="{{ old('gross_sum') }}" required>
                    </div>
                </div>

                <!--Percentage VAT to be added/removed-->
                <div class="form-group row">
                    <div class="col-md-12">
                        <input name="vat_rate" type="text" placeholder="VAT Rate %"
                        class="form-control" value="{{ old('vat_rate') }}" required>
                    </div>
                </div>

                <!--Submit buttons both containing a value-->
                <div class="form-group row mb-0">
                    <div class="col-md-12 offset-md-4">
                        <button type="submit" class="btn btn-primary form-control" name="multiplier" value="1">
                            Add VAT to price
                        </button>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 offset-md-4">
                        <button type="submit" class="btn btn-primary form-control" name="multiplier" value="-1">
                            Remove VAT from price
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Past Calculations</h2></div>

                <div class="card-body" style="background-color: white; padding: 20px">

                    <div class="row">
                        <div class="col-xs-2">
                            {{-- Export table as .csv file --}}
                            <a href="{{ route('price.csv') }}" class="btn btn-primary">Export as CSV</a>
                        </div>

                        <div class="col-xs-2">
                            {{-- Delete all price calculations --}}
                            <form action="{{ route('price.clear') }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('Delete') }}

                                <button type="submit" class="btn btn-danger">Clear Table</button>
                            </form>
                        </div>
                    </div>

                    <div style="padding: 10px"></div>

                    <!--Display prices inside a form to edit each price-->
                    @if ($prices->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>VAT rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($prices as $price)
                            <tr>
                                <td>{{ $price->gross_sum }}</td>
                                <td>{{ $price->vat_rate_formatted }}</td>
                                <td>{{ $price->final_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    <div class="alert alert-info">
                    No past calculations
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
