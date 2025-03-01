<!-- Contenedor de tarjetas -->
        <div class="row g-4" id="product-list">
            <?php $__currentLoopData = $productos->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Carousel for multiple images -->
                        <div id="carousel-<?php echo e($producto->id); ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php $__currentLoopData = $producto->media->where('image_path', '!=', null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" 
                                             class="d-block w-100" 
                                             style="height: 200px; object-fit: contain;"
                                             alt="Producto">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if($producto->media->where('image_path', '!=', null)->count() > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo e($producto->id); ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo e($producto->id); ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($producto->titulo); ?></h5>
                            <p class="card-text"><?php echo e($producto->descripcion); ?></p>
                            <p>Código: <?php echo e($producto->codigo); ?></p>
                            <p>Configuraciones: <?php echo e($producto->configuraciones); ?></p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div class="d-flex" style="height: 54px">
                                    <button type="button" 
                                    class="btn btn-primary m-2 edit-button pb-1 justify-content-center align-content-center"
                                    data-id="<?php echo e($producto->id); ?>"
                                    data-filters="<?php echo e($producto->filters); ?>" 
                                    >Editar</button>
                                    <form action="<?php echo e(route('admin.productos.destroy', $producto)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger m-2">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div><?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/admin/productos_filtrados.blade.php ENDPATH**/ ?>