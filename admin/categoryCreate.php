<?php
include "layout/head.php";
$title = 'category';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category_name    = inputValidate($_POST['category_name']);
    $category_slug    = inputValidate($_POST['category_slug']);


    if (empty($category_name)) {
        $error['category_name'] = 'Category name is required';
    } else {
        $data['category_name'] = $category_name;
    }
    if (empty($category_slug)) {
        $error['category_slug'] = 'Category slug is required';
    } else {
        $data['category_slug'] = $category_slug;
    }

    if (empty($error['category_name']) && empty($error['category_slug'])) {

        try {
            $sql = "INSERT INTO category(name,slug)VALUES(:name, :slug)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bindParam(':name', $data['category_name'], PDO::PARAM_STR);
                $stmt->bindParam(':slug', $data['category_slug'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Category inserted successfully";
                    header('location:category.php');
                }
            }
        } catch (PDOException $e) {
            die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
        }
    }
}

?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php
    include "layout/sidebar.php";
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php
            include "layout/topbar.php";
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Cateogry</h1>
                    <a href="category.php" class="d-none d-sm-inline-block btn  btn-danger shadow-sm">
                        <i class="fas fa-reply fa-sm "></i>
                        Back to list
                    </a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Category Create</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="category_name" class="form-control" id="category_name">
                                <small id="category_name" class="form-text text-danger">
                                    <?php
                                    echo $error['category_name'] ?? '';
                                    ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="category_slug">Category Slug</label>
                                <input type="text" name="category_slug" class="form-control" id="category_slug">
                                <small id="category_slug" class="form-text text-danger">
                                    <?php
                                    echo $error['category_slug'] ?? '';
                                    ?>
                                </small>
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <!-- footer page link -->
        <?php
        include "layout/footer.php";
        include "layout/_script.php";
        include "layout/datatable.php";
        ?>

        <script>
            $('#category_name').on('keyup', function() {
                $('#category_slug').val('')
                var category = $(this).val();
                category =slugify(category);
                $('#category_slug').val(category)
            })
            function slugify(text) {
                return text.toLowerCase()
                    .replace(text, text)
                    .replace(/^-+|-+$/g, '')
                    .replace(/\s/g, '-')
                    .replace(/\-\-+/g, '-');
            }
        </script>

        </body>

        </html>