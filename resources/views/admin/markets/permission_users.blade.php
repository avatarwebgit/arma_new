@foreach($users as $user)
    <tr>
        <td>
            @if($market->created_market_by!=null)
                {{ 'Armx-'.ucfirst(mb_substr($market->CreatedBy->Roles[0]->name, 0, 1)).(1000+$market->CreatedBy->id) }}
            @else
                -
            @endif
        </td>
        <td>
            {{ $market->date }}
        </td>
        <td>
            <strong>
                {{ isset($user->Roles()->first()->name) ? $user->Roles()->first()->name : '-' }}
            </strong>
        </td>
        <td>
            @if($user->user_id==null or $user->user_id=='')
                <span class="text-danger">User Not Registered</span>
            @else
                {{ $user->user_id }}
            @endif
        </td>
        <td>
            {{ $user->email }}
        </td>

        <td class="text-right">

            {!! Form::open([
'method' => 'POST',
'route' => ['marketPermission.remove', ['user'=>$user->id,'market'=>$market_id]],
'class' => 'd-inline',
]) !!}
            <a href="#"
               class="btn btn-sm small btn-danger show_confirm"
               data-bs-toggle="tooltip" data-bs-placement="bottom"
               title=""
               data-bs-original-title="{{ __('Delete') }}"><i
                    class="ti ti-trash mr-1"></i></a>
            {!! Form::close() !!}
        </td>
    </tr>
@endforeach
