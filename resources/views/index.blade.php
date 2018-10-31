@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-sm-12 margin-top-large">
                <h1><strong>RANKING</strong></h1>
                <div class="input-group input-group-lg margin-top-medium">
                    <input type="text" class="form-control" placeholder="Busca por nome" aria-describedby="button-addon">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon">Button</button>
                    </div>
                </div>
                <table class="table table-dark table-striped margin-top-medium">
                    <thead>
                        <tr>
                            <td><h4>NAME</h4></td>
                            <td><h4 class="text-right">KILLS</h4></td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>NAME</td>
                            <td class="text-right">KILLS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
