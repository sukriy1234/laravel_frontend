<template>
    <div class="container">
      <router-link type='button' class='btn btn-primary' :to="{ name: 'orderadd' }">ADD ORDER</router-link>
       <table class="table">
         <thead class="thead-dark">
           <tr>
             <th>Request</th>
             <th>Requester</th>
             <th>Reporter</th>
             <th>Finance</th>
             <th>Due Date</th>
             <th>Total</th>
             <th>Status</th>
             <th>Manage</th>
           </tr>
         </thead>
         <tbody v-for='order in orders'>
           <tr>
              <td v-text='order.created_at'></td>
              <td v-text='order.input_username'></td>
              <td v-text='order.report_username'></td>
              <td v-text='order.finance_username'></td>
              <td v-text='order.duedate'></td>
              <td v-text='order.total'></td>
              <td v-text='order.status'></td>
              <td>
                 <button type='button' class='btn btn-primary' v-if="(order.flag == 1 && order.input_user == session.id)" @click="edit(order.id)"><i class="fas fa-edit"></i></button>
                 <button type='button' class='btn btn-danger'  v-if="(order.flag == 1 && order.input_user == session.id)" @click="delete0(order.id)"><i class="fas fa-trash-alt"></i></button>
                 <button type='button' class='btn btn-warning' v-if="(order.flag != 3 && order.reporter == session.id)"   @click="response(order.id)"><i class="fas fa-clipboard-check"></i></button>
                 <button type='button' class='btn btn-success' v-if="((order.flag == 2 || order.flag == 3) && session.flag == 2)" @click="edit_finance(order.id)"><i class="fas fa-truck"></i></button>
                 <button type='button' class='btn btn-light' @click="detail(order.id)"><i class="fas fa-info-circle"></i></button>
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
            session: [],
            orders: []
         }
      },
      methods : {
         delete0 : function(id_pass) {
            var r = confirm("Are you sure?");
            if (r == true) {
               let vm = this;
               axios.post('/order/delete', {
                   id: id_pass
                 })
               .then(function (response) {
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
            this.$router.push('/order/edit/'+id);
         },
         detail : function(id) {
            this.$router.push('/order/detail/'+id);
         },
         response: function(id){
            var r = confirm("Are you sure?");
            if (r == true) {
               var flag = 2;
            }else{
               var flag = 0;
            }
            axios.post('/order/reporter', {
                id: id,
                flag: flag
            })
            .then(function (response) {
               if(response.data.success == true){
                 alert('Success Approve');
                 location.reload();
               }else{
                 alert(response.data.message);
               }
            })
            .catch(function (error) {
               console.log(error);
            });
         },
         edit_finance(id){
            this.$router.push('/order/edit_finance/'+id);
         }
      },
      beforeCreate() {
         let vm = this;
         axios.post('/order')
         .then(function (response) {
            console.log(response.data);
            vm.orders = response.data.message;
            vm.session = response.data.session;
         })
         .catch(function (error) {
            console.log(error);
         });
      }
   }
</script>
