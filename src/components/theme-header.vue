<template>
    <ul>
        <li v-for="menu in menus">
            <router-link :to="{ path: menu.url}"> {{ menu.title }} </router-link>
        </li>
    </ul>
</template>
<script>
export default {
    data() {
        return {
            menus: this.getMenu()
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
