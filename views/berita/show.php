<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\BeritaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<style>
    /*
 * Globals
 */

    body {
        font-family: Georgia, "Times New Roman", Times, serif;
        color: #555;
    }

    h1, .h1,
    h2, .h2,
    h3, .h3,
    h4, .h4,
    h5, .h5,
    h6, .h6 {
        margin-top: 0;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: normal;
        color: #333;
    }

    /*
     * Override Bootstrap's default container.
     */

    /*@media (min-width: 1200px) {*/
    /*.container {*/
    /*width: 970px;*/
    /*}*/
    /*}*/

    /*
     * Masthead for nav
     */

    .blog-masthead {
        background-color: #428bca;
        -webkit-box-shadow: inset 0 -2px 5px rgba(0, 0, 0, .1);
        box-shadow: inset 0 -2px 5px rgba(0, 0, 0, .1);
    }

    /* Nav links */
    .blog-nav-item {
        position: relative;
        display: inline-block;
        padding: 10px;
        font-weight: 500;
        color: #cdddeb;
    }

    .blog-nav-item:hover,
    .blog-nav-item:focus {
        color: #fff;
        text-decoration: none;
    }

    /* Active state gets a caret at the bottom */
    .blog-nav .active {
        color: #fff;
    }

    .blog-nav .active:after {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 0;
        margin-left: -5px;
        vertical-align: middle;
        content: " ";
        border-right: 5px solid transparent;
        border-bottom: 5px solid;
        border-left: 5px solid transparent;
    }

    /*
     * Blog name and description
     */

    .blog-header {
        padding-top: 10px;
        padding-bottom: 20px;
    }

    .blog-title {
        margin-top: 0px;
        margin-bottom: 0;
        font-size: 60px;
        font-weight: normal;
    }

    .blog-description {
        font-size: 20px;
        color: #999;
    }

    /*
     * Main column and sidebar layout
     */

    .blog-main {
        font-size: 18px;
        line-height: 1.5;
    }

    /* Sidebar modules for boxing content */
    .sidebar-module {
        padding: 15px;
        margin: 0 -15px 15px;
    }

    .sidebar-module-inset {
        padding: 15px;
        background-color: #f5f5f5;
        border-radius: 4px;
    }

    .sidebar-module-inset p:last-child,
    .sidebar-module-inset ul:last-child,
    .sidebar-module-inset ol:last-child {
        margin-bottom: 0;
    }

    /* Pagination */
    .pager {
        margin-bottom: 60px;
        text-align: left;
    }

    .pager > li > a {
        width: 140px;
        padding: 10px 20px;
        text-align: center;
        border-radius: 30px;
    }

    /*
     * Blog posts
     */

    .blog-post {
        margin-bottom: 60px;
    }

    .blog-post-title {
        margin-bottom: 5px;
        font-size: 40px;
    }

    .blog-post-meta {
        margin-bottom: 20px;
        color: #999;
    }

    /*
     * Footer
     */

    .blog-footer {
        padding: 40px 0;
        color: #999;
        text-align: center;
        background-color: #f9f9f9;
        border-top: 1px solid #e5e5e5;
    }

    .blog-footer p:last-child {
        margin-bottom: 0;
    }
</style>

<div class="berita-show">

    <div class="blog-header">
        <h1 class="blog-title">Berita UKM Jombang</h1>
    </div>
    <div class="row">
        <div class="col-sm-8 blog-main">
            <?php foreach ($showBerita as $berita): ?>
                <div class="blog-post">
                    <h2 class="blog-post-title"><?= $berita['title'] ?></h2>
                    <p class="blog-post-meta"><?= $berita['updated_at'] ?></p>
                    <p><?= $berita['text'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>About</h4>
                <p>Berikut ini berita-berita terkait dengan UKM di kabupaten Jombang.</p>
            </div>
            <div class="sidebar-module">
                <h4>Berita Lain</h4>
                <ol class="list-unstyled">
                    <?php foreach ($listBerita as $berita): ?>
                        <li><a href="#"><?= $berita['title'] ?></a></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div><!-- /.blog-sidebar -->
    </div>