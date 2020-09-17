			function setCookie(c_name, value, exdays) {
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
				document.cookie = c_name + "=" + c_value + '; path=/';
			}

			function getCookie(c_name) {
				var i, x, y, ARRcookies = document.cookie.split(";");
				for ( i = 0; i < ARRcookies.length; i++) {
					x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
					y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
					x = x.replace(/^\s+|\s+$/g, "");
					if (x == c_name) {
						return unescape(y);
					}
				}
				return null;
			}
			function SimpleDeleteCookie( name) {
	path="/";
	domain="";
if ( getCookie( name ) ) 
	{strDel=name + "=" + ( ( path ) ? ";path=" + path : "") + ( ( domain ) ? ";domain=" + domain : "" ) + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
	//alert(strDel);
		document.cookie = strDel;}
}
			
			
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
	function getValue(varname) {
				var url = window.location.href;
				var qparts = url.split("?");
				if (qparts.length <= 1) {
					return "";
				}
				var query = qparts[1];
				var vars = query.split("&");
				var value = "";
				for ( i = 0; i < vars.length; i++) {
					var parts = vars[i].split("=");
					if (parts[0] == varname) {
						value = parts[1];
						break;
					}
				}
				value = decodeURIComponent(value);
				//value = unescape(value);
				value.replace(/\+/g, " ");

				return value;
			}
			
			function valideConnexion(){
						var courriel = getCookie("courriel");
			if (getCookie("courriel") != null) {
				$.ajax({
					type : "POST",
					url : "valide_connexion.php",
					data : {
						courriel : courriel
					},
					cache : false,
					success : function(result) {
						//alert("stop!");
						if (result == 1) {
							getInfosAffiliationPourMembreExclusif(getCookie("courriel"));
						} else {
							window.location.href = "connexion.php";
						}
					}
				});

			} else {
				window.location.href = "connexion.php";
			}

			}
			function getInfosAffiliationPourMembreExclusif(courriel) {
				$.ajax({
					url : "getInfosAffiliation.php",
					type : "POST",
					data : {
						courriel : courriel,
					},
					dataType : 'json', // JSON
					success : function(json) {
						lesInfos = json;
						if(parseInt(json.membreExclusif)<1){
						$('#membres-exclusifs').hide();}
					}
				});		
				}	
				
function clicChevron(){
//	$( window ).on( "load", function() {
		$( document ).ready(function() {
	//	alert("ClicChevron!");
				$(".card-header").on("click",function(){
				$(this).find(".fa-angle-right").removeClass("fa-angle-right").addClass("fa-angle-temp");
				$(this).find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-right");
				$(this).find(".fa-angle-temp").removeClass("fa-angle-temp").addClass("fa-angle-down");
				});
	});
}
