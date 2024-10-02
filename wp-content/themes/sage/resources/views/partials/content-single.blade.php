<article @php(post_class('h-entry'))>
  <header>
    <h1 class="p-name text-3xl text-bold text-center p-5">
      {!! $title !!}
    </h1>
  </header>
<div class="flex items-center justify-center w-screen">
  <div class="e-content bg-indigo-400 w-1/2 p-4  rounded-2xl ">
    <div class="text-xs text-gray-50 pb-5">
      @include('partials.entry-meta')
    </div>
    @php(the_content())
  </div>
</div>


  @if ($pagination)
    <footer>
      <nav class="page-nav" aria-label="Page">
        {!! $pagination !!}
      </nav>
    </footer>
  @endif

  @php(comments_template())
</article>
