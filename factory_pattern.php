<?php
/* Template Name: Factory Method Template */ 
 get_header();
?>
<div class="container"> //start container
  <h3>Electronics Manufacturing Company</h3>
  <br>
	  <div class="row">     
		<form id="factory_pattern">
		  <div class="col-md-6">
		     <div class="form-group">
				<label for="inputProduct">Product Name </label>
				<select class="js-example-basic-single form-control">
				      <option id="product">laptop</option>
				      <option id="product">mobilephone</option>
				       <option id="product">externalharddrive</option>					      
			       </select>      
		      </div>
		    </div>
			 
		    <div class="col-md-6">
			<br>
			    <button type="submit" class="btn btn-primary">Get Product</button>
	            </div>
	         </form>
	        <br><br>  
	 </div>

	<div class="row" >
		 <div class="col-md-12" id="dis_product">
		 </div>
	</div>
      <h3 class="text text-success" id="msg"></h3>
 </div> //end container


