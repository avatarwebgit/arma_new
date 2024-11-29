<div class="col-xl-4">

    <div class="row g-0">
        <div class="col d-flex flex-column bg-light-warning px-6 py-8 rounded-2 me-7 mb-7 mr10">
            <i class="fas fa-list fs-2x text-warning my-2"></i>
            <a href="{{ route('sale_form', ['page_type' => 'Create']) }}" class="text-warning fw-semibold fs-6">
                {{ __('New Sales Order') }}
            </a>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col d-flex flex-column bg-light-primary px-6 py-8 rounded-2 mb-7">
            <i class="fas fa-file fs-2x text-primary my-2"></i>
            <a href="{{ route('sale_form_list',['type'=>'Save']) }}" class="text-primary fw-semibold fs-6">
                Save ( {{ $SalesFormCounts['Save'] }} )
            </a>
        </div>
        <!--end::Col-->
    </div>
    <div class="row g-0">
        <!--begin::Col-->
        <div class="col d-flex flex-column bg-light-danger px-6 py-8 rounded-2 me-7 mb-7 mr10">
            <i class="fas fa-cogs fs-2x text-danger my-2"></i>
            <a href="{{ route('sale_forms',['status'=>5]) }}"
               class="text-danger fw-semibold fs-6 mt-2">
                Previous
            </a>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col d-flex flex-column bg-light-success px-6 py-8 rounded-2 mb-7">
            <i class="fas fa-file-alt fs-2x text-success my-2"></i>
            <a href="{{ route('sale_forms',['status'=>3]) }}"
               class="text-success fw-semibold fs-6 mt-2">
                Pending
            </a>
        </div>
        <!--end::Col-->
    </div>
</div>
