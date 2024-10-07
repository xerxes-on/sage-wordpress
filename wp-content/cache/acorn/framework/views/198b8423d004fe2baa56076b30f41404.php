<article <?php (post_class()); ?> >
  <div class="m-5 bg-indigo-400 p-4 rounded-2xl relative">
    <header>
      <h2 class="entry-title">
        <a href="<?php echo e(get_permalink()); ?>" class="text-2xl hover:text-gray-50">
          <?php echo $title; ?>

        </a>
      </h2>
    </header>
    <div class="entry-summary">
      <?php ( the_excerpt()); ?>
    </div>
    <span class="text-xs text-gray-50 absolute bottom-3 right-3 ">
        <?php echo $__env->make('partials.entry-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </span>
  </div>
</article>
<?php /**PATH /var/www/html/wp-content/themes/sage/resources/views/partials/content.blade.php ENDPATH**/ ?>