<?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm product-card">
                <div class="carousel" id="carousel<?php echo e($producto->id); ?>">
                    <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($media->image_path): ?>
                    <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                        <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" alt="<?php echo e($producto->titulo); ?>">
                    </div>
                    <?php endif; ?>
                    <?php if($media->video_link): ?>
                    <div class="carousel-item <?php echo e($loop->first && !$media->image_path ? 'active' : ''); ?>">
                        <iframe class="video" width="560" height="315" src="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button class="carousel-control-prev">&#60;</button>
                    <button class="carousel-control-next">&#62;</button>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo e($producto->titulo); ?></h5>
                    <p class="card-text"><?php echo e($producto->descripcion); ?></p>
                    <p>Código: <?php echo e($producto->codigo); ?></p>
                    <p>Configuraciones: <?php echo e($producto->configuraciones); ?></p>
                    <div class="mt-auto d-flex justify-content-between">
                    <a href="#" class="btn btn-primary mb-2 edit-button" data-id="<?php echo e($producto->id); ?>">Editar</a>
                        <form action="<?php echo e(route('productos.destroy', $producto)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <?php echo e($productos->links()); ?>

            </nav>
        </div>
<?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/admin_product_list.blade.php ENDPATH**/ ?>