<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "ecommerce_website");

if(mysqli_connect_errno()){
    echo "failed to connect to MySQL: ". mysqli_connect_errno();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Results</title>

   
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href = "css/customStyle.css" rel = "stylesheet"> 

    <script type = "text/javascript" src = "js/java.js"></script>

  </head>
  <body> 

      <nav class = "navbar navbar-inverse navbar-fixed-top">
      

        <div class = "logo"><a href = "#"><img src = "images/logo.jpg"></a>
        </div>

       

            
        <ul class = "nav navbar-nav navbar-right">

            
            <li><a href = "index.php"> Home </a></li>
            <li><a href = "all_products.php"> Shop </a></li>

            <li class = "dropdown">
              <a class = "dropdown-toggle" data-toggle = "dropdown"> Products <span class = "caret"></span></a>
                
              <ul id = "cats"class = "dropdown-menu">
                  <li class = "dropdown-header"><strong> Categories</strong> </li>
                  <!-- <li><a href = "index.php"> Colognes </a></li>
                  <li><a href = "index.php"> Perfumes </a></li>
                  <li><a href = "index.php"> Cosmetics </a></li>
                  <li><a href = "index.php"> T-shirts </a></li>
                  <li><a href = "index.php"> Hoodies </a></li> -->

                  <?php 

                  global $con;

                  $get_cats = "SELECT * from categories";

                  $run_cats = mysqli_query ($con, $get_cats);

                  while($row_cats = mysqli_fetch_array ($run_cats)){
                    $cat_id = $row_cats['cat_id'];

                    $cat_title = $row_cats['cat_title'];

                    echo "<li><a href = 'results.php?cat=$cat_id'>$cat_title</a></li>";
                  }               


                  ?>
              
                  <li class = "dropdown-header"><strong> Brands </strong> </li>
                  <!-- <li><a href = "index.php"> Villa </a></li>
                  <li><a href = "index.php"> Routine </a></li>
                  <li><a href = "index.php"> Glamour </a></li> -->

                  

                 
                  <?php 

                  global $con;

                  $get_brands = "SELECT * from brands";

                  $run_brands = mysqli_query ($con, $get_brands);

                  while($row_brands = mysqli_fetch_array ($run_brands)){
                    $brand_id = $row_brands['brand_id'];

                    $brand_title = $row_brands['brand_title'];

                    echo "<li><a href = 'results.php?brand=$brand_id'>$brand_title</a></li>";
                  }


                  ?>

              </ul>

            </li>
            <li><a href = "#"> About</a></li>
            <!-- <li><a href = "#"> Learn </a></li> -->
            <li><a href = "#"> Promotions </a></li>
        
             
                
        </ul> 

       
        <form action = "results.php" class = "navbar-form">
          <div class = "form-group input-group">
            <input type = "text" name = "user_query" placeholder = "Search" class = "form-control"/>
            <div class = "input-group-btn">
            <input type = "submit" name = "search" value = "Search"  class = "btn btn-default"/>
            </div>
          </div>
        </form>

      </nav>

      <div id = "content_area">
            <div id = "products_box">

                <?php 
                  if(isset($_GET['search'])){
                    $search_query = $_GET['user_query'];

                    $run_query_by_pro_id = mysqli_query($con, "SELECT * from products where product_code like '%$search_query%' ");
                        
                    while($row_pro = mysqli_fetch_array( $run_query_by_pro_id)){
                        $pro_id = $row_pro['product_id'];
                        $pro_name = $row_pro['product_name'];
                        $pro_cat = $row_pro['product_cat'];
                        $pro_brand = $row_pro['product_brand'];
                        $pro_image = $row_pro['product_image'];
                        $pro_price = $row_pro['product_price'];
                        $pro_size = $row_pro['product_size'];
                        // $pro_desc = $row_pro['product_desc'];
                        // $pro_code = $row_pro['product_code'];
    
                        echo "
                            <div id = 'single_product'>
                                <h3>$pro_name </h3>
                                <img src = 'admin_area/product_images/$pro_image' width = '180' height = '180' />

                                <h6>
                                <i class = 'fa fa-star' color= 'gold' padding = 3% 0></i>
                                <i class = 'fa fa-star' color= 'gold'></i>
                                <i class = 'fa fa-star' color= 'gold'></i>
                                <i class = 'fa fa-star' color= 'gold'></i>
                                <i class = 'fa fa-star'></i>
                              </h6>
    
                                <p><b> Price: R$pro_price </b></p>
                                <a href = 'details.php?pro_id=$pro_id'> Details </a>
                                <a href = 'products.php?add_cart=$pro_id'>
                                <button type = 'submit' class = 'btn btn-warning my-3' style = 'float:right'> Add to Cart <i class = 'fa fa-shopping-cart'></i></button>
                                </a>
                                <input type = 'text' name = 'quantity' class = 'form-control' value = '1'/>
                            </div>
                        ";
                      } 
                  }
                ?>

<?php 
                if(isset($_GET['cat'])){
                    $cat_id = $_GET['cat'];
                    
                    $get_cat_pro = "SELECT * from products where product_cat='$cat_id' ";

                    $run_cat_pro = mysqli_query($con, $get_cat_pro);

                    $count_cats = mysqli_num_rows($run_cat_pro);

                        if($count_cats == 0){
                            echo "<h2 style = 'padding:20px;'> No products where found in this category! </h2>";
                        }

                        while($row_cat_pro = mysqli_fetch_array($run_cat_pro)){
                            $pro_id = $row_cat_pro['product_id'];

                            $pro_cat = $row_cat_pro['product_cat'];

                            $pro_brand = $row_cat_pro['product_brand'];
                            $pro_name = $row_cat_pro['product_name'];
                            $pro_image = $row_cat_pro['product_image'];
                            $pro_price = $row_cat_pro['product_price'];

                            echo "

                                 <div id = 'single_product'>
                            <h3>$pro_name </h3>
                            <img src = 'admin_area/product_images/$pro_image' width = '180' height = '180' />

                            <h6>
                            <i class = 'fa fa-star' color= 'gold' padding = 3% 0></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star'></i>
                          </h6>

                            <p><b> Price: R$pro_price </b></p>
                            <a href = 'details.php?pro_id=$pro_id'> Details </a>
                            <a href = 'products.php?add_cart=$pro_id'>
                            <button type = 'submit' class = 'btn btn-warning my-3' style = 'float:right'> Add to Cart <i class = 'fa fa-shopping-cart'></i></button>
                            </a>
                            <input type = 'text' name = 'quantity' class = 'form-control' value = '1'/>
                        </div>
                            
                            
                            ";
                        }
                }
                
                ?>

                <?php 
                if(isset($_GET['brand'])){
                    $brand_id = $_GET['brand'];
                    
                    $get_brand_pro = "SELECT * from products where product_brand='$brand_id' ";

                    $run_brand_pro = mysqli_query($con, $get_brand_pro);

                    $count_brands = mysqli_num_rows($run_brand_pro);

                        if($count_brands == 0){
                            echo "<h2 style = 'padding:20px;'> No products where found in this brand! </h2>";
                        }

                        while($row_brand_pro = mysqli_fetch_array($run_brand_pro)){
                            $pro_id = $row_brand_pro['product_id'];

                            $pro_cat = $row_brand_pro['product_cat'];

                            $pro_brand = $row_brand_pro['product_brand'];
                            $pro_name = $row_brand_pro['product_name'];
                            $pro_image = $row_brand_pro['product_image'];
                            $pro_price = $row_brand_pro['product_price'];

                            echo "

                            <div id = 'single_product'>
                            <h3>$pro_name </h3>
                            <img src = 'admin_area/product_images/$pro_image' width = '180' height = '180' />

                            <h6>
                            <i class = 'fa fa-star' color= 'gold' padding = 3% 0></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star' color= 'gold'></i>
                            <i class = 'fa fa-star'></i>
                          </h6>

                            <p><b> Price: R$pro_price </b></p>
                            <a href = 'details.php?pro_id=$pro_id'> Details </a>
                            <a href = 'products.php?add_cart=$pro_id'>
                            <button type = 'submit' class = 'btn btn-warning my-3' style = 'float:right'> Add to Cart <i class = 'fa fa-shopping-cart'></i></button>
                            </a>
                            <input type = 'text' name = 'quantity' class = 'form-control' value = '1'/>
                        </div>
                            
                            
                            ";
                        }
                }
                
                ?>



            </div>
        </div>
         



<!-- 
      
      <div class = "navbar navbar-inverse navbar-bottom">
        <div class = "container">
          <div class = "footer-social-icons">
            <ul>
              <li><a href = ""> <i class = "fab fa-facebook"></i></a></li>
              <li><a href = ""><i class = "fab fa-twitter"></i></a></li>
              <li><a href = "http://instagram.com"><i class = "fab fa-instagram"></i></a></li>
              <li><a href = ""><i class = "fab fa-youtube"></i></a></li>
            </ul>
          </div>
          <div class = "footer-menu-one"> 
            <ul>
              <li><a href = "#">Home</a></li>
              <li><a href = "#">About us</a></li>
              <li><a href = "#">Services</a></li>
              <li><a href = "#">Contact us</a></li>
            </ul>
          </div>
            <div class = "navbar-text pull-left">
            <p> Copyright 2020 All Rights Reserved. Triple L Holdings</p>
            <p> Terms & Conditions / Privacy Policy </p>
            </div>  
        </div>
    </div>
 -->
      <div class = "navbar navbar-inverse navbar-fixed-bottom">
        <div class = "container">
          <div class = "nav-icon-bar">
            <ul>
              <li><a href = "index.php"> <i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li><a href = ""> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
              <li><a href = ""> <i class="fa fa-heart" aria-hidden="true"></i></a></li>
              <li><a href = ""> <i class="fa fa-user" aria-hidden="true"></i></a></li>


            </ul>
          </div>
      </div>
      

    

 

        
       
        





      <script defer src = "https://use.fontawesome.com/releases/v5.0.9/js/all.js"
      integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>