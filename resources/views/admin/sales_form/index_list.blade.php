<thead>
<tr class="text-center">
    <th>Row</th>
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
    <tr class="text-center">
        <td>
            {{ $items->firstItem()+$key }}
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
                        {{ $form->commodity }}
{{--            On--}}
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

        <td class="text-right">

            {{--                                                    <a href="{{ route('sale_form',['page_type'=>'Edit','item'=>$form->id]) }}"--}}
            {{--                                                       class="btn btn-sm btn-info text-white mr-1">--}}
            {{--                                                        <i class="fa fa-pen"></i>--}}
            {{--                                                    </a>--}}
            <a href="{{ route('sale_form.show',['id'=>$form->id]) }}"
               class="btn btn-sm btn-primary text-white mr-1">
                <i class="fa fa-eye"></i>
            </a>
            <button onclick="show_change_status_modal({{ $form->id }})"
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
