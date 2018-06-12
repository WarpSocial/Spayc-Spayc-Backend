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
		window.location.replace($("form#userFilterFrm").prop('action').split('?')[0]);
	});
	$('#filter-reset').on('click',function(){  
		window.location.replace($("form#userFilterFrm").prop('action').split('?')[0]);
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
	$(document).on('click', '#advertisement_delete_btn', function (e) {                         
      form = $("form#advertisement_delete_form");  
      $(".loader").addClass('show-loader');          
      setTimeout(function(){
	      $.ajax({
	       type:'POST',
	       url:form.prop('action'),
	       data: form.serialize(),
	       dataType:'JSON',
	       async: false,             
	       success:function(data){               	
	          $(".loader").removeClass('show-loader'); 
	          $( ".skip-popup").trigger('click');                            
	            if (data.result) {
	              $( "div #"+data.id).remove();
	              $('.users-msg').text(data.message);
	              messageFadeOut('users-msg',data.message);
	              if (!$(".table-row")[0]){
	                $(".main-advertisement-div").html($("#no-advertisement").html());
	              }
	            } 
	       },
	       error: function (e,x,t) {
	        $(".loader").removeClass('show-loader'); 
	        ajax_error(e);
	      }
	   	  });
  	  });
   	  e.preventDefault();
  	});  
        
        
    $(document).on('click', '#ban_spayc_member_btn', function (e) {                                     
      form = $("form#ban_spayc_member_form");  
      $(".loader").addClass('show-loader');          
      setTimeout(function(){
	    $.ajax({
	       type:'POST',
	       url:form.prop('action')+"/"+$("#set_status").val(),
	       data: form.serialize(),
	       dataType:'JSON',
	       async: false,             
	       success:function(data){  
                  $(".loader").removeClass('show-loader'); 
	          $( ".skip-popup").trigger('click'); 
	          if (data.result) {
                      $(".t_status_"+data.res).text(data.status);
                      $(".status_"+data.res).html($("#"+data.status+"_image").html());
                      var value="Banned";
                      if(data.status=="Banned")  {
                        value='Unbanned';
                        $('.spaycs-msg').removeClass('success-alert').addClass('error-alert');
                      } else {
                        $('.spaycs-msg').removeClass('error-alert').addClass('success-alert'); 
                      } 
                      $(".status_div_"+data.res).attr("onclick","setStatus('"+value+"')");
                      messageFadeOut('spaycs-msg',data.message);
                  }
	       },
	       error: function (e,x,t) {
	        $(".loader").removeClass('show-loader'); 
	        ajax_error(e);
               }
            });
  	  });
   	  e.preventDefault();
  	});

 }); 

function showModel(description, heading){    
    $("#cmnPoupUp").addClass('modal-dialog-lg');
    $("#cmnPoupUp .modal-content").addClass('user-list-modal');
    $("#cmnPoupUp .modal-content").html("<div class='modal-header'><h5 class='modal-title'>"+heading+"</h5><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true' class='modal-close'></span></button></div><div class='advertisement-desc'>"+description+"</div>");
    $("#cmnPoupUp").modal('show');
}


function showAdmin(id, totalAdmin){
    $("#cmnPoupUp").addClass('modal-dialog-lg');
    $("#cmnPoupUp .modal-content").addClass('user-list-modal');
    $("#cmnPoupUp .modal-content").html("<div class='modal-header'><h5 class='modal-title'>Admin ("+totalAdmin+")</h5><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true' class='modal-close'></span></button></div><div>"+$('#admin_'+id).html()+"</div>");
    $("#cmnPoupUp").modal('show');
}

function setStatus(value) {
   $("#set_status").val(value);
}