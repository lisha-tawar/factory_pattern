$(function () {

        $('#factory_pattern').on('submit', function (e) {

          e.preventDefault();
          var product_name = $('#product').val();
        
          if(product_name != '')
           {    
          	  $.ajax({
	               type : 'POST',
	               url  : ajax_object.ajaxurl,
	               data :{ 
	                      'action' : 'display_product',
	                      'pname'  :  product_name,
	                     },
	               success:function(result){ 
	               	if(result != '')
	               	{   $('#product').val(product_name);
	               		$('#dis_product').html(result);
	               	}
				  }
	          });
          }
         
      });

       $(document).on('click','#reset_memory',function(e) {

          e.preventDefault();
          var memory = $('#memory').val();
          var product_name =$('#product').val();
          if(product_name != '')
           {
              $.ajax({
	               type : 'POST',
	               url  : ajax_object.ajaxurl,
	               data :{ 
	                      'action' : 'reset_product',
	                      'memory' :  memory,
	                      'pname'  : product_name
	                     },
	               success:function(result){ 
	               	if(result != '')
	               	{   
	               		$('#reset_memory').val(result);
	               		alert('You have successful reset memory of '+product_name+'..!');
	               	}
				  }
	          });
           }
         
       });

  });