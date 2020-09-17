@extends('layout.backened.header') @section('content')

<div class="table-section-main">
	<div class="container">
                        @if(Session::has('add_message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('add_message') !!} 
                        </div>
                        @endif 

						
	<div class="">
<h1> Coming Soon</h1>				
				
			</div>
	<!-- /.box-header -->
    
			
			
			 	
	</div>
</div>
@endsection