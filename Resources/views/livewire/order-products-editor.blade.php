<section>
    <div class="clearfix mb-4">
        <div class="float-left">
            <h4>Produkter</h4>
            <p>Søg efter produkter og tilføj dem fra dit lager</p>
        </div>

        <button class="btn btn-primary float-right" wire:click="$set('dialog', true)">
            <span class="mdi mdi-plus"></span> Tilføj produkt
        </button>
    </div>

    @if(count($products) === 0)
        <div class="alert alert-info">Der er endnu ikke tilføjet nogen produkter til ordren.</div>
    @else
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Navn</th>
                    <th>Pris</th>
                    <th>Antal</th>
                    <th>Rabat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ number_format($product['price'], 2) }} DKK</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td></td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="removeProduct({{ $index }})">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table mt-2">
            <tr>
                <td>Subtotal (uden moms):</td>
                <td class="text-right">{{ number_format($subtotal, 2) }} DKK</td>
            </tr>
            <tr>
                <td>Moms (25%):</td>
                <td class="text-right">{{ number_format($vat, 2) }} DKK</td>
            </tr>
            <tr>
                <td>Total (inkl. moms):</td>
                <td class="text-right">{{ number_format($total, 2) }} DKK</td>
            </tr>
        </table>
    @endif

    @if($dialog)
        <div class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg w-1/2">
                <h3 class="text-lg font-bold mb-2">Tilføj produkt</h3>
                <p class="text-sm mb-4">Søg efter produkter og tilføj dem fra dit lager</p>

                <div class="mb-3">
                    <strong>Produkt</strong>
                    <select class="form-control" wire:model="selectedProduct">
                        <option value="">Vælg produkt</option>
                        @foreach($productOptions as $prod)
                            <option value="{{ $prod->toJson() }}">{{ $prod->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>
                        <strong>Antal</strong>
                        <input type="number" min="1" class="form-control" wire:model="selectedQuantity" />
                    </label>
                </div>

                <div class="flex justify-end mt-4">
                    <button class="btn btn-secondary mr-2" wire:click="$set('dialog', false)">Annuller</button>
                    <button class="btn btn-primary" wire:click="addProduct">Tilføj</button>
                </div>
            </div>
        </div>
    @endif
</section>
