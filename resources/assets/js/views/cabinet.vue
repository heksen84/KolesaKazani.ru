<template>
<div>
<b-navbar toggleable="md" variant="light">
  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
  	<b-navbar-nav>
      <b-nav-item href="#" @click="goHome"><b>Назад</b></b-nav-item>
  	</b-navbar-nav>
  
	<b-collapse is-nav id="nav_collapse">
    <b-navbar-nav class="ml-auto">
      <b-nav-item href="#" @click="createAdvert"><b-button size="sm">Разместить объявление</b-button></b-nav-item>
      <b-nav-item href="#" @click="logout"><b-button variant="primary" size="sm">Выйти</b-button></b-nav-item>
    </b-navbar-nav>
  </b-collapse>
	
</b-navbar>
	<b-container>
	<br>
	<b-row>
		<b-col>
			<h5 class="shadow_text" style="text-align:left">мои объявления</h5>
			<b-table hover :items="_items" style="background:white;color:black">

			<template slot="Действие">
        <b-button size="sm" variant="outline-success" @click="goUp">поднять в вверх</b-button>
				<b-button size="sm" variant="link" @click="deleteAdvert">удалить</b-button>
      </template>

			</b-table>
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
		
		for (var i=0;i<this._items.length;i++)			
			this._items[i].Действие = "";		
},
components: {},
  methods: {

		goUp() {
			alert("Поднять вверх")
		},
		deleteAdvert() {
			alert("Удалить объявление")
		},


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
    	window.location='/podat-obyavlenie';
    }
}
}
</script>