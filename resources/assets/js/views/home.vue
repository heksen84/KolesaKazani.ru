<template>
<div>
<b-navbar toggleable="md" variant="light">

  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

  <b-collapse is-nav id="nav_collapse">

    <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">
      <b-nav-item href="#" @click="createAdvert">Разместить объявление</b-nav-item>
      <b-nav-item href="#" @click="goHome">Назад</b-nav-item>
      <b-nav-item href="#" @click="logout">Выйти</b-nav-item>
    </b-navbar-nav>

  </b-collapse>
</b-navbar>

	<b-container fluid>
	<br>
	<b-row>
		<b-col cols="12" sm="12" md="8" lg="8" xl="8" style="text-align:center;margin:auto">
			<h4 class="shadow_text" style="text-align:left">мои объявления</h4>
			<b-table hover :items="items" style="background:white;color:black"></b-table>
		</b-col>
	</b-row>
</b-container>
</div>
</template>
<script>

import { get } from './../helpers/api'
export default {
	props: ["items"],
	data () {
    return 	{
    	items: items
	}
},
	created() {
},
components: {},
  methods: {
    logout() {
		get('/logout').then((res) => {
			window.location='/';
		}).catch((err) => {});
    },
    goHome() {
    	window.location='/';
    },
    createAdvert() {
    	window.location='/new';
    }
}
}
</script>
