<div x-data="{ activeCategory: '0', selectedSorting: '0', lastXDays: '7' }" class="flex flex-col gap-6 p-8">
    <!-- --------------- -->
    <!-- Header Controls -->
    <!-- --------------- -->
    <div class="flex gap-1">
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend" x-text="`Bestseller der letzten ${lastXDays} Tage`"></legend>
            <select class="select" x-model="lastXDays">
                <option>7</option>
                <option>14</option>
                <option>30</option>
            </select>
        </fieldset>
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
        <div
            x-show="activeCategory === '{{ $index }}'"
            class="bg-base-200 rounded-lg p-6 shadow-lg"
            wire:key="content-{{ $index }}"
        >
            <h2 class="mb-4 text-2xl font-bold">
                Bestseller in Kategorie
                <i>{{ $categories[$index] }}</i>
            </h2>
            <div class="rounded-box border-base-content/5 bg-base-100 overflow-x-auto border">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Artikel</th>
                            <th>Sterne</th>
                            <th>Bewertungen</th>
                            <th>Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productGroups[$categories[$index]] as $product)
                            <livewire:bestseller-list-item :product="$product" />
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <!-- ----------- -->
    <!-- Last Update -->
    <!-- ----------- -->
    <span class="text-sm">
        Letzte Aktualisierung:
        <i>{{ $lastUpdate }}</i>
    </span>
</div>
