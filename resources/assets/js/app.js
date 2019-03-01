//
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//Librerias
import { store } from './store'
import VueRouter from 'vue-router'

//Importando mis componentes
	//Miembros
	import ListMiembro from './components/miembros/List'
	import CreateMiembro from './components/miembros/Create'
	import EditMiembro from './components/miembros/Edit'
	import DetalleMiembro from './components/miembros/Detalle'

	//Grupos
	import listGrupo from './components/grupos/List'
	import createGrupo from './components/grupos/Create'
	import detalleGrupo from './components/grupos/Detalle'
	import editGrupo from './components/grupos/Edit'

	//Clases
	import listClase from './components/clases/List'
	import createClase from './components/clases/Create'
	import asignarClase from './components/clases/Asignar'
	import editClase from './components/clases/Edit'

	//Usuarios
	import listUsuarios from './components/usuarios/list.vue'

	//Respaldo
	import listRespaldo from './components/respaldo/List'

	//Perfil
	import Perfil from './components/perfil/index.vue'

	//Sidebar
	import Sidebar from './components/Sidebar.vue'

//Logica Vue-Router
Vue.use(VueRouter);//Libreria router-vue

const routes = [//Libreria router-vue
	//Miembros
	{path: '/miembros', component: ListMiembro},
	{path: '/create-miembro', component: CreateMiembro},
	{path: '/edit-miembro/:id', name: 'editar-miembro', component: EditMiembro},
	{path: '/detalle-miembro/:id', name: 'detalle-miembro', component: DetalleMiembro},
	//{path: '/create-banco', component: CreateBanco},

	//Grupos
	{path: '/grupos', component: listGrupo},
	{path: '/create-grupo', component: createGrupo},
	{path: '/detalle-grupo/:id', name: 'detalle-grupo', component: detalleGrupo},
	{path: '/edit-grupo/:id', name: 'editar-grupo', component: editGrupo},

	//Clases
	{path: '/clases', component: listClase},
	{path: '/create-clase', component: createClase},
	{path: '/asignar-clase/:id', name: 'asignar-clase', component: asignarClase},
	{path: '/edit-clase/:id', name: 'editar-clase', component: editClase},

	//Usuarios
	{path: '/usuarios', component: listUsuarios},

	//Respaldo
	{path: '/respaldo', component: listRespaldo},

	//Perfil
	{path: '/perfil', component: Perfil},

	//transferencias
	//{path: '/transferencias', component: transferencias},
	//{path: '/create-transferencias', component: createTransferencias}
];

const router = new VueRouter({//Libreria router-vue
	routes,
	mode: 'abstract'
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    store,//vuex
    router, //Libreria router-vue
    components: {Sidebar}
});
