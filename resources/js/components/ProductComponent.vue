<template>
    <div class="container">
      <router-link type='button' class='btn btn-primary' :to="{ name: 'productadd' }">ADD PRODUCT</router-link>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Link</th>
          <th>Manage</th>
        </tr>
      </thead>
      <tbody v-for="product in products">
        <tr>
           <td v-text=product.name></td>
           <td v-text=product.link></td>
           <td>
              <button type='button' class='btn btn-primary' @click="edit(product.id)"><i class="fas fa-edit"></i></button>
              <button type='button' class='btn btn-danger' @click="delete0(product.id)"><i class="fas fa-trash-alt"></i></button>
           </td>
        </tr>
      </tbody>
    </table>
    </div>
</template>

<script>
   export default {
      data: function() {
         return  {
            products: []
         }
      },
      methods : {
         delete0 : function(id_pass) {
            var r = confirm("Are you sure?");
            if (r == true) {
               let vm = this;
               axios.post('product/delete', {
                   id: id_pass
                 })
               .then(function (response) {
                  console.log(response);
                  if(response.data.success == true){
                    alert('Success Delete');
                    location.reload();
                  }else{
                    alert(response.data.message);
                  }
               })
               .catch(function (error) {
                  console.log(error);
               });
            }
         },
         edit : function(id) {
            console.log(id);
            this.$router.push('/product/edit/'+id);
         }
      },
      beforeCreate() {
         let vm = this;
         axios.post('product')
         .then(function (response) {
            console.log(response);
            vm.products = response.data.message;
         })
         .catch(function (error) {
            console.log(error);
         });
      }
   }
</script>
