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
                    <a href="postCreate.php" class="d-none d-sm-inline-block btn  btn-primary shadow-sm">
                        <i class="fas fa-plus-circle fa-sm "></i>
                        Add New Post
                    </a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Post List</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['success'])) { ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                            unset($_SESSION['success']);
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Create Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- SELECT post.id,post.title,post.is_published,post.created_at,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id ORDER BY post.id DESC; -->
                                    <?php
                                    $sql = "SELECT post.id,post.title,post.is_published,post.created_at,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id ORDER BY post.id DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    if ($posts) {
                                        foreach ($posts as $key => $post) { ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $post->title; ?></td>
                                                <td><?php echo $post->Author; ?></td>
                                                <td><?php echo $post->categoryName; ?></td>
                                                <td><?php echo $post->created_at; ?></td>
                                                <td>
                                                    <?php
                                                    if ($post->is_published == 'Published') { ?>
                                                        <span class="badge badge-success">Published</span>
                                                    <?php  } else { ?>
                                                        <span class="badge badge-danger">Draft</span>
                                                    <?php } ?>

                                                </td>
                                                <td width="12%">
                                                    <a href="" class="btn btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
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