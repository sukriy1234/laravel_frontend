<template>
    <div class="container">
       <h1>ADD PRODUCT</h1>
       <form @submit.prevent='onSubmit()'>
         <div class="form-group row">
          <label for="username" class="col-md-1 col-form-label">Name</label>
          <div class="col-md-4">
               <input type="text" class="form-control" v-model='name'>
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-md-1 col-form-label">link</label>
          <div class="col-md-4">
               <input type="text" class="form-control" v-model="link">
          </div>
        </div>
        <div class="form-group row">
            <div class="col-md-5">
             <button type="submit" class="form-control btn btn-primary">Submit</button>
          </div>
        </div>
     </form>
    </div>
</template>

<script>
    export default {
       data() {
         return {
           name: '',
           link: ''
         }
       },
       methods: {
          onSubmit(){
            console.log('onSubmit');
            if(this.name != ''){
               let vm = this;
               axios.post('store', {
                  name: vm.name,
                  link: vm.link
                 })
                 .then(function (response) {
                    console.log(response);
                    if(response.data.success == true){
                        alert('Success Input');
                        vm.$router.push('/product');
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
    }
</script>
