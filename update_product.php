<?php
    $page_title = "Update Product";
    include_once "header.php";
?>

<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Read Products</a>
</div>

<?php
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

    include_once 'config/database.php';
    include_once 'objects/product.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $product->id = $id;

    $product->readOne();
?>
<?php
    if(isset($_POST['btn-update']))
    {
        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->description = $_POST['description'];
        $product->category_id = $_POST['category_id'];

        if($product->update())
        {
            echo "<div class=\"alert alert-success alert-dismissable\">";
                echo "<button type=\"button\" class=\"close\" data-miss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "Product was updated";
            echo "</div>";
        }
        else
        {
            echo "<div class=\"alert alert-danger alert-dismissable\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "Unable to update product.";
            echo "</div>";
        }
    }
?>
<form action="update_product.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="" class="form-control" value="<?php echo $product->name; ?>"></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" id="" class="form-control" value="<?php echo $product->price; ?>"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea name="description" id="" class="form-control"><?php echo $product->description; ?></textarea></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <?php
                    include_once 'objects/category.php';

                    $category = new Category($db);
                    $stmt = $category->read();

                    echo "<select class='form-control' name='category_id'>";
                        echo "<option>Please select...</option>";
                        while($row_category = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row_category);

                            if($product->category_id==$id)
                            {
                                echo "<option value='$id' selected>";
                            }
                            else
                            {
                                echo "<option value='$id'>";
                            }
                            echo "$name</option>";
                        }
                    echo "</select>";
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary" name="btn-update">Update</button>
            </td>
        </tr>
    </table>
</form>

<?php include_once 'footer.php';?>