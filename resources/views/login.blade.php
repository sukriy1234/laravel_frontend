<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel = "stylesheet">
        <title>Request Item</title>
    </head>
    <body>
      <div class='container' id='app'>
         <h1>LOGIN PAGE</h1>
         <form @submit.prevent='onSubmit()'>
            <div class="form-group row">
             <label for="username" class="col-md-1 col-form-label">Username</label>
             <div class="col-md-4">
                 <input type="username" class="form-control" v-model='username'>
             </div>
           </div>
           <div class="form-group row">
             <label for="password" class="col-md-1 col-form-label">Password</label>
             <div class="col-md-4">
                 <input type="password" class="form-control" v-model='password'>
             </div>
           </div>
           <div class="form-group row">
              <div class="col-md-5">
                <button type="submit" class="form-control btn btn-primary">Submit</button>
             </div>
          </div>
        </form>
      </div>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
      <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      <script type='text/javascript'>
      console.log('run');
      var vue_det = new Vue({
         el: '#app',
         data: {
            username: '',
            password: ''
         },
         methods: {
            onSubmit(){
               console.log('onSubmit');
               if(this.username != '' && this.password != ''){
                  let vm = this;
                  axios.post('login', {
                      username: vm.username,
                      password: vm.password
                    })
                    .then(function (response) {
                       console.log(response);
                       if(response.data.success == true){
                          alert('Success Login');
                          location.reload();
                       }else{
                          alert(response.data.message);
                       }
                    })
                    .catch(function (error) {
                      console.log(error);
                    });
               }else{
                  alert("Please fill all field");
               }
            }
         }
      });
      </script>
    </body>
</html>
