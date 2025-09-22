<x-filament-widgets::widget>
    <x-filament::section>
        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
            <div class="bg-amber-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: {{ $this->getProgress() }}%"> {{ $this->getProgress() }}% Used</div>
          </div>
    </x-filament::section>
</x-filament-widgets::widget>
