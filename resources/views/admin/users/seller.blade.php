<table class="table table-striped">
    <thead>
    <tr class="text-center">
        <th>Confirmed By</th>
{{--        <th>User ID</th>--}}
        <th>Date</th>
{{--        <th>Time</th>--}}
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
<!--                @if($item->created_by!=null)
                 
                    {{ $item->CreatedBy->email ?? '-' }}
               @endif -->
                {{$item->category ?? '-'}}
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
   
                {{ isset($item->Roles()->first()->name) ? ucfirst($item->Roles()->first()->name) : '-' }}
            </td>
            <td>
                {{ $item->commodity }}
            </td>
            <td>
                <select onchange="ChangeActivationStatus(this,{{ $item->id }})" class="form-control">
                    @foreach($activation_status as   $activation)
                        <option {{ $item->active==$activation->id ? 'selected' : '' }} value="{{ $activation->id}}">{{ $activation->title }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                                          <a onclick="showUserPreview({{ $item->id }})"
                   style="margin-right: 10px;padding: 5px 20px"
                   class="btn btn-sm btn-info text-white">
                    <i class="fa fa-eye text-white"></i>

                </a>
                <a style="margin-left: 20px" onclick="removeModal({{ $item->id }},event)"
                   class="btn btn-sm btn-danger text-white">
                    <i class="fa fa-trash text-white"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
