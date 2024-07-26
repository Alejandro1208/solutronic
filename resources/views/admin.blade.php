@extends('layouts.app')
@section('content')
<div class="container contenido my-5">
   @if (Auth::check())
   <h1 class="mb-4 text-center">Panel de Administración</h1>
   <!-- Botón para abrir el modal -->
   <button type="button" class="btn btn-primary" id="openAddProductModal">
   Agregar Producto
   </button>
   <hr>
   <h2 class="my-4 text-center">Productos Existentes</h2>
   <form id="filter-form" method="GET" action="{{ route('admin.productos.filtrar') }}">
      <select name="filter" id="editFilter" class="form-control">
         <option value="" selected disabled>Selecciona un filtro</option>
         <option value="{{ route('admin.productos.filtrar') }}">Mostrar todos</option>
         <option value="Automotor" disabled>Automotor</option>
         <option value="Lamparas Electronica">Lamparas Electronica</option>
         <option value="Medidores de bateria">Medidores de bateria</option>
         <option value="Luminarias" disabled>Luminarias</option>
         <option value="Luminaria">Luminaria</option>
         <option value="Portatil">Portatil</option>
         <option value="Reflectores">Reflectores</option>
         <option value="Atoelevadores" disabled>Atoelevadores</option>
         <option value="Balizas">Balizas</option>
         <option value="Seguridad">Seguridad</option>
         <option value="Energias Alternativas" disabled>Energias Alternativas</option>
         <option value="iluminacion">iluminacion</option>
         <option value="reguladores">reguladores</option>
         <option value="Solar">Solar</option>
      </select>
   </form>
   <div class="row g-4" id="product-list">
      @foreach ($productos as $producto)
      <div class="col-md-4">
         <div class="card h-100 shadow-sm product-card">
            <div class="carousel" id="carousel{{ $producto->id }}">
               @foreach ($producto->media as $media)
               @if ($media->image_path)
               <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                  <img src="{{ asset('images/' . $media->image_path) }}" alt="{{ $producto->titulo }}">
               </div>
               @endif
               @if ($media->video_link)
               <div class="carousel-item {{ $loop->first && !$media->image_path ? 'active' : '' }}">
                  <iframe class="video" width="560" height="315" src="https://www.youtube.com/embed/{{ $media->video_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               </div>
               @endif
               @endforeach
               <button class="carousel-control-prev">&#60;</button>
               <button class="carousel-control-next">&#62;</button>
            </div>
            <div class="card-body d-flex flex-column">
               <h5 class="card-title">{{ $producto->titulo }}</h5>
               <p class="card-text">{{ $producto->descripcion }}</p>
               <p>Código: {{ $producto->codigo }}</p>
               <p>Configuraciones: {{ $producto->configuraciones }}</p>
               <div class="mt-auto d-flex justify-content-between">
                  <a href="#" class="btn btn-primary mb-2 edit-button" data-id="{{ $producto->id }}">Editar</a>
                  <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   <div class="d-flex justify-content-center">
      {{ $productos->links() }}
   </div>
   @else
   <p class="text-center">Debe iniciar sesión para acceder al panel de administración.</p>
   @endif
</div>
@if (session('error'))
<div class="alert alert-danger">
   {{ session('error') }}
</div>
@endif
<!-- Modal editar  -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <form id="editForm" enctype="multipart/form-data">
         <input type="hidden" name="_method" value="PUT">
         <input type="hidden" id="product-id">
         <div class="modal-body">
            <div class="mb-3">
               <label for="titulo" class="form-label">Título:</label>
               <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="mb-3">
               <label for="descripcion" class="form-label">Descripción:</label>
               <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
            <div class="mb-3">
               <div class="mb-3">
                  <label for="imagen1" class="form-label">Imagen 1:</label>
                  <input type="file" class="form-control" id="imagen1" name="imagenes[]">
                  <img id="preview1" src="#" alt="Agregar Imagen" />
                  <input type="hidden" name="existing_image_ids[]" value="{{ $producto->image_ids[0] ?? '' }}">
                  <button class="btn btn-danger delete-image" data-id="">Eliminar</button>
              </div>
              <div class="mb-3">
                  <label for="imagen2" class="form-label">Imagen 2:</label>
                  <input type="file" class="form-control" id="imagen2" name="imagenes[]">
                  <img id="preview2" src="#" alt="Agregar Imagen" />
                  <input type="hidden" name="existing_image_ids[]" value="{{ $producto->image_ids[1] ?? '' }}">
                  <button class="btn btn-danger delete-image" data-id="">Eliminar</button>
               </div>
               <div class="mb-3">
                  <label for="imagen3" class="form-label">Imagen 3:</label>
                  <input type="file" class="form-control" id="imagen3" name="imagenes[]">
                  <img id="preview3" src="#" alt="Agregar Imagen" />
                  <input type="hidden" name="existing_image_ids[]" value="{{ $producto->image_ids[2] ?? '' }}">
                  <button class="btn btn-danger delete-image" data-id="">Eliminar</button>
              </div>
              <div class="mb-3">
                  <label for="imagen4" class="form-label">Imagen 4:</label>
                  <input type="file" class="form-control" id="imagen4" name="imagenes[]">
                  <img id="preview4" src="#" alt="Agregar Imagen" />
                  <input type="hidden" name="existing_image_ids[]" value="{{ $producto->image_ids[3] ?? '' }}">
                  <button class="btn btn-danger delete-image" data-id="">Eliminar</button>
            </div>
               <!-- Aquí irán los demás campos de entrada -->
               <div class="mb-3">
                  <label for="video" class="form-label">Video:</label>
                  <input type="text" class="form-control" id="video" name="video">
               </div>
               <div class="mb-3">
                  <label for="codigo" class="form-label">Código:</label>
                  <input type="text" class="form-control" id="codigo" name="codigo">
               </div>
               <div class="mb-3">
                  <label for="configuraciones" class="form-label">Configuraciones:</label>
                  <textarea class="form-control" id="configuraciones" name="configuraciones"></textarea>
               </div>
               <select name="filter" id="filter" class="form-control">
                  <option value="" selected disabled>Selecciona un filtro</option>
                  <option value="">Mostrar todos</option>
                  <option value="Automotor"  disabled>Automotor</option>
                  <option value="Lamparas Electronica">Lamparas Electronica</option>
                  <option value="Medidores de bateria">Medidores de bateria</option>
                  <option value="Luminarias"  disabled>Luminarias</option>
                  <option value="Luminaria">Luminaria</option>
                  <option value="Portatil">Portatil</option>
                  <option value="Reflectores">Reflectores</option>
                  <option value="Atoelevadores"  disabled>Atoelevadores</option>
                  <option value="Balizas">Balizas</option>
                  <option value="Seguridad">Seguridad</option>
                  <option value="Energias Alternativas"  disabled>Energias Alternativas</option>
                  <option value="iluminacion">iluminacion</option>
                  <option value="reguladores">reguladores</option>
                  <option value="Solar">Solar</option>
               </select>
               <div class="form-group">
                  <label for="destacado">Destacado:</label>
                  <select class="form-control" id="destacado" name="destacado">
                      <option value="0" {{ old('destacado', $producto->destacado) == 0 ? 'selected' : '' }}>No</option>
                      <option value="1" {{ old('destacado', $producto->destacado) == 1 ? 'selected' : '' }}>Sí</option>
                  </select>
              </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
      </form>
      </div>
   </div>
</div>
</div>
@if (session('success'))
<div class="alert alert-success">
   {{ session('success') }}
</div>
@endif
<!-- fin Modal editar -->
<!-- Modal Agregar Producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               @if ($errors->any())
               <div class="alert alert-danger">
                  <ul class="mb-0">
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <div class="mb-3">
                  <label for="titulo" class="form-label">Título:</label>
                  <input type="text" class="form-control" id="titulo" name="titulo"
                     value="{{ old('titulo') }}" required>
               </div>
               <div class="mb-3">
                  <label for="descripcion" class="form-label">Descripción:</label>
                  <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
               </div>
               <div class="mb-3">
                  <label for="imagen1" class="form-label">Imagen 1:</label>
                  <input type="file" class="form-control" id="imagen1" name="imagenes[]">
                  <img id="preview1" src="#" alt="Agregar Imagen" />
               </div>
               <div class="mb-3">
                  <label for="imagen2" class="form-label">Imagen 2:</label>
                  <input type="file" class="form-control" id="imagen2" name="imagenes[]">
                  <img id="preview2" src="#" alt="Agregar Imagen" />
               </div>
               <div class="mb-3">
                  <label for="imagen3" class="form-label">Imagen 3:</label>
                  <input type="file" class="form-control" id="imagen3" name="imagenes[]">
                  <img id="preview3" src="#" alt="Agregar Imagen" />
               </div>
               <div class="mb-3">
                  <label for="imagen4" class="form-label">Imagen 4:</label>
                  <input type="file" class="form-control" id="imagen4" name="imagenes[]">
                  <img id="preview4" src="#" alt="your image" />
               </div>
               <div class="mb-3">
                  <label for="video" class="form-label">Video:</label>
                  <input type="text" class="form-control" id="video" name="video"
                     value="{{ old('video') }}">
               </div>
               <div class="mb-3">
                  <label for="codigo" class="form-label">Código:</label>
                  <input type="text" class="form-control" id="codigo" name="codigo"
                     value="{{ old('codigo') }}">
               </div>
               <div class="mb-3">
                  <label for="configuraciones" class="form-label">Configuraciones:</label>
                  <textarea class="form-control" id="configuraciones" name="configuraciones" rows="4">{{ old('configuraciones') }}</textarea>
               </div>
               <select name="filter" id="filter" class="form-control">
                  <option value="" selected disabled>Selecciona un filtro</option>
                  <option value="">Mostrar todos</option>
                  <option value="Automotor" disabled>Automotor</option>
                  <option value="Lamparas Electronica">Lamparas Electronica</option>
                  <option value="Medidores de bateria">Medidores de bateria</option>
                  <option value="Luminarias" disabled>Luminarias</option>
                  <option value="Luminaria">Luminaria</option>
                  <option value="Portatil">Portatil</option>
                  <option value="Reflectores">Reflectores</option>
                  <option value="Atoelevadores"  disabled>Atoelevadores</option>
                  <option value="Balizas">Balizas</option>
                  <option value="Seguridad">Seguridad</option>
                  <option value="Energias Alternativas" disabled>Energias Alternativas</option>
                  <option value="iluminacion">iluminacion</option>
                  <option value="reguladores">reguladores</option>
                  <option value="Solar">Solar</option>
               </select>
               <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="destacado" id="destacado">
                  <label class="form-check-label" for="destacado">
                  Destacado
                  </label>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Fin Modal Agregar Producto -->
@endsection
<head>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/js/bootstrap.bundle.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<script>
   //--------Filtro--------
   $(document).ready(function() {
   $('#filter').on('change', function() {
       $('#filter-form').submit();
   });
   });
   //--------Fin Filtro--------
</script>
<script>
   //----------Modal agregar------------//
   $(document).ready(function() {
   $('#openAddProductModal').click(function() {
      $('#addProductModal').modal('show');
   });
   function readURL(input, previewId) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
   
      reader.onload = function(e) {
          $(previewId).attr('src', e.target.result);
      }
   
      reader.readAsDataURL(input.files[0]); // convert to base64 string
   }
   }
   
   $("#imagen1").change(function() {
   readURL(this, '#preview1');
   });
   
   $("#imagen2").change(function() {
   readURL(this, '#preview2');
   });
   $("#imagen3").change(function() {
   readURL(this, '#preview3');
   });
   
   $("#imagen4").change(function() {
   readURL(this, '#preview4');
   });
   
   });
   //----------fin Modal agregar------------//
</script>
<script>
   //----------Modal editar------------//
    // Modal editar
    $(document).ready(function() {
       $('.edit-button').click(function(e) {
           e.preventDefault();
               // Agrega estas líneas para registrar los valores de existing_image_ids[]
    var existingImageIds = $('input[name="existing_image_ids[]"]').map(function() {
        return $(this).val();
    }).get();
    console.log('IDs de imágenes existentes:', existingImageIds);
   
           var id = $(this).data('id');
           $('#editModal #product-id').val(id);
   
           $.ajax({
   url: '{{ route('productos.data', ['producto' => 'PRODUCTO_ID']) }}'.replace('PRODUCTO_ID', id),
   success: function(data) {
       console.log('Datos del producto:', data); 
   
       // Llenar los campos del formulario en el modal con los datos del producto
       $('#editModal #titulo').val(data.titulo);
       $('#editModal #descripcion').val(data.descripcion);
       $('#editModal #codigo').val(data.codigo);
       $('#editModal #configuraciones').val(data.configuraciones);
       $('#editModal #filter').val(data.filter);
   
       // Establecer el estado del checkbox "destacado"
       $('#editModal #destacado').val(data.destacado);
   
       // Nueva línea: registra el estado del checkbox "destacado"
       console.log('Estado del checkbox destacado:', $('#editModal #destacado').is(':checked'));
   
       $('#editModal #video').val(data.video_link);
   
// Actualizar las vistas previas y los botones de eliminar
for (var i = 0; i < 4; i++) {
    if (data.imagenes[i]) {
        $('#preview' + (i + 1)).attr('src', '/images/' + data.imagenes[i]);
        $('.delete-image').eq(i).data('id', data.image_ids[i]);
        $('input[name="existing_image_ids[]"]').eq(i).val(data.image_ids[i]); // Agrega esta línea
    } else {
        $('#preview' + (i + 1)).attr('src', '#');
        $('.delete-image').eq(i).data('id', '');
        $('input[name="existing_image_ids[]"]').eq(i).val(''); // Agrega esta línea
    }
}

   
       // Mostrar el modal
       $('#editModal').modal('show');
   }
   });
       });
   
       $('#editForm').on('submit', function(e) {
           e.preventDefault();
   
           var id = $('#editModal #product-id').val();
   
           // Crear un nuevo objeto FormData y agregar cada campo manualmente
           var formData = new FormData();
           formData.append('_method', 'PUT');
           formData.append('_token', '{{ csrf_token() }}');
           formData.append('titulo', $('#editModal #titulo').val());
           formData.append('descripcion', $('#editModal #descripcion').val());
           formData.append('codigo', $('#editModal #codigo').val());
           formData.append('configuraciones', $('#editModal #configuraciones').val());
   
           var filter = $('#editModal #filter').val();
           if (filter === '') {
               filter = null;
           }
           formData.append('filter', filter);
   
           formData.append('destacado', $('#editModal #destacado').val());
           console.log('Enlace del video:', $('#editModal #video').val());
           formData.append('video', $('#editModal #video').val());

   
           // Agregar las imágenes al objeto FormData
           $('#editModal input[name^="imagenes"]').each(function(i, fileInput) {
               var key = $(fileInput).attr('name');
               if (fileInput.files[0]) {
                   formData.append(key, fileInput.files[0]);
               }
           });
   
           // Agregar los IDs de las imágenes al objeto FormData
           $('#editModal input[name^="image_ids"]').each(function(i, input) {
               var key = $(input).attr('name');
               formData.append(key, $(input).val());
   });
   
   console.log('Form data:', Array.from(formData.entries())); // Registra los datos del formulario
   console.log('Estado del checkbox destacado:', $('#editModal #destacado').is(':checked'));
   $.ajax({
   url: '/admin/productos/' + $('#editModal #product-id').val(),
   type: 'POST',
   data: formData,
   processData: false,
   contentType: false,
   headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
   success: function(response) {
       // Cerrar el modal y recargar la página o actualizar la lista de productos
       $('#editModal').modal('hide');
       location.reload();
       console.log('Respuesta del servidor:', response);
   }
   }).fail(function(jqXHR, textStatus, errorThrown) {
   console.log(jqXHR.responseText);

   });

   });
   $('#editModal .close, #editModal .btn-secondary').click(function() {
   $('#editModal').modal('hide');
   });
   });
   $('#editModal #destacado').change(function() {
   console.log('Estado del checkbox destacado:', $(this).is(':checked'));
   });

   $(document).on('click', '.delete-image', function(e) {
   e.preventDefault();
   
   var id = $(this).data('id');
   var button = $(this);
   
   $.ajax({
       url: '/admin/productos/delete-image/' + id,
       type: 'POST',
       data: {
           _method: 'DELETE',
           _token: '{{ csrf_token() }}'
       },
       success: function() {
           // Eliminar la imagen del DOM
           button.siblings('img').attr('src', '#');
           button.data('id', '');
   
           // Reorganizar los campos de entrada de archivo y las vistas previas de las imágenes
           var inputs = $('#editModal input[type="file"]').toArray();
           var previews = $('#editModal img').toArray();
   
           inputs.sort(function(a, b) {
               return $(a).siblings('img').attr('src') === '#' ? -1 : 1;
           });
   
           previews.sort(function(a, b) {
               return $(a).attr('src') === '#' ? -1 : 1;
           });
   
           for (var i = 0; i < inputs.length; i++) {
               $(inputs[i]).insertBefore($(previews[i]));
           }
       }
   });
   });
</script>
<script>
   $(document).ready(function() {
       // ... Resto de tu código JavaScript ...
   
       $('#editModal input[type="file"]').change(function() {
           if (this.files && this.files[0]) {
               var reader = new FileReader();
               var image = $(this).siblings('img');
   
               reader.onload = function(e) {
                   image.attr('src', e.target.result);
               }
   
               reader.readAsDataURL(this.files[0]);
           }
       });
   });
</script>
<script>
   $(document).ready(function() {
       $('.carousel').each(function() {
           var items = $(this).find('.carousel-item');
           var currentIndex = 0;
   
           function updateCarousel() {
               items.removeClass('active');
               $(items[currentIndex]).addClass('active');
           }
   
           $(this).find('.carousel-control-prev').click(function() {
               currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
               updateCarousel();
           });
   
           $(this).find('.carousel-control-next').click(function() {
               currentIndex = (currentIndex + 1) % items.length;
               updateCarousel();
           });
   
           updateCarousel();
       });
   });
   
</script>
<style>
   #preview1,
   #preview2,
   #preview3,
   #preview4{
   width: 100px;
   }
   .modal-backdrop {
   z-index: 1030 !important;
   }
   .modal {
   z-index: 1040 !important;
   }
   .carousel-control-prev,
   .carousel-control-next {
   background-color: black !important;
   color: white;
   margin: 0px;
   font-size: 25px;
   }
   .carousel-item img, .video{
   width: 100%;
   height: 200px;
   object-fit: cover;
   }
   .carousel {
   display: flex;
   overflow: hidden;
   }
   .carousel-item {
   flex: 0 0 auto;
   opacity: 0;
   transition: opacity 1s;
   }
   .carousel-item.active {
   opacity: 1;
   }
   .contenido {
   position: absolute;
   top: 50px;
   left: 50%;
   transform: translate(-50%, 10px);
   }
   body {
   background-color: #f8f9fa;
   }
   .card {
   border: none;
   border-radius: 0.5rem;
   transition: transform 0.3s, box-shadow 0.3s;
   }
   .card:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
   }
   .card-title {
   font-size: 1.25rem;
   font-weight: bold;
   }
   .card-text {
   font-size: 1rem;
   color: #6c757d;
   }
   .btn-primary,
   .btn-danger {
   transition: background-color 0.3s, box-shadow 0.3s;
   }
   .btn-primary:hover {
   background-color: #0056b3;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }
   .btn-danger:hover {
   background-color: #c82333;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }
   .alert-danger {
   background-color: #f8d7da;
   color: #721c24;
   border-color: #f5c6cb;
   }
   .form-label {
   font-weight: bold;
   }
   h1,
   h2 {
   font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
   color: #343a40;
   }
   h1 {
   font-size: 2.5rem;
   }
   h2 {
   font-size: 2rem;
   }
   .card-body {
   padding: 1.5rem;
   }
   .card-img-top {
   height: 200px;
   object-fit: cover;
   border-top-left-radius: 0.5rem;
   border-top-right-radius: 0.5rem;
   }
   .container {
   max-width: 1200px;
   }
   .product-card {
   display: flex;
   flex-direction: column;
   justify-content: space-between;
   }
</style>