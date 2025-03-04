<div class="site-section">

        <div class="container">

            <div class="row mb-5">

                <div class="site-blocks-table" style="width: 1140px !important;">

                    <table class="table table-bordered" >
                          <thead>
                          <tr>
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                            <th class="product-remove">Remove</th>
                          </tr>
                          </thead>
                          <tbody>

                              @foreach ($orderItems as $item)

                                <tr wire:key="cart-item-{{ $item['id'] }}">
                                  <td class="product-thumbnail">
                                    <img src="{{ Storage::url($item['product']['image']) }}" alt="Image" class="img-fluid">
                                  </td>
                                  <td class="product-name">
                                    <h2 class="h5 text-black">{{ $item['product']['name'] }}</h2>
                                  </td>
                                  <td>${{ $item['product']['price'] }}</td>
                                  <td>
                                    <div class="input-group mb-3" style="max-width: 120px;">
                                      <input type="number"
                                             min="1"
                                             class="form-control text-center"
                                             wire:model.defer="orderItems.{{ $loop->index }}.quantity"
                                             wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)">
                                    </div>

                                  </td>
                                  <td>${{ $item['quantity'] * $item['product']['price'] }}</td>
                                  <td><a wire:click="deleteItem({{ $item['id'] }})" href="#" class="btn btn-primary btn-sm">X</a></td>
                                </tr>

                              @endforeach

                          </tbody>
                    </table>

                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        {{--<div class="col-md-6 mb-3 mb-md-0">
                          <button class="btn btn-primary btn-sm btn-block">Update Cart</button>
                        </div>--}}
                        <div class="col-md-6">
                            <a href="{{ route('show-index') }}"><button class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Coupon</label>
                            <p>Enter your coupon code if you have one.</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm">Apply Coupon</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Total</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">${{ number_format($orderItems[0]['order']['total_price'] ?? 0, 2) }}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout.html'">Proceed To Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>