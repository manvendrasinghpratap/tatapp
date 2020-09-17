
<div class="footer-container">
		<div class="container">
			<!--<p>Copyright &copy; {{ date('Y')}} All rights reserved.</p>-->
		</div>
</div>
</main>
</div>
	<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	 <script src="{{asset('assets/js/common.js')}}"></script>
	
	
	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>

	<script>
	 $( document ).ready(function() {
	  $.validator.addMethod('filesize', function(value, element, param) {
		  
		  return this.optional(element) || (element.files[0].size <= param)
      },jQuery.format("You have allowed only 5MB image file to upload."));
	  
	  //validate file extension custom  method.
            jQuery.validator.addMethod("extension", function (value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            }, jQuery.format("You have allowed only an image file to upload."));
	});
		$('input[name="chkOrgRow"]').on('change', function () {
			$(this).closest('tr').toggleClass('yellow', $(this).is(':checked'));
		});
		$(".mob_trigger").click(function () {
			$(this).toggleClass("active");
			$(".navigation-container").toggleClass("active");
		});
		$(".close-btn").click(function () {
			$(".navigation-container").removeClass("active");
		});
		$(document).ready(function () {
			$('#task-table').DataTable({
				responsive: true,
				"bLengthChange": false,
				"bInfo": false,
				"bPaginate": false,
				"bFilter": false,
				"bLengthChange": false,
				"scrollY": "263px",
				"scrollCollapse": true,
				"paging": false,
				"language": {
					"infoEmpty": "No records available - Got it?",
				}
			});
			$('#report-table').DataTable({
				responsive: true,
				"bLengthChange": false,
				"bInfo": false,
				"bPaginate": false,
				"bFilter": false,
				"bLengthChange": false,
				"language": {
					"infoEmpty": "No records available - Got it?",
				}
			});
			$('.check-check input').on('change', function () {
				$(this).parents('.check-check').next('.delet-btn').toggleClass('active');
			});
			$(".user-img img").click(function(){
			  $(".user-popup").slideToggle();
			});
			$("form").attr('autocomplete', 'off');
		});

		var idleTime = 600; //10 minutes
		var idleSeconds = 0;
		document.onclick = function() {
		idleSeconds = 0;
		};
		document.onmousemove = function() {
		idleSeconds = 0;
		};
		document.onkeypress = function() {
		idleSeconds = 0;
		};

		var idleInterval = window.setInterval(timerIncrement, 1000);

		function timerIncrement() {
		idleSeconds++;
		if (idleSeconds > idleTime) {
		//http://almalllocal.com/OS_tadapp/public/admin/logout
			window.location.href= "<?php  echo URL('/')?>/admin/logout";
		}
		}
	</script>
</body>

</html>