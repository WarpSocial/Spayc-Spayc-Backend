 $( document ).ready(function() {

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
		//window.location.replace(base_url_admin+'users/manage-user');
	});

  });