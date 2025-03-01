<?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 col-6">
        <div class="card h-100">
            <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($media->image_path && $loop->first): ?>
                    <a href="<?php echo e(asset('images/' . $media->image_path)); ?>" data-lightbox="producto<?php echo e($producto->id); ?>">
                        <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" class="card-img-top"
                            alt="<?php echo e($producto->titulo); ?>">
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-body">
                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                    data-bs-target="#productModal<?php echo e($producto->id); ?>">Más info</button>

            </div>
        </div>
    </div>

    <!-- Aquí comienza el modal -->
    <div class="modal fade" id="productModal<?php echo e($producto->id); ?>" tabindex="-1"
        aria-labelledby="productModalLabel<?php echo e($producto->id); ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="productModalLabel<?php echo e($producto->id); ?>">
                        <?php echo e($producto->titulo); ?>

                        <?php if($producto->id == 1): ?>
                            <button type="button" class="btn btn-secondary btn-sm ms-3"
                                id="extraInfoBtn<?php echo e($producto->id); ?>" style="background-color: #6c757d;">P03 6L</button>
                        <?php endif; ?>
                        <?php if($producto->id == 2): ?>
                            <button type="button" class="btn btn-secondary btn-sm ms-3"
                                id="extraInfoBtn<?php echo e($producto->id); ?>" style="background-color: #6c757d;">P04 6L</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary btn-sm ms-3"
                            onclick="downloadFichaTecnica(<?php echo e($producto->id); ?>)">
                            Ficha Técnica
                        </button>
                    </h5>
                    <h3 class="card-text"><?php echo e($producto->titulo); ?></h3>
                    <p class="card-text"><?php echo e($producto->descripcion); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Aquí comienza el cuerpo del modal -->
                <div class="modal-body">
                    <div id="carouselModal<?php echo e($producto->id); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                                    <?php if($media->image_path): ?>
                                        <a href="<?php echo e(asset('images/' . $media->image_path)); ?>"
                                            data-lightbox="producto<?php echo e($producto->id); ?>">
                                            <img src="<?php echo e(asset('images/' . $media->image_path)); ?>"
                                                class="d-block w-100 carousel-image-fixed"
                                                alt="<?php echo e($producto->titulo); ?>">
                                            <h3 class="card-text"><?php echo e($producto->titulo); ?></h3>
                                            <p class="card-text"><?php echo e($producto->descripcion); ?></p>
                                        </a>
                                    <?php elseif($media->video_link): ?>
                                        <a href="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>"
                                            data-fancybox="producto<?php echo e($producto->id); ?>">
                                            <iframe width="560" height="315"
                                                src="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselModal<?php echo e($producto->id); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselModal<?php echo e($producto->id); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <p><?php echo e($producto->descripcion); ?></p>
                    <p>Código: <?php echo e($producto->codigo); ?></p>
                    <p>Configuraciones: <?php echo e($producto->configuraciones); ?></p>
                </div>
                <!-- Aquí termina el cuerpo del modal -->
                <div class="modal-footer">
                    <!-- Botón que llama a la función -->
                    <button type="button" class="btn btn-primary"
                        onclick="copyModalUrl('<?php echo e($producto->id); ?>')">Compartir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
        <div id="copyMessage<?php echo e($producto->id); ?>"
            style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;">
            Link copiado
        </div>
    </div>

    <!-- Aquí termina el modal -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/buscador.blade.php ENDPATH**/ ?>