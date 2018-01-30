<template>
	<p>Home</p>
</template>

<script>
export default {
	name: 'app',
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
      
      vm.pageTitle = 'Home';
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