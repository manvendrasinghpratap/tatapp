@extends('layout.backened.header')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Update Email Template</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('admin-emailtemplates')}}">Email Templates</a></li>
            <li class="active">Update Email Template</li>
        </ol>
    </section>
    <script>
        $(function () {
            CKEDITOR.replace('description');
            CKEDITOR.config.breakBeforeOpen = false;
            CKEDITOR.config.breakAfterOpen = false;
            CKEDITOR.config.breakBeforeClose = false;
            CKEDITOR.config.breakAfterClose = false;
            CKEDITOR.config.autoParagraph = false;
            CKEDITOR.config.extraAllowedContent = 'div(*)';
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.extraAllowedContent = '*(*);*{*}';
            CKEDITOR.config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';

            $('#add-form').validate({
                ignore: [],
                debug: false,
                rules: {
                    title: "required",
                    description: {
                        required: function ()
                        {
                            CKEDITOR.instances.description.updateElement();
                        }
                    },
                    subject: "required",
                },
                messages: {
                    title: "Please enter title.",
                    description: "Please enter description.",
                    subject: "Please enter subject.",
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

        });
    </script>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        @if(Session::has('add_message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('add_message') !!} 
                        </div>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="add-form" class="form-horizontal" action="{{route('admin-edit-emailtemplates',['id'=>@$data->id_email])}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="box-body">
                            <input type="hidden" name="id" value="{{old('id',@$data->id_email)}}">

                            <div class="form-group @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                                <label for="inputError" class="col-sm-2 control-label">Title {{redstar()}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" readonly class="form-control" id="inputError" placeholder="Title" value="{{old('title',@$data->title)}}">
                                    <?php if (@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('subject')) {{' has-error has-feedback'}} @endif ">
                                <label for="inputError" class="col-sm-2 control-label">Subject {{redstar()}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="subject" class="form-control" id="inputError" placeholder="Subject" value="{{old('subject',@$data->subject)}}">
                                    <?php if (@$errors->first('subject')) { ?><span class="help-block">{{@$errors->first('subject')}}</span> <?php } ?>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                                <label for="inputError" class="col-sm-2 control-label">Description {{redstar()}}</label>
                                <div class="col-sm-10">
                                    <textarea name="description" rows="10" id="description" class="form-control" id="inputError" placeholder="Description"> {{old('description',@$data->description)}}</textarea>
                                    <?php if (@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route('admin-emailtemplates')}}" class="btn btn-default">Cancel</a>
                            <input type="submit" value="Submit" class="btn btn-info">
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection