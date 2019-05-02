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

			<b-table responsive hover small :items="cloneItems" :fields="fields" style="background:white;color:black">

			<template slot="text" slot-scope="row">
				<div style="margin-left:10px">				
				<span style="font-size:90%;text-decoration:underline">Объявление № {{ row.item.id }}</span>
				<div style="margin-top:2px;font-weight:600;color:rgb(70,70,70);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;word-wrap:break-all">{{ row.value }}</div>        
				<div style="font-size:95%;margin-top:5px">
					<span class="link" style="color:green" @click="advertGoTop(row.item.id)">в топ</span> |
					<span class="link" style="color:blue" @click="advertGoUp(row.item.id)">поднять в вверх</span> |
					<span class="link" style="color:blue" @click="advertGoUp(row.item.id)">продлить</span> |
					<span class="link" style="color:red" @click="advertDelete(row.item.id)">удалить</span>
				</div>
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
			fields: ["text"]
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
	// Поднять объявление в топ
	// ---------------------------------
	advertGoTop(advert_id) {

		console.log(advert_id)

		get("/advertGoTop?id="+advert_id).then((res) => {
			}).catch((err) => {
				console.log(err)
		});
	},
	
	// ---------------------------------
	// Поднять объявление в вверх
	// ---------------------------------
	advertGoUp(advert_id) {

		console.log(advert_id)

		get("/advertGoUp?id="+advert_id).then((res) => {
			}).catch((err) => {
				console.log(err)
		});
	},
		
	// ---------------------------------
	// Удалить объявление
	// ---------------------------------
	advertDelete(advert_id) {
		
		if (!confirm("Удалить объявление?"))
			return;		

		console.log(advert_id)

		get("/deleteAdvert?id="+advert_id).then((res) => {

			this.cloneItems = res.data;

		}).catch((err) => {
				console.log(err)
		});
	},

	// ---------------------------------
	// Выйти из кабинета
	// ---------------------------------
  logout() {
		get("/logout").then((res) => {
			window.location = "/";
		}).catch((err) => {
			console.log(err)
		});
  },

	// ---------------------------------
	// На домашнюю страницу
	// ---------------------------------
  goHome() {
    window.location = "/";
	},
		
	// ---------------------------------
	// Новое объявление
	// ---------------------------------
	createAdvert() {
    window.location="/podat-obyavlenie";
	}
}
}
</script>