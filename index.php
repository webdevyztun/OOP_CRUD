<?php
    $page_title = "Read Products";
    include_once "header.php";
?>
<div class="right-button-margin">
    <a href="create_product.php" class="btn btn-default pull-right">Create Products</a>
</div>

<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 3;
    $from_record_num = ($records_per_page * $page) - $records_per_page;
?>
<?php
    include_once 'config/database.php';
    include_once 'objects/Product.php';
    include_once 'objects/Category.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $stmt = $product->readAll($page,$from_record_num,$records_per_page);
    $num = $stmt->rowCount();

    if($num > 0)
    {
        $category = new Category($db);

        echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>Product</th>";
                echo "<th>Price</th>";
                echo "<th>Description</th>";
                echo "<th>Category</th>";
                echo "<th>Actions</th>";
            echo "</tr>";

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);

                echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td>";
                        $category->id = $category_id;
                        $category->readname();
                        echo $category->name;
                    echo "</td>";
                    echo "<td>";
                        echo "<a href='update_product.php?id={$id}' class='btn btn-default left-margin'>Edit</a>";
                        echo "<a delete-id='{$id}' class='btn btn-default delete-object'>Delete</a>";
                    echo "</td>";
                echo "</tr>";
            }

        echo "</table>";
    }
    else
    {
        echo "<div>No products found.</div>";
    }

?>
<?php
    include_once 'paging_product.php';
?>
<script>
    $(document).on('click','.delete-object',function(){
       var id = $(this).attr('delete-id');
        $.post('delete_product.php',
            {object_id:id},function(data)
                {
                    location.reload();
                });
    });
</script>
<?php
    include_once 'footer.php';
?>
