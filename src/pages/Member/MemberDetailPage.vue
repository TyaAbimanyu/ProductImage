<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Member Detail Page</H4>

    <div class="row text-subtitle-1 q-gutter-x-sm items-center q-my-lg q-ma-xl">
      <nav>
        <router-link class="text-blue-9 hover-color"  :to="({ name: 'MemberPage' })">Member</router-link>
      </nav>
      <q-icon name="navigate_next"></q-icon>
      <nav>
        <router-link class="text-black hover-color">Detail</router-link>
      </nav>
    </div>

    <div class="q-ma-xl">
      <h6 class="row">Email :
        <p class="q-mx-xl">{{ emailMember }}</p>
      </h6>
      <h6 class="row">Name :
        <p class="q-mx-xl">{{ nameMember }}</p>
      </h6>
      <h6 class="row">Phone :
        <p class="q-mx-xl">{{ phoneMember }}</p>
      </h6>
      <!-- Status Yang Ga Tau Apaan T_T -->
      <h6 class="row">Status :
        <p class="q-mx-xl">{{ status }}</p>
      </h6>
    </div>

    <div>
      <h6  class="q-mx-xl">Member Order</h6>
      <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
      style="max-width: 90%"
      class="q-mx-auto"
      >
      <template v-slot:body-cell-action="props">
        <q-btn-dropdown
        class="q-ml-xl"
        filled
        type="submit"
         color="green"
         style="max-width: 70%">
        <q-list>
          <q-item clickable v-close-popup @click="detail(props.row)">
            <q-item-section>
              <q-item-label>Detail</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable v-close-popup @click="payment(props.row)">
            <q-item-section>
              <q-item-label>Payment Confirmation</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable v-close-popup @click="deleteData(props.row)">
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
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const rows = ref([])
const route = useRoute()
const paramData = ref(route.params.memberId)
const emailMember = ref('')
const nameMember = ref('')
const phoneMember = ref('')
const status = ref('')

const columns = [
  {
    name: 'orderNumber',
    label: 'Order Number',
    align: 'left',
    field: 'orderNumber'
  },
  {
    name: 'dateTime',
    label: 'Date Time',
    field: row => row.dateTime.date
  },
  {
    name: 'totalPrice',
    label: 'Total Price',
    field: 'totalPrice'
  },
  {
    name: 'status',
    label: 'Status',
    field: 'status'
  },
  {
    name: 'action',
    label: 'Actions',
    field: 'action'
  }
]

const token = localStorage.getItem('admin_token_uuid')
function getMemberData () {
  api.get('Checker', { token })
    .then(response => {
      console.log('response axios', response)
      return api.get('member/getMemberDetailData/' + paramData.value)
    })
    .then(response => {
      const memberDetail = response.data.memberData
      emailMember.value = memberDetail.emailMember
      nameMember.value = memberDetail.nameMember
      phoneMember.value = memberDetail.phoneMember
      status.value = memberDetail.status

      return api.get('member/getMemberOrderData/' + paramData.value)
    })
    .then(response => {
      rows.value = response.data
    })
    .catch(error => {
      console.error(error)
    })
}
getMemberData()

function detail (data) {
  router.push({ name: '', params: { memberId: data.memberId } })
  console.log(data)
}

// Ngarah ke Payment Confirmation yang ada tablenya
function payment (data) {
  router.push({ name: 'OrderPayConfirm', params: { memberId: data.memberId, orderId: data.orderId } })
  console.log(data)
}

function deleteData (data) {
  api.delete('member/deleteMemberData/' + data.orderId, {

  }).then((response) => {
    getMemberData()
  }).catch((error) => {
    console.log(error)
  })
}

// function status (data) {
//   api.put('', {
//     memberId: data.memberId,
//     show: !data.show
//   }).then((response) => {
//     console.log(response.data)
//     getMenu()
//   }).catch((error) => {
//     console.error(error.data)
//   })
// }

</script>
