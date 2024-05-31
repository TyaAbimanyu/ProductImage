const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/LoginPage.vue') },
      {
        path: 'Head',
        component: () => import('layouts/HeadLayout.vue'),
        children: [
          { path: '', name: 'HomePage', component: () => import('pages/HomePage.vue') },
          {
            path: 'Bank',
            component: () => import('layouts/BankLayout.vue'),
            children: [
              { path: '', name: 'BankPage', component: () => import('pages/Bank/BankPage.vue') },
              { path: 'InsertBank', name: 'InsertBankPage', component: () => import('pages/Bank/InsertBankPage.vue') },
              { path: 'UpdateBank/:bankId', name: 'UpdateBankPage', component: () => import('pages/Bank/UpdateBankPage.vue') }

            ]
          },
          {
            path: 'Member',
            component: () => import('layouts/MemberLayout.vue'),
            children: [
              { path: '', name: 'MemberPage', component: () => import('pages/Member/MemberPage.vue') },
              { path: 'MemberDetail/:memberId', name: 'MemberDetailPage', component: () => import('pages/Member/MemberDetailPage.vue') }
            ]
          },
          {
            path: 'Product',
            component: () => import('layouts/ProductLayout.vue'),
            children: [
              { path: '', name: 'ProductPage', component: () => import('pages/ProductPage.vue') },
              { path: 'Insert', component: () => import('pages/InsertPage.vue') },
              { path: 'Update/:productId', name: 'UpdatePage', component: () => import('pages/UpdatePage.vue') },
              { path: 'Image/:productId', name: 'ImageProductPage', component: () => import('pages/ImageProdcutPage.vue') },
              { path: 'InsertImage/:productId/insert', name: 'InsertImageProductPage', component: () => import('pages/InsertImageProductPage.vue') }

            ]
          },
          {
            path: 'Order',
            component: () => import('layouts/ProductLayout.vue'),
            children: [
              { path: '', name: 'OrderPage', component: () => import('pages/OrderPage.vue') },
              { path: 'OrderInsert', name: 'OrderInsert', component: () => import('pages/OrderInsertPage.vue') },
              { path: 'PaymentConfirmation/:memberId/:orderId', name: 'OrderPayConfirm', component: () => import('pages/Order/OrderPaymentConfirmationPage.vue') },
              { path: 'PaymentConfirmationDetail/:memberId/:orderId/:paymentId', name: 'OrderPayConfirmDetail', component: () => import('pages/Order/OrderPaymentConfirmationDetaiPage.vue') }
            ]
          }
        ]
      }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
