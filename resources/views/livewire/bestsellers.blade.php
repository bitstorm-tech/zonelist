<div x-data="{ activeTab: 0 }" class="flex flex-col gap-6 p-8">
    <div>
        Die Bestseller der vergangenen
        <select class="mx-2">
            <option>7</option>
            <option>14</option>
            <option>30</option>
        </select>
        Tage
    </div>
    <div role="tablist" class="tabs tabs-box">
        @foreach ($categories as $index => $category)
            <a @click="activeTab = {{ $index }}" :class="{ 'tab-active': activeTab === {{ $index }} }"
                class="tab" wire:key="tab-{{ $index }}">
                {{ $category }}
            </a>
        @endforeach
    </div>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
        <legend class="fieldset-legend">Sortierung</legend>
        <div class="flex gap-2">
            <button class="btn btn-primary">Rang ↑</button>
            <button class="btn btn-primary">Preis ↑</button>
            <button class="btn btn-primary">Sterne ↑</button>
            <button class="btn btn-primary">Bewertungen ↑</button>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-primary">Rang ↓</button>
            <button class="btn btn-primary">Preis ↓</button>
            <button class="btn btn-primary">Sterne ↓</button>
            <button class="btn btn-primary">Bewertungen ↓</button>
        </div>
    </fieldset>
    @foreach (range(0, count($categories) - 1) as $index)
        <div x-show="activeTab === {{ $index }}" class="bg-base-200 rounded-lg p-6 shadow-lg"
            wire:key="content-{{ $index }}">
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
</div>
