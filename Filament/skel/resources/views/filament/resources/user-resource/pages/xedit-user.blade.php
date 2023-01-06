<x-filament::page
    :widget-data="['record' => $record]"
    :class="\Illuminate\Support\Arr::toCssClasses([
        'filament-resources-create-record-page',
        'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'filament-resources-record-' . $record->getKey(),
    ])"
>
    <div x-cloak x-data="{ tab: 't1' }">
      <div class="font-medium text-center text-gray-500 border-b border-rounded-5 border-gray-200 dark:text-gray-400 dark:border-gray-700 mb-2">
        <ul class="flex flex-wrap -mb-px">
          <li class="mr-2">
            <a href="javascript:" :class="{ 'bg-primary-500 text-white': tab === 't1' }" x-on:click.prevent="tab = 't1'" class="inline-block p-2 rounded-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">{{ __('Editar') }}</a>
          </li>
          <li class="mr-2">
            <a href="javascript:" :class="{ 'bg-primary-500 text-white': tab === 't2' }" x-on:click.prevent="tab = 't2'" class="inline-block p-2 rounded-lg border-b-2 border-blue-600 active dark:text-blue-500 dark:border-blue-500" aria-current="page">{{ __('Adjuntos') }}</a>
          </li>
        </ul>
      </div>
      
      <div x-show="tab === 't1'">
        <x-filament::form wire:submit.prevent="save">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
      </div>

      <div x-show="tab === 't2'">
        @if (count($relationManagers = $this->getCustomRelationManagers(['Adjuntos'])))
          <x-filament::hr />

          <x-filament::resources.relation-managers :active-manager="$activeRelationManager" :managers="$relationManagers" :owner-record="$record" :page-class="static::class" />
        @endif
      </div>

    </div>
</x-filament::page>
