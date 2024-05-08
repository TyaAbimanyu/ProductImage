<template>
  <div class="text-center">
    <H2>Selamat Datang Pada Home Page</H2>
  </div>
  <div class="text-center">
    <q-btn @click="Order">Order Product</q-btn>
    <q-btn @click="Insert">Insert Product</q-btn>
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
</script>
