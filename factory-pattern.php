<?php

/**
* Plugin Name: Design Pattern 
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Lisha
* Author URI: http://yourwebsiteurl.com/
**/
namespace Includescript{
  class DesignPattern
   {
    public function __construct()
	{ 
      add_action( 'wp_enqueue_scripts',array( $this,'design_more_scripts' ) );
    }
	  
    public function design_more_scripts() {
 
     wp_register_script('design_pattern', plugins_url(). '/Design-pattern/js/factory.js', array( 'jquery' ) );
     wp_enqueue_script( 'design_pattern');  

     wp_enqueue_script( 'design_pattern',  plugins_url(). '/Design-pattern/js/factory.js', array( 'jquery' ));
     wp_localize_script( 'design_pattern', 'ajax_object', array( 'ajaxurl' =>admin_url( 'admin-ajax.php' ) ) );
      
   }

  }
  new DesignPattern();
}
//Factory Method 
namespace FactoryMethod_DesignPattern
{
    abstract class ElectronicProduct {
         //Common property
          public $Name;
          public $Memory;
          public $Description;

        //Common Method / Function / Behaviour
          abstract public function GetMemory();
          abstract public function SetMemory($value);
     }
	
    //'ConcreteProduct' Class
    class MobilePhone extends ElectronicProduct
     {  
        public function __construct()
        {
	  $this->Name = "Nokia";
	  $this->Memory = "8 GB";
	  $this->Description = "It's famous mobile phone in india";
        }
        public function GetMemory()
        {
            return $this->Memory;
        }    
        public function SetMemory($value)
        {
          $this->Memory = $value;
        }
     }
	
    //'ConcreteProduct' Class
    class Laptop extends ElectronicProduct
    {
        public function __construct()
        {   
            $this->Name = "Lenovo";
            $this->Memory = "500 GB";
            $this->Description = "It's famous labtop in india";       
        }
        public function GetMemory()
        {
            return $this->Memory;
        } 
        public function SetMemory($value)
        {     
            $this->Memory = $value;
        }    
    }
	
    //'ConcreteProduct' Class     
    class ExternalHardDrive extends ElectronicProduct
    {   	
        public function __construct()
        {
            $this->Name = "Dell";
            $this->Memory = "1 TB";
            $this->Description = "It's famous External Hard Drive in india";
        }
        public function GetMemory()
        {
            return $this->Memory;
        }    
        public function SetMemory($value)
        {
            $this->Memory = $value;
        }
    }

   //Different product that can be created by the factory
    class AvailableProducts
    {
        public function __construct()
        {
           $this->Available_Products = array('mobilephone'=>'mobilephone','laptop'=>'laptop','externalharddrive'=>'externalharddrive');
        }     
    }

   //'IProduct' Interface
    interface IProductFactory
    {
        public function CreateProduct($type);
    }

   //'Concrete Creator' Class
    class ProductFactory implements IProductFactory
    {
      //'Factory Method' to decide which class instantiate
    	public function CreateProduct($type)
    	{  
           if(strtolower($type))
           {
               switch ($type)
                {
                    case 'laptop':
                        return new Laptop();
                    case 'mobilephone':
                        return new MobilePhone();
                    case 'externalharddrive':
                        return new ExternalHardDrive();
                    default:
                        throw new NotImplementedException();

                }
           }
    	}

   }
 
//main class act as 'Client'
    class Program 
    {
        public function __construct()
    	{
           add_action( 'wp_ajax_display_product',array( $this,'display_product_callback' ) ); 
           add_action( 'wp_ajax_nopriv_display_product',array( $this,'display_product_callback' ) );

           add_action( 'wp_ajax_reset_product',array( $this,'reset_product_callback' ) ); 
           add_action( 'wp_ajax_nopriv_reset_product',array( $this,'reset_product_callback' ) );      
    	}

        public function display_product_callback()
        {
             $data          = $_POST['pname'];
             $details       = new AvailableProducts();
             $check_product = $details->Available_Products;
              
            if(array_key_exists($data,$check_product))
            {
            	$factory = new ProductFactory();
            	$make    = $factory->CreateProduct($data);
                $this->Info_product($make);              
            }
            else 
            {
                echo '<div class="text text-danger text-bold">This Product is not available..!</div>';
            }
           
          wp_die();
       }
        
        public function reset_product_callback()
        {
            $memory        = $_POST['memory'];
            $pname         = $_POST['pname'];
            $all_products  = new AvailableProducts();
            $check         = $all_products->Available_Products;
            if(array_key_exists($pname,$check))
            {
                $fact     = new ProductFactory();
                $set_product = $fact->CreateProduct($pname);
                $set_product->SetMemory($memory);
                $data = $set_product->GetMemory();    
                echo $data;       
            }
            wp_die();
        }

        public function Info_product($make)
        {
            ?> 
              <h4 style="text-align:center;">Available Laptop:</h4>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Memory</th>
                    <th colspan="2">Description</th>    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $make->Name; ?></td>
                    <td><input type="text" id="memory" value='<?php echo $make->Memory; ?>'></td>
                    <td><?php echo $make->Description; ?></td>
                    <td><button type="button" class="btn btn-warning btn-lg" id="reset_memory">Reset Memory</button></td>
                  </tr>   
                </tbody>
              </table>

              <h6><strong>Note:</strong> If you want to reset memory please click on reset button </h6>
              <?php 
              wp_die();
        }
    }
   new Program();

 }


?>
