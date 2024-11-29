<thead>
<tr>
    <th>Row</th>
    <th>Account</th>
    <th>Sales Order No.</th>
    <th>Date</th>
    <th>Time</th>
    <th>Commodity</th>
    <th>User ID</th>
    <th>Email</th>
    <th>Status</th>
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
            Account
        </td>
        <td>
            {{ $form->form_id }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($form->crated_at)->format('m/d/Y') }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($form->crated_at)->format('H:m') }}
        </td>
        <td>
            {{--            {{ $form->commodity }}--}}
            On
        </td>
        <td>
            {{ $form->User->user_id }}
        </td>
        <td>
            {{ $form->User->email }}
        </td>
        <td>
            {{ $form->Status->title }}
        </td>

        <td>

            {{--                                                    <a href="{{ route('sale_form',['page_type'=>'Edit','item'=>$form->id]) }}"--}}
            {{--                                                       class="btn btn-sm btn-info text-white mr-1">--}}
            {{--                                                        <i class="fa fa-pen"></i>--}}
            {{--                                                    </a>--}}
            <button onclick="ShowRejectReason('{{ $form->data_pending_message }}')" class="btn btn-info btn-sm">
                Reason
            </button>
            <a href="{{ route('sale_form.show',['id'=>$form->id]) }}"
               class="btn btn-sm btn-primary text-white mr-1">
                <i class="fa fa-eye"></i>
            </a>
            @if(auth()->user()->hasRole(['admin']))
                <button onclick="show_change_status_modal({{ $form->id }},{{$status}})"
                        class="btn btn-sm btn-warning text-white mr-1">
                    change status
                </button>
                <a onclick="removeModal({{ $form->id }},event)"
                   class="btn btn-sm btn-danger text-white mr-1">
                    <i class="fa fa-trash"></i>
                </a>
            @endif
        </td>
    </tr>
@endforeach
</tbody>
