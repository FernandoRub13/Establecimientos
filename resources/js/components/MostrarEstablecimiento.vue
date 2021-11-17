<template>
  <div class="container my-5">
    <h2 class=" text-center mb-5">{{establecimiento.nombre}}</h2>
    <div class="row align-items-start" >
      <div class="col-md-8  order-2">
        <img :src="`../storage/${establecimiento.imagen_principal}`" class="img-fluid" alt="Imagen principal del  establecimiento">
        <p class="mt-3">{{establecimiento.descripcion}}</p>
        <galeria-imagenes></galeria-imagenes>
      </div>
      <aside class="col-md-4 order-1" >
        <div >
          <mapa-ubicacion></mapa-ubicacion>
        </div>
        <div class="p-4 bg-primary">
          <h2 class="text-center text-white mt-2 mb-4" >Más información</h2>
          <p class="text-white">
            <span class="font weight-bold">Telefono: </span>
            <span class="ml-2">{{establecimiento.telefono}}</span>
          </p>
          <p class="text-white">
            <span class="font weight-bold">Ubicación: </span>
            <span class="ml-2">{{establecimiento.direccion}}</span>
          </p>
          <p class="text-white">
            <span class="font weight-bold">Colonia: </span>
            <span class="ml-2">{{establecimiento.colonia}}</span>
          </p>
          <p class="text-white">
            <span class="font weight-bold">Telefono: </span>
            <span class="ml-2">{{establecimiento.telefono}}</span>
          </p>

          <p class="text-white">
            <span class="font weight-bold">Horario: </span>
            <span class="ml-2">{{establecimiento.apertura}} - {{establecimiento.cierre}} </span>
          </p>

        </div>
      </aside>
    </div>
  </div>
</template>

<script>
import MapaUbicacion from '../components/MapaUbicacion.vue'
import GaleriaImagenes from '../components/GaleriaImagenes.vue'

export default {
  components: {
    MapaUbicacion,
    GaleriaImagenes
  },
  mounted() {
    const {id} = this.$route.params;
    axios.get('/api/establecimiento/' + id)
      .then(response => {
        this.$store.commit('AGREGAR_ESTABLECIMIENTO', response.data);
      })
  },
  computed: {
    establecimiento() {
      return this.$store.getters.getEstablecimiento;
    }
  },

}
</script>