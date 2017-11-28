@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
    <section class="content">

    <div class="container">
        <div class="row">
            <div class="col-sm-6 form-group">
                <div class="input-group" id="DateDemo">
                    <input type='text' id='period' placeholder="Select Week" />
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- /.content -->

@section('pagescript')
    <script src="{{ asset('/plugins/bootstrap-datepickever r/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>

        $(function() {
            var date = new Date();
            var past = '';
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate()-7);

            $('#period').datepicker({
                todayHighlight: true,
                //startDate : today-2,
                endDate   : today
            });
            $('#period').datepicker('setDate', today);
            activeWeek();
            $('#period').on('changeDate', function() {
                $('#period').val($('#period').datepicker('getFormattedDate'));
                activeWeek();
            });

            function activeWeek() {
                $('.day.active').closest('tr').find('.day').addClass('active');
            }

            //Date range pickerer
            jQuery('#period').daterangepicker()
        });

    </script>

@stop

@endsection



