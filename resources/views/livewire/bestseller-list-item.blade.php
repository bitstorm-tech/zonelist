<li class="flex flex-col rounded-md border text-base">
    <div class="flex items-start">
        <div class="rounded-br-3xl border-r border-b p-3">{{ $this->rank() }}</div>
        <span class="p-2"><b>{{ $this->title() }}</b></span>
    </div>
    <div class="mx-4 flex justify-between p-4">
        <div class="flex items-center gap-2">
            <livewire:rating-stars stars="{{ $this->stars() }}" />
            <div class="text-xs">({{ $this->ratings() }})</div>
        </div>
        <div>{{ $this->price() }}</div>
    </div>
    <img src="{{ $this->imageUrl() }}" alt="Product image" class="mx-14" />
    <a class="btn m-4 bg-orange-400 text-black" href="{{ $this->productUrl() }}" target="_blank">zum Produkt</a>
</li>
