@extends('admin.layouts.adminLayout')
{{-- page title --}}
@section('title','Акции')
{{-- vendor style --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css"  href="{{asset('assets/css/style.css')}}">
@endsection

@section('content')
    <!-- invoice list -->
    <h1>Акции</h1>

    <hr class="mt-2 mb-3"/>
    <section class="invoice-list-wrapper">

        <a href="{{route('admin.discount.create')}}" class="btn btn-primary">Создать акцию</a>
        <div class="table-responsive">
            <table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>
                        <span class="align-middle">ID</span>
                    </th>
                    <th>Название акции</th>
                    <th>Активность</th>
                    <th>Активен с</th>
                    <th>Активен до</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $discount)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <span class="invoice-amount">{{ $discount->id }}</span>
                        </td>
                        <td><span class="invoice-amount"><a href="{{ route('admin.discount.getById', ['discountId' => $discount->id]) }}">{{ $discount->title }}</a></span></td>
                        <td><span class="invoice-amount">@if($discount->active == 1) Да @else Нет @endif</span></td>

                        <td><span class="invoice-amount">{{ $discount->active_from }}</span></td>
                        <td><span class="invoice-amount">{{ $discount->active_to }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($discounts->lastPage() > 1)
                <ul class="pagination d-flex float-right mt-1">
                    <li class="paginate_button page-item previous " >
                        <a href="{{route('admin.discount.all',$prevPageParams)}}"  class="page-link">Назад</a>
                    </li>
                    @for($i = 1; $i <= $discounts->lastPage() ; $i++)
                        <li class="paginate_button page-item active">
                            <a href="{{route('admin.discount.all',['page'=>$i])}}"   class="page-link">{{$i}}</a>
                        </li>
                    @endfor
                    <li class="paginate_button page-item next " >
                        @php $nextPageParams['page'] = $discounts->currentPage() + 1;  @endphp
                        <a href="{{route('admin.discount.all',$nextPageParams)}}"   class="page-link">Вперед</a>
                    </li>
                </ul>
            @endif
        </div>
    </section>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{asset('js/scripts/discounts/table.js')}}"></script>
    <script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
@endsection
