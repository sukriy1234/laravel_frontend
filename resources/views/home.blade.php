<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </head>
    <body>
      <div class="container" id='app'>
         <p>
              <router-link :to="{ name: 'home' }">Home</router-link> |
              <router-link :to="{ name: 'product' }">Product</router-link> |
              <router-link :to="{ name: 'order' }">Order</router-link> |
              <a href='#' id='logout'>Logout</a>
         </p>
         <router-view></router-view>
      </div>
      <script src="{{ asset('js/app.js') }}"></script>
      <script>
      document.getElementById("logout").addEventListener("click", function(e) {
         axios.get('/logout')
         .then(function (response) {
            alert(response.data.message);
            if(response.data.success == true){
               window.location = "/";
            }
         })
         .catch(function (error) {
            console.log(error);
         });
      });
      </script>
    </body>
</html>
