<?php
$sql = "SELECT post.id,post.title,post.is_published,post.created_at,post.image,category.name as categoryName,admin.name as Author FROM post INNER JOIN category ON post.category_id=category.id INNER JOIN admin ON post.admin_id=admin.id WHERE post.is_published='Published' LIMIT 6";
$stmt = $conn->query($sql);
$posts = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            <?php
            if ($posts !=null){
                foreach($posts as $post){?>
                    <div class="item">
                        <img src="admin/<?php echo $post->image??''?>" alt="">
                        <div class="item-content">
                            <div class="main-content">
                                <div class="meta-category">
                                    <span><?php echo $post->categoryName??''?></span>
                                </div>
                                <a href="post-details.php?slug=<?php echo $post->slug;?>"><h4><?php echo $post->title??''?></h4></a>
                                <ul class="post-info">
                                    <li><a href="#"><?php echo $post->Author??''?></a></li>
                                    <li><a href="#"><?php echo $post->created_at??''?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php        }
            }
            ?>


        </div>
    </div>
</div>