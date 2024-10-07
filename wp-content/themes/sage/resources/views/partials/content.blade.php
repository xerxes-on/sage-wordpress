<article @php(post_class()) >
  <div class="m-5 bg-indigo-400 p-4 rounded-2xl relative">
    <header>
      <h2 class="entry-title">
        <a href="{{ get_permalink() }}" class="text-2xl hover:text-gray-50">
          {!! $title !!}
        </a>
      </h2>
    </header>
    <div class="entry-summary">
      @php( the_excerpt())
    </div>
    <span class="text-xs text-gray-50 absolute bottom-3 right-3 ">
        @include('partials.entry-meta')
    </span>
  </div>
</article>
