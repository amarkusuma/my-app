<!DOCTYPE html>
<html>
<head>
{{-- <link rel="stylesheet" href="styles.css"> --}}
<link rel="icon" href="{{ url('assets/brand/logo2.jpeg') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
{{-- <script src="password.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
<style>
</style>
<title>Page Varification</title>
</head>
<body>

    <div class="container">
        <div class="row" style="margin-top: 100px; margin-bottom:100px;">
            <div class="col-md-5 mx-auto shadow-lg p-3 mb-5 bg-white rounded" style="padding:40px;">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-5">
                            <center>
                                <div>
                                    <img src="{{ url('assets/img/logo/logo2.jpeg') }}" class="mb-2 mt-4 rounded" alt="images2" width="85" height="85">
                                </div>
                                {{-- <div>
                                    <img src="https://i.imgur.com/EHEvezf.png?s=wa" class="mb-3 mt-3" alt="images2" width="45" height="45">
                                </div> --}}
                            </center>
                            <div class="col-md-12 text-center mt-4">
                                <h4 style="color:#4B5563;" class="mb-3 mt-2"><b>{{$title}}</b></h4>
                                <h6 style="color:#7D7E7F;">{{$message}}</h6>
                            </div>
                            <br />
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn  tx-tfm" id="start_button" style="background-color: #562AD9;border-radius: 100px;width: 64px; height: 40px;box-shadow: 4px 6px 20px rgba(86, 42, 217, 0.4);color:#FFFFFF"><b>OK</b></button>
                            </div>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
