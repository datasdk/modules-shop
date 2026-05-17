<section>
    @if($paidAt)
        <span class="px-2 py-1 text-green-800 bg-green-100 text-sm rounded">
            {{ $paidAt }}
        </span>
    @else
        <span class="px-2 py-1 text-red-800 bg-red-100 text-sm rounded">
            Ikke betalt
        </span>
    @endif
</section>
