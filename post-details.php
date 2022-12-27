<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include "layout/head.php";
    ?>

</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- Header -->
<header class="">
    <?php
    include "layout/navbar.php";
    ?>
</header>
<!--get post slug-->
<?php
if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT post.*,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id WHERE post.slug=:postSlug";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postSlug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_OBJ);
}
?>


<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Post Details</h4>
                        <h2><?php echo $post->title??''?></h2>
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
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="admin/<?php echo $post->image??''?>" alt="">
                                    </div>
                                    <div class="down-content">
                                        <span><?php echo $post->categoryName??''?></span>
                                        <a href="post-details.html"><h4><?php echo $post->title??''?></h4></a>
                                        <ul class="post-info">
                                            <li><a href="#"><?php echo $post->Author??''?></a></li>
                                            <li><a href="#">
                                                    <?php
                                                    $date=date_create($post->created_at);
                                                    echo date_format($date,"M d, Y  ");
                                                    ?>
                                                </a></li>
                                        </ul>
                                        <p>
                                            <?php echo html_entity_decode($post->description)??''?>
                                        </p>
                                        <div class="post-options">
                                            <div class="row">
                                                <div class="col-6">
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
                                                <div class="col-6">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--     <div class="col-lg-12">
                                     <div class="sidebar-item comments">
                                         <div class="sidebar-heading">
                                             <h2>4 comments</h2>
                                         </div>
                                         <div class="content">
                                             <ul>
                                                 <li>
                                                     <div class="">
                                                         <h4>Charles Kate</h4>
                                                         <p>Fusce ornare mollis eros. Duis et diam vitae justo fringilla condimentum eu quis leo. Vestibulum id turpis porttitor sapien facilisis scelerisque. Curabitur a nisl eu lacus convallis eleifend posuere id tellus.</p>
                                                     </div>
                                                 </li>
                                                 <li class="replied">
                                                     <div class="">
                                                         <h5>Mr. Admin</h5>
                                                         <p>In porta urna sed venenatis sollicitudin. Praesent urna sem, pulvinar vel mattis eget.</p>
                                                     </div>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>

                                 <br>
                                 <div class="col-lg-12">
                                     <div class="sidebar-item submit-comment">
                                         <div class="sidebar-heading">
                                             <h2>Your comment</h2>
                                         </div>
                                         <div class="content">
                                             <form id="comment" action="#" method="post">
                                                 <div class="row">
                                                     <div class="col-md-6 col-sm-12">
                                                         <fieldset>
                                                             <input name="name" type="text" id="name" placeholder="Your name" required="">
                                                         </fieldset>
                                                     </div>
                                                     <div class="col-md-6 col-sm-12">
                                                         <fieldset>
                                                             <input name="email" type="text" id="email" placeholder="Your email" required="">
                                                         </fieldset>
                                                     </div>
                                                     <div class="col-lg-12">
                                                         <fieldset>
                                                             <textarea name="message" rows="6" id="message" placeholder="Type your comment" required=""></textarea>
                                                         </fieldset>
                                                     </div>
                                                     <div class="col-lg-12">
                                                         <fieldset>
                                                             <button type="submit" id="form-submit" class="main-button">Submit</button>
                                                         </fieldset>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>-->

                        </div>
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
<section class="blog-posts grid-system">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="sidebar-heading">
                        <h2>Related Posts</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="assets/images/blog-thumb-06.jpg" alt="">
                                </div>
                                <div class="down-content p-3">
                                    <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                                    <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="assets/images/blog-thumb-06.jpg" alt="">
                                </div>
                                <div class="down-content p-3">
                                    <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                                    <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="assets/images/blog-thumb-06.jpg" alt="">
                                </div>
                                <div class="down-content p-3">
                                    <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                                    <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="assets/images/blog-thumb-06.jpg" alt="">
                                </div>
                                <div class="down-content p-3">
                                    <a href="post-details.html"><h4>Mauris ac dolor ornare</h4></a>
                                    <p class="p-0 border-bottom-0">Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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