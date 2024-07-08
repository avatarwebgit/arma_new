<table class="table table-striped">
    <thead>
    <tr>
        <th>User ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>email</th>
        <th>Country</th>
        <th>User Type</th>
        <th>Status</th>
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
                <select onchange="ChangeRegisterStatus(this,{{ $item->id }})" class="form-control">
                    <option value="0">Step 1</option>
                    <option value="1">Step 2</option>
                    <option value="2">Create Account</option>
                </select>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
