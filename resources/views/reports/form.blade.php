@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            {!! Form::open() !!}

            <div class="panel-body">
                <div class="form-group">
                    <label for="title">Select Country:</label>
                    {!! Form::select('country',$countries,null, ['placeholder' => 'select Country', 'id'=>'country', 'class'=>'form-control', 'style'=>'width:350px;'])!!}

                </div>
                <div class="form-group">
                    <label for="title">Select State:</label>
                    <select name="state" id="state" class="form-control" style="width:350px">
                    </select>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@section('pagescript')
<script>
    $('#country').change(function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:"GET",
                url:"{{url('reports/get-loja-list')}}?country_id="+countryID,
                success:function(res){
                    if(res){
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#state").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#state").empty();
                    }
                }
            });
        }else{
            $("#state").empty();
            $("#city").empty();
        }
    });

</script>


@stop
@endsection