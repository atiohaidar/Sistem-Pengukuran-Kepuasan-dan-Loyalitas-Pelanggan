<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  		<title>SHE</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.jpg">

        <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/fontAwesome.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/light-box.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/templatemo-style.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600,700,800,900" rel="stylesheet">

        <script src="{{ asset('assets_frontend/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    </head>

<body style="background-image: url({{asset('assets_backend/img/background/wika.jpeg')}})">

    
            <div class="inner">
               
               <center> 
               <br/><br/><br/><br/><img width="20%" src="{{ asset('assets_backend/img/logo/logowika.png') }}" />
      
              <h1>Selamat Datang Di <em>SHE</em></h1>
              <p>SAFETY HEALTH ENVIRONMENT</p>
              <br/><br/><br/><br/><br/><br/><br/>
                <div class="scroll-icon">
                    
                    
                        <a class="btn btn-primary" href="/ind">Induction</a>
                        <a class="btn btn-warning" href="/permit">Permit</a>
                    
                </div>   
                <br/><br/><br/>
                </center>
            </div>
        





    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
    <script src="{{ asset('assets_frontend/js/vendor/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('assets_frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/main.js') }}"></script>

    
</body>
</html>
