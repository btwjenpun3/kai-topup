<div class="payments">
    <div class="row">
        <div class="col-lg-12">
            <div class="heading-section text-center">
                <h4>Pilih Metode Pembayaran</h4>
            </div>
            <div class="payment-parent">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="row">
                            <ul id="accordion" class="accordion">
                                <li>
                                    <div class="link">EWALLET<i class="fa fa-chevron-down"></i></div>
                                    <ul class="submenu">
                                        <div class="row">
                                            @foreach ($ewallets as $ewallet)
                                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                                    <div class="item payment text-center clickable-payment">
                                                        <img src="{{ asset(Storage::url($ewallet->image)) }}"
                                                            class="img-fluid">
                                                        <h4 class="text-sm">{{ $ewallet->name }}</h4>
                                                        <span class="text-sm">Biaya Admin
                                                            {{ $ewallet->admin_fee }}%</span>
                                                        <input id="{{ $ewallet->payment_method }}" type="hidden"
                                                            value="{{ $ewallet->payment_method }}">
                                                        <input class="getPaymentType" type="hidden"
                                                            value="{{ $ewallet->payment_type }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </li>
                                <li>
                                    <div class="link">QRIS<i class="fa fa-chevron-down"></i></div>
                                    <ul class="submenu">
                                        <div class="row">
                                            @foreach ($qris as $q)
                                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                                    <div class="item payment text-center clickable-payment">
                                                        <img src="{{ asset(Storage::url($q->image)) }}"
                                                            class="img-fluid">
                                                        <h4 class="text-sm">{{ $q->name }}</h4>
                                                        <span class="text-sm">Biaya Admin {{ $q->admin_fee }}%</span>
                                                        <input id="{{ $q->payment_method }}" type="hidden"
                                                            value="{{ $q->payment_method }}">
                                                        <input class="getPaymentType" type="hidden"
                                                            value="{{ $q->payment_type }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </li>
                                <li>
                                    <div class="link">VIRTUAL ACCOUNT<i class="fa fa-chevron-down"></i></div>
                                    <ul class="submenu">
                                        <div class="row">
                                            @foreach ($vas as $va)
                                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                                    <div class="item payment text-center clickable-payment">
                                                        <img src="{{ asset(Storage::url($va->image)) }}"
                                                            class="img-fluid">
                                                        <h4 class="text-sm">{{ $va->name }}</h4>
                                                        <span class="text-sm">Biaya Admin Rp.
                                                            {{ number_format($va->admin_fee_fixed, 0, ',', '.') }}</span>
                                                        <input id="{{ $va->payment_method }}" type="hidden"
                                                            value="{{ $va->payment_method }}">
                                                        <input class="getPaymentType" type="hidden"
                                                            value="{{ $va->payment_type }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </li>
                                <li>
                                    <div class="link">OUTLET<i class="fa fa-chevron-down"></i></div>
                                    <ul class="submenu">
                                        <div class="row">
                                            @foreach ($outlets as $outlet)
                                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                                    <div class="item payment text-center clickable-payment">
                                                        <img src="{{ asset(Storage::url($outlet->image)) }}"
                                                            class="img-fluid">
                                                        <h4 class="text-sm">{{ $outlet->name }}</h4>
                                                        <input id="{{ $outlet->payment_method }}" type="hidden"
                                                            value="{{ $outlet->payment_method }}">
                                                        <input class="getPaymentType" type="hidden"
                                                            value="{{ $outlet->payment_type }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
