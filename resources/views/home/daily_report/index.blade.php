<div class="col-12 mb-4">
    <form id="dateFilterForm" class="d-flex justify-content-between">
        <div>
            <label for="startDate">شروع تاریخ:</label>
            <input type="date" id="startDate" name="startDate" required>
        </div>
        <div>
            <label for="endDate">پایان تاریخ:</label>
            <input type="date" id="endDate" name="endDate" required>
        </div>
        <div>
            <button type="button" onclick="printReport()" class="btn btn-primary">پرینت</button>
            <button type="button" onclick="exportToExcel()" class="btn btn-success">خروجی اکسل</button>
        </div>
    </form>
</div>

<div class="col-12">
    <div class="table-responsive">
        <table class="table daily_report">
            <thead>
            <tr style="background-color: #d9d9d9 !important">
                <!-- Header columns as you provided -->
                <td><span>Date</span></td>
                <td><span>Commodity</span></td>
                <td><span>Quantity</span></td>
                <td><span>Min Order</span></td>
                <td><span>Packing</span></td>
                <td><span>Delivery</span></td>
                <td><span>Region</span></td>
                <td><span>Price Type</span></td>
                <td><span>Offer Price</span></td>
                <td><span>Highest Bid</span></td>
                <td><span>Quantity</span></td>
                <td><span>Status</span></td>
            </tr>
            </thead>
            <tbody>
            @foreach($markets as $market)
                @php
                    // Your existing PHP logic here
                @endphp
                <tr class="{{ $status_color }}">
                    <!-- Your existing table data here -->
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col-12 d-flex justify-content-center mt-5">
    {{ $markets->links() }}
</div>

<script>
    // JavaScript functions for print and export
    function printReport() {
        window.print();
    }

    function exportToExcel() {
        // Implement your export logic here
        alert('خروجی اکسل در حال حاضر پیاده‌سازی نشده است.');
    }
</script>
