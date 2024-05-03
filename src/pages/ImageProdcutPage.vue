<template>
  <div>
    <h4>Product Image Page</h4>
  </div>

  <div class="row q-my-md justify-between" style="width: 80%">
    <h5 class="q-ma-none">{{title}}</h5>
    <q-btn filled class="btn" type="submit" icon="add" label="Insert Product Image" color="green" @click="InserProduct()" style="height: 30%;"/>
  </div>

  <div class="row justify-center" style="width: auto;">
    <q-card class="q-ma-sm q-pa-sm column col-3" v-for="item in data" :key="item">
    <q-img :src="'http://localhost:8080/uploads/'+ item.image" :ratio="1">
      <!-- <img src="https://www.simplilearn.com/ice9/free_resources_article_thumb/what_is_image_Processing.jpg" alt=""> -->
    </q-img>
    <q-card-actions>
      <q-btn color="green" :icon="item.show ? 'visibility' : 'visibility_off'" @click="showImage(item)"/>
      <q-btn icon="delete" @click="deleteImage(item)"/>
    </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter, useRoute } from 'vue-router'
const title = ref('')
const data = ref([])
const route = useRoute()
const router = useRouter()
const paramData = ref(route.params.productId)
const token = localStorage.getItem('admin_token_uuid')
const image = ref('')

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

const getImage = () => {
  api.get('getImage/' + paramData.value, {

  }).then((response) => {
    title.value = response.data.title
    data.value = response.data.result
    console.log(image.value)
  }).catch((error) => {
    console.error(error.data)
  })
}
getImage()

const InserProduct = () => {
  router.push({ name: 'InsertImageProductPage' })
}

const showImage = (item) => {
  api.put('statusUpdateImage', {
    productId: item.productId,
    show: item.show === '1' ? '0' : '1'
  }).then(() => {
    getImage()
  })
}

// Icon Visibiltynya masih ga mau berubah, tapi datanya berubah

const deleteImage = (data) => {
  api.delete('deleteImage/' + data.productId, {

  }).then(() => {
    getImage()
  }).catch((error) => {
    console.log(error)
  })
}
</script>
