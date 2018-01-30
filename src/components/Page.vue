<template>
    <p>page</p>
</template>

<script>
export default {
  name: 'page',
  mounted: function() {
		this.getPage();
  },
  data() {
		return {
			page: {},
			loaded: 'false',
			pageTitle: ''
		}
  },
  methods: {
		getPage: function() {
			const vm = this;
      vm.loaded = 'true';
      
      vm.pageTitle = 'Pagina Exemplo';
			vm.$store.commit( 'changeTitle', vm.pageTitle );
		}
	},
	watch: {
		'$route'( to, from ) {
			// react to route changes...
			this.getPage();
		}
	}
}
</script>

