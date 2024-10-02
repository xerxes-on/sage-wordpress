<article <?php (post_class('h-entry')); ?>>
  <header>
    <h1 class="p-name text-3xl text-bold text-center p-5">
      <?php echo $title; ?>

    </h1>
  </header>
<div class="flex items-center justify-center w-screen">
  <div class="e-content bg-indigo-400 w-1/2 p-4  rounded-2xl ">
    <div class="text-xs text-gray-50 pb-5">
      <?php echo $__env->make('partials.entry-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php (the_content()); ?>
  </div>
</div>


  <?php if($pagination): ?>
    <footer>
      <nav class="page-nav" aria-label="Page">
        <?php echo $pagination; ?>

      </nav>
    </footer>
  <?php endif; ?>

  <?php (comments_template()); ?>
</article>
<?php /**PATH /var/www/html/wp-content/themes/sage/resources/views/partials/content-single.blade.php ENDPATH**/ ?>