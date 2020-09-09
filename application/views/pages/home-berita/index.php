<!-- ##### Blog Area Start ##### -->
<div class="blog-area section-padding-0-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="blog-posts-area">

                    <!-- Single Featured Post -->
                    <div class="single-blog-post featured-post single-post">
                        <div class="post-thumb">
                            <a href="#"><img src="<?php echo $berita->gambar ?>" alt="" style="width:100%"></a>
                        </div>
                        <div class="post-data">
                            <a href="#" class="post-catagory"><?php echo $berita->sumber->text ?></a>
                            <a href="#" class="post-title">
                                <h6><?php echo $berita->judul . " " ?></h6>
                            </a>
                            <div class="post-meta">
                                <p class="post-author">By <a href="#">Christinne Williams</a></p>
                                <?php foreach ($berita->paragraft as $key => $value) : ?>
                                    <p>
                                        <?php foreach ($value as $k => $v) : ?>
                                            <?php echo $v->kalimat . "." ?>
                                        <?php endforeach ?>
                                    </p>
                                <?php endforeach ?>
                                <a href="<?php echo $berita->full_link ?>" target="_BLANK" class="related--post">Full Berita: <?php echo $berita->sumber->teks ?></a>
                                <div class="newspaper-post-like d-flex align-items-center justify-content-between">
                                    <!-- Tags -->
                                    <div class="newspaper-tags d-flex">
                                        <span>Tags:</span>
                                        <ul class="d-flex">
                                            <li><a href="#">finacial,</a></li>
                                            <li><a href="#">politics,</a></li>
                                            <li><a href="#">stock market</a></li>
                                        </ul>
                                    </div>

                                    <!-- Post Like & Post Comment -->
                                    <div class="d-flex align-items-center post-like--comments">
                                        <a href="#" class="post-like"><img src="<?php echo base_url("assets_home/") ?>img/core-img/like.png" alt=""> <span>392</span></a>
                                        <a href="#" class="post-comment"><img src="<?php echo base_url("assets_home/") ?>img/core-img/chat.png" alt=""> <span>10</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Author -->
                    <div class="blog-post-author d-flex">
                        <div class="author-thumbnail">
                            <a href="<?php echo $berita->sumber->url ?>" target="_BLANK">
                                <img src="<?php echo base_url("storage/image/" . $berita->sumber->icon) ?>" alt="">
                            </a>
                        </div>
                        <div class="author-info">
                            <a href="<?php echo $berita->sumber->url ?>" target="_BLANK" class="author-name"><span>Penerbit</span>, <?php echo $berita->sumber->teks ?></a>
                            <p><?php echo $berita->sumber->tentang ?></p>
                            <a href="<?php echo $berita->sumber->url ?>" target="_BLANK" class="link">Menuju Ke Halaman terkait</a>
                        </div>
                    </div>

                    <div class="pager d-flex align-items-center justify-content-between">

                        <?php if ($berita->prev != null) : ?>
                            <div class="prev">
                                <a href="<?php echo $berita->prev->link ?>" class="active"><i class="fa fa-angle-left"></i> previous</a>
                            </div>

                        <?php endif ?>
                        <?php if ($berita->next != null) : ?>
                            <div class="next">
                                <a href="<?php echo $berita->next->link ?>">Next <i class="fa fa-angle-right"></i></a>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="section-heading">
                        <h6>Related</h6>
                    </div>

                    <div class="row">
                        <!-- Single Post -->
                        <?php foreach ($berita->related_berita as $key => $value) : ?>
                            <div class="col-12 col-md-6">
                                <div class="single-blog-post style-3 mb-80">
                                    <div class="post-thumb">
                                        <a href="<?php echo $value->link ?>"><img src="<?php echo $value->gambar ?>" alt=""></a>
                                    </div>
                                    <div class="post-data">
                                        <a href="#" class="post-catagory"><?php echo $value->sumber ?></a>
                                        <a href="<?php echo $value->link ?>" class="post-title">
                                            <h6><?php echo $value->judul ?></h6>
                                        </a>
                                        <div class="post-meta d-flex align-items-center">
                                            <a href="#" class="post-like"><img src="<?php echo base_url("assets_home/") ?>img/core-img/like.png" alt=""> <span>392</span></a>
                                            <a href="#" class="post-comment"><img src="<?php echo base_url("assets_home/") ?>img/core-img/chat.png" alt=""> <span>10</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>

                    <!-- Comment Area Start -->
                    <div class="comment_area clearfix">
                        <h5 class="title">3 Comments</h5>

                        <ol>
                            <!-- Single Comment Area -->
                            <li class="single_comment_area">
                                <!-- Comment Content -->
                                <div class="comment-content d-flex">
                                    <!-- Comment Author -->
                                    <div class="comment-author">
                                        <img src="<?php echo base_url("assets_home/") ?>img/bg-img/30.jpg" alt="author">
                                    </div>
                                    <!-- Comment Meta -->
                                    <div class="comment-meta">
                                        <a href="#" class="post-author">Christian Williams</a>
                                        <a href="#" class="post-date">April 15, 2018</a>
                                        <p>Donec turpis erat, scelerisque id euismod sit amet, fermentum vel dolor. Nulla facilisi. Sed pellen tesque lectus et accu msan aliquam. Fusce lobortis cursus quam, id mattis sapien.</p>
                                    </div>
                                </div>
                                <ol class="children">
                                    <li class="single_comment_area">
                                        <!-- Comment Content -->
                                        <div class="comment-content d-flex">
                                            <!-- Comment Author -->
                                            <div class="comment-author">
                                                <img src="<?php echo base_url("assets_home/") ?>img/bg-img/31.jpg" alt="author">
                                            </div>
                                            <!-- Comment Meta -->
                                            <div class="comment-meta">
                                                <a href="#" class="post-author">Sandy Doe</a>
                                                <a href="#" class="post-date">April 15, 2018</a>
                                                <p>Donec turpis erat, scelerisque id euismod sit amet, fermentum vel dolor. Nulla facilisi. Sed pellen tesque lectus et accu msan aliquam. Fusce lobortis cursus quam, id mattis sapien.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </li>

                            <!-- Single Comment Area -->
                            <li class="single_comment_area">
                                <!-- Comment Content -->
                                <div class="comment-content d-flex">
                                    <!-- Comment Author -->
                                    <div class="comment-author">
                                        <img src="<?php echo base_url("assets_home/") ?>img/bg-img/32.jpg" alt="author">
                                    </div>
                                    <!-- Comment Meta -->
                                    <div class="comment-meta">
                                        <a href="#" class="post-author">Christian Williams</a>
                                        <a href="#" class="post-date">April 15, 2018</a>
                                        <p>Donec turpis erat, scelerisque id euismod sit amet, fermentum vel dolor. Nulla facilisi. Sed pellen tesque lectus et accu msan aliquam. Fusce lobortis cursus quam, id mattis sapien.</p>
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div>

                    <div class="post-a-comment-area section-padding-80-0">
                        <h4>Leave a comment</h4>

                        <!-- Reply Form -->
                        <div class="contact-form-area">
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <input type="text" class="form-control" id="name" placeholder="Name*">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="email" class="form-control" id="email" placeholder="Email*">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="subject" placeholder="Website">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn newspaper-btn mt-30 w-100" type="submit">Submit Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="blog-sidebar-area">

                    <!-- Latest Posts Widget -->
                    <div class="latest-posts-widget mb-50" id="recent-berita">


                    </div>

                    <!-- Popular News Widget -->
                    <div class="popular-news-widget mb-50">
                        <h3>4 Most Popular News</h3>

                        <!-- Single Popular Blog -->
                        <div class="single-popular-post">
                            <a href="#">
                                <h6><span>1.</span> Amet, consectetur adipiscing elit. Nam eu metus sit amet odio sodales.</h6>
                            </a>
                            <p>April 14, 2018</p>
                        </div>

                        <!-- Single Popular Blog -->
                        <div class="single-popular-post">
                            <a href="#">
                                <h6><span>2.</span> Consectetur adipiscing elit. Nam eu metus sit amet odio sodales placer.</h6>
                            </a>
                            <p>April 14, 2018</p>
                        </div>

                        <!-- Single Popular Blog -->
                        <div class="single-popular-post">
                            <a href="#">
                                <h6><span>3.</span> Adipiscing elit. Nam eu metus sit amet odio sodales placer. Sed varius leo.</h6>
                            </a>
                            <p>April 14, 2018</p>
                        </div>

                        <!-- Single Popular Blog -->
                        <div class="single-popular-post">
                            <a href="#">
                                <h6><span>4.</span> Eu metus sit amet odio sodales placer. Sed varius leo ac...</h6>
                            </a>
                            <p>April 14, 2018</p>
                        </div>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="newsletter-widget mb-50">
                        <h4>Newsletter</h4>
                        <p>Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        <form action="#" method="post">
                            <input type="text" name="text" placeholder="Name">
                            <input type="email" name="email" placeholder="Email">
                            <button type="submit" class="btn w-100">Subscribe</button>
                        </form>
                    </div>

                    <!-- Latest Comments Widget -->
                    <div class="latest-comments-widget">
                        <h3>Latest Comments</h3>

                        <!-- Single Comments -->
                        <div class="single-comments d-flex">
                            <div class="comments-thumbnail mr-15">
                                <img src="<?php echo base_url("assets_home/") ?>img/bg-img/29.jpg" alt="">
                            </div>
                            <div class="comments-text">
                                <a href="#">Jamie Smith <span>on</span> Facebook is offering facial recognition...</a>
                                <p>06:34 am, April 14, 2018</p>
                            </div>
                        </div>

                        <!-- Single Comments -->
                        <div class="single-comments d-flex">
                            <div class="comments-thumbnail mr-15">
                                <img src="<?php echo base_url("assets_home/") ?>img/bg-img/30.jpg" alt="">
                            </div>
                            <div class="comments-text">
                                <a href="#">Jamie Smith <span>on</span> Facebook is offering facial recognition...</a>
                                <p>06:34 am, April 14, 2018</p>
                            </div>
                        </div>

                        <!-- Single Comments -->
                        <div class="single-comments d-flex">
                            <div class="comments-thumbnail mr-15">
                                <img src="<?php echo base_url("assets_home/") ?>img/bg-img/31.jpg" alt="">
                            </div>
                            <div class="comments-text">
                                <a href="#">Jamie Smith <span>on</span> Facebook is offering facial recognition...</a>
                                <p>06:34 am, April 14, 2018</p>
                            </div>
                        </div>

                        <!-- Single Comments -->
                        <div class="single-comments d-flex">
                            <div class="comments-thumbnail mr-15">
                                <img src="<?php echo base_url("assets_home/") ?>img/bg-img/32.jpg" alt="">
                            </div>
                            <div class="comments-text">
                                <a href="#">Jamie Smith <span>on</span> Facebook is offering facial recognition...</a>
                                <p>06:34 am, April 14, 2018</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>