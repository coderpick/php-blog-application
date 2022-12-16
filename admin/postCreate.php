<?php
include "layout/head.php";
$title = 'category';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $post_name    = inputValidate($_POST['post_name']);
    $category_slug    = inputValidate($_POST['category_slug']);


    if (empty($post_name)) {
        $error['post_name'] = 'Category name is required';
    } else {
        $data['post_name'] = $post_name;
    }
    if (empty($category_slug)) {
        $error['category_slug'] = 'Category slug is required';
    } else {
        $data['category_slug'] = $category_slug;
    }

    if (empty($error['post_name']) && empty($error['category_slug'])) {

        try {
            $sql = "INSERT INTO category(name,slug)VALUES(:name, :slug)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bindParam(':name', $data['post_name'], PDO::PARAM_STR);
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
                    <h1 class="h3 mb-0 text-gray-800">Post</h1>
                    <a href="post.php" class="d-none d-sm-inline-block btn  btn-danger shadow-sm">
                        <i class="fas fa-reply fa-sm "></i>
                        Back to list
                    </a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Post Create</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="post_title">Post title</label>
                                        <input type="text" name="post_title" class="form-control" id="post_title">
                                        <small id="post_title" class="form-text text-danger">
                                            <?php
                                            echo $error['post_title'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Post Slug</label>
                                        <input type="text" name="slug" class="form-control" id="slug">
                                        <small id="slug" class="form-text text-danger">
                                            <?php
                                            echo $error['slug'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Post Description</label>
                                        <textarea type="text" name="description" class="form-control" id="description"></textarea>
                                        <small id="description" class="form-text text-danger">
                                            <?php
                                            echo $error['description'] ?? '';
                                            ?>
                                        </small>
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="image">Post Image</label>
                                        <input type="file" name="image" class="form-control dropify" id="image">
                                        <small id="image" class="form-text text-danger">
                                            <?php
                                            echo $error['image'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select class="custom-select" name="category">
                                            <option selected disabled>Select Category</option>
                                            <?php
                                            $sql = "SELECT * FROM category";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            if ($categories) {
                                                foreach ($categories as $key => $category) { ?>
                                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Tags</label>
                                        <select class="custom-select select2" name="tags[]" multiple>
                                            <option  disabled>Select Tags</option>
                                            <?php
                                            $sql = "SELECT * FROM tag";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            if ($tags) {
                                                foreach ($tags as $key => $tag) { ?>
                                                    <option value="<?php echo $tag->id; ?>"><?php echo $tag->name; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block mb-2">Post Status</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="published" name="status" class="custom-control-input">
                                            <label class="custom-control-label" for="published">Published</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="draft" name="status" class="custom-control-input">
                                            <label class="custom-control-label" for="draft">Draft</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

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
        ?>
        <script src="vendor/dropify/js/dropify.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('.dropify').dropify();
            $(document).ready(function() {
                $('#description').summernote({
                    height: 300
                });

                $('.select2').select2();
            });

            $('#post_name').on('keyup', function() {

                $('#category_slug').val('')

                var category = $(this).val();
                category = category.toLowerCase();
                category = category.replace(/[^a-zA-Z0-9]+/g, '-');
                $('#category_slug').val(category)
            })
        </script>

        </body>

        </html>