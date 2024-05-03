const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/LoginPage.vue') },
      { path: 'Home', name: 'HomePage', component: () => import('pages/HomePage.vue') },
      { path: 'Insert', component: () => import('pages/InsertPage.vue') },
      { path: 'Update/:productId', name: 'UpdatePage', component: () => import('pages/UpdatePage.vue') },
      { path: 'Image/:productId', name: 'ImageProductPage', component: () => import('pages/ImageProdcutPage.vue') },
      { path: 'InsertImage/:productId/insert', name: 'InsertImageProductPage', component: () => import('pages/InsertImageProductPage.vue') }

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
