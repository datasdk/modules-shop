@if($items && count($items))
<section>
    <h4>Købsoversigt</h4>
    <p>På denne liste fremgår de varer/ydelser, som kunden har købt</p>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Produktnavn</th>
                <th>Beskrivelse</th>
                <th>Antal</th>
                <th>Pris</th>
                <th>Rabat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['product_name']['da'] ?? '-' }}</td>
                    <td>{!! $item['description']['da'] ?? '' !!}</td>
                    <td>{{ $item['quantity'] ?? 0 }}</td>
                    <td>{{ $this->formatPrice($item['price'] ?? 0) }}</td>
                    <td>{{ $this->formatPrice($item['discount'] ?? 0) }}</td>
                    <td>{{ $this->formatPrice($this->itemTotal($item)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table">
        <tr>
            <th colspan="5" class="text-right">Subtotal (uden moms)</th>
            <td>{{ $this->formatPrice($subtotal) }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">Moms ({{ ($vatRate * 100) }}%)</th>
            <td>{{ $this->formatPrice($vatAmount) }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">Total (inkl. moms)</th>
            <td><strong>{{ $this->formatPrice($total) }}</strong></td>
        </tr>
    </table>
</section>
@endif
