@extends('layout.backened.header')
@section('content')


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Email Templates</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Email Templates</li>
      </ol>
    </section>
  
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('message') !!} 
                </div>
                @endif
            </div>
  
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <!--<th>Sr.No.</th>-->
                  <th>Title</th>
                  <th>Subject</th>
                  <th width="15%">Action</th>
                </tr>
                @if(count($data['records'])>0)
                <?php
                $k = ($pageNo==1)?$pageNo:(($pageNo-1)*$record_per_page)+1; ?>
                    @foreach($data['records'] as $row)
                        <tr>
                            <!--<th scope="row">{{$k}}</th>-->
                            <td>{{$row->title}}</td>
                              <td>{{$row->subject}}
                              </td>
                              <td>
                                <a href="{{route('admin-edit-emailtemplates',['id'=>$row->id_email])}}" class="btn btn-info btn-xs action-btn"  title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                               
                                </td>
                              
                        </tr>
                  <?php $k++; ?>     
                  @endforeach
                  @else
                   <tr class="bg-info">
                      <td colspan="8">Record(s) not found.</td>
                  </tr>
                  @endif
                
               
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
               {!! $data['records']->links() !!}
              </ul>
            </div>
          </div>
          <!-- /.box -->
          
          
        </div>
      </div>
           
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
  @endsection