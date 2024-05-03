<template>
  <div>
    <h3 class="q-mb-xl text-center">Product Image Insert Page</h3>
  </div>

  <q-form style="width: 50%;">
    <div>
      <h5>
      Images
    </h5>
  </div>
    <div>
      <q-file v-model="file" label="Choose File" filled multiple>
        <template v-slot:prepend>
          <q-icon name="upload"/>
        </template>
      </q-file>
    </div>
  </q-form>

  <div style="max-width: 60%">
    <p>Show/Hide</p>
    <q-radio v-model="shape" val="hide" label="Hide"/>
    <q-radio v-model="shape" val="show" label="Show"/>
  </div>
  <div class="text-center">
    <q-btn rounded standout type="submit" label="Submit" color="primary" @click="Insert()"/>
    <q-btn rounded standout type="submit" label="Cancel" color="primary" @click.prevent="router.replace({name:'ImageProductPage'})"/>
  </div>
</template>

<script setup>

import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter, useRoute } from 'vue-router'

const shape = ref('')
const file = ref(null)
const router = useRouter()
const route = useRoute()
const token = localStorage.getItem('admin_token_uuid')
const paramData = ref(route.params.productId)
console.log(paramData)

function check () {
  console.log('Token', token)
  if (!token) {
    router.push('/')
  }
}
check()

function validate (localToken) {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
  }).catch((error) => {
    console.error(error.data)
  })
}
validate()

function Insert () {
  api.post('AddImage', {
    productId: paramData.value,
    file: file.value,
    shape: shape.value
  }).then(() => {
    console.log(paramData.value)
    router.push({ name: 'ImageProductPage' })
  }).catch((error) => {
    console.error(error.data)
  })
}
</script>
