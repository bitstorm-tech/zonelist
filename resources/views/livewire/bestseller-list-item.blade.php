<div class="flex flex-col rounded-md border text-base">
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
    <div class="m-4 block border p-10 py-72">Image</div>
    <a class="btn btn-primary m-4" href="amazone.de">zum Produkt</a>
</div>
