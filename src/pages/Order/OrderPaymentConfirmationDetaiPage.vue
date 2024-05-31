<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Order Payment Confirmation</H4>

    <div class="row text-subtitle-1 q-gutter-x-sm items-center q-my-lg q-ma-xl">
      <nav>
        <router-link class="text-blue-9 hover-color"  :to="({ name: 'OrderPage' })">Order</router-link>
      </nav>
      <q-icon name="navigate_next"></q-icon>
      <nav>
        <router-link class="text-blue-9 hover-color"  :to="({ name: 'OrderPayConfirm' })">Payment Confirmation</router-link>
      </nav>
      <q-icon name="navigate_next"></q-icon>
      <nav>
        <router-link class="text-black hover-color">Detail</router-link>
      </nav>
    </div>

    <div class="q-ma-sm">
      <h5 class="row">Order Number :
        <p class="q-mx-xl">{{ orderNumber }}</p>
      </h5>
    </div>

    <div class="q-mx-lg">
      <h6 class="row">Order Date Time :
        <p class="q-mx-xl">{{ dateTime }}</p>
      </h6>

      <h6 class="row">Total Price :
        <p class="q-mx-xl">{{ totalPrice }}</p>
      </h6>

      <h6 class="row">Status :
        <p class="q-mx-xl">{{ status }}</p>
      </h6>
    </div>

    <div>
      <h5 class="q-ma-sm">
        Payment Confirmation
      </h5>
    </div>

    <div class="q-mx-lg">
      <h6 class="row">Transfer to :
        <p class="q-mx-xl">{{ bankName + '-' + bankNumber }}</p>
      </h6>

      <h6 class="row">Bank Name :
        <p class="q-mx-xl">{{ bankName }}</p>
      </h6>

      <h6 class="row"> Account Name :
        <p class="q-mx-xl">{{ accountName }}</p>
      </h6>

      <h6 class="row">Account Number :
        <p class="q-mx-xl">{{accountNumber }}</p>
      </h6>

      <h6 class="row">Total Payment :
        <p class="q-mx-xl">{{totalPayment }}</p>
      </h6>

      <h6 class="row">Receipt :
        <q-img  class="q-mx-xl" :src="'http://localhost:8080/receipts/'+ image" :ratio="1" style="width: 40%;">
        <!-- <q-img>
          <img style="width: 30%;" src="https://www.simplilearn.com/ice9/free_resources_article_thumb/what_is_image_Processing.jpg" alt=""> -->
        </q-img>
      </h6>
    </div>

    <div class="justify-end row q-gutter-x-md q-px-md">
      <q-btn @click="reject(data)" color="red">Reject</q-btn>
      <q-btn @click="approve(data)" color="green">Approve</q-btn>
    </div>

  </div>
</template>

<script setup>

import { ref } from 'vue'
import { api } from 'src/boot/axios'
// import { useRouter, useRoute } from 'vue-router'
import { useRoute } from 'vue-router'

// const router = useRouter()
const route = useRoute()
const paramData = ref(route.params.orderId)
const paramDataPay = ref(route.params.paymentId)
const orderNumber = ref('')
const dateTime = ref('')
const totalPrice = ref('')
const status = ref('')

const bankName = ref('')
const bankNumber = ref('')
const accountName = ref('')
const accountNumber = ref('')
const totalPayment = ref('')
const image = ref('')

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
      return api.get('payment/orderData/' + paramData.value)
    })
    .then(response => {
      console.log(response.data)
      const orderDetails = response.data.OrderData
      dateTime.value = orderDetails.dateTime.date
      totalPrice.value = orderDetails.totalPrice
      status.value = orderDetails.status
      return api.get('payment/orderPaymentData/' + paramDataPay.value)
    }).then(response => {
      console.log(response.data)
      const orderPaymentData = response.data.PaymentData
      bankNumber.value = orderPaymentData.bankNumber
      bankName.value = orderPaymentData.bankName
      accountName.value = orderPaymentData.accountName
      accountNumber.value = orderPaymentData.accountNumber
      totalPayment.value = orderPaymentData.totalPayment
      image.value = orderPaymentData.image
    })
    .catch(error => {
      console.error(error)
    })
}
getMemberData()

function approve (data) {
  api.put('payment/updateStatusPaymentApprove', {
    paymentId: paramDataPay.value
  }).then((response) => {
    console.log(response)
    getMemberData()
  }).catch((error) => {
    console.error(error)
  })
}

function reject (data) {
  api.put('payment/updateStatusPaymentReject', {
    paymentId: paramDataPay.value
  }).then((response) => {
    console.log(response)
    getMemberData()
  }).catch((error) => {
    console.error(error)
  })
}

</script>
