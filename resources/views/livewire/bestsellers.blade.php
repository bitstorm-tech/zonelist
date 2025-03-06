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
            <h2 class="mb-4 text-2xl font-bold">
                Bestsellers in Kategorie
                <i>{{ $categories[$index]["category"] }}</i>
            </h2>

            <ul class="list bg-base-100 rounded-box shadow-md">
                @foreach ($categories[$index] as $product)
                    <li class="list-row">
                        <div class="text-4xl font-thin tabular-nums opacity-30">01</div>
                        <div>
                            <img
                                class="rounded-box size-10"
                                src="https://img.daisyui.com/images/profile/demo/1@94.webp"
                            />
                        </div>
                        <div class="list-col-grow">
                            <div>Dio Lupa</div>
                            <div class="text-xs font-semibold uppercase opacity-60">Remaining Reason</div>
                        </div>
                        <button class="btn btn-square btn-ghost">
                            <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g
                                    stroke-linejoin="round"
                                    stroke-linecap="round"
                                    stroke-width="2"
                                    fill="none"
                                    stroke="currentColor"
                                >
                                    <path d="M6 3L20 12 6 21 6 3z"></path>
                                </g>
                            </svg>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
