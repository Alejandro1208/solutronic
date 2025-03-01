<?php $__currentLoopData = $productos->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm product-card" data-id="<?php echo e($producto->id); ?>" data-order="<?php echo e($producto->order); ?>">
            <div class="carousel" id="carousel<?php echo e($producto->id); ?>">
                <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($media->image_path): ?>
                        <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                            <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" alt="<?php echo e($producto->titulo); ?>">
                        </div>
                    <?php endif; ?>
                    <?php if($media->video_link): ?>
                        <div class="carousel-item <?php echo e($loop->first && !$media->image_path ? 'active' : ''); ?>">
                            <iframe class="video" width="560" height="315"
                                src="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo e($producto->titulo); ?></h5>
                <p class="card-text"><?php echo e($producto->descripcion); ?></p>
                <p>Código: <?php echo e($producto->codigo); ?></p>
                <p>Configuraciones: <?php echo e($producto->configuraciones); ?></p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary m-2 edit-button pb-0"
                            data-id="<?php echo e($producto->id); ?>">Editar</button>
                        <form action="<?php echo e(route('productos.destroy', $producto)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger m-2">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/components/admin-product-list.blade.php ENDPATH**/ ?>