<?php
$title = 'post';
include "layout/head.php";
error_reporting(0);

if (isset($_POST['submit'])) {

    $title       = inputValidate($_POST['title']);
    $slug        = inputValidate($_POST['slug']);
    $description = $_POST['description'];
    $category    = inputValidate($_POST['category']);
    $tags        = $_POST['tag'];
    $status      = inputValidate($_POST['status']);
    /*post id & post old image*/
    $postId       = inputValidate($_POST['postId']);
    $postOldImage = inputValidate($_POST['postOldImage']);

    $fileName    = $_FILES['image']['name'];
    $fileTmp     = $_FILES['image']['tmp_name'];
    $fileSize    = $_FILES['image']['size'];


    if (empty($title)) {
        $error['title'] = 'Post title is required';
    } else {
        $data['title'] = $title;
    }
    if (empty($slug)) {
        $error['slug'] = 'Post slug is required';
    } else {
        $data['slug'] = str_slug($slug);
    }
    if (empty($description)) {
        $error['description'] = 'Post description is required';
    } else {
        $data['description'] = $description;
    }
    if (empty($category)) {
        $error['category'] = 'Category is required';
    } else {
        $data['category'] = $category;
    }

    if (is_array_empty($tags)) {
        $data['tags'] = $tags;
    } else {
        $error['tag'] = 'Tag is required';
    }

    if (empty($status)) {
        $error['status'] = 'Status is required';
    } else {
        $data['status'] = $status;
    }
    if ($fileName) {
        $ext           = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowItem     = array('jpg', 'jpeg', 'png', 'webp');
        $uniqueImgName = uniqid() . rand(1000, 99999) . '.' . $ext;
        $upload_Image  = 'uploads/post/' . $uniqueImgName;

        if (in_array($ext, $allowItem)) {
            if ($fileSize < 1048576) {
                unlink($postOldImage);
                move_uploaded_file($fileTmp, $upload_Image);
            } else {
                $photoErr = "Image size less then 1mb required";
            }
        } else {
            $photoErr = "Only jpg,jpeg, png & webp allow";
        }
    } else {
        $upload_Image = $postOldImage;
    }


    if (empty($error['title']) && empty($error['slug']) && empty($error['description']) && empty($error['category']) && empty($error['tag']) && empty($error['image']) && empty($error['status'])) {
        $cdTime = date('Y-m-d H:i:s');
        try {
            $sql = "UPDATE post SET admin_id=:admin_id, category_id=:category_id, title=:title,slug=:slug, description=:description, image=:image, is_published=:is_published, updated_at=:updated_at WHERE id=:id";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bindParam(':admin_id', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->bindParam(':category_id', $data['category'], PDO::PARAM_INT);
                $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
                $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $stmt->bindParam(':image', $upload_Image, PDO::PARAM_STR);
                $stmt->bindParam(':is_published', $data['status'], PDO::PARAM_STR);
                $stmt->bindParam(':updated_at', $cdTime, PDO::PARAM_STR);
                $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
                $stmt->execute();

                $lastId = $conn->lastInsertId();

                /* select existing post tags */
                $query = "SELECT * FROM post_tag WHERE post_id=:postId";
                $stmtForTag = $conn->prepare($query);
                $stmtForTag->bindParam('postId', $postId,PDO::PARAM_INT);
                $stmtForTag->execute();
                $tagIds = $stmtForTag->fetchAll(PDO::FETCH_ASSOC);
                /*Delete existing post tags*/
                if ($tagIds){
                    foreach ($tagIds as $tagId){
                        $sql ="DELETE FROM post_tag WHERE post_id=:postId";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam('postId', $postId,PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
                /* update post tags */
                if ($data['tags']) {
                    foreach ($tags as $key => $tag) {
                        $sql = "INSERT INTO post_tag(post_id,tag_id)VALUES(:post_id,:tag_id)";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
                            $stmt->bindParam(':tag_id', $tags[$key], PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    }
                }

                $_SESSION['success'] = "Post update successfully";
                header('Location:post.php');

            }
        } catch (PDOException $e) {
            die('ERROR: Could not able to prepare/execute query: ' . $slq . $e->getMessage());
        }
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM post WHERE id=:id";
    $selectStmt = $conn->prepare($sql);
    $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $selectStmt->execute();
    $post = $selectStmt->fetch(PDO::FETCH_OBJ);
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
                        <h6 class="m-0 font-weight-bold text-primary">Post Edit</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="title">Post Title </label>
                                        <input type="text" name="title" class="form-control" value="<?php echo $post->title; ?>" id="title">
                                        <small id="title" class="form-text text-danger">
                                            <?php
                                            echo $error['title'] ?? '';
                                            ?>
                                        </small>
                                    </div><!-- //title end -->
                                    <div class="form-group">
                                        <label for="slug">Post Slug</label>
                                        <input type="text" name="slug" class="form-control" value="<?php echo $post->slug; ?>" id="slug">
                                        <small id="slug" class="form-text text-danger">
                                            <?php
                                            echo $error['slug'] ?? '';
                                            ?>
                                        </small>
                                    </div><!-- //slug end -->
                                    <div class="form-group">
                                        <label for="description">Post Description</label>
                                        <textarea name="description" class="form-control" id="description"><?php echo $post->description; ?></textarea>
                                        <small id="description" class="form-text text-danger">
                                            <?php
                                            echo $error['description'] ?? '';
                                            ?>
                                        </small>
                                    </div><!-- //description end -->
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Post Image</label>
                                        <input type="file" name="image" class="form-control dropify" data-default-file="<?php echo $post->image; ?>" id="image">
                                        <small id="image" class="form-text text-danger">
                                            <?php
                                            echo $error['image'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Select Category</label>
                                        <select class="custom-select" name="category" id="category">
                                            <option  disabled>Select Category</option>
                                            <?php
                                            $sql = "SELECT * FROM category";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            if ($categories) {

                                                foreach ($categories as  $category) { ?>
                                                    <option <?php echo $post->category_id == $category->id? 'selected':'' ?> value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                        <small id="category" class="form-text text-danger">
                                            <?php
                                            echo $error['category'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Select Tags</label>
                                        <select class="custom-select" name="tag[]" multiple id="tag">
                                            <option disabled>Select tags</option>
                                            <?php
                                            /*get post tags id*/
                                            $query = "SELECT * FROM post_tag WHERE post_id=:postId";
                                            $stmtForTag = $conn->prepare($query);
                                            $stmtForTag->bindParam('postId', $post->id,PDO::PARAM_INT);
                                            $stmtForTag->execute();
                                            $tagIds = $stmtForTag->fetchAll(PDO::FETCH_OBJ);

                                            $sql = "SELECT * FROM tag";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            if ($tags) {
                                                foreach ($tags as  $tag) { ?>
                                                    <option
                                                        <?php
                                                        foreach ($tagIds as $tagId) {
                                                            if ($tagId->tag_id == $tag->id) {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>
                                                            value="<?php echo $tag->id; ?>"><?php echo $tag->name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <small id="tag" class="form-text text-danger">
                                            <?php
                                            echo $error['tag'] ?? '';
                                            ?>
                                        </small>
                                    </div>

                                    <!-- post status -->
                                    <div class="form-group">
                                        <label class="d-block" for="">Post Status</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="published" value="Published" <?php echo  $post->is_published=='Published'?'checked':''?> name="status" class="custom-control-input">
                                            <label class="custom-control-label" for="published">Published</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="draft" <?php echo  $post->is_published=='Draft'?'checked':''?> name="status" value="Draft" class="custom-control-input">
                                            <label class="custom-control-label" for="draft">Draft</label>
                                        </div>
                                        <small id="status" class="form-text text-danger">
                                            <?php
                                            echo $error['status'] ?? '';
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="postId" value="<?php echo $post->id; ?>">
                            <input type="hidden" name="postOldImage" value="<?php echo $post->image?? ''; ?>">
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
        <!-- include summernote css/js -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="vendor/dropify/js/dropify.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#description').summernote({
                    height: 300
                });

                /* dropify active */
                $('.dropify').dropify();

                $('#tag').select2();
            });

            $('#title').on('keyup', function() {
                $('#slug').val('')
                var slug = $(this).val();
                slug = slugify(slug);
                $('#slug').val(slug)
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