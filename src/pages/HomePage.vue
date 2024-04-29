<template>
  <div class="q-pa=md">
    <H4>Product Page</H4>
    <div class="text-right">
      <q-btn filled class="btn" type="submit" icon="add" label="Insert Product" color="green"/>
    </div>
    <p></p>
    <div>
      <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
      style="max-width: 70%"
      class="q-mx-auto"
      >
      <template v-slot:body-cell-dropdown="props">
        <q-btn-dropdown
        :props="props"
        filled
        class="btn"
        type="submit"
         color="green"
         @click="Update(props)"
         style="max-width: 70%"/>
      </template>
    </q-table>
    </div>
  </div>
</template>

<script setup>

import { ref } from 'vue'
import { api } from 'src/boot/axios'

const title = ref('')
const description = ref('')
const price = ref('')
const shape = ref('')

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
    name: 'dropdown',
    label: 'Actions',
    field: 'dropdown'
  }
]

const rows = ref([])

function getMenu () {
  api.get('ShowMenu', {
    title: title.value,
    description: description.value,
    price: price.value,
    shape: shape.value
  }).then((response) => {
    rows.value = response.data
  }).catch((error) => {
    console.log(error.response.data)
  })
}
getMenu()
function Update () {

}

</script>
