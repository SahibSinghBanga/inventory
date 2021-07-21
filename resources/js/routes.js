// Auth Routes
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let home = require('./components/home.vue').default;
let logout = require('./components/auth/logout.vue').default;

// Employee Routes
let employee = require('./components/employee/index.vue').default;
let storeEmployee = require('./components/employee/create.vue').default;
let editEmployee = require('./components/employee/edit.vue').default;

// Supplier Routes
let supplier = require('./components/supplier/index.vue').default;
let storeSupplier = require('./components/supplier/create.vue').default;
let editSupplier = require('./components/supplier/edit.vue').default;

// Category Routes
let category = require('./components/category/index.vue').default;
let storeCategory = require('./components/category/create.vue').default;
let editCategory = require('./components/category/edit.vue').default;

export const routes = [
  { path: '/', component: login, name: '/' },
  { path: '/register', component: register, name: 'register' },
  { path: '/forget', component: forget, name: 'forget' },
  { path: '/home', component: home, name: 'home' },
  { path: '/logout', component: logout, name: 'logout' },

  { path: '/employee', component: employee, name: 'employee' },
  { path: '/store-employee', component: storeEmployee, name: 'store-employee' },
  { path: '/edit-employee/:id', component: editEmployee, name: 'edit-employee' },

  { path: '/supplier', component: supplier, name: 'supplier' },
  { path: '/store-supplier', component: storeSupplier, name: 'store-supplier' },
  { path: '/edit-supplier/:id', component: editSupplier, name: 'edit-supplier' },

  { path: '/category', component: category, name: 'category' },
  { path: '/store-category', component: storeCategory, name: 'store-category' },
  { path: '/edit-category/:id', component: editCategory, name: 'edit-category' },
]
