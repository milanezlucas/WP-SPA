<template>
    <ul>
        <li>
            <router-link :to="{ path: '/vue/wp/'}"> HOME </router-link>
        </li>
        <li v-for="menu in menus">
            <router-link :to="{ path: base_path + menu.url }"> {{ menu.title }} </router-link>
        </li>
    </ul>
</template>
<script>
export default {
    data() {
        return {
            menus: this.getMenu(),
            base_path: wp.base_path
        }
    },
    methods: {
        getMenu: function () {
            this.$http.get(wp.base_url + '/api/menu/menu-header')
            .then(function(response) {
                this.menus = response.data.data;
            })
            .catch(function (response) { console.log(response) });
        }
    }
}
</script>
