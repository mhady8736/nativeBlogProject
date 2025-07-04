<?php

require_once('header.php');
require_once('../../classes.php');
$usre = unserialize($_SESSION["user"]);
$homePosts = $user->home_posts();
?>

<main>

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light ">Welcome <?= $user->name ?></h1>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-body-tertiary"></div>
    <div class="container">
        <div class="row">
            <?php
            foreach ($homePosts as $post) {
                // var_dump($post);
            ?>


            <div class="col-6 offset-3 bg-light mt-5 rounded-2">
                <div class="d-flex justify-ontent-between p-3">
                    <div class="d-flex flex-row align-items-center">
                        <img style="width: 50px; height: 50px; border-radius: 50px;"
                            src="<?php if (!empty($comment["image"])) echo $comment["image"];
                                                                        else echo 'http://bootdey.com/img/Content/avatar/avatar7.png' ?>" alt="">
                        <div class=" ms-2 c-details">
                            <h6 class="mb-0"><?= $post["name"] ?></h6><span><?= $post["created_at"] ?></span>
                        </div>
                    </div>
                    <div class="badge"> <span></span></div>
                </div>




                <div class="card">
                    <?php
                        if (!empty($post["image"])) {
                        ?>
                    <img class="card-img-top" src="<?= $post["image"] ?>" alt="Title" />

                    <?php
                        }
                        ?>
                    <div class="card-body">
                        <h4 class="card-title"><?= $post["title"] ?></h4>
                        <p class="card-text"><?= $post["content"] ?></p>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                <div class="card-body p-4">
                                    <form action="stor_comment.php" method="post">
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" name="comment" id="addANote" class="form-control"
                                                placeholder="Type comment..." />
                                            <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
                                            <button type="submit" class="btn btn-primary mt-2 ms-2">+ Add a
                                                note</button>

                                        </div>
                                    </form>

                                    <?php

                                        $comments = $user->get_post_comment($post["id"]);

                                        foreach ($comments as $comment) {
                                        ?>
                                    <div class=" card mb-4">
                                        <div class="card-body">
                                            <p><?= $comment["comment"] ?></p>


                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <img src="<?php if (!empty($comment["image"])) echo $comment["image"];
                                                                        else echo 'http://bootdey.com/img/Content/avatar/avatar7.png' ?>
                                                            alt=" avatar width="25" height="25" />
                                                    <p class="small mb-0 ms-2">
                                                        <?= $comment["name"] ?></p>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <p class="small text-muted mb-0"><?= $comment["created_at"] ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                        }
                                        ?>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>



        </div>
    </div>
    </div>
</main>



<?php

require_once('footer.php');

?>