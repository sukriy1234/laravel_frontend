<template>
    <div class="container">
    <h1>EDIT ORDER</h1>
    <router-link type='button' class='btn btn-primary' :to="{ name: 'order' }">BACK</router-link>

    <button type="button" class="btn btn-primary" @click='addRow'><i class="fas fa-plus"></i></button>

   <form class="form-inline">
      <input class="form-control" placeholder='Payment Methods' type="text" v-model="payment" />
      <input class="form-control" readonly type="text" v-model="finance" placeholder="Finance"/>
      <input class="form-control" readonly type="text" v-model="reporter" />
      <input class="form-control" readonly type="text" v-model="duedate" />
   </form>

    <table class="table">
      <thead class="thead-light">
        <tr>
          <th nowrap></th>
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
                 <input class="form-control" readonly type="text" v-model="product.qty" />
             </td>
             <td>
                 <input class="form-control" readonly type="text" v-model="product.price_per_1_qty" />
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
            id: '',
            finance: '',
            payment: '',
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
                 id: '',
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
                  total += +this.products[k].actual_price.toString().replace(/,/g , "");
               }
               this.total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           },
           onSubmit(){
               console.log("onSubmit");
               let vm = this;
               axios.post('/order/update_finance', {
                  id: vm.id,
                  payment: vm.payment,
                  product: vm.products,
                  concierge_fee: vm.concierge_fee
               })
              .then(function (response) {
                  console.log(response.data);
                 if(response.data.success == true){
                     alert('Success Deliver');
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
       },
       created(){
          console.log('mounted');
           let vm = this;
           axios.get('/user/search')
           .then(function (response) {
              for (var k in response.data){
                 vm.list_user.push(response.data[k]);
              }
              console.log(vm.list_user);
           }).catch(function (error) {
              console.log(error);
           });
       },
       beforeCreate() {
         console.log('beforeCreate2');
          let vm = this;
          axios.post('/order/view', {
             id: vm.$route.params.id
            })
          .then(function (response) {
            console.log(response);
             if(response.data.success == true){
               console.log('hitung');
               var total = 0;
               for (var k in response.data.message){
                  total += +response.data.message[k].actual_price;

                  if(response.data.message[k].actual_quantity == '') response.data.message[k].actual_quantity=response.data.message[k].qty;
                  if(response.data.message[k].actual_per_price == '') response.data.message[k].actual_per_price=response.data.message[k].price_per_1_qty;


                  if(response.data.message[k].name != 'concierge fee'){
                     vm.products.push(response.data.message[k]);
                  }else{
                     vm.concierge_fee=response.data.message[k].actual_price;
                  }
                  if(k ==0){
                     vm.duedate = konvert_tgl(response.data.message[k].duedate);
                     vm.reporter = response.data.message[k].reporter_username;
                     vm.payment = response.data.message[k].payment;
                     vm.finance = response.data.message[k].finance_username;
                  }
               }
               vm.total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
               vm.id = vm.$route.params.id;
             }else{
               alert("Data not found");
               vm.$router.push('/order');
             }
          })
          .catch(function (error) {
             console.log(error);
          });
       }
    }
    function konvert_tgl(tgl) {
      if(tgl == null) return '';

      var temp = tgl.split(' ');
      if(temp[1]){
         var tgl0 = temp[0].split('-');
         var tgl = tgl0[2]+'-'+tgl0[1]+'-'+tgl0[0]+' '+temp[1];
      }else{
         var tgl0 = tgl.split('-');
         var tgl = tgl0[2]+'-'+tgl0[1]+'-'+tgl0[0];
      }
      return tgl;
    }
</script>
