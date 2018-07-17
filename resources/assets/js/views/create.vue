<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="7" xl="7" style="text-align:left;margin: auto;color:black;background:white">
		<div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
		<h3 style="color:rgb(120,120,120);margin-top:-25px"><ins>новое объявление</ins></h3>
		<br>
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
			<div v-if="root"></div>
			<transport v-else-if="transport"/>
			<realestate v-else-if="real_estate"/>
			<h1 v-else-if="appliances"></h1>
			

			<b-form-group label="Дополнительная информация:" label-for="addit_info">
			 <b-form-textarea id="addit_info" v-model="form.text"
										placeholder="Наберите дополнительную информацию"
										:rows="3"
										:max-rows="3">
	 		 </b-form-textarea>
			</b-form-group>

			<!-- ЦЕНА -->
			<b-form-group label="Цена:" label-for="price">
			 	<b-form-input id="price" v-model="form.price" placeholder="Цена" style="width:150px;margin:auto;font-size:20px;text-align:center"></b-form-input>
			</b-form-group>

			<!-- ФОТОГРАФИИ -->
			<b-form-group label="Фотографии:">
				<b-img v-for="i,index in form.images" :src="i.src" width="105" height="105" :key="index" @click="deletePhoto(index)" class="image" />
				<b-form-file v-model="form.file" multiple accept="image/jpeg, image/png" class="mt-1" @change="loadImage"></b-form-file>
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
import transport from '../components/characteristics/transport';
import realestate from '../components/characteristics/real-estate';

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
		transport:false,
		real_estate:false,
		appliances:false
	}
	},
	created() {
	},
	components: { transport, realestate },
  	methods: {

  		loadImage(evt) {

  			var files = evt.target.files;;

        	for (var i=0; i<files.length; i++) {

        		if ( i>=this.$root.max_load_images  || this.form.images.length>=this.$root.max_load_images ) {
        			//alert("Не более "+this.$root.max_load_images+" изображений");
        			break;
        		}

        		var image = files[i]
  				var reader = new FileReader();

  				//console.log(files[i]);

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
  		resetCategories(data) {

  			this.root=false;
  			this.transport=false;
  			this.real_estate=false;
  			this.appliances=false;

  		},
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
