<div class="sidebar">
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar-item search">
                <form id="search_form" name="gs" method="GET" action="#">
                    <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                </form>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="sidebar-item recent-posts">
                <div class="sidebar-heading">
                    <h2>Recent Posts</h2>
                </div>
                <div class="content">
                    <ul>
                        <?php
                        $sql = "SELECT id,title,slug,created_at FROM post ORDER BY id DESC LIMIT 5";
                        $stmt = $conn->query($sql);
                        $latestPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if ($latestPosts){
                            foreach ($latestPosts as $post){?>
                                <li>
                                    <a href="post-details.html">
                                        <h5><?php echo $post->title;?></h5>
                                        <span>
                                            <?php
                                            $date=date_create($post->created_at);
                                            echo date_format($date,"M d, Y  ");
                                            ?>
                                        </span>

                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="sidebar-item categories">
                <div class="sidebar-heading">
                    <h2>Categories</h2>
                </div>
                <div class="content">
                    <ul>
                        <?php
                        $sql = "SELECT * FROM category";
                        $stmt = $conn->query($sql);
                        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if ($categories){
                            foreach ($categories as $category){?>
                                <li><a href="#">- <?php echo $category->name;?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="sidebar-item tags">
                <div class="sidebar-heading">
                    <h2>Tag Clouds</h2>
                </div>
                <div class="content">
                    <ul>
                        <?php
                        $sql = "SELECT * FROM tag ORDER BY RAND() LIMIT 20";
                        $stmt = $conn->query($sql);
                        $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if ($tags){
                            foreach ($tags as $tag){?>
                                <li><a href="#"><?php echo $tag->name;?></a></li>
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