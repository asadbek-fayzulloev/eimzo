<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
    </style>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{asset("css/demo.css")}}">
    <script src="http://dls.yt.uz/e-imzo.js"></script>
    <script src="http://dls.yt.uz/e-imzo-client.js"></script>
    <style>
        body {
            padding: 10px;

        }

        #exTab1 .tab-content {
            background-color: #428bca;
            padding: 5px 15px;
        }

        #exTab2 h3 {
            background-color: #428bca;
            padding: 5px 15px;
        }

        /* remove border radius for the tab */

        #exTab1 .nav-pills > li > a {
            border-radius: 0;
        }

        /* change border radius for the tab , apply corners on top*/

        #exTab3 .nav-pills > li > a {
            border-radius: 4px 4px 0 0;
        }

        #exTab3 .tab-content {
            background-color: #428bca;
            padding: 5px 15px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            color: black;

        }
    </style>
</head>
<body class="antialiased">
<div class="container">
    @include('asadbek.eimzo.common.alert')
    <h2>Eimzo Sign methods </h2>
    <form name="testform" action="{{route('sign.verify')}}" method="POST">
        @csrf
        <label id="message"></label>
        <div class="form-group">
            <label for="select1">Выберите ключ</label>
            <select name="key" id="select1" onchange="cbChanged(this)"></select><br />
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст для подписи</label>
            <textarea class="form-control" name="data" rows="3"></textarea>
        </div>
        ID ключа <label id="keyId"></label><br />

        <button onclick="sign()" class="btn btn-success" type="button">GENERATE KEY</button><br />


        <div class="form-group">
            <label for="exampleFormControlTextarea3">Подписанный документ PKCS#7</label>
            <textarea class="form-control" readonly required name="pkcs7" id="exampleFormControlTextarea3"
                      rows="3"></textarea>
        </div><br />
        <div class="row ml-4">
            <button type="submit" class="btn btn-success col-md-2" >Sign</button>

        </div>
    </form>

    <br>
    <table id="example" class="display signs responsive nowrap" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @php
            $username = '';
        @endphp
        @foreach($signs as $sign)

            <tr>
                <td>{{$sign->id}}</td>
                <td>{{$sign->text}}</td>
                <td>{{$sign->data}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

</div>

</body>
<!-- jQuery -->
<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
<!-- Popper JS -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
<!-- Bootstrap JS -->
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
<!-- Custom Script -->
<script src="{{asset("js/script.js")}}"></script>
<script src="{{asset("js/eimzo/e-imzo.js")}}"></script>
<script src="{{asset("js/eimzo/e-imzo-client.js")}}"></script>
<script src="{{asset("js/eimzo/eimzo.js")}}"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

</html>
