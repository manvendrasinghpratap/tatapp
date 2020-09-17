<?php //dd($data); ?>
@extends('pdf.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{_i('Manage Case')}}</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{_i('Home')}}</a></li>
            <li class="active">{{_i('Manage Case')}}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                           <h3 class="box-title"></h3>
             
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                                <th>Sr.No.</th>
                                <th width="25%">{{_i('Title')}}</th>
                                <th>Assign To</th>
                                <!-- <th width="15%">{{_i('Account')}}</th> -->
                                <th>{{_i('Status')}}</th>
                                <th>{{_i('Created Date')}}</th>
                                <th width="15%">{{_i('Action')}}</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                                <td scope="row">{{$k}}</td>
                                <td> <?php 
                            echo $row->title;

                                        ?></td>
                                <td>{{$row->CaseOwnerName[0]->first_name}}</td>
                                <!-- <td>{{$row->name}}</td> -->
                                <td>{{$row->status}}</td>
                                <td>
                                    {{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                                <td>
                                     
                                    <a href="{{route('admin-viewCase',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="View Detail"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                    
                                    <a href="{{route('admin-editCase',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit Package"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                     

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

@endsection
