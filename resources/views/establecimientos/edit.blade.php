@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin="" />
<!-- Esri Leaflet Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css" />
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css"
/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css" integrity="sha512-0ns35ZLjozd6e3fJtuze7XJCQXMWmb4kPRbb+H/hacbqu6XfIX0ZRGt6SrmNmv5btrBpbzfdISSd8BAsXJ4t1Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="container">
  <h1 class="text-venter mt-4">Editar establecimiento</h1>
  <div class="mt-5 row justify-content-center">
{{-- Show all error in case they are --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form 
      method="POST" 
      class="col-md-9 col-xs-12 card card-body"
      action="{{ route('establecimiento.update', ['establecimiento' => $establecimiento->id]) }}" 
      enctype="multipart/form-data" 
    >
      @csrf
      @method('PUT')
      <fieldset class="border p-4">
        <legend class="text-primary">Nombr, categoría e imagen del establecimiento</legend>
        <div class="form-group">
          <label for="nombre">Nombre del establecimiento</label>
          <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
            placeholder="Nombre establecimiento" name="nombre" value="{{ $establecimiento->nombre }}">
          @error('nombre') <div class="invalid-feedback">{{$message}}</div> @enderror
        </div>
        <div class="form-group">
          <label for="categoria">Categoria</label>
          <select class="form-control @error('categoria_id') is-invalid @enderror" name="categoria_id" id="categoria">
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
            <option {{ $establecimiento->categoria_id == $categoria->id ? 'selected' : ''}}
              value="{{$categoria->id}}">
              {{$categoria->nombre}}</option>
            @endforeach
          </select>
          @error('categoria_id') <div class="invalid-feedback">{{$message}}</div> @enderror
        </div>
        <div class="form-group">
          <label for="imagen_principal">Imagen principal  del establecimiento</label>
          <input  id="imagen_principal" type="file" class="form-control @error('imagen_principal') is-invalid @enderror"
            name="imagen_principal">
          @error('imagen_principal') <div class="invalid-feedback">{{$message}}</div> @enderror
          <img style="width:200px; margin-top: 20px;" src="/storage/{{$establecimiento->imagen_principal}}" alt="">
        </div>
      </fieldset>
      <fieldset class="border p-4 mt-5">
        <legend class="text-primary">Ubicación</legend>
        <div class="form-group">
          <label for="nombre">Coloca la ubicación del establecimiento</label>
          <input id="formbuscador" type="text"
          buscadorype="text" placeholder="Calle del negocio o establemiento" class="form-control">
          <p>El asistente colocará una dirección estimada o mueve el Pin hacia el lugar correcto </p>
        </div>
        <div class="form-group">
          <div id="mapa" style="height: 400px;"></div>
        </div>
        <p class="informacion">Confirma que los siguientes campos son correctos</p>
        <div class="form-group">
          <label for="direccion">Dirección</label>
          <input type="text" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
            placeholder="Dirección" name="direccion" value="{{ $establecimiento->direccion }}">
          @error('direccion') <div class="invalid-feedback">{{$message}}</div> @enderror
        </div>
        <div class="form-group">
          <label for="direccion">Colonia</label>
          <input type="text" id="colonia" class="form-control @error('colonia') is-invalid @enderror"
            placeholder="Colonia" name="colonia" value="{{$establecimiento->colonia}}">
          @error('colonia') <div class="invalid-feedback">{{$message}}</div> @enderror
        </div>
        <input type="hidden" name="lat" id="lat" value="{{ $establecimiento->lat }}">
        <input type="hidden" name="lng" id="lng" value="{{ $establecimiento->lng }}">

      </fieldset>
      <fieldset class="border p-4 mt-5">
        <legend  class="text-primary">Información Establecimiento: </legend>
            <div class="form-group">
                <label for="nombre">Teléfono</label>
                <input 
                    type="tel" 
                    class="form-control @error('telefono')  is-invalid  @enderror" 
                    id="telefono" 
                    placeholder="Teléfono Establecimiento"
                    name="telefono"
                    value="{{ $establecimiento->telefono }}"
                >

                    @error('telefono')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Descripción</label>
                <textarea
                    class="form-control  @error('descripcion')  is-invalid  @enderror" 
                    name="descripcion"
                >{{ $establecimiento->descripcion }}</textarea>

                    @error('descripcion')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Hora Apertura:</label>
                <input 
                    type="time" 
                    class="form-control @error('apertura')  is-invalid  @enderror" 
                    id="apertura" 
                    name="apertura"
                    value="{{ $establecimiento->apertura }}"
                >
                @error('apertura')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Hora Cierre:</label>
                <input 
                    type="time" 
                    class="form-control @error('cierre')  is-invalid  @enderror" 
                    id="cierre" 
                    name="cierre"
                    value="{{ $establecimiento->cierre}}"

                >
                @error('cierre')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
      </fieldset> 
      <fieldset class="corder p-4 mt-5" >
        <legend class="text-primary">Galería del establecimiento</legend>
        <div class="form-group">
          <label for="dropzone">Imagenes</label>
          <div id="dropzone" class="dropzone" ></div>
        </div>
        @if (count($imagenes)>0)
          @foreach ($imagenes as $imagen)
              <input class="galeria" type="hidden" value="{{$imagen->ruta_imagen}}" >
          @endforeach          
        @endif
      </fieldset>

      <input type="hidden" name="uuid" id="uuid" value="{{ $establecimiento->uuid }}" >
      <input type="submit" class="btn btn-primary mt-3 d-block" value="Guardar Cambios">
    </form>
  </div>
</div>
@endsection

@section('scripts')
{{-- CDN Scripts --}}
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
{{-- <script src="https://unpkg.com/esri-leaflet"></script> --}}
<script src="https://unpkg.com/esri-leaflet"  defer></script>
<script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js" defer></script>
{{-- Leaflet script --}}
<script defer >

  document.addEventListener('DOMContentLoaded', function(){
      let lat = document.querySelector('#lat').value || 19.29688645796798;
      let lng = document.querySelector('#lng').value || -99.2131519317627;

      function showPosition(position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;
      }

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }

      const provider = new GeoSearch.OpenStreetMapProvider();

      const mapa = L.map('mapa').setView([lat, lng],13);

      //Eliminar pines previos 
      let markers = new L.FeatureGroup().addTo(mapa);
      
      const buscador = document.getElementById('formbuscador');
      buscador.addEventListener('blur', function(){
        if (buscador.value.length > 7) {
          provider.search({ query: buscador.value + ' CDMX MX ' })
          .then(function(resultado){
            if (resultado[0]) {
              
              geocodeService.reverse().latlng(resultado[0].bounds[0], 13).run(function(error, result){
                if(error){
                  console.log(error);
                }else{
                  //limpiar pines previos
                  markers.clearLayers();
                  //agregar nuevos pines
                  const direccion = result.address.Match_addr;                  
                  document.querySelector('#direccion').value = direccion || '';
                  document.querySelector('#colonia').value = result.address.Neighborhood || '';
                  document.querySelector('#lat').value = result.latlng.lat || '';
                  document.querySelector('#lng').value = result.latlng.lng || '';
                  // Centra el mapa
                  mapa.setView(result.latlng, 13);
                  // Crea un popup para el marker 
                  marker.bindPopup(direccion).openPopup();
                  // agrega el marker al mapa
                  marker = new L.marker(result.latlng, {
                    draggable: true,
                    autoPan: true,
                  }).addTo(mapa);
                  // agrega el marker al grupo de markers
                  markers.addLayer(marker);
                  marker.on('dragend', function(e){
                    const coordenadas = marker.getLatLng();
                    const lat = coordenadas.lat;
                    const lng = coordenadas.lng;
                    document.querySelector('#lat').value = lat;
                    document.querySelector('#lng').value = lng;
                    // Centrar el mapa
                    mapa.panTo(new L.LatLng(lat, lng));
                    // Buscar la dirección reverse geocoding
                    
                    geocodeService.reverse().latlng(coordenadas, 13).run(function(error, result){
                      if(error){
                        console.log(error);
                      }else{
                        const direccion = result.address.Match_addr;
                        // Crea un popup para el marker 
                        
                        marker.bindPopup(direccion).openPopup();
                        document.querySelector('#direccion').value = direccion || '';
                        document.querySelector('#colonia').value = result.address.Neighborhood || '';
                        document.querySelector('#lat').value = result.latlng.lat || '';
                        document.querySelector('#lng').value = result.latlng.lng || '';
                      }
                    });

                  });
                }
              });
            }
          })
        }
        
      });

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(mapa);
  
      let marker;

      // agregar el pin
      marker = new L.marker([lat, lng], {
        draggable: true,
        autoPan: true,
      }).addTo(mapa);
      // agrega el marker al grupo de markers
      markers.addLayer(marker);
      // agregar el geocoder
      const geocodeService = L.esri.Geocoding.geocodeService({
        apikey: 'AAPK86b9025db77945ed9158f4fee7cb3964r-fq11FUiBRq4pHLXWQzNw84PuKQ1oD0dIfIupZ3rPYjnsWaRuWIYWHUzi05d902'
        
      });

      marker.on('dragend', function(e){
        const coordenadas = marker.getLatLng();
        const lat = coordenadas.lat;
        const lng = coordenadas.lng;
        document.querySelector('#lat').value = lat;
        document.querySelector('#lng').value = lng;
        // Centrar el mapa
        mapa.panTo(new L.LatLng(lat, lng));
        // Buscar la dirección reverse geocoding
        
        geocodeService.reverse().latlng(coordenadas, 13).run(function(error, result){
          if(error){
            console.log(error);
          }else{
            const direccion = result.address.Match_addr;
            // Crea un popup para el marker 
            
            marker.bindPopup(direccion).openPopup();
            document.querySelector('#direccion').value = direccion || '';
            document.querySelector('#colonia').value = result.address.Neighborhood || '';
            document.querySelector('#lat').value = result.latlng.lat || '';
            document.querySelector('#lng').value = result.latlng.lng || '';
          }
        });

      });
  });
</script>
{{-- Dropzone script --}}
<script src="{{ asset('js/dropzone.js') }}" defer ></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
  Dropzone.autoDiscover = false;
  var myDropzone = new Dropzone('div#dropzone', {
    url: '/imagenes/store',
    maxFiles: 10,
    addRemoveLinks: true, 
    acceptedFiles: 'image/*',
    dictDefaultMessage: 'Arrastra una imagen aquí o haz click para buscar una imagen',
    dictRemoveFile: 'Eliminar',
    dictCancelUpload: 'Cancelar',
    dictFileTooBig: 'El archivo es muy grande',
    dictInvalidFileType: 'No puedes subir archivos de este tipo',
    dictCancelUploadConfirmation: '¿Estás seguro de que quieres cancelar la subida?',
    dictRemoveFileConfirmation: '¿Estás seguro de que quieres eliminar la imagen?',
    dictMaxFilesExceeded: 'Solo puedes hasta 10 imagenes',
    required: true, 
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    init: function() { 
      const galeria = document.querySelectorAll('.galeria');

      if (galeria.length > 0) {
        galeria.forEach(imagen => {
          const imagenPublicada = {};
          imagenPublicada.size = 1;
          imagenPublicada.name = imagen.value;
          imagenPublicada.nombreServidor = imagen.value;
          // console.log(imagenPublicada.name);
          this.options.addedfile.call(this, imagenPublicada);
          this.options.thumbnail.call(this, imagenPublicada,  `/storage/${imagenPublicada.name}`);

          imagenPublicada.previewElement.classList.add('dz-success');
          imagenPublicada.previewElement.classList.add('dz-complete');

        })
      }

      this.on("addedfile", function(file) {
        console.log('addedfile');
      });
      this.on("sending", function(file, xhr, formData) {
        formData.append("uuid", document.querySelector('#uuid').value);
      });
      this.on("success", function(file, response) {
        console.log(response);
        file.nombreServidor = response.archivo
        console.log(file);
      });
      this.on("removedfile", function(file) {
        console.log('removed');
        const params = {
          imagen: file.nombreServidor,
          uuid: document.querySelector('#uuid').value
        }
        axios.post('/imagenes/destroy', params)
        .then(function(response){
          console.log(response);

          file.previewElement.parentNode.removeChild(file.previewElement);

        })
        .catch(function(error){
          console.log(error);
        });
       
      });
      this.on("error", function(file, response) {
        console.log('error');
      });
    }
  });
  
});
</script>

@endsection