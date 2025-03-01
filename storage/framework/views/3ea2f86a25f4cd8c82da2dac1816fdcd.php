<div id="product-list">
    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 mb-4">
            <div class="card product-card">
                <!-- Mantén el mismo contenido de las cards que tienes en admin.blade.php -->
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($producto->titulo); ?></h5>
                    <!-- ... resto del contenido de la card ... -->
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/admin/productos_partial.blade.php ENDPATH**/ ?>