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
        @foreach ($categories as $index => $value)
            <a
                @click="activeTab = {{ $index }}"
                :class="{ 'tab-active': activeTab === {{ $index }} }"
                class="tab"
                wire:key="tab-{{ $index }}"
            >
                {{ $value["category"] }}
            </a>
        @endforeach
    </div>
    @foreach (range(0, count($categories) - 1) as $index)
        <div
            x-show="activeTab === {{ $index }}"
            class="bg-base-200 rounded-lg p-6 shadow-lg"
            wire:key="content-{{ $index }}"
        >
            <h2 class="mb-4 text-2xl font-bold">Bestsellers in Category {{ $categories[$index]["category"] }}</h2>
            <div class="space-y-4">
                <div class="bg-base-300 h-16"></div>
                <div class="bg-base-300 h-16"></div>
                <div class="bg-base-300 h-16"></div>
            </div>
        </div>
    @endforeach
</div>
