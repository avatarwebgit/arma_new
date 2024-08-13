<table class="table table-striped">
    <thead>
    <tr class="text-center">
        <th>#</th>
        <th>Date</th>
{{--        <th>Time</th>--}}
        <th>email</th>
        <th>Country</th>
        <th>User Type</th>
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
                {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
            </td>
{{--            <td>--}}
{{--                {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}--}}
{{--            </td>--}}
            <td>
                {{ $item->email }}
            </td>
            <td>
                {{ $item->company_country }}
            </td>
            <td>
                <strong style="width: 40px;display: block;text-align: left;margin: 0 auto">
                    @if($item->user_type==2)
                        Seller
                    @elseif($item->user_type==3)
                        Buyer
                    @else
                        Broker
                    @endif
                </strong>
            </td>
            <td>
                <select onchange="ChangeActivationStatus(this,{{ $item->id }})" class="form-control form-control-sm">
                    @foreach($activation_status as   $activation)
                        <option {{ $item->active==$activation->id ? 'selected' : '' }} value="{{ $activation->id}}">{{ $activation->title }}</option>
                    @endforeach
                </select>
            </td>
            <td class="text-right">
                <a onclick="RejectedUser({{ $item->id }},'{{ $item->reject_reason }}')"
                   style="margin-right: 10px"
                   class="btn btn-sm btn-info text-white mr-2">
                    <i class="icon ion-md-close text-white"></i>
                    Reason
                </a>
{{--                <a style="margin-right: 10px"--}}
{{--                   onclick="ChangeStatus({{ $item->id }},1)"--}}
{{--                   class="btn btn-sm btn-success text-white">--}}
{{--                    <i class="icon ion-md-close text-white"></i>--}}
{{--                    Registering--}}
{{--                </a>--}}
{{--                <a style="margin-right: 10px"--}}
{{--                   onclick="RejectedUser({{ $item->id }})"--}}
{{--                   class="btn btn-sm btn-danger text-white">--}}
{{--                    <i class="icon ion-md-close text-white"></i>--}}
{{--                    Reject--}}
{{--                </a>--}}
                                                                    <a style="margin-right: 10px" onclick="removeModal({{ $item->id }},event)"
                                                                       class="btn btn-sm btn-danger text-white">
                                                                        <i class="icon ion-md-close text-white"></i>
                                                                        Delete
                                                                    </a>
                {{--                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"--}}
                {{--                                                       class="btn btn-sm btn-warning mr-1">--}}
                {{--                                                        <i class="icon ion-md-eye text-white"></i>--}}
                {{--                                                        Edit--}}
                {{--                                                    </a>--}}
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
