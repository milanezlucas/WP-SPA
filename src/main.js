import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);
Vue.use(require('vue-resource'));

import App from './App.vue'
import ThemeHeader from './components/theme-header.vue'
import Page from './components/Page.vue'
import Post from './components/Post.vue'

Vue.component('theme-header', ThemeHeader)

var routes = [
  {
    path: wp.base_path,
    name: 'home',
    component: App
  }
];
for (var key in wp.routes) {
  var route     = wp.routes[key];
  routes.push({
    path: wp.base_path + route.slug,
    name: route.slug,
    component: getComponent(route.type)
  });
}

const router = new VueRouter({
  mode: 'history',
  routes: routes
});

const app = new Vue({
  router
}).$mount('#app')

function capitalize(string) {
  return string.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function getComponent(type) {
  switch (type) {
    case 'page':
      return Page;
      break;
    case 'post':
      return Post;
      break;
  }
}