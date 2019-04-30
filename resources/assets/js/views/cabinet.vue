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
			<template slot="text" slot-scope="data">				
				<div style="overflow:hidden;text-overflow:ellipsis;font-weight:505">{{ data.value }}</div>        
				<div style="font-size:91%;margin-top:5px">
					<span class="link" style="color:green">(в топ)</span>
					<span class="link" style="color:blue">(поднять в вверх)</span>
					<span class="link" style="color:red">(удалить)</span>					
				</div>
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
				{ key: "text", sortable: true }
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