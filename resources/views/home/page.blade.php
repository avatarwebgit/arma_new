@extends('home.homelayout.app')

@section('style')
<style>
    td,th{
        border: none !important;
    }
    th{
       color: #036f88  !important;
        position: relative;
    }
    th:before{
        content: "";
        position: absolute;
        top: 8px !important;
        left: 10px !important;
        width: 2px;
        height: 20px !important;
        background-color: #ffa700;
    }
</style>
@endsection

@section('script')

@endsection



@section('content')

    <div class="landing-feature">
        <div class="container">
            @if($page!=null)
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ $page->title }}</h2>
                    </div>
                    <div class="col-md-12">
                        {!! $page->description !!}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <table class="table table-responsive-sm text-left">
                        <thead class="p-5 text-white" style="background-color: #006">
                        <tr>
                            <td style="font-size: 17pt">Market</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <thead>
                        <tr>
                            <th scope="col">Chemical Fertilizer & Agricalture</th>
                            <th scope="col">Polymer</th>
                            <th scope="col">Chemicals</th>
                            <th scope="col">Aromatics</th>
                            <th scope="col">Fule</th>
                            <th scope="col">Refinery Products</th>
                            <th scope="col">Miniral</th>
                            <th scope="col">Metal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Urea</td>
                            <td>HDEP</td>
                            <td>Butadiane</td>
                            <td>Banzen</td>
                            <td>Light Hydrocarbon</td>
                            <td>Bitumen</td>
                            <td>Iron ore</td>
                            <td>Copper</td>
                        </tr>
                        <tr>
                            <td>Phosphate</td>
                            <td>LDPE</td>
                            <td>Buten 1</td>
                            <td>Paralaizen</td>
                            <td>Heavey Hydeocarbon</td>
                            <td>Lubcat</td>
                            <td>Coal</td>
                            <td>Steel</td>
                        </tr>
                        <tr>
                            <td>AN</td>
                            <td>LLDPE</td>
                            <td>Aside Asetic</td>
                            <td>Ortolizen</td>
                            <td>LPG</td>
                            <td>Vacum Battom</td>
                            <td>Cement</td>
                            <td>Aluminum</td>
                        </tr>
                        <tr>
                            <td>UAN</td>
                            <td>ABS</td>
                            <td>Propylen</td>
                            <td>Toluen</td>
                            <td>C3+</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Weaht</td>
                            <td>PET</td>
                            <td>Methanol</td>
                            <td>Parazaelien</td>
                            <td>C5+</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Corn</td>
                            <td></td>
                            <td>Sulphur</td>
                            <td>Asetairen</td>
                            <td>MTBE</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('home.partials.footer')

@endsection
