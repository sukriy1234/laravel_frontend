<template>
    <div class="container">
    <h1>ADD ORDER</h1>
    <router-link type='button' class='btn btn-primary' :to="{ name: 'order' }">BACK</router-link>

    <button type="button" class="btn btn-primary" @click='addRow'><i class="fas fa-plus"></i></button>

    <form class="form-inline">
      <autocomplete-vue :list="list_user" :auto-hide="true" placeholder="Reporter" inputClass="form-control" v-model='reporter'></autocomplete-vue>
      <datepicker input-class="form-control" placeholder="Due Date" v-model="duedate"></datepicker>
    </form>

    <table class="table">
      <thead class="thead-light">
        <tr>
          <th></th>
          <th nowrap>Product</th>
          <th nowrap>Unit of Measure</th>
          <th nowrap>Qty</th>
          <th nowrap>Price Per 1 Qty</th>
          <th nowrap>Actual Quantity</th>
          <th nowrap>Actual Per Price</th>
          <th nowrap>Actual Price</th>
          <th nowrap>Note</th>
        </tr>
      </thead>
      <tbody>
         <tr v-for="(product, k) in products" :key="k">
             <td scope="row" class="trashIconContainer">
                 <i class="far fa-trash-alt"  @click="deleteRow(k, product)"></i>
             </td>
             <td>
                 <autocomplete-vue :list="list" :auto-hide="true" inputClass="form-control" v-model='product.name'></autocomplete-vue>
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.unit_of_measure"/>
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.qty" />
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.price_per_1_qty" />
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.actual_quantity" @change="calculateLineTotal(product)">
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.actual_per_price" @change="calculateLineTotal(product)">
             </td>
             <td>
                 <input class="form-control" readonly type="text" v-model="product.actual_price" />
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.note" />
             </td>
         </tr>
      </tbody>
      <tfoot>
         <tr>
             <td></td>
             <td>concierge fee</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>
                 <input class="form-control" type="text" v-model="concierge_fee" @change="calculateTotal()" />
             </td>
             <td></td>
         </tr>
         <tr>
          <td colspan='6'></td>
          <td>Total</td>
          <td>{{total}}</td>
   
            products: [{
               name: '',
               unit_of_measure: '',
               qty: '',
               price_per_1_qty: '',
               actual_quantity: '',
               actual_per_price: '',
               actual_price: 0,
               note: ''
            }]
         }
       },
       methods:{
           addRow() {
              this.products.push({
                 name: '',
                 unit_of_measure: '',
                 qty: '',
                 price_per_1_qty: '',
                 actual_quantity: '',
                 actual_per_price: '',
                 actual_price: 0,
                 note: ''
              });
           },
           deleteRow(index, product) {
               var idx = this.products.indexOf(product);
               console.log(idx, index);
               if (idx > -1) {
                   this.products.splice(idx, 1);
               }
           },
           calculateLineTotal(product) {
               var total = parseFloat(product.actual_quantity) * parseFloat(product.actual_per_price);
               if (!isNaN(total)) {
                   product.actual_price = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                   this.calculateTotal();
               }
           },
           calculateTotal(){
               var total = +this.concierge_fee;
               for (var k in this.products){
                  total += +this.products[k].actual_price.replace(/,/g , "");
               }
               this.total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           },
           onSubmit(){
               console.log("onSubmit");
               let vm = this;
               axios.post('/order/store', {
                  duedate: vm.duedate,
                  reporter: vm.reporter,
                  product: vm.products,
                  concierge_fee: vm.concierge_fee
               })
              .then(function (response) {
                  console.log(response);
                 if(response.data.success == true){
                     alert('Success Input');
                     vm.$router.push('/order');
                  }else{
                     alert(response.data.message);
                  }
               })
              .catch(function (error) {
                  console.log(error);
              });
           }
        },
        created(){
           console.log('mounted');
            let vm = this;
            axios.get('http://localhost:8080/user/search')
            .then(function (response) {
               for (var k in response.data){
                  vm.list_user.push(response.data[k]);
               }
               console.log(vm.list_user);
            }).catch(function (error) {
               console.log(error);
            });
        },
        mounted() {
           console.log('mounted');
            let vm = this;
            axios.get('http://localhost:8080/product/search')
            .then(function (response) {
               for (var k in response.data){
                  vm.list.push(response.data[k]);
               }
               console.log(vm.list);
            }).catch(function (error) {
               console.log(error);
            });
       }
    }
</script>
