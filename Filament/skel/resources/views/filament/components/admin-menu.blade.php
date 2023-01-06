@if(auth()->user()->isAdmin())
<div x-data class="relative">
  <button x-on:click="$refs.adminMenuPanel.toggle" style="margin-inline-start: 1rem;"
    @class([ 'flex flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 items-center justify-center' , 'dark:bg-gray-900'=>
    config('filament.dark_mode'),
    ])
    >
    <x-heroicon-o-user-circle class="w-4 h-4" />
  </button>

  <div x-ref="adminMenuPanel" x-float.placement.bottom-end.flip x-transition:enter="transition"
    x-transition:enter-start="-translate-y-1 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition" x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="-translate-y-1 opacity-0" x-cloak
    class="absolute hidden z-10 mt-2 overflow-y-auto shadow-xl rounded-xl w-52 top-full" style="max-height: 15rem;">
    <ul @class([ 'py-1 space-y-1 overflow-hidden bg-white shadow rounded-xl' , 'dark:border-gray-600 dark:bg-gray-700'=>
      config('filament.dark_mode'),
      ])>
      @foreach ($items as $resource)
      <x-filament::dropdown.item
          :color="'secondary'"
          :href="$resource['url']"
          :icon="$resource['icon']"
          tag="a"
      >
          {{ $resource['label'] }}
      </x-filament::dropdown.item>
      @endforeach
    </ul>
  </div>
</div>
@endif
