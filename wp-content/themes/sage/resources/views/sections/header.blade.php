<header class="banner relative">
  <a class="brand" href="{{ home_url('/') }}">
    {!! $siteName !!}
    {{ wp_title()}}
  </a>

  @if ( has_nav_menu('primary_navigation'))
    <nav class="nav-primary bg-violet-400 text-bold text-gray-50 text-2xl"
         aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
    >
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
    </nav>
  @endif
</header>
