@extends('admin.layouts.adminLayout')
{{-- page title --}}
@section('title','Изменение акции')
{{-- page styles --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">

@endsection
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css"  href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-file-manager.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/summernote.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">

@endsection


@section('content')
    <!-- File Manager app overlay -->
    <h2>Изменение акции</h2>
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.discount.edit',['discountId'=>$discount->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Элемент</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="name">Заголовок</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ $discount->title }}" required>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="slug">URL*</label>
                                        <input type="text" class="form-control"  name="slug" id="slug"
                                               value="{{ $discount->slug }}" required>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="menu_type">Активность</label>
                                        <div class="custom-control custom-switch custom-switch-success custom-switch-glow custom-control-inline mb-1 d-block">
                                            <input type="hidden" name="active" value="0" />
                                            <input type="checkbox" {{(intval($discount->active))? "checked" : ""}} class="custom-control-input" id="customSwitchGlow2" name="active" value="1"  >

                                            <label class="custom-control-label" for="customSwitchGlow2"></label>
                                        </div>
                                    </fieldset>
                                    <div class="mb-1">
                                        <h6>Активность с </h6>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control pickadate" name="active_from" placeholder="Выбрать дату" value="{{date('d F, Y',strtotime($discount->active_from))}}">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar'></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="mb-1">
                                        <h6>Активность до </h6>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control pickadate" name="active_to" placeholder="Выбрать дату" value="{{date('d F, Y',strtotime($discount->active_to))}}">
                                            <div class="form-control-position">
                                                <i class='bx bx-calendar'></i>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <fieldset class="form-group">
                                        <label for="name">Анонс</label>
                                        <input type="text" name="announce" class="form-control"
                                               value="{{ $discount->announce }}" required>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="name">Описание</label>
                                        <textarea id="summernote" name="description">{{ $discount->description }}</textarea>
                                    </fieldset>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Фотография</h4>
                        </div>
                        <div class="card-body">
                            <div class="row photo-banner">
                                <img src="{{"/uploads/discount/280x192/".$discount->img_path}}">
                            </div>
                            <div class="dropzone dropzone-area upload-discount-photo">
                                <div class="dz-message">Перетащите файлы в формате .jpg, .png, .gif сюда</div>
                                <input type="hidden" class="discount_img_path"  name="img_path" value="{{$discount->img_path}}">
                            </div>
                            <input type="hidden" id="drop-zone-route" value="{{route('admin.discount.upload')}}">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Параметры скидки</h4>
                        </div>
                        <div class="card-body">
                            <fieldset class="form-group">
                                <label for="proteins">Вид скидки</label>
                                <select class="form-group discount_type" name="discount_type">
                                    @foreach(\App\Models\SeasonDiscount::DISCOUNT_TYPE_LABELS as $keyDiscount => $valueDiscount )
                                         <option {{($discountType == $keyDiscount)? "selected" : ""}} value="{{$keyDiscount}}"> {{$valueDiscount}}</option>
                                    @endforeach
                                </select>
                            </fieldset>


                            <fieldset class="form-group">
                                <label for="proteins">Скидка</label>
                                <select class="form-group" name="discount_param">
                                     @foreach(\App\Models\SeasonDiscount::DISCOUNT_PARAM_LABELS as $discountParamKey => $discountParamValue)
                                        <option {{($discount->discount_param == $discountParamKey)? "selected" : ""}} value="{{$discountParamKey}}"> {{$discountParamValue}}</option>
                                     @endforeach
                                </select>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="carbohydrates">Размер скидки</label>
                                <input type="text" class="form-control"  name="discount_size"
                                       value="{{ $discount->discount_size }}">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="proteins">Условия скидки</label>
                                <select class="form-group" name="condition_discount_type">
                                    @foreach(\App\Models\SeasonDiscount::CONDITION_DISCOUNT_TYPE_LABELS as $discountConditionTypeKey => $discountConditionTypeValue)
                                        <option {{($discount->condition_discount_type == $discountConditionTypeKey)? "selected" : ""}} value="{{$discountConditionTypeKey}}"> {{$discountConditionTypeValue}} </option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="carbohydrates">Сумма заказа</label>
                                <input type="text" class="form-control"  name="price_order"
                                       value="{{ $discount->price_order }}">
                            </fieldset>
                        </div>
                    </div>

                    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_PRODUCTS)
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Состав акции</h4>
                        </div>
                        <table class="col-10 ml-2" id="products-result">
                            <th>ID</th>
                            <th>Название</th>
                            <th>Активность</th>
                            <th>В продаже</th>
                            <th>Остатки</th>
                            <th>Цена</th>
                            <th></th>
                            @foreach($discountProducts as $discountProduct)
                                <tr>
                                    <input type="hidden" name="products[]" value="{{$discountProduct->id}}">
                                    <td>{{$discountProduct->id}}</td>
                                    <td>{{$discountProduct->name}}</td>
                                    <td>{{$discountProduct->active}}</td>
                                    <td>{{$discountProduct->onsale}}</td>
                                    <td>{{$discountProduct->min_balance}}</td>
                                    <td>{{$discountProduct->price}}</td>
                                    <td class='remove-product-result' style='cursor: pointer'> X </td>
                                </tr>
                            @endforeach


                        </table>
                        <fieldset>
                            <button type="button" class="btn btn-primary mt-3 ml-2 mb-2 add-product-button">Добавить продукты</button>

                        </fieldset>

                    </div>
                    @endif
                    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_CATEGORY )
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">Состав акции</h4>
                            </div>
                            <table class="col-10 ml-2" id="category-result">
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Активность</th>
                                    <th>Сортировка</th>
                                </tr>
                                @foreach($discountCategories as $categoryItem)
                                <tr>
                                    <input type="hidden" name="categories[]" value="{{$categoryItem->id}}">

                                    <td>{{$categoryItem->id}}</td>
                                    <td>{{$categoryItem->name}}</td>
                                    <td>{{$categoryItem->active}}</td>
                                    <td>{{$categoryItem->sort}}</td>
                                    <td class='remove-category-result' style='cursor: pointer'> X </td>
                                </tr>
                                @endforeach
                            </table>

                            <fieldset>
                                <button type="button" class="btn btn-primary mt-3 ml-2 mb-2 add-category-button">Добавить категорию</button>
                            </fieldset>

                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>


      </div>

    </section>
    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_PRODUCTS)
        <div class="table-responsive modal-products d-none  col-12 " style="position: fixed; z-index: 9999;  left:0;  top:0%; height:100%; background-color: #F2F4F4">
        <input type="hidden" disabled id="getProductForModalRoute" value="{{route('admin.discount.getProductsForModal')}}">
        <div class="ml-3 mt-2">
            <input type="text" class="form-control col-2 search-product "  placeholder="Поиск">
            <form action="" class="form-products">
            <table id="products" class="table table-striped table-bordered" style="width:99%;">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Название товара</th>
                    <th>Дата создания</th>
                    <th>Активность</th>
                    <th>В продаже</th>
                    <th>Остатки</th>
                    <th>Цена,руб</th>
                </tr>

            </table>
            </form>
        </div>

        @if($products->lastPage() > 1)
        <ul class="pagination d-flex float-right mt-1">
            <li class="paginate_button page-item previous " >
                <a href="{{route('admin.discount.getProductsForModal',$prevPageParams)}}"  class="page-link">Назад</a>
            </li>
            @for($i = 1; $i <= $products->lastPage() ; $i++)
                <li class="paginate_button page-item active">
                    <a  href="{{route('admin.discount.getProductsForModal',['page'=>$i])}}"   class="page-link">{{$i}}</a>
                </li>
            @endfor
            <li class="paginate_button page-item next " >
                @php $nextPageParams['page'] = $products->currentPage() + 1;  @endphp
                <a href="{{route('admin.discount.getProductsForModal',$nextPageParams)}}"   class="page-link">Вперед</a>
            </li>
        </ul>
        @endif


        <button class="btn btn-primary save-products">Сохранить</button>
        <button class="btn btn-dark cancel-modal-products">Отмена</button>
    </div>
    @endif
    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_CATEGORY)
        <div class="table-responsive modal-category d-none  col-12 " style="position: fixed; z-index: 9999;  left:0;  top:0%; height:100%; background-color: #F2F4F4">
            <input type="hidden" disabled id="getCategoryForModalRoute" value="{{route('admin.discount.getCategoriesForModal')}}">
            <div class="ml-3 mt-2">
                <input type="text" class="form-control col-2 search-category "  placeholder="Поиск">
                <form action="" class="form-categories">
                    <table id="categories" class="table table-striped table-bordered" style="width:99%;">
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Название категории</th>
                            <th>Активность</th>
                            <th>Сортировка</th>
                            <th>Дата создания</th>
                        </tr>
                    </table>
                </form>
            </div>

            @if($categories->lastPage() > 1)
                <ul class="pagination d-flex float-right mt-1">
                    <li class="paginate_button page-item previous " >
                        <a href="{{route('admin.discount.getCategoriesForModal',$prevPageParams)}}"  class="page-link">Назад</a>
                    </li>
                    @for($i = 1; $i <= $categories->lastPage() ; $i++)
                        <li class="paginate_button page-item active">
                            <a  href="{{route('admin.discount.getCategoriesForModal',['page'=>$i])}}"   class="page-link">{{$i}}</a>
                        </li>
                    @endfor
                    <li class="paginate_button page-item next " >
                        @php $nextPageParams['page'] = $categories->currentPage() + 1;  @endphp
                        <a href="{{route('admin.discount.getCategoriesForModal',$nextPageParams)}}"   class="page-link">Вперед</a>
                    </li>
                </ul>
            @endif


            <button class="btn btn-primary save-categories">Сохранить</button>
            <button class="btn btn-dark cancel-modal-categories">Отмена</button>
        </div>
    @endif
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
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script src="{{asset('vendors/js/file-uploaders/dropzone.js')}}"></script>
@endsection
{{-- page scrips --}}
@section('page-scripts')
    <script src="{{asset('js/scripts/translite.js')}}"></script>
    <script type="text/javascript">
        $('#name').keyup(function () {
            $('#slug').val(urlRusLat($(this).val()));
        });
    </script>
    <script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
    <script src="{{asset('js/scripts/summernote.js')}}"></script>
    <script src="{{asset('js/scripts/discounts/discounts.js')}}"></script>
    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_PRODUCTS)   <script src="{{asset('js/scripts/discounts/discountProduct.js')}}"></script> @endif
    @if($discountType == \App\Models\SeasonDiscount::DISCOUNT_TYPE_CATEGORY)   <script src="{{asset('js/scripts/discounts/discountCategory.js')}}"></script> @endif
    <script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>



@endsection
