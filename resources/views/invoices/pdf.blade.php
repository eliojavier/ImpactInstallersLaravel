<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        h1, h2, h3, h4, h5, h6, p {
            font-family: Raleway, 'sans-serif';
        }
        th {
            background-color: gainsboro;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1><strong>INVOICE</strong></h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4><strong>IMPACT INSTALLERS</strong></h4>
            <p><strong>7040 NW 77th Terrace</strong></p>
            <p><strong>Miami, Fl 33166</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4><strong>Invoice #:  {{$assignment->bill->bill_number}} </strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4><strong>Date: {{$assignment->date}}</strong></h4>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Bill to</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$assignment->clientName}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price each</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignment->bill->details as $detail)
                <tr>
                    <td>{{$detail->description}}</td>
                    <td>{{$detail->quantity}}</td>
                    <td>{{$detail->unitary_price}}</td>
                    <td>{{$detail->total_item}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <h4><strong>Total: {{$total}}</strong></h4>
            <h3><strong>Balance due: {{$total}}</strong></h3>
        </div>
    </div>
</div>
</body>
</html>
