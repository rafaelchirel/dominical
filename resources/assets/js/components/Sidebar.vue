<template>
	<div>
		<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul v-if="isRol" class="nav" id="main-menu">
                    <li>
                        <router-link to="/miembros"><i class="fas fa-users"></i> Miembros</router-link>
                    </li>
                    <li>
                        <router-link to="/grupos"><i class="fas fa-users-cog"></i> Grupos</router-link>
                    </li>
                    <li>
                        <router-link to="/clases"><i class="fab fa-accusoft"></i> Clases</router-link>
                    </li>
                    <li>
                        <router-link to="/perfil"><i class="fas fa-male"></i> Perfil</router-link>
                    </li>
                    <li>
                        <router-link to="/usuarios"><i class="fas fa-chalkboard-teacher"></i> Usuarios</router-link>
                    </li>
                    <li>
                        <router-link to="/respaldo"><i class="fas fa-coins"></i> Respaldo</router-link>
                    </li>

                    <!--
                    <li>
                        <a href="#"><i class="fa fa-desktop "></i>Bancos<span class="fa arrow"></span></a>
                        <router-link to="/transferencias"><i class="fa fa-desktop"></i>transferencias<span class="fa arrow"></span></router-link>
                        
                         <ul class="nav nav-second-level">
                            <li>
                                <router-link to="/transferencias"><i class="fa fa-toggle-on"></i>Registrar</router-link>
                            </li>
                            <li>
                                <a href="panel-tabs.html"><i class="fa fa-toggle-on"></i>En Espera</a>
                            </li>
                            <li>
                                <a href="notification.html"><i class="fa fa-bell "></i>Procesadas</a>
                            </li>
                             <li>
                                <a href="progress.html"><i class="fa fa-circle-o "></i>Rechazadas</a>
                            </li>
                            
                             <li>
                                <a href="buttons.html"><i class="fa fa-code "></i>Buttons</a>
                            </li>
                             <li>
                                <a href="icons.html"><i class="fa fa-bug "></i>Icons</a>
                            </li>
                             <li>
                                <a href="wizard.html"><i class="fa fa-bug "></i>Wizard</a>
                            </li>
                             <li>
                                <a href="typography.html"><i class="fa fa-edit "></i>Typography</a>
                            </li>
                             <li>
                                <a href="grid.html"><i class="fa fa-eyedropper "></i>Grid</a>
                            </li>
                            
                        </ul>
                        
                    </li>
                    -->

                    <!--
                     <li>
                        <a href="#"><i class="fa fa-yelp "></i>Titulares<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="invoice.html"><i class="fa fa-coffee"></i>Invoice</a>
                            </li>
                            <li>
                                <a href="pricing.html"><i class="fa fa-flash "></i>Pricing</a>
                            </li>
                             <li>
                                <a href="component.html"><i class="fa fa-key "></i>Components</a>
                            </li>
                             <li>
                                <a href="social.html"><i class="fa fa-send "></i>Social</a>
                            </li>
                            
                             <li>
                                <a href="message-task.html"><i class="fa fa-recycle "></i>Messages & Tasks</a>
                            </li>
                        </ul>
                    </li>
                    -->

                    <!--
                    <li>
                        <a href="table.html"><i class="fa fa-flash "></i>Data Tables </a>
                    </li>
                     <li>
                        <a href="#"><i class="fa fa-bicycle "></i>Forms <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                           
                             <li>
                                <a href="form.html"><i class="fa fa-desktop "></i>Basic </a>
                            </li>
                             <li>
                                <a href="form-advance.html"><i class="fa fa-code "></i>Advance</a>
                            </li>
                        </ul>
                    </li>
                      <li>
                        <a href="gallery.html"><i class="fa fa-anchor "></i>Gallery</a>
                    </li>
                     <li>
                        <a href="error.html"><i class="fa fa-bug "></i>Error Page</a>
                    </li>
                    <li>
                        <a href="login.html"><i class="fa fa-sign-in "></i>Login Page</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap "></i>Multilevel Link <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-bicycle "></i>Second Level Link</a>
                            </li>
                             <li>
                                <a href="#"><i class="fa fa-flask "></i>Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#"><i class="fa fa-plus "></i>Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-comments-o "></i>Third Level Link</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="blank.html"><i class="fa fa-square-o "></i>Blank Page</a>
                    </li>
                    -->
                </ul>
                 <ul v-else="" class="nav" id="main-menu">
                    <li>
                        <router-link to="/miembros"><i class="fas fa-users"></i> Miembros</router-link>
                    </li>
                    <li>
                        <router-link to="/grupos"><i class="fas fa-users-cog"></i> Grupos</router-link>
                    </li>
                    <li>
                        <router-link to="/clases"><i class="fas fa-align-center"></i> Clases</router-link>
                    </li>
                    <li>
                        <router-link to="/perfil"><i class="fas fa-male"></i> Perfil</router-link>
                    </li>
                    <!--
                    <li>
                        <router-link to="/">Ofrenda</router-link>
                    </li>
                    -->
                    <!--
                    <li>
                        <router-link to="/usuarios"><i class="fa fa-square-o"></i> Usuarios</router-link>
                    </li>
                    <li>
                        <router-link to="/"><i class="fa fa-square-o"></i> Bitacora</router-link>
                    </li>
                    <li>
                        <router-link to="/"><i class="fa fa-square-o"></i> Respaldo</router-link>
                    </li>

                    
                    <li>
                        <a href="#"><i class="fa fa-desktop "></i>Bancos<span class="fa arrow"></span></a>
                        <router-link to="/transferencias"><i class="fa fa-desktop"></i>transferencias<span class="fa arrow"></span></router-link>
                        
                         <ul class="nav nav-second-level">
                            <li>
                                <router-link to="/transferencias"><i class="fa fa-toggle-on"></i>Registrar</router-link>
                            </li>
                            <li>
                                <a href="panel-tabs.html"><i class="fa fa-toggle-on"></i>En Espera</a>
                            </li>
                            <li>
                                <a href="notification.html"><i class="fa fa-bell "></i>Procesadas</a>
                            </li>
                             <li>
                                <a href="progress.html"><i class="fa fa-circle-o "></i>Rechazadas</a>
                            </li>
                            
                             <li>
                                <a href="buttons.html"><i class="fa fa-code "></i>Buttons</a>
                            </li>
                             <li>
                                <a href="icons.html"><i class="fa fa-bug "></i>Icons</a>
                            </li>
                             <li>
                                <a href="wizard.html"><i class="fa fa-bug "></i>Wizard</a>
                            </li>
                             <li>
                                <a href="typography.html"><i class="fa fa-edit "></i>Typography</a>
                            </li>
                             <li>
                                <a href="grid.html"><i class="fa fa-eyedropper "></i>Grid</a>
                            </li>
                            
                        </ul>
                        
                    </li>
                    -->

                    <!--
                     <li>
                        <a href="#"><i class="fa fa-yelp "></i>Titulares<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="invoice.html"><i class="fa fa-coffee"></i>Invoice</a>
                            </li>
                            <li>
                                <a href="pricing.html"><i class="fa fa-flash "></i>Pricing</a>
                            </li>
                             <li>
                                <a href="component.html"><i class="fa fa-key "></i>Components</a>
                            </li>
                             <li>
                                <a href="social.html"><i class="fa fa-send "></i>Social</a>
                            </li>
                            
                             <li>
                                <a href="message-task.html"><i class="fa fa-recycle "></i>Messages & Tasks</a>
                            </li>
                        </ul>
                    </li>
                    -->

                    <!--
                    <li>
                        <a href="table.html"><i class="fa fa-flash "></i>Data Tables </a>
                    </li>
                     <li>
                        <a href="#"><i class="fa fa-bicycle "></i>Forms <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                           
                             <li>
                                <a href="form.html"><i class="fa fa-desktop "></i>Basic </a>
                            </li>
                             <li>
                                <a href="form-advance.html"><i class="fa fa-code "></i>Advance</a>
                            </li>
                        </ul>
                    </li>
                      <li>
                        <a href="gallery.html"><i class="fa fa-anchor "></i>Gallery</a>
                    </li>
                     <li>
                        <a href="error.html"><i class="fa fa-bug "></i>Error Page</a>
                    </li>
                    <li>
                        <a href="login.html"><i class="fa fa-sign-in "></i>Login Page</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap "></i>Multilevel Link <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-bicycle "></i>Second Level Link</a>
                            </li>
                             <li>
                                <a href="#"><i class="fa fa-flask "></i>Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#"><i class="fa fa-plus "></i>Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-comments-o "></i>Third Level Link</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="blank.html"><i class="fa fa-square-o "></i>Blank Page</a>
                    </li>
                    -->
                </ul>
            </div>
    </nav>
	</div>
</template>

<script>
    //Librerias
    import axios from 'axios'

    //Components
    import Const from './Const'

    export default {
        mounted() {
            this.getURol()
        },
        data () {
            return {
                rol: null
            }
        },
        methods: {
            getURol: function () {
              var urlApiURL = Const.apiURL + '/usuario/consultarrol'
              axios.post(urlApiURL).then(response => {
                this.$store.state.sidebarRol = response.data.rol
              });
            }
        },
        computed: {
            isRol: function () {
                return this.$store.state.sidebarRol
            }
        }
    }
</script>

<style lang="css">

</style>