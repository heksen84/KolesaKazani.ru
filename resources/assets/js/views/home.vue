<template>
<div>
<b-navbar toggleable="md" variant="light">
  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

  <!--<b-navbar-brand href="#" >/b-navbar-brand>-->

  	<b-navbar-nav>
      <b-nav-item href="#" @click="goHome"><b>Назад</b></b-nav-item>
  	</b-navbar-nav>

  <b-collapse is-nav id="nav_collapse">


    <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">
      <b-nav-item href="#" @click="createAdvert"><b>Разместить объявление</b></b-nav-item>
      <b-nav-item href="#" @click="logout"><b><u>Выйти</u></b></b-nav-item>
    </b-navbar-nav>

  </b-collapse>
</b-navbar>
	<b-container fluid>
	<br>
	<b-row>
		<b-col cols="12" sm="12" md="8" lg="8" xl="8" style="text-align:center;margin:auto">
			<h5 class="shadow_text" style="text-align:left">мои объявления</h5>
			<b-table hover :items="_items" style="background:white;color:black"></b-table>
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
    	_items: []
	}
},
	created() {
		this._items = this.items;

		console.log(this._items );

		for (var i=0;i<this._items.length;i++) {
			this._items[i][""]="продлить";
			console.log(this._items[i]);
		}
		console.log(this._items);
},
components: {},
  methods: {

  	// ВЫХОД
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
