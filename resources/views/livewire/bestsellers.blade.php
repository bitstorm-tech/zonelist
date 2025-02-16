<div x-data="{ activeTab: 1 }" class="flex flex-col gap-6 p-8">
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
        @foreach (range(1, 10) as $tab)
            <a
                @click="activeTab = {{ $tab }}"
                :class="{ 'tab-active': activeTab === {{ $tab }} }"
                class="tab"
                wire:key="tab-{{ $tab }}"
            >
                Category {{ $tab }}
            </a>
        @endforeach
    </div>
    @foreach (range(1, 10) as $tab)
        <div
            x-show="activeTab === {{ $tab }}"
            class="bg-base-200 rounded-lg p-6 shadow-lg"
            wire:key="content-{{ $tab }}"
        >
            <h2 class="mb-4 text-2xl font-bold">Bestsellers in Category {{ $tab }}</h2>
            <div class="space-y-4">
                <div class="skeleton h-16"></div>
                <div class="skeleton h-16"></div>
                <div class="skeleton h-16"></div>
            </div>
        </div>
    @endforeach
</div>
