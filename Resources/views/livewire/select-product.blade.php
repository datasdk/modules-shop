<section>
    @if($mainLoading)
        <div>Henter produkt...</div>
    @else
        @if($product)
            <div class="choosen-product">
                @if($product->image)
                    <img src="{{ $product->image }}" width="50" alt="Produktbillede">
                @endif
                {{ $product->name }} – {{ $product->price }} DKK
                <span wire:click="remove" class="close">X Fjern produkt</span>
                <span class="float-right text-muted pr-3">id: {{ $product->id }}</span>
            </div>
        @else
            <input type="text" wire:model.debounce.500ms="searchText" 
                   class="form-control mb-3" placeholder="Søg produkt (navn, kategori, etc.)">
            
            @if($loading)
                <div class="p-2 d-flex">
                    <div>Henter produkter...</div>
                </div>
            @elseif(count($products))
                <div class="mt-3 mb-3"><strong>Vælg produkt fra listen:</strong></div>
                <ul>
                    @foreach($products as $p)
                        <li class="product pl-4 pr-4" wire:click="choose({{ $p->id }})">
                            <span>{{ $p->name }}</span>
                            <span class="float-right pr-3">{{ $p->price }} DKK</span>
                            <span class="float-right text-muted">ID: {{ $p->id }}</span>
                        </li>
                    @endforeach
                </ul>
            @elseif($notFound)
                <div class="text-danger">Produktet blev ikke fundet, og er muligvis blevet slettet!</div>
            @endif
        @endif
    @endif
</section>
