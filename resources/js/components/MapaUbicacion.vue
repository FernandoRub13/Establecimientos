<template>
  <div v-if="lat" class="mapa">
    <l-map 
     
      :zoom="zoom"
      :center="center"
      :option="mapOptions"
     >
      <l-tile-layer :url="url" :attribution="attribution" />
      
      <l-marker :lat-lng="{lat, lng}">
        <l-tooltip>
          <div>
            {{establecimiento.nombre}}
          </div>
        </l-tooltip>
      </l-marker>

    </l-map>

  </div>
</template>

<script>
import {latLng} from 'leaflet';
import { LMap, LTileLayer, LMarker, LTooltip } from 'vue2-leaflet'
export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LTooltip
  },
  data() {
    return {
      zoom: 16,
      center: latLng(19.29688645796798, -99.2131519317627),
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      currentZoom: 11.5,
      mapOptions: {
        zoomSnap: 0.5
      },
      showMap: true,
      lat: NaN,
      lng: NaN
    };
  },
  created() {
    setTimeout(() => {
      this.lat = this.$store.getters.getEstablecimiento.lat;
      this.lng = this.$store.getters.getEstablecimiento.lng;
      this.center = latLng(this.lat, this.lng);
    }, 100);
  },
  computed: {
    establecimiento() {
      return this.$store.getters.getEstablecimiento;
    }
  },
}
</script>

<style scoped>
  @import 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css';
  .mapa {
    height: 300px;
    width: 100%;
  }
</style>