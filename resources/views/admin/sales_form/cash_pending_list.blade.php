<thead>
<tr>
    <th>Row</th>
    <th>Date</th>
    <th>Time</th>
    <th>Commodity</th>
    <th>User</th>
    <th>Status</th>
    <th>Amount</th>
    <th></th>
</tr>
</thead>
<tbody>
@foreach($items as $key=>$form)
    <tr>
        <td>
            {{ $items->firstItem()+$key }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($form->crated_at)->format('m/d/Y') }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($form->crated_at)->format('H:m') }}
        </td>
        <td>
            {{ $form->commodity }}
        </td>
        <td>
            {{ $form->User->email }}
        </td>
        <td>
            {{ $form->Status->title }}
        </td>
        <td>
            @if($form->deposit_value==" " or $form->deposit_value==null)
                -
            @else
                <strong>
                    {{ number_format($form->deposit_value).' ('.$form->cash_pending_currency.')' }}
                </strong>
            @endif
        </td>

        <td>


            <a href="{{ route('sale_form.show',['id'=>$form->id]) }}"
               class="btn btn-sm btn-primary text-white mr-1">
                <i class="fa fa-eye"></i>
            </a>
            <button onclick="EditCurrency({{$form->id}},'{{ $form->deposit_value }}','{{ $form->cash_pending_currency }}')" class="btn btn-sm btn-info text-white mr-1">
                <i class="fa fa-pen"></i>
            </button>
            <button onclick="show_change_status_modal({{ $form->id }},6)"
                    class="btn btn-sm btn-warning text-white mr-1">
                change status
            </button>
            <a onclick="removeModal({{ $form->id }},event)"
               class="btn btn-sm btn-danger text-white mr-1">
                <i class="fa fa-trash"></i>
            </a>

        </td>
    </tr>
@endforeach
</tbody>
