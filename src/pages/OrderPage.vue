<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Order Page</H4>
    <div class="text-right">
      <q-btn filled class="q-mx-xl q-mb-lg" type="submit" icon="add" label="Insert Order" color="green" @click="submit()"/>
    </div>
    <p> </p>
    <div>
      <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
      style="max-width: 70%"
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

          <q-item clickable v-close-popup @click="deleted(props.row)">
            <q-item-section>
              <q-item-label>Delete</q-item-label>
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
import { useRouter } from 'vue-router'

const orderNumber = ref('')
const dateTime = ref('')
const totalPrice = ref('')
const status = ref('')
const router = useRouter()
const rows = ref([])

const columns = [
  {
    name: 'orderNumber',
    label: 'Order Number',
    align: 'left',
    field: 'orderNumber'
  },
  {
    name: 'dateTime',
    label: 'Date Time',
    field: 'dateTime'
  },
  {
    name: 'totalPrice',
    label: 'Total Price',
    field: 'totalPrice'
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

function getMenu () {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
    api.get('getOrder', {
      orderNumber: orderNumber.value,
      dateTime: dateTime.value,
      totalPrice: totalPrice.value,
      status: status.value
    }).then((response) => {
      rows.value = response.data
    })
  }).catch((error) => {
    console.error(error.data)
  })
}
getMenu()
function submit (localToken) {
  api.get('Checker', {
    token: localToken
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
    router.push('OrderInsert')
  }).catch((error) => {
    console.error(error.data)
  })
}
function detail (data) {

}

//  Buat Delete Data tapi nanti setelah insert dan get menu
function deleted (data) {
  api.delete('deletedOrder/' + data.orderId, {

  }).then(() => {
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}
</script>
