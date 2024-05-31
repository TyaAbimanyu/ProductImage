<template>
  <div class="q-pa=md">
    <H4 class="q-mx-xl">Bank Page</H4>
    <div class="text-right">
      <q-btn filled class="q-mx-xl q-mb-lg" type="submit" icon="add" label="Insert Bank" color="green" @click="submit()"/>
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
        class="q-ml-xl"
        filled
        type="submit"
         color="green"
         style="max-width: 70%">
        <q-list>
          <q-item clickable v-close-popup @click="detail(props.row)">
            <q-item-section>
              <q-item-label>Update</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable v-close-popup @click="status(props.row)">
            <q-item-section>
              <q-item-label>Show/Hide</q-item-label>
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

// const bankName = ref('')
// const accountName = ref('')
// const accountNumber = ref('')
// const status = ref('')
const router = useRouter()
const rows = ref([])

const columns = [
  {
    name: 'bankName',
    label: 'Bank Name',
    align: 'left',
    field: 'bankName'
  },
  {
    name: 'accountName',
    label: 'Account Name',
    field: 'accountName'
  },
  {
    name: 'accountNumber',
    label: 'Account Number',
    field: 'accountNumber'
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
    api.get('bank/getBankData', {
    }).then((response) => {
      rows.value = response.data
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
    router.push({ name: 'InsertBankPage' })
  }).catch((error) => {
    console.error(error.data)
  })
}

function detail (data) {
  router.push({ name: 'UpdateBankPage', params: { bankId: data.bankId } })
  console.log(data)
}

function status (data) {
  api.put('bank/updateStatusBank', {
    bankId: data.bankId,
    show: !data.show
  }).then((response) => {
    console.log(response.data)
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}

//  Buat Delete Data tapi nanti setelah insert dan get menu
function deleted (data) {
  api.delete('bank/deletedBank/' + data.bankId, {

  }).then(() => {
    getMenu()
  }).catch((error) => {
    console.error(error.data)
  })
}
</script>
