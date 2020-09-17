@extends('layout.backened.header')
@section('content')
<?php
//dd($data);
?>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <div class="row">
            <div class="col-md-12">
               <table width="100%">
<tbody><tr><td colspan="2" style="font-family:Trebuchet MS;font-weight:bold;color:white" bgcolor="red" align="center">Access has been denied 

</td></tr></tbody></table>
<br>



<font face="Helvetica">
The access to requested URL has been denied. 
<br>
Please <a href="{{route('admin-dashboard')}}">Click here</a> to go to the dashboard.
</font>


<font face="Helvetica">
<br><br>
<p id="urlp">
</p>
</font>


<font face="Helvetica" size="2">
<br><br>
To have the rating of this web page re-evaluated please contact your <a href="mailto:admin@tatapp.com">web moderator</a>.
</font>




<hr><br>
               
            </div>
        </div>
</div>
</div>

@endsection
