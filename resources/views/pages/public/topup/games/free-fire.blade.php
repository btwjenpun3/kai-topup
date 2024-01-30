<div class="col-md-12">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h5>💎 Diamond</h5>
        </div>
    </div>
    <div class="row">
        @foreach ($harga as $h)
            @if ($h->status == 1 && $h->tipe == 'Umum')
                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                    <div class="item text-center clickable-item">
                        <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                        <h4 class="text-md">{{ $h->nama_produk }}</h4>
                        <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                        <input id="getItemId-{{ $h->id }}" type="hidden" value="{{ $h->id }}" />
                        <input id="getItemPrice-{{ $h->id }}" type="hidden" value="{{ $h->harga_jual }}" />
                        <input id="getItemName-{{ $h->id }}" type="hidden" value="{{ $h->nama_produk }}" />
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
{{-- <hr>
<div class="col-md-12">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h5>✨ Membership</h5>
        </div>
    </div>
    <div class="row">
        @foreach ($harga as $h)
            @if ($h->status == 1 && $h->tipe == 'Membership')
                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                    <div class="item text-center clickable-item">
                        <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                        <h4 class="text-md">{{ $h->nama_produk }}</h4>
                        <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                        <input id="getItemId-{{ $h->id }}" type="hidden" value="{{ $h->id }}" />
                        <input id="getItemPrice-{{ $h->id }}" type="hidden" value="{{ $h->harga_jual }}" />
                        <input id="getItemName-{{ $h->id }}" type="hidden" value="{{ $h->nama_produk }}" />
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div> --}}
