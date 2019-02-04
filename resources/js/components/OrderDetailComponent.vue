<template>
    <div class="container">
    <h1>Detail ORDER</h1>
    <router-link type='button' class='btn btn-primary' :to="{ name: 'order' }">BACK</router-link>

       <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Due Date</label>
        <div class="col-sm-3">
           <input type="text" readonly class="form-control-plaintext" v-model="duedate">
        </div>
       </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Requester</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control-plaintext" v-model="input">
        </div>
        <div class="col-sm-2">
          <input type="text" readonly class="form-control-plaintext" v-model="request_date">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Reporter</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control-plaintext" v-model="reporter">
        </div>
        <div class="col-sm-2">
          <input type="text" readonly class="form-control-plaintext" v-model="respond_reporter">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Finance</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control-plaintext" v-model="finance">
        </div>
        <div class="col-sm-2">
          <input type="text" readonly class="form-control-plaintext" v-model="respond_finance">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Payment</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control-plaintext" v-model="payment">
        </div>
      </div>
      <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
      <div class="col-sm-3">
          <input type="text" readonly class="form-control-plaintext" v-model="status">
      </div>
      </div>
    <table class="table">
      <thead class="thead-light">
        <tr>
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
             <td>
                 <autocomplete-vue :list="list" :auto-hide="true" inputClass="form-control" v-model='product.name'></autocomplete-vue>
             </td>
             <td>
                 <input class="form-control" type="text" v-model="product.unit_of_measure"/>
             </td>
             <td>
                 <input class="form-control text-right" readonly type="text" v-model="product.qty" />
             </td>
             <td>
                 <input class="form-control text-right" readonly type="text" v-model="product.price_per_1_qty" />
             </td>
             <td>
                 <input class="form-control text-right" type="text" v-model="product.actual_quantity" @change="calculateLineTotal(product)">
             </td>
             <td>
                 <input class="form-control text-right" type="text" v-model="product.actual_per_price" @change="calculateLineTotal(product)">
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
             <td>concierge fee</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>
                 <input class="form-control text-right" type="text" v-model="concierge_fee" @change="calculateTotal()" />
             </td>
             <td></td>
         </tr>
         <tr>
          <td colspan='5'></td>
          <td>Total</td>
          <td align="right">{{total}}</td>
         </tr>
      </tfoot>
    </table>
    </div>
</template>

<script>
    export default {
       data() {
         return {
            respond_reporter: '',
            respond_finance: '',
            request_date: '',
            status: '',
            reporter: '',
            finance: '',
            id: '',
            input: '',
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
       mounted() {
        console.log('mounted');
         let vm = this;
         axios.get('http://localhost:8080/product/search')
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
                     vm.respond_reporter = konvert_tgl(response.data.message[k].respond_reporter);
                     vm.respond_finance = konvert_tgl(response.data.message[k].respond_finance);
                     vm.request_date = konvert_tgl(response.data.message[k].created_at);

                     vm.reporter = response.data.message[k].reporter_username;
                     vm.finance = response.data.message[k].finance_username;
                     vm.input = response.data.message[k].input_username;
                     vm.payment = response.data.message[k].payment;
                     vm.status = response.data.message[k].status;
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
