<div x-data="{ activeTab: {{ $activeTab }} }" class="p-8">
    <div class="tabs tabs-boxed mb-4 bg-base-100">
        @foreach (range(1, 10) as $tab)
            <button @click="activeTab = {{ $tab }}; $wire.selectTab({{ $tab }})"
                :class="{ 'tab-active': activeTab === {{ $tab }} }" class="tab"
                wire:key="tab-{{ $tab }}">
                Category {{ $tab }}
            </button>
        @endforeach
    </div>

    @foreach (range(1, 10) as $content)
        <div x-show="activeTab === {{ $content }}" class="p-6 rounded-lg shadow-lg {{ $colors[$loop->index] }}"
            wire:key="content-{{ $content }}">
            <h2 class="text-2xl font-bold mb-4">Bestsellers in Category {{ $content }}</h2>
            <div class="space-y-4">
                <div class="skeleton h-16"></div>
                <div class="skeleton h-16"></div>
                <div class="skeleton h-16"></div>
                <div>{{ $colors[$loop->index] }}</div>
            </div>
        </div>
    @endforeach
</div>
