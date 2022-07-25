<?php
session_start();
$conn = mysqli_connect("localhost","root","","online_grocery");
if(mysqli_connect_error())
{
    echo "<script>
    alert('cannot connect to database');
    window.location.href='mycart.php';
    </script>";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST['purchase'])){
        foreach($_SESSION['cart'] as $key => $values)
        {
         
            $food=$values['Item_Name'];
            $price=$values['Price'];
            $qty=$values['Quantity'];
            $total = $price * $qty;
            $order_date = date_create()->format('Y-m-d H:i:s');;
            $status="Ordered";

            $customer_name = $_POST['full_name'];
            $customer_contact = $_POST['phone_no'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];
            $f_id = $values['food_id'];


                //SQL Query
            $sql2 = "INSERT INTO tbl_order SET 
            food = '$food',
            price = $price,
            qty = $qty,
            total = $total,
            order_date = '$order_date',
            status = '$status',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address',
            f_id = '$f_id'
            ";
                //echo $sql2;

            $res2 = mysqli_query($conn, $sql2);
                //Check whether query executed successfully or not
            if($res2==false)
            {
                    //Query Executed and Order Saved
                
                $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                echo "<script>
                window.location.href='cart.php';
                </script>";
            }
        }
            //die();
        unset($_SESSION['cart']);
        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
        echo "<script>
        window.location.href='foods.php';
        </script>";

    }
    else{
        echo "<script>
        alert('SQL ERROR to database');
        window.location.href='mycart.php';
        </script>";
    }
}
?>