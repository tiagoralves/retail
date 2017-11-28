/@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
    <div class=""></div><!-- .corner-preloader -->
    <div id="wrapper">
        <div id="upload-widget">
            <h1>
                <i class="fa fa-cloud-upload"></i> File Uploader**********
            </h1>

            <form id="file-upload-form">
                <div class="file-input-wrap">
                    Browse Files
                    <input type="file" name="file" id="file" multiple>
                </div><!-- .file-input-wrap -->
            </form><!-- #file-upload-form -->
        </div><!-- #upload-widget -->

        <div id="upload-result">
        </div><!-- #upload-result -->
    </div><!-- #wrapper -->

    <div id="preloader">
        <img src="img/preloader.gif" alt="files uploading..." />
    </div>
@section('pagescript')
    <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
    <script>
        $(function() {
            // grab the file input and bind a change event onto it
            $('#file').change(function () {
                alert('111111');
                // new html5 formdata object.
                var formData = new FormData();
                //for each entry, add to formdata to later access via $_FILES["file" + i]
                for (var i = 0, len = document.getElementById('file').files.length; i < len; i++) {
                    formData.append("file" + i, document.getElementById('file').files[i]);
                }

                //send formdata to server-side
                $.ajax({
                    url: "upload/create", // our php file
                    type: 'post',
                    data: formData,
                    dataType: 'html', // we return html from our php file
                    async: true,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    success: function (data) {
                        $('#upload-result').append('<div class="alert alert-success"><p>File(s) uploaded successfully!</p><br />');
                        $('#upload-result .alert').append(data);

                    },
                    error: function (request) {
                        console.log(request.responseText);
                    }
                });
            });
        });
    </script>
@stop
@endsection