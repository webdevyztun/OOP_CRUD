<?php
    if($_POST)
    {
        include_once 'config/database.php';
        include_once 'objects/Product.php';

        $database = new Database();
        $db = $database->getConnection();

        $product = new Product($db);

        $product->id = $_POST['object_id'];

        if($product->delete())
        {
            echo "Object was deleted";
        }
        else
        {
            echo "Unable to delete object.";
        }
    }

?>