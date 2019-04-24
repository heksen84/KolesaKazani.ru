<template>
<div>
<b-navbar toggleable="md" variant="light">
  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
  	<b-navbar-nav>
      <b-nav-item href="#" @click="goHome">Назад</b-nav-item>
  	</b-navbar-nav>
  
	<b-collapse is-nav id="nav_collapse">
    <b-navbar-nav class="ml-auto">
      <b-nav-item href="#" @click="createAdvert">Подать объявление</b-nav-item>
      <b-nav-item href="#" @click="logout">Выйти</b-nav-item>
    </b-navbar-nav>
  </b-collapse>
	
</b-navbar>
	<b-container>
	<br>
	<b-row>
		<b-col>
			<h5 class="shadow_text" style="text-align:left">мои объявления</h5>
			<b-table responsive hover small :fields="fields" :items="cloneItems" style="background:white;color:black">			
				
				<!--Статус: отклонено (нецензурная лексика)
			
        <b-button size="sm" variant="outline-success" @click="advertGoUp">поднять в вверх</b-button>
				<b-button size="sm" variant="link" @click="advertDelete">удалить</b-button>      -->

			<template slot="Действие" slot-scope="row">
        <b-button variant="success" @click="row.toggleDetails">Дополнительно</b-button>
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
	
props: ["items"], // Входящие данные

// данные компонента
data () {
    return 	{
			cloneItems: [],
			sortBy: "text",
			fields: [				
				{ key: "text", sortable: true },
        { key: "Действие", sortable: false }
			]								
	}
},

// компонент создан
created() {		
		this.cloneItems = this.items;
		console.log(this.cloneItems)
},

// методы
methods: {
	// ---------------------------------
	// поднять объявление в верх
	// ---------------------------------
	advertGoUp() {		

		get("/advertGoUp").then((res) => {
			}).catch((err) => {
				console.log(err)
		});
	},
		
	// ---------------------------------
	// удалить объявление
	// ---------------------------------
	advertDelete() {			

		get("/advertDelete").then((res) => {				
			}).catch((err) => {
				console.log(err)
		});
	},

		// ---------------------------------
		// Выйти из кабинета
		// ---------------------------------
  logout() {

		get('/logout').then((res) => {
			window.location='/';
		}).catch((err) => {
			console.log(err)
		});
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