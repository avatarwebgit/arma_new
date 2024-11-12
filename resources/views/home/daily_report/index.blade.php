<div class="col-12 mb-4">
    <form id="dateFilterForm" class="d-flex justify-content-between">
        <div class="d-flex">
            <div>
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required>
                <p id="startDate_error" class="input_error_validation d-none">
                    Start Date is Required
                </p>
            </div>
            <div class="ml-3">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required>
                <p id="endDate_error" class="input_error_validation d-none">
                    End Date is Required
                </p>
            </div>
            <div class="ml-3">
                <button style="padding: 2px 10px" type="button" onclick="FilterMarket()" class="btn btn-sm btn-primary">
                    <img src="{{ asset('home/img/loader.png') }}">
                    <span>Filter</span>
                </button>
            </div>
            <div class="ml-3">
                <button style="padding: 2px 10px" type="button" onclick="window.location.reload()" class="btn btn-sm btn-danger">
                    Clear Filter
                </button>
            </div>
        </div>
        <div>
            <button type="button" onclick="printReport()" class="btn btn-sm btn-primary">Print</button>
            <button type="button" onclick="exportToExcel()" class="btn btn-sm btn-success">Excel</button>
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

           Quantity
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
