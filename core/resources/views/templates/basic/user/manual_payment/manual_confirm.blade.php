@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container pt-80 pb-80">
        <div class="card custom--card card-deposit">
            <div class="card-header py-3 text-center">
                <h5 class="title"><span>{{__($pageTitle)}}</span></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="text-center mb-5 light--color-pay">
                            <p class="text-center mt-2">@lang('You have requested') <b class="text-success">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                <b class="text-success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                            </p>
                            <h4 class="text-center mb-2">@lang('Please follow the instruction below')</h4>
                            
                            <p class="mb-4 text-center ">@php echo  $data->gateway->description @endphp</p>
                        </div>


                        @if($method->gateway_parameter)

                        @foreach(json_decode($method->gateway_parameter) as $k => $v)

                            @if($v->type == "text")
                                    <div class="form-group mb-3">
                                        <label class="form--label"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                        <input type="text" class="form-control form--control bg--section" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}">
                                    </div>
                            @elseif($v->type == "textarea")
                                        <div class="form-group mb-3">
                                            <label class="form--label"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                            <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3">{{old($k)}}</textarea>

                                        </div>
                            @elseif($v->type == "file")
                                    <div class="form-group mb-3">
                                        <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                        <input type="file" class="form-control form--control bg--section" name="{{$k}}" accept="image/*">
                                    </div>
                            @endif
                        @endforeach
                    @endif
                        <div class="form-group mb-3">
                            <button type="submit" class="cmn--btn mt-2">@lang('Pay Now')</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
