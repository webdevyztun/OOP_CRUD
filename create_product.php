<?php
    $page_title = "Create Product";
    include_once "header.php";
?>
<?php
include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();
?>
<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Read Products</a>
</div>
<?php
    if(isset($_POST['btn-create']))
    {
        include_once 'objects/Product.php';
        $product = new Product($db);

//        echo $_POST['name'];
//        echo $_POST['price'];
//        echo $_POST['description'];
//        echo $_POST['category_id'];

        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->description = $_POST['description'];
        $product->category_id = $_POST['category_id'];

        if($product->create())
        {
            echo "<div class=\"alert alert-success alert-dismissable\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "Product was created.";
            echo "</div>";
        }
        else
        {
            echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\ class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Unable to create Product.";
            echo "</div>";
        }
    }
?>

<form method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="" class="form-control"></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" id="" class="form-control"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea name="description" id="" rows="4" class="form-control"></textarea></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <select name="category_id" class="form-control" id="">
                    <option>Select category...</option>
                    <?php
                        include_once 'objects/Category.php';

                        $category = new Category($db);
                        $stmt = $category->read();

                        while($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_category);
                            ?>
                            <option value="<?php echo $id;?>"><?php echo $name;?></option>
                            <?php
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary" name="btn-create">Create</button>
            </td>
        </tr>
    </table>
</form>
<?php
    include_once "footer.php";
?>
