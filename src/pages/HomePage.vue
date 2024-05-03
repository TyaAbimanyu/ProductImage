<template>
  <div class="q-pa=md">
    <H4>Product Page</H4>
    <div class="text-right">
      <q-btn filled class="btn" type="submit" icon="add" label="Insert Product" color="green" @click="submit()"/>
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
        filled
        class="btn"
        type="submit"
         color="green"
         style="max-width: 70%">
        <q-list>
          <q-item clickable v-close-popup @click="status(props.row)">
            <q-item-section>
              <q-item-label>Status</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable v-close-popup @click="image(props.row)">
            <q-item-section>
              <q-item-label>Image</q-item-label>
            </q-item-section>
          </q-item>

            <q-item clickable v-close-popup @click="update(props.row)">
              <q-item-section>
                <q-item-label>Update</q-item-label>
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

const title = ref('')
const price = ref('')
const shape = ref('')
const router = useRouter()
const rows = ref([])

const columns = [
  {
    name: 'title',
    label: 'Title',
    align: 'left',
    field: 'title'
  },
  {
    name: 'price',
    label: 'Price',
    field: 'price'
  },
  {
    name: 'shows',
    label: 'Show / Hide',
    field: 'shows'
  },
  {
    name: 'action',
    label: 'Actions',
    field: 'action'
  }
]

const token = localStorage.getItem('admin_token_uuid')

function getMenu (localToken) {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)

    api.get('ShowMenu', {
      title: title.value,
      price: price.value,
      shape: shape.value
    }).then((response) => {
      rows.value = response.data
    }).catch((error) => {
      console.log(error.response.data)
      router.push('/')
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
    router.push('Insert')
  }).catch((error) => {
    console.error(error.data)
  })
}
function status (data) {
  api.put('StatusUpdate', {
    productId: data.productId,
    show: !data.show
  }).then((response) => {
    console.log(response.data)
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}

const update = (data) => {
  router.push({ name: 'UpdatePage', params: { productId: data.productId } })
  console.log(data)
}

const image = (data) => {
  router.push({ name: 'ImageProductPage', params: { productId: data.productId } })
  console.log(data)
}

function deleted (data) {
  api.delete('deletedData/' + data.productId, {

  }).then(() => {
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}
</script>
