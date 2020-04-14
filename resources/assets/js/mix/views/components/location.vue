<template>
  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-label="Close" @click="closeLocationWindow">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">	
          <div v-if="regions">
            <div class="link" @click="searchInCountry"><b>Искать по всему Казахстану</b></div>
	      <input type="text" class="form-control mt-3" placeholder="Введите местоположение поиска, например Нур-Султан"></input>
              <div v-for="(item, index) in regionsList" :key=index style="margin:10px">  
                <h3><a :href="getUrl(item.url)" class="grey link" @click="showPlacesByRegion($event, item.region_id)">{{ item.name }}</a></h3>
              </div>
            </div>
            <div v-if="places" class="text-center">
              <div class="link" @click="searchInRegion"><b>Искать по всей области</b></div><hr>            
                <a v-for="(item, index) in placesList" :key="index" :href="item.url" class="grey link" style="margin:5px;padding:8px;border: 1px solid rgb(200,200,200);border-radius:5px;display:inline-block" @click="selectPlace($event, item.name, item.url)">{{item.name}}</a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary margin-auto" @click="closeLocationWindow">Закрыть</button>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
import $ from "jquery";
import { get } from '../../../helpers/api' // axios

export default {  
  
  //props: ["country", "language"],

  data () {
    return 	{
      placesList: [],
      regionsList: [],
      regions: true,    
      places: false,
      locationName: "",
      tmpLocationName: ""
		}
  },
  
  // Компонент создан
  created() {    
    get("/api/getRegions").then((res) => {      
      this.regionsList = res.data;
    }).catch((err) => { console.log(err) });
  },
  
  methods: {

  // Вернуть форматированный урл
  getUrl(url) { 
    return "/"+url; 
  },
  
  // Закрыть окно расположения
  closeLocationWindow() {
    this.regions=true;
    this.places=false;
    $("#locationModal").modal("hide");    
  },
    
  // Выбор региона  
  showPlacesByRegion(e, regionId) {    
    
    e.preventDefault();    
    this.tmpLocationName=e.target.innerText;

    // Получить города / сёлы
    get("/api/getPlaces?region_id="+regionId).then((res) => {    
      this.placesList=res.data;
      this.regionUrl=e.target.pathname;
      this.regions=false;
      this.places=true;
    }).catch((err) => { 
      console.log(err) 
    });

  },
  
  // Поиск в стране
  searchInCountry(e) {
    localStorage.setItem("locationUrl", "");    
    localStorage.setItem("locationName", "Весь Казахстан");    
    window.location = "/"; // редирект
  },
  
  // Поиск в регионе  
  searchInRegion(e) {
    e.preventDefault();    
    window.location = this.regionUrl;
  },
    
  // Выбрать город / село и т.п.  
  selectPlace(e, placeName, placeUrl) {    
    e.preventDefault();    
    window.location = this.regionUrl+"/"+placeUrl;
  }

  }
}
</script>
<style>
.modal-lg {
    max-width: 80% !important;
    margin:auto !important;
    margin-top:10px !important;
}
</style>