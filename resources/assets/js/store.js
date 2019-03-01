import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		urlGlobal: '',
		condicionUrl: false,
		filter: '',
		sidebarRol: ''
	}
});

//para llamarlo es: this.$store.state.data