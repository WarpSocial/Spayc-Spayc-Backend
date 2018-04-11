 $(document).ready(function() {
	if($('#keyword').val() != ''){
		$('#clear-search').removeClass('hide');
	} else {
		$('#clear-search').addClass('hide');
	}

	$('#keyword').on('keyup',function(){
		if($(this).val().length > 0){
			$('#clear-search').removeClass('hide');	
		}else{
			$('#clear-search').addClass('hide');	
		}
	});

	$('#clear-search').on('click',function(){  			
		$('#keyword').val('');
		$('#clear-search').addClass('hide');
		//window.location.replace(base_url_admin+'users/manage-user');
	});
	$('#filter-reset').on('click',function(){  
		window.location.replace(base_url_admin+'users/index');	
	});
	
	if($("#to-date").length) {
	    $(".date-filter").on('change',function(){	  	
		    var startDate = $("#from-date").val();
		    var endDate = $("#to-date").val();
			if ((Date.parse(endDate) <= Date.parse(startDate))) {
				messageFadeOut('users-msg',"To date should be greater than From date");
		  		$("#to-date").val('');
			}
	  	});
	}



 }); 