<?php
include "layout/head.php";
$title = 'post';
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
                        <h6 class="m-0 font-weight-bold text-primary">Post details</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $id = $_GET['id'];
                            $sql = "SELECT post.*,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id WHERE post.id=:postId";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':postId', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $post = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="<?php echo $post->image; ?>" alt="">
                            </div>
                            <div class="down-content mt-3">
                                <span class="category"><?php echo $post->categoryName; ?></span>
                                <a href="post-details.html">
                                    <h4><?php echo $post->title; ?></h4>
                                </a>
                                <ul class="list-inline d-flex">
                                    <li class="pr-2"><a href="#"><?php echo $post->Author; ?></a></li> | <li class="pl-2"><a href="#"><?php echo $post->created_at; ?></a></li>
                                </ul>
                                <?php echo $post->description; ?>

                                <div class="post-options">
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="list-inline d-flex">
                                                <li class="pr-1"><i class="fa fa-tags"></i></li>
                                                <?php
                                                $sql = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_id=:postId";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bindParam(':postId', $post->id, PDO::PARAM_INT);
                                                $stmt->execute();
                                                $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                 if ($tags) {
                                                    foreach ($tags as $key => $tag) { ?>
                                                    <li class="mr-2 badge border"><?php echo $tag->name;?></li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-6">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        </script>

        </body>

        </html>