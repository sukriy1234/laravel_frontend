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
          <th nowrap>Total</th>
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
                 <input class="form-control text-right" type="text" v-model="product.qty" @change="calculateLineTotal(product)" />
             </td>
             <td>
                 <input class="form-control text-right" type="text" v-model="product.price_per_1_qty" @change="calculateLineTotal(product)" />
             </td>
             <td>
                 <input class="form-control text-right" readonly type="text" v-model="product.actual_price" />
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
             <td>
                 <input class="form-control text-right" type="text" v-model="concierge_fee" @change="calculateTotal()" />
             </td>
             <td></td>
         </tr>
         <tr>
          <td colspan='4'></td>
          <td>Total</td>
          <td align="right">{{total}}</td>
         </tr>
      </tfoot>
    </table>
    <button type="button" class="form-control btn btn-primary" @click='onSubmit'>SUBMIT</button>
    </div>
</template>

<script>
    export default {
       data() {
         return {
            duedate: '',
            reporter: '',
            list: [],
            list_user: [],
            total: 0,
            concierge_fee: 0,
            products: []
         }
       },
       methods:{
           addRow() {
              this.products.push({
                 name: '',
                 unit_of_measure: '',
                 qty: '',
                 price_per_1_qty: '',
                 actual_price: '',
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
               var total = parseFloat(product.qty) * parseFloat(product.price_per_1_qty);
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
            axios.get('/user/search')
            .then(function (response) {
               console.log(response);
               for (var k in response.data){
                  vm.list_user.push(response.data[k]);
               }
            }).catch(function (error) {
               console.log(error);
            });
        },
        mounted() {
           console.log('mounted');
            let vm = this;
            axios.get('/product/search')
            .then(function (response) {
               for (var k in response.data){
                  vm.list.push(response.data[k]);
               }
            }).catch(function (error) {
               console.log(error);
            });
       }
    }
</script>
