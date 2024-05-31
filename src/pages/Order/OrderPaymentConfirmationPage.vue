<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Order Payment Confirmation</H4>

    <div class="row text-subtitle-1 q-gutter-x-sm items-center q-my-lg q-ma-xl">
      <nav>
        <router-link class="text-blue-9 hover-color"  :to="({ name: 'OrderPage' })">Order</router-link>
      </nav>
      <q-icon name="navigate_next"></q-icon>
      <nav>
        <router-link class="text-black hover-color">Payment Confirmation</router-link>
      </nav>
    </div>

    <div class="q-ma-xl">
      <h6 class="row">Order Number :
        <p class="q-mx-xl">{{ orderNumber }}</p>
      </h6>

    </div>

    <div>
      <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
      style="max-width: 90%"
      class="q-mx-auto"
      >
      <template v-slot:body-cell-action="props">
        <q-btn-dropdown
        class="q-ml-xl"
        filled
        type="submit"
         color="green"
         style="max-width: 70%">
        <q-list>
          <q-item clickable v-close-popup @click="detail(props.row)">
            <q-item-section>
              <q-item-label>Detail</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable v-close-popup @click="status(props.row)">
            <q-item-section>
              <q-item-label>Approve/Reject</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
        </q-btn-dropdown>
      </template>
    </q-table>
    </div>
  </div>
</template>

<script setup>

import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const rows = ref([])
const route = useRoute()
const paramData = ref(route.params.orderId)
const orderNumber = ref('')

const columns = [
  {
    name: 'transferTo',
    label: 'Transfer To',
    align: 'left',
    field: row => `${row.accountName} - ${row.accountNumber}`
  },
  {
    name: 'bankName',
    label: 'Bank',
    field: 'bankName'
  },
  {
    name: 'accountName',
    label: 'Account Name',
    field: 'accountName'
  },
  {
    name: 'accountNumber',
    label: 'Account Number',
    field: 'accountNumber'
  },
  {
    name: 'date',
    label: 'Transfer Date',
    field: 'date'
  },
  {
    name: 'status',
    label: 'Status',
    field: 'status'
  },
  {
    name: 'action',
    label: 'Actions',
    field: 'action'
  }
]

const token = localStorage.getItem('admin_token_uuid')
function getMemberData () {
  api.get('Checker', { token })
    .then(response => {
      console.log('response axios', response)
      return api.get('payment/getOrderNumber/' + paramData.value)
    })
    .then(response => {
      const orderDetail = response.data.orderData
      orderNumber.value = orderDetail.orderNumber

      return api.get('payment/getPaymentData/' + paramData.value)
    })
    .then(response => {
      rows.value = response.data
    })
    .catch(error => {
      console.error(error)
    })
}
getMemberData()

function detail (data) {
  router.push({ name: 'OrderPayConfirmDetail', params: { paymentId: data.paymentId } })
  console.log(data)
}

function status (data) {
  api.put('payment/updateStatusPayment', {
    paymentId: data.paymentId,
    show: !data.show
  }).then((response) => {
    console.log(response)
    getMemberData()
  }).catch((error) => {
    console.error(error)
  })
}

</script>
