<?php
include "layout/head.php";
$title = 'tag';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tag_name    = inputValidate($_POST['tag_name']);
    $tag_slug    = inputValidate($_POST['tag_slug']);


    if (empty($tag_name)) {
        $error['tag_name'] = 'Tag name is required';
    } else {
        $data['tag_name'] = $tag_name;
    }
    if (empty($tag_slug)) {
        $error['tag_slug'] = 'Tag slug is required';
    } else {
        $data['tag_slug'] = $tag_slug;
    }

    if (empty($error['tag_name']) && empty($error['tag_slug'])) {
        try {
            $sql = "INSERT INTO tag(name,slug)VALUES(:name, :slug)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bindParam(':name', $data['tag_name'], PDO::PARAM_STR);
                $stmt->bindParam(':slug', $data['tag_slug'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Tag inserted successfully";
                    header('location:tag.php');
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
                    <h1 class="h3 mb-0 text-gray-800">Tag</h1>
                    <a href="tag.php" class="d-none d-sm-inline-block btn  btn-danger shadow-sm">
                        <i class="fas fa-reply fa-sm "></i>
                        Back to list
                    </a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tag Create</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="form-group">
                                <label for="tag_name">Tag Name</label>
                                <input type="text" name="tag_name" class="form-control" id="tag_name">
                                <small id="tag_name" class="form-text text-danger">
                                    <?php
                                    echo $error['tag_name'] ?? '';
                                    ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="tag_slug">Tag Slug</label>
                                <input type="text" name="tag_slug" class="form-control" id="tag_slug">
                                <small id="tag_slug" class="form-text text-danger">
                                    <?php
                                    echo $error['tag_slug'] ?? '';
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
           
            $('#tag_name').on('keyup', function() {
                $('#category_slug').val('')
                var tag = $(this).val();
                tag = slugify(tag);
                $('#tag_slug').val(tag)
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