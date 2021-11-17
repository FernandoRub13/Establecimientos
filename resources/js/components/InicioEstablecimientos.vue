<template>
  <div>
      <listado-categorias></listado-categorias>
    <mapa-establecimientos></mapa-establecimientos>
    <div class="container" >
      <categoria-cafe></categoria-cafe>
      <categoria-restaurant></categoria-restaurant>
      <categoria-hotel></categoria-hotel>
    </div>
  </div>
</template>


<script>
import CategoriaCafe from './CategoriaCafe.vue';
import CategoriaRestaurant from './CategoriaRestaurant.vue';
import CategoriaHotel from './CategoriaHotel.vue';
import MapaEstablecimientos from './MapaEstablecimientos.vue';
import ListadoCategorias from './ListadoCategorias.vue';

export default {
  components: {
    CategoriaCafe,
    CategoriaRestaurant,
    CategoriaHotel,
    MapaEstablecimientos,
    ListadoCategorias
  },
  

}
</script>