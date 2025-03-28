<div x-data="{ activeCategory: '0', selectedSorting: '0', lastXDays: '7' }" class="flex flex-col gap-6 p-2">
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
            <select class="select" x-model="activeCategory">
                @foreach ($categories as $index => $category)
                    <option value="{{ $index }}">{{ $category }}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend">Sortierung</legend>
            <select class="select">
                <option>Rang ↑</option>
                <option>Rang ↓</option>
                <option>Preis ↑</option>
                <option>Preis ↓</option>
                <option>Sterne ↑</option>
                <option>Sterne ↓</option>
                <option>Bewertungen ↑</option>
                <option>Bewertungen ↓</option>
            </select>
        </fieldset>
    </div>

    <!-- ------------- -->
    <!-- Category List -->
    <!-- ------------- -->
    @foreach (range(0, count($categories) - 1) as $index)
        <fieldset
            class="fieldset bg-base-200 border-base-300 rounded-box grid-cols-1 gap-4 border p-4 lg:grid-cols-2 2xl:grid-cols-3"
            x-show="activeCategory === '{{ $index }}'"
            wire:key="content-{{ $index }}"
        >
            <legend class="fieldset-legend text-2xl">
                Bestseller in Kategorie
                <i>{{ $categories[$index] }}</i>
            </legend>
            @foreach ($productGroups[$categories[$index]] as $product)
                <livewire:bestseller-list-item :product="$product" />
            @endforeach
        </fieldset>
    @endforeach

    <!-- ----------- -->
    <!-- Last Update -->
    <!-- ----------- -->
    <span class="text-sm">
        Letzte Aktualisierung:
        <i>{{ $lastUpdate }}</i>
    </span>
</div>
