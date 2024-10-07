<form role="search" method="get"
      class="search-form flex items-center justify-center"
      action="{{ home_url('/') }}"
>
  <label>
    <span class="sr-only">
      {{ _x('Search for:', 'label', 'sage') }}
    </span>

    <input
      type="search"
      placeholder="{!! esc_attr_x('Search &hellip;', 'placeholder', 'sage') !!}"
      value="{{ get_search_query() }}"
      name="s"
      class="bg-indigo-400 p-3 border m-5 w-full rounded-2xl text-gray-50"
    >
  </label>

  <button
    class="bg-indigo-400 text-bold text-gray-50 text-2xl p-2 ml-10 rounded-2xl"
  >{{ _x('Search', 'submit button', 'sage') }}</button>
</form>
