<template>
  <div>
    <h3 style="text-align: center;">Product Update Page</h3>
    <q-form @submit="Insert" class="q-gutter-md q-mx-auto" style="max-width: 50%">
      <q-input rounded standout v-model="title" label="Title"/>
      <q-input rounded standout v-model="description" label="Description" type="textarea"/>
      <q-input rounded standout v-model="price" label="Price"/>
      <p></p>
    </q-form>
    <div class="text-center" style="max-width: 60%">
      <p>Show/Hide</p>
      <q-radio v-model="shape" val="hide" label="Hide"/>
      <q-radio v-model="shape" val="show" label="Show"/>
    </div>
    <div class="text-center">
      <q-btn rounded standout type="submit" label="Update" color="primary" @click="Update()"/>
      <q-btn rounded standout type="submit" label="Cancel" color="primary" @click.prevent="router.push({name: 'ProductPage'})"/>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { api } from 'src/boot/axios.js'

const shape = ref('')
const title = ref('')
const description = ref('')
const price = ref('')
const router = useRouter()
const route = useRoute()
const paramData = ref(route.params.productId)

const token = localStorage.getItem('admin_token_uuid')

function validate () {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
  }).catch((error) => {
    console.error(error.data)
    router.push('/')
  })
}
validate()

function getUpdate () {
  api.get('getUpdateData/' + paramData.value, {

  }).then((response) => {
    title.value = response.data.title
    description.value = response.data.description
    price.value = response.data.price
    shape.value = response.data.shape
  }).catch((error) => {
    console.error(error)
  })
}
getUpdate()

function Update () {
  console.log(title.value)
  api.put('Update', {
    title: title.value,
    description: description.value,
    price: price.value,
    shape: shape.value,
    productId: paramData.value

  }).then((response) => {
    console.log(response.data)
    router.push({ name: 'ProductPage' })
  }).catch((error) => {
    console.error(error)
  })
}
</script>
