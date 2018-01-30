<template>
  <h1>Post</h1>
</template>

<script>
export default {
  name: 'post',
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
      
      vm.pageTitle = 'Post Exemplo';
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

