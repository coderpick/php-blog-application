<?php
$title = 'post';
include "layout/head.php";


if (isset($_POST['submit'])) {

    $tags          = $_POST['tag'];
    $postId        = $_POST['postId'];

    if (is_array_empty($tags)) {
        $data['tags'] = $tags;
    } else {
        $error['tag'] = 'Tag is required';
    }

    if ( empty($error['tag']) ) {
        try {

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
            /* insert post tags */
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


        } catch (PDOException $e) {
            die('ERROR: Could not able to prepare/execute query: '.$sql. $e->getMessage());
        }
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    /*select item for delete image*/
    $sql = "SELECT * FROM post WHERE id=:id";
    $selectStmt = $conn->prepare($sql);
    $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $selectStmt->execute();
    $post = $selectStmt->fetch(PDO::FETCH_OBJ);
    // print_r($post);
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
                            <input type="hidden" name="postId" value="<?php echo $post->id;?>">
                    </div>
                </div>

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