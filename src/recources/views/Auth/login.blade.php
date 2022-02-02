<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    </style>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{asset("css/demo.css")}}">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">


<main>
    <article>
        <div class="container">
            <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#loginModal">
                Login
            </button>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-title text-center">
                            <h4>Login</h4>
                        </div>
                        <div class="d-flex flex-column text-center">
                            <div class="mb-2 mg-t-15" style="position: relative; z-index: 999999;">
                                <form name="eri_form" action={{route('eimzo:postlogin')}} id="eri_form" method="post">
                                    <input type="hidden" name="_token" value="gMNU6uPx5DoNAe5mntW8O9QPOI855WKSyTdQMybd">
                                    <div class="form-group mb-2">
                                        <label for="">Калитни танланг</label>
                                        <select name="key" class="form-control bordered" onchange="cbChanged(this)"></select>
                                    </div>
                                    <div hidden="" id="keyId" class="none"></div>

                                    <input type="hidden" name="eri_fullname" id="eri_fullname">
                                    <input type="hidden" name="eri_inn" id="eri_inn">
                                    <input type="hidden" name="eri_pinfl" id="eri_pinfl">
                                    <input type="hidden" name="eri_sn" id="eri_sn">
                                    <textarea hidden="" class="none" name="eri_data" id="eri_data">authorization</textarea>
                                    <textarea hidden="" class="none" name="eri_hash" id="eri_hash"></textarea>
                                    <div class="text-center">
                                        <button class="btn btn-sm btn-primary" id="eri_sign" onclick="sign()" type="button">Имзолаш</button>
                                        <button class="btn btn-sm btn-info" id="eri_sign" onclick="uiLoadKeys()" type="button">Янгилаш</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </article>
</main>

<!-- jQuery -->
<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
<!-- Popper JS -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
<!-- Bootstrap JS -->
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
<!-- Custom Script -->
<script  src="{{asset("assets/js/script.js")}}"></script>
<script  src="{{asset("assets/js/eimzo/e-imzo.js")}}"></script>
<script  src="{{asset("assets/js/eimzo/e-imzo-client.js")}}"></script>
<script  src="{{asset("assets/js/eimzo/imzo.js")}}"></script>


</body>
</html>
