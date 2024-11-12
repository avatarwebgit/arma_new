<div class="col-12">
    <div class="table-responsive">
        <table class="table daily_report">
            <thead>
            <tr style="background-color: #d9d9d9 !important">
                <td>
              <span>
            Date
            </span>
                </td>
                <td>
            <span>
            Commodity
            </span>
                </td>

                <td>
            <span>
              Quantity
            </span>
                </td>
                <td>
             <span>
            Min Order
            </span>
                </td>
                <td>
            <span>
            Packing
            </span>
                </td>
                <td>
             <span>
            Delivery
            </span>
                </td>
                <td>
                        <span>

            Region
            </span>
                </td>
                <td>
                        <span>

            Price Type
            </span>
                </td>
                <td>
                        <span>

            Offer Price
            </span>
                </td>
                <td>
                        <span>

            Highest Bid
            </span>
                </td>
                <td>
                        <span>

           Quantity
            </span>
                </td>
                <td>
                        <span>

           Status
            </span>
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach($markets as $market)
                @php
                    $bid=$market->Bids()->orderBy('price','desc')->first();

                    $has_winner=$market->Bids()->where('is_win',1)->exists();
                    if ($has_winner){
                        $status_color='green';
                        $status_text='Done';
                    }else{
                         $status_color='red';
                        $status_text='Failed';
                    }
                    if ($market->SalesForm->unit=='other' or $market->SalesForm->unit=='Other'){
                        $unit=$market->SalesForm->unit_other;
                    }else{
                        $unit=$market->SalesForm->unit;
                    }
                    if ($market->SalesForm->currency=='other' or $market->SalesForm->currency=='Other'){
                        $currency=$market->SalesForm->currency_other.'/'.$unit;
                    }else{
                        $currency=$market->SalesForm->currency.'/'.$unit;
                    }

                    if ($bid){

                        $highest=$bid->price.' '.$currency;
                        $quantity=$bid->quantity.' '.$unit;
                    }else{
                        $highest=0;
                        $quantity=0;
                    }

                @endphp
                <tr class="{{ $status_color }}">
                    <td>
              <span>
            {{ $market->date }}
            </span>
                    </td>
                    <td>
            <span>
            {{ $market->SalesForm->commodity }}
            </span>
                    </td>

                    <td>
            <span>

             {{ $market->SalesForm->max_quantity.' '.$unit }}
            </span>
                    </td>
                    <td>
             <span>
                  @php
                      $minQuantity=str_replace(',','',$market->SalesForm->min_order);
                  @endphp
                 {{ number_format($minQuantity).' '.$unit }}
            </span>
                    </td>
                    <td>
            <span>
             {{ $market->SalesForm->packing }}
            </span>
                    </td>
                    <td>
             <span>
            {{ $market->SalesForm->incoterms }}
            </span>
                    </td>
                    <td>
                        <span>

            {{ $market->SalesForm->origin_country }}
            </span>
                    </td>
                    <td>
                        <span>

            {{ $market->SalesForm->price_type }}
            </span>
                    </td>
                    @if($market->SalesForm->price_type=='Fix')
                        <td>{{ number_format($market->SalesForm->price).' '.$currency }}</td>
                    @else
                        <td>{{ number_format($market->SalesForm->alpha) .' '.$currency }}</td>
                    @endif
                    <td>
                        <span>



                            {{ $highest==0 ? 'N.A' : $highest }}

            </span>
                    </td>
                    <td>
                        <span>

           {{ $quantity==0? 'N.A' : $quantity }}
            </span>
                    </td>
                    <td>
                        <span>

           {{ $status_text }}
            </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col-12 d-flex justify-content-center mt-5">
    {{ $markets->links() }}
</div>
