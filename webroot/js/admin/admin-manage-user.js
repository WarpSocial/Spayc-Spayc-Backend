 $( document ).ready(function() {

	if($('#keyword').val() != ''){
		$('#clear-search').removeClass('hide');
	} else {
		$('#clear-search').addClass('hide');
	}
	$('#clear-search').on('click',function(){  			
		window.location.replace(base_url_admin+'users/manage-user');
	});

  });