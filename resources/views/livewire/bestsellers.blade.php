<div id="top" class="flex flex-col gap-6 p-2">
    <!-- --------------- -->
    <!-- Header Controls -->
    <!-- --------------- -->
    <div class="flex gap-1">
        {{-- <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4"> --}}
        {{-- <legend class="fieldset-legend" x-text="`Bestseller der letzten ${lastXDays} Tage`"></legend> --}}
        {{-- <select class="select" x-model="lastXDays"> --}}
        {{-- <option>7</option> --}}
        {{-- <option>14</option> --}}
        {{-- <option>30</option> --}}
        {{-- </select> --}}
        {{-- </fieldset> --}}
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend">Kategorien</legend>
            <select class="select" wire:model.live="activeCategory">
                @foreach ($allCategories as $category)
                    <option>{{ $category }}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend">Sortierung</legend>
            <select class="select" wire:model.live="orderBy">
                @foreach ($orderOptions as $index => $option)
                    <option>{{ $option }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <!-- ------------ -->
    <!-- Product List -->
    <!-- ------------ -->
    <ul class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-3">
        @foreach ($this->productsOfActiveCategory() as $product)
            <livewire:bestseller-list-item :$product wire:key="{{ $product->id }}" />
        @endforeach
    </ul>

    <!-- --------- -->
    <!-- Up Button -->
    <!-- --------- -->
    <div class="sticky bottom-3 left-3">
        <a class="btn btn-primary rounded-full text-xl" href="#top">↑</a>
    </div>

    <!-- ----------- -->
    <!-- Last Update -->
    <!-- ----------- -->
    <span class="text-sm">
        Letzte Aktualisierung:
        <i>{{ $lastUpdate }}</i>
    </span>
</div>
