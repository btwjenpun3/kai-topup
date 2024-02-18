<div class="flex-row">
    @foreach ($harga as $h)
        @php
            $flashsale = $h->flashsale;
        @endphp
        @if ($h->status == 1 && $h->tipe == 'Membership')
            @if ($flashsale && $flashsale->status == 1 && $flashsale->stock > 0 && $flashsale->expired_at > $now)
                <div class="flex-column item text-center clickable-item">
                    <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                    <h4 class="text-md">{{ $h->nama_produk }}</h4>
                    <span class="text-danger"><s>Rp.
                            {{ number_format($h->harga_jual, 0, ',', '.') }}</s></span>
                    <span>Rp.
                        {{ number_format($h->flashsale->final_price, 0, ',', '.') }}</span>
                    <input id="getItemId-{{ $h->id }}" type="hidden" value="{{ $h->id }}" />
                    <input id="getItemPrice-{{ $h->id }}" type="hidden"
                        value="{{ $h->flashsale->final_price }}" />
                    <input id="getItemName-{{ $h->id }}" type="hidden" value="{{ $h->nama_produk }}" />
                </div>
            @else
                <div class="flex-column item text-center clickable-item">
                    <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                    <h4 class="text-md">{{ $h->nama_produk }}</h4>
                    <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                    @if ($game->kategori == 'Voucher')
                        <p>{{ $h->deskripsi }}</p>
                    @endif
                    <input id="getItemId-{{ $h->id }}" type="hidden" value="{{ $h->id }}" />
                    <input id="getItemPrice-{{ $h->id }}" type="hidden" value="{{ $h->harga_jual }}" />
                    <input id="getItemName-{{ $h->id }}" type="hidden" value="{{ $h->nama_produk }}" />
                </div>
            @endif
        @elseif(($h->harga_jual < $h->modal && $h->tipe == 'Membership') || ($h->status == 3 && $h->tipe == 'Membership'))
            <div class="flex-column item text-center offline">
                <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                <h4 class="text-md">{{ $h->nama_produk }}</h4>
                <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
            </div>
        @endif
    @endforeach
</div>
