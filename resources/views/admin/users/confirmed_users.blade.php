<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Time</th>
        <th>email</th>
        <th>Country</th>
        <th>User Type</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$item)
        <tr>
            <td>
                {{ $users->firstItem()+$key }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}
            </td>
            <td>
                {{ $item->email }}
            </td>
            <td>
                {{ $item->company_name }}
            </td>
            <td>
                {{ isset($item->Roles()->first()->name) ? $item->Roles()->first()->name : '-' }}
            </td>
            <td>

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
                                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"
                                                                       class="btn btn-sm btn-warning mr-1">
                                                                        <i class="icon ion-md-eye text-white"></i>
                                                                        Edit
                                                                    </a>
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