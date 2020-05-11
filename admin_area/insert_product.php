<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "ecommerce_website");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- <link href = "css/customStyle.css" rel = "stylesheet">  -->

    <title>Uploading Products</title>
</head>
<body bgcolor = "darkkhaki">

    <form action = "insert_product.php" method = "post" enctype = "multipart/form-data">
        <table align = "center" width = "795" border = "2" bgcolor = "darkkhaki" >

            <tr align = "center">
                <td colspan = "8"><h2> Upload New Post Here </h2></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Name: </b></td>
                <td><input type = "text" name = "product_name" size = "60" required/></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Category: </b></td>
                <td>
                    <select name = "product_cat">
                        <option> Select a Category </option>

                        <?php 

                        global $con;

                        $get_cats = "SELECT * from categories";

                        $run_cats = mysqli_query ($con, $get_cats);

                        while($row_cats = mysqli_fetch_array ($run_cats)){
                            $cat_id = $row_cats['cat_id'];

                            $cat_title = $row_cats['cat_title'];

                            echo "<option value = '$cat_id'>$cat_title</option>";
                        }               
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td align = "right"><b> Product Brand: </b></td>
                <td>
                    <select name = "product_brand">
                        <option> Select a Brand </option>

                        <?php 

                        global $con;

                        $get_brands = "SELECT * from brands";

                        $run_brands = mysqli_query ($con, $get_brands);

                        while($row_brands = mysqli_fetch_array ($run_brands)){
                            $brand_id = $row_brands['brand_id'];

                            $brand_title = $row_brands['brand_title'];

                            echo "<option value = '$brand_id'>$brand_title</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td align = "right"><b> Product Image: </b></td>
                <td><input type = "file" name = "product_image" /></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Price: </b></td>
                <td><input type = "text" name = "product_price" required /></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Size: </b></td>
                <td><input type = "text" name = "product_size" required /></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Description: </b></td>
                <td><textarea name = "product_desc" cols = "23" rows = "10"></textarea></td>
            </tr>

            <tr>
                <td align = "right"><b> Product Code: </b></td>
                <td><input type = "text" name = "product_code" required /></td>
            </tr>

            <tr align = "center">
                <td colspan = "8"><input type = "submit" name = "upload_post" value = "Upload Product Now" />
            </tr>

        </table>



    </form>
 





<script defer src = "https://use.fontawesome.com/releases/v5.0.9/js/all.js"
        integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>    

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
        <script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php 

if(isset($_POST['upload_post'])){
    $product_name = $_POST['product_name'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $product_desc = trim(mysqli_real_escape_string($con, $_POST['product_desc']));
    $product_code = $_POST['product_code'];

    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];

    move_uploaded_file($product_image_tmp, "product_images/$product_image");

    $insert_product = "insert into products (product_name, product_cat, product_brand, product_image, product_price, product_size, product_desc, product_code) 
    values ('$product_name', '$product_cat', '$product_brand', '$product_image', ' $product_price', '$product_size', '$product_desc', ' $product_code') ";

    $insert_pro = mysqli_query($con, $insert_product);

    if($insert_pro){
        echo "<script>alert('Products have been uploaded successfully!')</script>";
        
    }  
}
?>