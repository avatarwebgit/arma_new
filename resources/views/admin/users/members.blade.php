<button class="btn btn-success btn-sm mb-2" onclick="CreateMember('{{ $type }}')">Create +</button>
<table class="table table-striped">
    <thead>
    <tr class="text-center">
        <th>Confirmed By</th>
        <th>User ID</th>
        <th>Date</th>
{{--        <th>Time</th>--}}
        <th>email</th>
        <th>Country</th>
        <th>Type</th>
        <th>Edit</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$item)
        <tr class="text-center">
            <td>
                @if($item->created_by!=null)
                    {{ $item->CreatedBy->email }}
                @endif
            </td>
            <td>
                <strong class="text-info">
                    {{ $item->user_id }}
                </strong>
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
                <strong>
                    @if(isset($item->Roles()->first()->name))
                        @if($item->Roles()->first()->name=='Members')
                            Member
                        @else
                            {{ $item->Roles()->first()->name }}
                        @endif
                    @else
                        -
                    @endif
                </strong>
            </td>
            <td>
                {{ $item->commodity }}
            </td>
            <td>
               <i onclick="ShowEditModal({{ $item->id }})" class="fa fa-edit fa-2x" style="cursor: pointer"></i>
            </td>
            <td>
                <select onchange="ChangeActivationStatus(this,{{ $item->id }})" class="form-control">
                    @foreach($activation_status as   $activation)
                        <option {{ $item->active==$activation->id ? 'selected' : '' }} value="{{ $activation->id}}">{{ $activation->title }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <a style="margin-left: 20px" onclick="removeModal({{ $item->id }},event)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="fa fa-trash text-white"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
