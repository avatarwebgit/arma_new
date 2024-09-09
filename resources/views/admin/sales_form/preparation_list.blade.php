{{--<thead>--}}
{{--<tr>--}}
{{--    <th>Row</th>--}}
{{--    <th>Date</th>--}}
{{--    <th>Time</th>--}}
{{--    <th>Commodity</th>--}}
{{--    <th>User</th>--}}
{{--    <th>Status</th>--}}

{{--    <th></th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--@foreach($items as $key=>$form)--}}
{{--    <tr>--}}
{{--        <td>--}}
{{--            {{ $items->firstItem()+$key }}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            {{ \Carbon\Carbon::parse($form->crated_at)->format('m/d/Y') }}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            {{ \Carbon\Carbon::parse($form->crated_at)->format('H:m') }}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            {{ $form->commodity }}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            {{ $form->User->email }}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <strong>--}}
{{--                {{ $form->Status->title }}--}}
{{--            </strong>--}}
{{--        </td>--}}

{{--        <td>--}}
{{--            <a href="{{ route('sale_form.preparation',['item'=>$form->id]) }}"--}}
{{--               class="btn btn-sm btn-info text-white mr-1">--}}
{{--                <i class="fa fa-pen"></i>--}}
{{--            </a>--}}
{{--            <a onclick="removeModal({{ $form->id }},event)"--}}
{{--               class="btn btn-sm btn-danger text-white mr-1">--}}
{{--                <i class="fa fa-trash"></i>--}}
{{--            </a>--}}

{{--        </td>--}}
{{--    </tr>--}}
{{--@endforeach--}}
{{--</tbody>--}}

<thead>
<tr>
    <th>Row</th>
    <th>Account</th>
    <th>Sales Order No.</th>
    <th>Date</th>
{{--    <th>Time</th>--}}
    <th>Commodity</th>
    <th>User ID</th>
    <th>Email</th>
{{--    <th>Status</th>--}}
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
            @if($form->created_by!=null)
                {{ $form->CreatedBy->user_id }}
            @else
                -
            @endif
        </td>
        <td>
            {{ $form->form_id }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($form->crated_at)->format('m/d/Y') }}
        </td>
{{--        <td>--}}
{{--            {{ \Carbon\Carbon::parse($form->crated_at)->format('H:m') }}--}}
{{--        </td>--}}
        <td>
                        {{ $form->commodity }}
        </td>
        <td>
            {{ $form->User->user_id }}
        </td>
        <td>
            {{ $form->User->email }}
        </td>
{{--        <td>--}}
{{--            {{ $form->Status->title }}--}}
{{--        </td>--}}

        <td>

            <a href="{{ route('sale_form.preparation',['item'=>$form->id]) }}"
               class="btn btn-sm btn-info text-white mr-1">
                <i class="fa fa-pen"></i>
            </a>
            <a onclick="removeModal({{ $form->id }},event)"
               class="btn btn-sm btn-danger text-white mr-1">
                <i class="fa fa-trash"></i>
            </a>

        </td>
    </tr>
@endforeach
</tbody>

