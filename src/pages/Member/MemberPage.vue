<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Member Page</H4>
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

          <q-item clickable v-close-popup @click="status(props.row)">
            <q-item-section>
              <q-item-label>Show/Hide</q-item-label>
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

const router = useRouter()
const rows = ref([])

const columns = [
  {
    name: 'email',
    label: 'Email',
    align: 'left',
    field: 'email'
  },
  {
    name: 'name',
    label: 'Name',
    field: 'name'
  },
  {
    name: 'numberPhone',
    label: 'Phone',
    field: 'numberPhone'
  },
  {
    name: 'status',
    label: 'Show / Hide',
    field: 'status'
  },
  {
    name: 'action',
    label: 'Actions',
    field: 'action'
  }
]

const token = localStorage.getItem('admin_token_uuid')

function getMenu () {
  api.get('Checker', {
    token
  }).then((response) => {
    console.log('response axios', response)
    console.log(response.data.success)
    api.get('member/getMemberData', {

    }).then((response) => {
      rows.value = response.data
    })
  }).catch((error) => {
    console.error(error.data)
  })
}
getMenu()

function detail (data) {
  router.push({ name: 'MemberDetailPage', params: { memberId: data.memberId } })
  console.log(data)
}

function status (data) {
  api.put('member/updateStatusMember', {
    memberId: data.memberId,
    show: !data.show
  }).then((response) => {
    console.log(response.data)
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}

</script>
