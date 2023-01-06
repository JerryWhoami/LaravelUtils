<form wire:submit.prevent="authenticate" class="bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8">

  {{ $this->form }}

  <x-filament::button type="submit" class="w-full">
      {{ __('filament::login.buttons.submit.label') }}
  </x-filament::button>
</form>
 
