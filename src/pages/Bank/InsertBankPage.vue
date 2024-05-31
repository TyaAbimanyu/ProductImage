<template>
  <div>
    <h3 style="text-align: center;">Bank Insert / Update Page</h3>
    <q-form @submit="Insert" class="q-gutter-md q-mx-auto" style="max-width: 50%">
      <q-input rounded standout v-model="bankName" label="Bank Name"/>
      <q-input rounded standout v-model="accountName" label="Account Name"/>
      <q-input rounded standout v-model="accountNumber" label="Account Number"/>
      <p></p>
    </q-form>
    <div class="text-center" style="max-width: 60%">
      <p>Show/Hide</p>
      <q-radio v-model="shape" val="hide" label="Hide"/>
      <q-radio v-model="shape" val="show" label="Show"/>
    </div>
    <div class="text-center">
      <q-btn rounded standout type="submit" label="Submit" color="primary" @click="Insert()"/>
      <q-btn rounded standout type="submit" label="Cancel" color="primary" @click.prevent="router.push({name:'BankPage'})"/>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter } from 'vue-router'

const accountName = ref('')
const bankName = ref('')
const accountNumber = ref('')
const shape = ref('')
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
  api.post('bank/insertBankData', {
    bankName: bankName.value,
    accountName: accountName.value,
    accountNumber: accountNumber.value,
    shape: shape.value
  }).then((response) => {
    console.log(response.data)
    router.push({ name: 'BankPage' })
  }).catch((error) => {
    console.error(error)
  })
}
</script>
