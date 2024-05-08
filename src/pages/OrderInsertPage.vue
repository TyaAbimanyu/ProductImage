<template>
  <div>
    <h5>Order Insert</h5>
  </div>

  <div class="text-right">
    <q-btn @click="canceling" color="red">Cancel</q-btn>
    <q-btn @click="submit" color="green">Submit</q-btn>
  </div>

  <div>
    <h6>Cart</h6>
    <q-table
    :rows="rows"
    :columns="columns"
    :row-key="product_title"
    style="max-width: 90%"
    class="q-mx-auto"
    >
    <template v-slot:body-cell-delete="props">
    <q-btn :props="props.data" icon="delete" color="red" filled @click="deleteOrder(props.index)"></q-btn>

    </template>
  </q-table>

  <div>
    <!-- h6 disini bakal nyimpen data dari pricenya pake {{ total_prtice }} -->
    <h6 class="q-ma-none">Total Price Rp. {{allTotalPrice()}}</h6>
  </div>

  </div>

  <div>
    <!-- Space buat bikin Q-form Search -->
    <div>
      <q-input outlined v-model="search" style="width: 20%;" label="Search">
        <template v-slot:prepend>
          <q-icon name="search"/>
        </template>
      </q-input>
    </div>

    <div  class="q-mt-xl q-gutter-y-md" style="width: 70%;">
      <q-card class="q-pa-md" v-for="index in data" :key="index">
        <div>
          <h5>{{index.product.title}}</h5>
          <h6>Quantity
            <q-btn icon="remove" @click="minus(index)"/>
            {{ index.quantity }}
            <q-btn icon="add" @click="plus(index)"/>
          </h6>

          <h6> Rp. {{index.product.price}}</h6>
          <div>
            <q-card class="row q-gutter-md" v-for="item in index.image" :key="item">
            <q-img :src="'http://localhost:8080/uploads/'+ item.image" :ratio="1">
              <!-- <q-img>
                <img src="https://www.simplilearn.com/ice9/free_resources_article_thumb/what_is_image_Processing.jpg" alt=""> -->
              </q-img>
            </q-card>
          </div>
          <div class="text-right">
            <q-btn class="text-right" @click="AddToCart(index)">Add To Cart</q-btn>
          </div>
        </div>
      </q-card>
    </div>

  </div>

</template>

<script setup>

import { ref, watch } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter } from 'vue-router'

const token = localStorage.getItem('admin_token_uuid')
const router = useRouter()
const rows = ref([])
const data = ref([])
const search = ref('')

const columns = [
  {
    name: 'title',
    label: 'Title',
    align: 'left',
    field: 'title'
  },
  {
    name: 'quantity',
    label: 'Quantity',
    field: 'quantity'
  },
  {
    name: 'price',
    label: 'Price',
    field: 'price'
  },
  {
    name: 'totalPrice',
    label: 'Total Price',
    field: 'totalPrice'
  },
  {
    name: 'delete',
    label: 'Delete',
    field: 'delete'
  }
]

function allTotalPrice () {
  const cartItem = JSON.parse(localStorage.getItem('cartItem')) || []
  let totalPrice = 0
  for (const item of cartItem) {
    totalPrice += item.totalPrice
  }
  return totalPrice
}
function minus (index) {
  if (index.quantity > 0) {
    index.quantity -= 1
    calculatePrice(index)
  } else {
    index.quantity = 0
  }
}

function plus (index) {
  index.quantity += 1
  calculatePrice(index)
}

function calculatePrice (index) {
  index.totalPrice = index.quantity * index.price
}
// Function buat nanti ambil data buat masuk orderItem
// function submit () {
//   api.get('Checker', {
//     token
//   }).then((response) => {
//     console.log('response axios', response)
//     console.log(response.data.success)

//     const cartItem = JSON.parse(localStorage.getItem('cartItem')) || []

//     api.post('insertOrder', {
//       cartItem: JSON.stringify(cartItem)
//     }).then((response) => {
//       console.log(response.data.message)
//       localStorage.removeItem('cartItem')
//       loadDataFromLocalStorage()
//     })
//   }).catch((error) => {
//     console.error(error.data)
//   })
// }

function submit () {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)

    api.post('insertOrder', {
      allTotalPrice: allTotalPrice()
    }).then((response) => {
      console.log(response.data.message)
      loadDataFromLocalStorage()
    })
  }).catch((error) => {
    console.error(error.data)
  })
}
function canceling () {
  router.push({ name: 'OrderPage' })
}

function AddToCart (index) {
  const item = {
    title: index.product.title,
    quantity: index.quantity,
    price: index.product.price,
    totalPrice: index.totalPrice
  }
  calculatePrice(item)

  const cartItem = JSON.parse(localStorage.getItem('cartItem')) || []

  cartItem.push(item)
  localStorage.setItem('cartItem', JSON.stringify(cartItem))

  loadDataFromLocalStorage()
}

function loadDataFromLocalStorage () {
  const storeData = JSON.parse(localStorage.getItem('cartItem')) || []
  rows.value = storeData
}

loadDataFromLocalStorage()

function deleteOrder (index) {
  const cartItem = JSON.parse(localStorage.getItem('cartItem')) || []
  cartItem.splice(index, 1)
  localStorage.setItem('cartItem', JSON.stringify(cartItem))
  loadDataFromLocalStorage()
}

function getProduct () {
  api.get('getProductData', {
    token
  }).then((response) => {
    data.value = response.data
  }).catch((error) => {
    console.error(error)
  })
}

getProduct()

function searchData () {
  api.get('SearchOrder/' + search.value, {
  }).then((response) => {
    data.value = response.data
  })
}

watch(search, () => {
  searchData()
})

</script>
