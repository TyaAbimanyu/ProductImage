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

      <!-- hasil AI -->
      <!-- <template v-slot:body-cell="cell">
        <q-td v-if="cell.column.name !== 'shows'">
          {{ cell.row[cell.column.field] }}
        </q-td>
        <q-td v-else>
          <q-dropdown down>
            <q-btn flat label="Actions" icon="more_vert" />
            <template v-slot:dropdown-menu>
              <q-item @click="onAction(cell.row)">Option 1</q-item>
              </template>
          </q-dropdown>
        </q-td>
      </template> -->
      <!-- ////// -->
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

</script>
