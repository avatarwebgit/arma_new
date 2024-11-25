<div class="col-12">
    <form id="dateFilterForm" class="d-flex justify-content-between">
        <div class="d-flex">
            <div class="d-flex mb-3 mr-3">
                <div>
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" required>
                    <p id="startDate_error" class="input_error_validation d-none">
                        Start Date is Required
                    </p>
                </div>
                <div class="ml-3 end_date">
                    <label for="endDate">End Date:</label>
                    <input id="endDate" name="endDate" required value="" type="date">
                    <p id="endDate_error" class="input_error_validation d-none">
                        End Date is Required
                    </p>
                </div>
            </div>
            <div class="mb-1">
               <div>
                   <button type="button" onclick="FilterMarket()" class="p-button btn btn-sm btn-primary">
                       <div id="filter_loader" class="loader d-none"></div>
                       <div id="filter_loader_text">Filter</div>
                   </button>
                   <button type="button" onclick="window.location.reload()"
                           class="btn btn-sm btn-danger ml-1 p-button">
                       Clear Filter
                   </button>
               </div>
                <div id="button_desktop">
                    <button type="button" onclick="printReport()" class="p-button btn btn-sm btn-warning ml-1">Print</button>
                    <button type="button" onclick="ExcellExport()" class="p-button btn btn-sm btn-success ml-1">Excel</button>
                </div>
            </div>
        </div>
        <div id="button_mobile">
            <button type="button" onclick="printReport()" class="p-button btn btn-sm btn-warning ml-1">Print</button>
            <button type="button" onclick="ExcellExport()" class="p-button btn btn-sm btn-success ml-1">Excel</button>
        </div>

    </form>
</div>
<div class="col-12">
    <div id="daily_report_table" class="table-responsive">
        <table class="table daily_report">
            <thead>
            <tr style="background-color: #d9d9d9 !important">
                <td>
              <span>
            Date
            </span>
                </td>
                <td>
              <span>
            Time
            </span>
                </td>
                <td>
            <span>
            Commodity
            </span>
                </td>

                <td>
            <span>
              Quantity
            </span>
                </td>
                <td>
             <span>
            Min Order
            </span>
                </td>
                <td>
            <span>
            Packing
            </span>
                </td>
                <td>
             <span>
            Delivery
            </span>
                </td>
                <td>
                        <span>

            Region
            </span>
                </td>
                <td>
                        <span>

            Price Type
            </span>
                </td>
                <td>
                        <span>

            Offer Price
            </span>
                </td>
                <td>
                        <span>

            Highest Bid
            </span>
                </td>
                <td>
                        <span>

           Quantity Bid
            </span>
                </td>
                                <td>
                        <span>

           Trade Value
            </span>
                </td>
                <td>
                        <span>

           Status
            </span>
                </td>
            </tr>
            </thead>
            <tbody id="market_daily_items">
            @include('home.daily_report.row')
            </tbody>
        </table>
    </div>
</div>

<div id="daily_paginate" class="col-12 d-flex justify-content-center mt-5">
    {{ $markets->links() }}
</div>

<form id="excel_form" action="{{ route('home.daily_report.excel') }}" method="post">
    @csrf
    <input type="hidden" id="excel_startDate" name="excel_startDate">
    <input type="hidden" id="excel_endDate" name="excel_endDate">

</form>
