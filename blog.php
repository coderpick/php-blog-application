<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    include "layout/head.php";
    ?>

</head>

<body>

<!-- ***** Preloader Start ***** -->
<!--<div id="preloader">-->
<!--    <div class="jumper">-->
<!--        <div></div>-->
<!--        <div></div>-->
<!--        <div></div>-->
<!--    </div>-->
<!--</div>-->
<!-- ***** Preloader End ***** -->

<!-- Header -->
<header class="">
    <?php
    include "layout/navbar.php";
    ?>
</header>

<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Recent Posts</h4>
                        <h2>Our Recent Blog Entries</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Banner Ends Here -->
<section class="blog-posts">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="all-blog-posts">
                    <div class="row">
                        <?php

                        $perPage     = 2;
                        // Calculate Total pages
                        $stmt = $conn->query('SELECT count(*) FROM post');
                        $total_results = $stmt->fetchColumn();
                        $total_pages = ceil($total_results / $perPage);

                       $currentPage = 1;    // Current page
                        if ($_GET['page']){
                              $page = $_GET['page'];
                              $currentPage =  $page;
                        }else{
                             $page = 1;
                        }
                        $starting_page = ($page - 1) * $perPage;

                        $sql = "SELECT post.*,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id WHERE is_published='Published' ORDER BY post.id DESC  LIMIT $starting_page,$perPage";
                        $stmt = $conn->query($sql);
                        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if ($posts){
                            foreach ($posts as $post){?>
                                <div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="admin/<?php echo $post->image;?>" alt="">
                                        </div>
                                        <div class="down-content">
                                            <span><?php echo $post->categoryName; ?></span>
                                            <a href="post-details.php?slug=<?php echo $post->slug;?>"><h4><?php echo $post->title; ?></h4></a>
                                            <ul class="post-info">
                                                <li><a href="#"><?php echo $post->Author; ?></a></li>
                                                <li>
                                                    <a href="#">
                                                        <?php
                                                        $date=date_create($post->created_at);
                                                        echo date_format($date,"M d, Y  ");
                                                        ?>
                                                    </a>
                                                </li>
                                            </ul>
                                            <p>
                                                <?php echo html_entity_decode(str_limit($post->description,200))??''?>
                                            </p>

                                            <div class="post-options">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <ul class="post-tags">
                                                            <li><i class="fa fa-tags"></i></li>
                                                            <?php
                                                            $sql = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_id=:postId";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bindParam(':postId', $post->id, PDO::PARAM_INT);
                                                            $stmt->execute();
                                                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                            if ($tags) {
                                                                foreach ($tags as $key => $tag) { ?>
                                                                    <li><a href="tag.php?slug=<?php echo $tag->slug;?>" class="badge badge-primary text-white"><?php echo $tag->name;?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <hr>

                        <!--pagination start-->
                        <div class="col-lg-12">
                            <ul class="page-numbers">
                                <?php for ($i = 1; $i <= $total_pages ; $i++):?>
                                        <?php
                                        $active ='';
                                        if ($currentPage == $i){
                                            $active = 'active';
                                        }
                                    ?>
                                       <li class="<?php echo $active; ?>">
                                           <a href='<?php echo "?page=$i"; ?>' class="links">
                                                 <?php  echo $i; ?>
                                           </a>
                                       </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                        <!--pagination end-->
                        <!-- <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!--sidebar start-->
                <?php
                include "layout/sidebar.php";
                ?>
                <!--sidebar end-->
            </div>
        </div>
    </div>
</section>

<!--footer start-->
<?php
include "layout/footer.php";
?>
<!--footer end-->

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Additional Scripts -->
<?php
include "layout/_script.php";
?>

</body>
</html>