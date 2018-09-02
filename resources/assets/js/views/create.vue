<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="8" xl="8" style="text-align:left;margin: auto;color:black;background:white">
		<div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
		<h1 class="title_text" style="margin-top:-20px">подать объявление</h1>
		<hr>
		
			<b-form @submit="onSubmit">
			<b-form-group label="Вид сделки:" label-for="default_group" style="width:270px;margin-top:-5px">
				 <b-form-radio-group id="deal_group" stacked v-model="form.deal_selected" :options="this.$root.options_sdelka" name="radioOpenions"></b-form-radio-group>
			</b-form-group>

			<b-form-group label="Категория товара или услуги:" label-for="categories" style="margin-top:30px;width:260px">
				<b-form-select v-model="form.category" class="mb-3" @change="changeCategory">
					 <option :value=null>-- Выберите категорию --</option>
					 <option v-for="item in items" :value="item.id">{{item.name}}</option>
				</b-form-select>
			</b-form-group>
			
			<!-- КАТЕГОРИИ -->

			<!-- null категория -->
			<div v-if="root"></div>

			<!-- транспорт -->
			<transport v-else-if="transport"/>

			<!-- недвижимость -->
			<realestate v-else-if="real_estate"/>

			<!-- бытовая техника -->
			<h1 v-else-if="appliances"></h1>

			<!-- работа и бизнес -->
			<h1 v-else-if="work_and_buisness"></h1>

			<!-- для дома и дачи -->
			<h1 v-else-if="for_home"></h1>

			<!-- для дома и дачи -->
			<h1 v-else-if="personal_effects"></h1>

			<!-- животные -->
			<h1 v-else-if="animals"></h1>

			<!-- хобби и отдых -->
			<h1 v-else-if="hobbies_and_leisure"></h1>

			<!-- услуги -->
			<h1 v-else-if="services"></h1>

			<!-- услуги -->
			<h1 v-else-if="other"></h1>

			<b-form-group label="Дополнительная информация:" label-for="addit_info">
			 <b-form-textarea id="addit_info" v-model="form.text"
										placeholder="Укажите дополнительную информацию"
										:rows="4"
										:max-rows="4">
	 		 </b-form-textarea>
			</b-form-group>

			<!-- ЦЕНА -->
			<b-form-group label="Цена:" label-for="price">
			 	<b-form-input id="price" v-model="form.price" placeholder="Цена" style="width:150px;margin:auto;font-size:20px;text-align:center"></b-form-input>
			</b-form-group>

			<!-- ФОТОГРАФИИ -->
			<b-form-group label="Фотографии:">
				<b-img v-for="i,index in form.images" :src="i.src" width="105" height="105" :key="index" @click="deletePhoto(index)" class="image" />
				<b-form-file v-model="form.file" multiple accept="image/jpeg, image/png" class="mt-2" @change="loadImage"></b-form-file>
			</b-form-group>

			<!-- ОТМЕТИТЬ НА КАРТЕ -->
			<b-form-group label="Расположение:" style="text-align:right">
				<button>отметить на карте</button>
			</b-form-group>

			<!-- ПУБЛИКАЦИЯ -->
			<b-form-group style="text-align:center;margin:25px">
				<b-button type="onSubmit" variant="outline-primary">ОПУБЛИКОВАТЬ</b-button>
			</b-form-group>
			
		</b-form>
	</b-col>
	</b-row>
</b-container>
</template>
<script>

// импорт
import { post } from './../helpers/api'
import transport from '../components/chars/transport';
import realestate from '../components/chars/realestate';

var tmp_images_array=[];

export default {
	props: ["items"],
	data () {
    return 	{
		form: {
			deal_selected: 0,
			category: null,
			title: '',
			text: '',
			price: '',
			file: null,
			images:[]
		},
		root:false,
		transport:false,			// транспорт
		real_estate:false,			// недвижимость
		appliances:false,			// бытовая техника
		work_and_buisness:false,	// работа и бизнес
		for_home:false,				// для дома и дачи
		personal_effects:false,		// личные вещи
		animals:false,				// животные
		hobbies_and_leisure:false,	// хобби и отдых
		services:false,				// услуги
		other:false					// другое
	}
	},
	created() {
		//alert(store.commit("getUserName"));
	},
	components: { transport, realestate },
  	methods: {
  		loadImage(evt) {

  			var files = evt.target.files;;

        	for (var i=0; i<files.length; i++) {

        		if ( i>=this.$root.max_load_images  || this.form.images.length>=this.$root.max_load_images ) break;

        		var image = files[i]
  				var reader = new FileReader();

  				reader.onload = (function(theFile) {
                return function(e) {
                	tmp_images_array.push({ "src": e.target.result });
                };
            })(image);

			reader.readAsDataURL(image);
				this.form.images = tmp_images_array;
        	}
  		},
  		deletePhoto(index) {
  			this.form.images.splice(index, 1);
  		},
  		closeAndReturn() {
 			window.history.back();
  		},

  		// сброс данных при выборе категории
  		resetCategories(data) {
  			this.root=false;				// по умолчанию
  			this.transport=false;			// транспорт
  			this.real_estate=false;			// недвижимость
  			this.appliances=false;			// бытовая техника
  			this.work_and_buisness=false; 	// работа и бизнес
  			this.for_home=false;			// для дома и дачи
  			this.personal_effects=false;	// личные вещи
			this.animals=false;				// животные
			this.hobbies_and_leisure=false;	// хобби и отдых
			this.services=false;			// услуги
			this.other=false;				// другое 	
  		},
  		
  		/*
  		--------------------------
  		изменения в категориях
  		--------------------------*/
  		changeCategory(data) {
  			switch(data) {
  				case null: {
  					this.resetCategories(data); 
  					this.root=true; 
  					break;
  				}
  				case 1: { 
  					this.resetCategories(data); 
  					this.transport=true; 
  					break; 
  				} 
  				case 2: { 
  					this.resetCategories(data); 
  					this.real_estate=true; 
  					break; 
  				}
  				case 3: { 
  					this.resetCategories(data); 
  					this.appliances=true; 
  					break; 
  				}
  				case 4: { 
  					this.resetCategories(data); 
  					this.work_and_buisness=true; 
  					break; 
  				}
  				case 5: { 
  					this.resetCategories(data); 
  					this.for_home=true; 
  					break; 
  				}
  				case 6: { 
  					this.resetCategories(data); 
  					this.personal_effects=true; 
  					break; 
  				}
  				case 7: { 
  					this.resetCategories(data); 
  					this.animals=true; 
  					break; 
  				}
  				case 8: { 
  					this.resetCategories(data); 
  					this.hobbies_and_leisure=true; 
  					break; 
  				}
  				case 9: { 
  					this.resetCategories(data); 
  					this.services=true; 
  					break; 
  				}
  				case 10: { 
  					this.resetCategories(data); 
  					this.other=true; 
  					break; 
  				}

  			}
  		},
    	onSubmit(evt) {
    		evt.preventDefault();
    		post('/create', { "data": this.form }).then((res) => {
    			window.location.href = "/home/555";
			}).catch((err) => {});
    	}
}
}
</script>
