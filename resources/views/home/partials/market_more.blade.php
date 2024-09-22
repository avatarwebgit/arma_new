<td colspan="11">
    <table class="table_in_table" style="width: 100%">
        <tr>
            <td class="text-center">
                <span class="text-bold">Contract Type</span>
                <span>
                                    @auth
                        {{ $market->SalesForm->contract_type }}
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>

                    @endif
                                </span>
            </td>
            <td class="text-center">
                <span class="text-bold">Min Order</span>
                <span>
                                    @auth
                        {{ $market->SalesForm->min_order }}
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>

            <td class="text-center">
                <span class="text-bold">Supplier</span>
                <span>
                                    @auth
                        {{ $market->SalesForm->company_type }}
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>


        </tr>
        <tr>
            <td class="text-center">
                <span class="text-bold">Specification</span>
                <span>
                                                                @auth
                        Available
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                                            </span>
            </td>
            <td class="text-center">
                <span class="text-bold">Price Type</span>
                <span>
                                    @auth
                        {{ $market->SalesForm->price_type }}
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>
            <td class="text-center">
                <span class="text-bold">Payment</span>
                <span>
                                    @auth
                        LC/TT/DP/DA
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>

        </tr>
        <tr>
            <td class="text-center">
                <span class="text-bold">Offer Price</span>
                <span>
                    @auth
                        @if($market->SalesForm->price_type=='Fix')
                            {{ number_format($market->SalesForm->price) }}
                        @else
                            {{ number_format($market->SalesForm->alpha)  }}
                        @endif
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                                            </span>
            </td>



            <td class="text-center">
                <span class="text-bold">Currency</span>
                <span>
                                        @auth
                        {{ $market->SalesForm->currency }}
                    @else
                        <a href="#" onclick="ShowLoginModal({{ $market->id }})" class="text-login">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>
            <td class="text-center">
                <span class="text-bold">Unit</span>
                <span>
                                    @auth
                        {{ $market->SalesForm->unit }}
                    @else
                        <a href="#" class="text-info" onclick="ShowLoginModal({{ $market->id }})">
                            Log in
                        </a>
                        /
                        <a href="#" onclick="ShowRegisterModal()" class="text-register">
                            Register
                        </a>
                    @endauth
                                </span>
            </td>
        </tr>
    </table>
</td>
