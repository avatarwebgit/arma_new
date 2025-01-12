{{-- // <table class="table table-striped">
//     <thead>
//     <tr class="text-center">
//         <th>#</th>
//         <th>Date</th>
//         <th>Time</th>
//         <th>email</th>
//         <th>Country</th>
//         <th>Type</th>
//         <th>Commodity</th>
//         <th></th>
//     </tr>
//     </thead>
//     <tbody>
//     @foreach($users as $key=>$item)
//         <tr class="text-center">
//             <td>
//                 {{ $users->firstItem()+$key }}
//             </td>
//             <td>
//                 {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
//             </td>
//             <td>
//                 {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}
//             </td>
//             <td>
//                 {{ $item->email }}
//             </td>
//             <td>
//                 {{ $item->company_country }}
//             </td>
//             <td>
//                 @if($item->user_type==2)
//                     Seller
//                 @elseif($item->user_type==3)
//                     Buyer
//                 @else
//                     Broker
//                 @endif
//             </td>
//             <td>
//                 {{ $item->commodity }}
//             </td>
//             <td class="text-right">
//                 <a onclick="showUserPreview({{ $item->id }})"
//                    style="margin-right: 10px;padding: 5px 20px"
//                    class="btn btn-sm btn-info text-white">
//                     <i class="fa fa-eye text-white"></i>

//                 </a>
//                 <a style="margin-right: 10px"
//                    onclick="ChangeStatus({{ $item->id }},1)"
//                    class="btn btn-sm btn-success text-white">
//                     <i class="icon ion-md-close text-white"></i>
//                     Registering
//                 </a>
//                 <a style="margin-right: 10px"
//                    onclick="RejectedUser({{ $item->id }},null)"
//                    class="btn btn-sm btn-danger text-white">
//                     <i class="icon ion-md-close text-white"></i>
//                     Reject
//                 </a>
//                                                                     <a style="margin-left: 20px" onclick="removeModal({{ $item->id }},event)"
//                                                                        class="btn btn-sm btn-danger text-white">
//                                                                         <i class="fa fa-trash text-white"></i>
//                                                                     </a>
// {{--                                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"--}}
// {{--                                                                       class="btn btn-sm btn-warning mr-1">--}}
// {{--                                                                        <i class="icon-md-eye text-white"></i>--}}
// {{--                                                                        Edit--}}
// {{--                                                                    </a>--}}
//                 {{--                                                    <a href="{{ route('admin.user.wallet',['user'=>$item->id]) }}"--}}
//                 {{--                                                       class="btn btn-sm btn-info mr-1">--}}
//                 {{--                                                        <i class="icon ion-md-eye text-white"></i>--}}
//                 {{--                                                        wallet--}}
//                 {{--                                                    </a>--}}
//                 {{--                                                            <a href="{{ route('admin.user.mails',['type'=>$type,'user'=>$item->id]) }}"--}}
//                 {{--                                                               class="btn btn-sm btn-warning mr-1">--}}
//                 {{--                                                                Mails--}}
//                 {{--                                                            </a>--}}
//             </td>
//         </tr>
//     @endforeach
//     </tbody>
// </table>

--}}


<table class="table table-striped">
    <thead>
    <tr class="text-center">
        <th>#</th>
        <th>Confirmed By</th>
        <th>Date</th>
{{--        <th>Time</th>--}}
        <th>email</th>
        <th>Country</th>
        <th>Type</th>
        <th>Commodity</th>
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
                @if($item->user_type==2)
                    Seller
                @elseif($item->user_type==3)
                    Buyer
                @else
                    Broker
                @endif
            </td>
            <td class="text-right">

{{--                <a onclick="RejectedUser({{ $item->id }},'{{ $item->reject_reason }}')"--}}
{{--                   style="margin-right: 10px"--}}
{{--                   class="btn btn-sm btn-info text-white">--}}
{{--                    <i class="icon ion-md-close text-white"></i>--}}
{{--                    Reason--}}
{{--                </a>--}}
                <a style="margin-right: 10px"
                   onclick="showCreateAccountModal('{{ $item->id}}','{{ $item->email }}',{{ $item->user_type }})"
                   class="btn btn-sm btn-success text-white">
                    <i class="icon ion-md-close text-white"></i>
                    Create Account
                </a>
                <a onclick="showUserPreview({{ $item->id }})"
                   style="margin-right: 10px;padding: 5px 20px"
                   class="btn btn-sm btn-info text-white">
                    <i class="fa fa-eye text-white"></i>

                </a>
                <a style="margin-right: 10px"
                   onclick="RejectedUser({{ $item->id }},null)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="icon ion-md-close text-white"></i>
                    Reject
                </a>
                <a style="margin-left: 20px" onclick="removeModal({{ $item->id }},event)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="fa fa-trash text-white"></i>
                </a>
{{--                                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"--}}
{{--                                                                       class="btn btn-sm btn-warning mr-1">--}}
{{--                                                                        <i class="icon ion-md-eye text-white"></i>--}}
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
