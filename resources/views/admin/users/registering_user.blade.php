<table class="table table-striped">
    <thead>
    <tr class="text-center">
        <th>#</th>
        <th>Confirmed By</th>
        <th>Date</th>
        <th>email</th>
        <th>Country</th>
        <th>Type</th>
        <th>Commodity</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$item)
        <tr class="text-center">
            <td>
                {{ $users->firstItem()+$key }}
            </td>
            <td>
                @if($item->created_by!=null)
                    {{ $item->CreatedBy->email }}
                @endif
            </td>
            <td>
                {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
            </td>
            <td>
                {{ $item->email }}
            </td>
            <td>
                {{ $item->company_country }}
            </td>
            <td>
                {{ $item->company_country }}
            </td>
            <td>
                @if($item->user_type==2)
                    Seller
                @elseif($item->user_type==3)
                    Buyer
                @else
                    Broker
                @endif
            </td>
            <td style="width: 200px">
                <select onchange="ChangeRegisterStatus(this,{{ $item->id }})" class="form-control">
                    <option {{ $item->active_status==10 ? 'selected' : '' }} value="10">Step 1</option>
                    <option {{ $item->active_status==11 ? 'selected' : '' }} value="11">Step 2</option>
                    <option {{ $item->active_status==2 ? 'selected' : '' }} value="2">Create Account</option>
                </select>
            </td>
            <td style="width: 100px" class="text-right">
                <a onclick="showUserPreview({{ $item->id }})"
                   style="margin-left: 2px;padding: 5px 20px"
                   class="btn btn-sm btn-info text-white">
                    <i class="fa fa-eye text-white"></i>

                </a>
                <a style="margin-left: 2px"
                   onclick="RejectedUser({{ $item->id }},null)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="icon ion-md-close text-white"></i>
                    Reject
                </a>
                <a style="margin-left: 2px" onclick="removeModal({{ $item->id }},event)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="fa fa-trash text-white"></i>
                </a>
                {{--                                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"--}}
                {{--                                                                       class="btn btn-sm btn-warning mr-1">--}}
                {{--                                                                        <i class="icon-md-eye text-white"></i>--}}
                {{--                                                                        Edit--}}
                {{--                                                                    </a>--}}
                {{--                                                    <a href="{{ route('admin.user.wallet',['user'=>$item->id]) }}"--}}
                {{--                                                       class="btn btn-sm btn-info mr-1">--}}
                {{--                                                        <i class="icon ion-md-eye text-white"></i>--}}
                {{--                                                        wallet--}}
                {{--                                                    </a>--}}
                {{--                                                            <a href="{{ route('admin.user.mails',['type'=>$type,'user'=>$item->id]) }}"--}}
                {{--                                                               class="btn btn-sm btn-warning mr-1">--}}
                {{--                                                                Mails--}}
                {{--                                                            </a>--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
