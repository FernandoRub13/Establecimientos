 import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      cafes: [],
      restaurantes: [],
      hoteles: [],
      establecimiento: {},
      establecimientos: {},
      categorias: [],
      categoria: ''
    },
    mutations: {
      AGREGAR_CAFES(state, cafes) {
        state.cafes = cafes;
      },
      AGREGAR_RESTAURANTES(state, restaurantes) {
        state.restaurantes = restaurantes;
      },
      AGREGAR_HOTELES(state, hoteles) {
        state.hoteles = hoteles;
      },
      AGREGAR_ESTABLECIMIENTO(state, establecimiento) {
        state.establecimiento = establecimiento;
      },
      AGREGAR_ESTABLECIMIENTOS(state, establecimientos) {
        state.establecimientos = establecimientos;
      },
      AGREGAR_CATEGORIAS(state, categorias) {
        state.categorias = categorias;
      },
      SELECCIONAR_CATEGORIA(state, categoria) {
        state.categoria = categoria;
      }
    },
    getters: {
      getEstablecimiento: state => {
        return state.establecimiento;
      },
      getImagenes: state => {
        return state.establecimiento.imagenes;
      },
      getEstablecimientos: state => {
        return state.establecimientos;
      },
      getCategorias: state => {
        return state.categorias;
      },
      getCategoria: state => {
        return state.categoria;
      }
    },
});
