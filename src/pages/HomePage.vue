<template>
  <div class="text-center">
    <H2>Selamat Datang Pada Home Page</H2>
  </div>
  <div class="text-center q-gutter-x-md">
    <q-btn @click="Order" color="green">Order Product</q-btn>
    <q-btn @click="Insert" color="green">Insert Product</q-btn>
    <q-btn @click="Member" color="green">Member Data</q-btn>
    <q-btn @click="Bank" color="green">Bank Data</q-btn>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()

function Order () {
  router.push({ name: 'OrderPage' })
}
function Insert () {
  router.push({ name: 'ProductPage' })
}
function Bank () {
  router.push({ name: 'BankPage' })
}
function Member () {
  router.push({ name: 'MemberPage' })
}
</script>
