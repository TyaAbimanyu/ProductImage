<template>
  <div>
    <h3 style="text-align: center;">Product Image Insert Page</h3>
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
      <q-btn rounded standout type="submit" label="Submit" color="primary" @click="Insert()"/>
      <q-btn rounded standout type="submit" label="Cancel" color="primary" @click.prevent="router.replace({path:'Product'})"/>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter } from 'vue-router'

const title = ref('')
const description = ref('')
const price = ref('')
const shape = ref('hide')
const router = useRouter()
const token = localStorage.getItem('admin_token_uuid')

function check () {
  console.log('Token', token)
  if (!token) {
    router.push('/')
  }
}
check()

function validate (localToken) {
  api.get('Checker', {
    token: localToken
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
  }).catch((error) => {
    console.error(error.data)
  })
}
validate()
function Insert () {
  api.post('Add', {
    title: title.value,
    description: description.value,
    price: price.value,
    shape: shape.value
  }).then((response) => {
    console.log(response.data)
    router.push('Product')
  }).catch((error) => {
    console.error(error)
  })
}
</script>
