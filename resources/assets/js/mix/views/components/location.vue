<template>
  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Расположение</h5>
            <button type="button" class="close" aria-label="Close" @click="closeLocationWindow">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">	
          <div v-if="regions">
            <div class="link" @click="searchInCountry"><b>Весь Казахстан</b></div><hr>
              <!--@foreach($regions as $region)
              <div style="margin:5px">  
                <a href="/{{ $region["url"]}}" class="grey link" @click="showPlacesByRegion($event,{{ $region['region_id'] }})">{{$region["name"]}}</a><br>
              </div>
              @endforeach-->
              <div style="margin:5px">  
                <a href="/" v-for="(item,index) in regions" :key=index class="grey link">{{ item.name }}</a><br>
              </div>
            </div>
            <div v-if="places">
              <div class="link" @click="searchInRegion"><b>Искать в области</b></div><hr>            
                <a v-for="(item, index) in placesList" :key="index" :href="item.url" class="grey link block" style="margin:5px" @click="selectPlace($event, item.name, item.url)">${item.name}</a>            
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

  props: ["lang", "regions"],
  
  components: {},

  data () {
    return 	{
      placesList: [],
      //regions: true,    
      places: false,
      locationName: "",
      tmpLocationName: ""
		}
  },
  
  created() {
    console.log(this.lang)
    console.log(this.regions)
  },
  
  methods: {

    // Закрыть окно расположения
  closeLocationWindow() {
    //this.regions=true;
    //this.places=false;
    $("#locationModal").modal("hide");    
  },
  
  // --------------------------------------
  // Выбор региона
  // --------------------------------------
  showPlacesByRegion(e, regionId) {
    e.preventDefault();

    this.tmpLocationName=e.target.innerText;

    // Получить города / сёлы
    get("api/getPlaces?region_id="+regionId).then((res) => {    
      this.placesList=res.data;
      this.regionUrl=e.target.pathname;
      this.regions=false;
      this.places=true;
    }).catch((err) => { console.log(err) });

  },

  // --------------------------------------
  // Поиск в стране
  // --------------------------------------
  searchInCountry(e) {

    localStorage.setItem("locationUrl", "");    
    localStorage.setItem("locationName", "Весь Казахстан");

    // редирект
    window.location = "/";
  },

  // --------------------------------------
  // Поиск в регионе
  // --------------------------------------
  searchInRegion(e) {
    window.location = this.regionUrl;
  },
  
  // --------------------------------------
  // Выбрать город / село и т.п.
  // --------------------------------------
  selectPlace(e, placeName, placeUrl) {    
    e.preventDefault();
    window.location = this.regionUrl+"/"+placeUrl;
  }

  }
}
</script>
