<?php
global $product;
function ta_get_reply_comment($ParentComentID)
{
    $args = [
        'parent' => $ParentComentID,
        'status' => 'approve',
        'order' => 'ASC',
    ];
    return get_comments($args);
}
?>
<?php
$paged = (get_query_var('cpage')) ? absint(get_query_var('cpage')) : 1;
$getCommentsPerPage = get_option('comments_per_page');
if (intval($getCommentsPerPage)) {
    $comments_per_page = $getCommentsPerPage;
} else {
    $comments_per_page = 3;
}
$offset = ($paged - 1) * $comments_per_page;
$totalComments = $product->get_review_count();
$totalPages = ceil($totalComments / $comments_per_page);
$order = 'ASC';
$close_comments_days_old = get_option('comment_order');
if ($close_comments_days_old == 'desc') {
    $order = 'DESC';
}


$args = [
    'post_id' => $product->get_id(),
    'status' => 'approve',
    'order' => $order,
    'parent' => 0,
    'number' => $comments_per_page,
    'offset' => $offset,
];
$comments = get_comments($args);
?>
<?php
function get_comments_author_ID($email)
{
    $user = get_user_by_email($email);
    return $user->ID;
}
?>
<?php $Can_reply = false;
if (is_user_logged_in()) {
    if (current_user_can('moderate_comments')) {
        $Can_reply = true;
    } elseif (comments_open() && get_option('thread_comments')) {
        $Can_reply = true;
    }
}

?>
<div class="container grid grid-cols-1 lg:grid-cols-5 font-sansFanumRegular mt-6 lg:mt-9  rounded-xl ">
    <!--    comments-->
    <?php if ($comments): ?>
        <div class="col-span-4 bg-white px-5 py-5 lg:py-7 rounded-xl shadow-md">

            <div class="mb-5  font-sansFanumBold">نظرات کاربران</div>

            <?php
            $size = 36;
            $template_uri = get_template_directory_uri();

            function idealboresh_get_avatar_url_by_role($comment, $template_uri)
            {
                // مسیر پیش‌فرض مشتری/مهمان
                $url = $template_uri . '/assets/img/avatar_placeholder.svg';

                if (!empty($comment->user_id)) {
                    $user = get_user_by('id', $comment->user_id);
                    if ($user) {
                        $roles = (array) $user->roles;
                        // اگر نقش غیر از customer بود → admin.svg
                        if (array_intersect($roles, ['administrator', 'shop_manager', 'editor', 'author', 'contributor'])) {
                            $url = $template_uri . '/assets/img/admin.svg';
                        }
                    }
                }

                return $url;
            }
            ?>

            <div class="space-y-6">
                <?php foreach ($comments as $comment):
                    $avatar_url = idealboresh_get_avatar_url_by_role($comment, $template_uri);
                    ?>
                    <div id="<?php echo esc_attr($comment->comment_ID); ?>" class="comment_item pb-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-x-2">
                                <div class="w-9 h-9 rounded-full avatar_author overflow-hidden">
                                    <img src="<?php echo esc_url($avatar_url); ?>" width="<?php echo esc_attr($size); ?>"
                                        height="<?php echo esc_attr($size); ?>"
                                        alt="<?php echo esc_attr($comment->comment_author); ?>" decoding="async">
                                </div>
                                <div class="text-zinc-500"><?php echo esc_html($comment->comment_author); ?></div>
                            </div>
                            <div class="flex flex-col items-center lg:flex-row-reverse gap-x-4">
                                <p>
                                    <?php
                                    $date = new DateTime($comment->comment_date_gmt);
                                    echo esc_html(gregorian_to_jalali(
                                        $date->format('Y'),
                                        $date->format('m'),
                                        $date->format('d'),
                                        '/'
                                    ));
                                    ?>
                                </p>
                                <?php if ($Can_reply): ?>
                                    <div class="Reply_comment text-zinc-500 flex items-center mt-2 cursor-pointer">
                                        <svg class="w-6 h-6">
                                            <use href="#arrow-turn-down-left"></use>
                                        </svg>
                                        <p class="text-[12px]">پاسخ</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <p class="text-[14px] lg:w-3/4 mt-4 text-neutral-800 comment__content">
                            <?php echo esc_html($comment->comment_content); ?>
                        </p>

                        <?php if ($comment->comment_parent == 0): ?>
                            <?php $reply_comments = ta_get_reply_comment($comment->comment_ID); ?>
                            <?php if (!empty($reply_comments)): ?>
                                <?php foreach ($reply_comments as $reply_comment):
                                    $reply_avatar_url = idealboresh_get_avatar_url_by_role($reply_comment, $template_uri);
                                    ?>
                                    <div class="pb-6 pr-[24px] mt-8">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-x-2">
                                                <div class="w-9 h-9 rounded-full avatar_author overflow-hidden">
                                                    <img src="<?php echo esc_url($reply_avatar_url); ?>"
                                                        width="<?php echo esc_attr($size); ?>" height="<?php echo esc_attr($size); ?>"
                                                        alt="<?php echo esc_attr($reply_comment->comment_author); ?>" decoding="async">
                                                </div>
                                                <div class="text-zinc-500"><?php echo esc_html($reply_comment->comment_author); ?></div>
                                            </div>
                                        </div>
                                        <p class="text-[14px] lg:w-3/4 mt-[6px] text-neutral-800">
                                            <?php echo esc_html($reply_comment->comment_content); ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>


            <?php if ($totalPages > 1) {
                ?>
                <div id="ideal_paginate_comment_single" class="flex justify-center font-sansFanumRegular py-2"
                    style="overflow-x: auto"><?php
                    echo paginate_links([
                        'base' => get_permalink() . '%_%',
                        'format' => '?cpage=%#%',
                        'current' => $paged,
                        'total' => $totalPages,
                        'type' => 'list',
                        'end_size' => 1,
                        'mid_size' => 1,
                        'next_text' => '<svg class="w-5 h-5"><use href="#chevronLeft"></use></svg>',
                        'prev_button' => false,
                    ]); ?></div> <?php
            } ?>
        </div>
    <?php endif; ?>


    <!--    Add comment-->
    <div id="reviews" class="col-span-4  px-5 py-5 lg:py-7 rounded-xl">
        <?php if (comments_open()): ?>
            <div>
                <div class="flex flex-col gap-x-1">
                    <svg class="w-5 h-5 lg:w-5 lg:h-5">
                        <use href="#chat"></use>
                    </svg>
                    <div class="font-sansFanumBold">ثبت نظر</div>

                    <?php if (isset($_GET['comment_status']) && $_GET['comment_status'] == 'waiting' && !can_current_user_approve_comments()): ?>
                        <p class="message__status__comment bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-4">دیدگاه شما ثبت شد و
                            پس از تأیید مدیر نمایش داده خواهد شد.</p>
                    <?php endif; ?>



                    <div id="Reply__alert" class="mt-4 hidden self-start" style="scroll-margin-top: 350px;">
                        <p>در حال پاسخ دادن به : </p>
                        <p id="Reply__alert__message" class=" bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-2"></p>
                    </div>

                </div>

                <?php if (!is_user_logged_in() && get_option('comment_registration')): ?>
                    <p class=" bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-2">برای ثبت نظر ابتدا وارد شوید.</p>
                <?php elseif (!is_user_logged_in() && !get_option('comment_registration')): ?>
                    <form action="<?php echo site_url() . '/wp-comments-post.php' ?>" method="post"
                        class="space-y-2 lg:space-y-3 mt-5 flex flex-col">
                        <input id="author" name="author" type="text" value="" size="30" maxlength="245"
                            placeholder="نام و نام خانوادگی" autocomplete="name" required="required"
                            class="p-3 rounded-xl outline-0 w-full lg:w-2/4">
                        <input id="email" name="email" type="text" value="" size="30" maxlength="100" placeholder="ایمیل"
                            aria-describedby="email-notes" autocomplete="email" required="required"
                            class="p-3 rounded-xl outline-0 w-full lg:w-2/4">
                        <textarea name="comment" id="comment" placeholder="توضیحات"
                            class="p-3 rounded-xl outline-0 w-full lg:w-2/4 h-[180px]  border-2" required></textarea>
                        <input type="submit" name="submit" id="submit"
                            class="cursor-pointer bg-[#35394C] text-white py-3 px-12 rounded-xl w-fit" value="ثبت نظر">
                        <input type="hidden" name="comment_post_ID" value="<?php echo $product->get_id() ?>"
                            id="comment_post_ID">
                        <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                        <?php
                        if (is_user_logged_in()): ?>
                            <input type="hidden" name="_wp_unfiltered_html_comment" id="_wp_unfiltered_html_comment_disabled"
                                value="<?php echo wp_create_nonce() ?>">
                        <?php endif;
                        ?>

                    </form>
                <?php elseif (is_user_logged_in()): ?>
                    <form action="<?php echo site_url() . '/wp-comments-post.php' ?>" method="post"
                        class="space-y-2 lg:space-y-3 mt-5 flex flex-col">


                        <!--                <input type="text" name="author" placeholder="نام و نام خانوادگی" class="p-3 rounded-xl outline-0 w-full lg:w-2/4">-->
                        <!---->
                        <!--                <input type="text" name="email" placeholder="ایمیل" class="p-3 rounded-xl outline-0 w-full lg:w-2/4">-->

                        <textarea name="comment" id="comment" placeholder="توضیحات"
                            class="p-3 rounded-xl outline-0 w-full lg:w-2/4 h-[180px]  border-2" required></textarea>

                        <input name="submit" type="submit" id="submit"
                            class="cursor-pointer bg-[#35394C] text-white py-3 px-12 rounded-xl w-fit" value="ثبت نظر">
                        <input type="hidden" name="comment_post_ID" value="<?php echo $product->get_id() ?>"
                            id="comment_post_ID">
                        <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                        <?php
                        if (is_user_logged_in()): ?>
                            <input type="hidden" name="_wp_unfiltered_html_comment" id="_wp_unfiltered_html_comment_disabled"
                                value="<?php echo wp_create_nonce() ?>">
                        <?php endif;
                        ?>

                    </form>
                <?php endif; ?>
            </div>

        <?php elseif (current_user_can('moderate_comments')): ?>
            <div>

                <div class="flex flex-col gap-x-1">

                    <svg class="w-5 h-5 lg:w-5 lg:h-5">
                        <use href="#chat"></use>
                    </svg>

                    <div class="font-sansFanumBold">ثبت نظر</div>

                    <?php if (isset($_GET['comment_status']) && $_GET['comment_status'] == 'waiting' && !can_current_user_approve_comments()): ?>
                        <p class="message__status__comment bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-4">دیدگاه شما ثبت شد و
                            پس از تأیید مدیر نمایش داده خواهد شد.</p>
                    <?php endif; ?>



                    <div id="Reply__alert" class="mt-4 hidden self-start" style="scroll-margin-top: 350px;">
                        <p>در حال پاسخ دادن به : </p>
                        <p id="Reply__alert__message" class=" bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-2"></p>
                    </div>

                </div>


                <form action="<?php echo site_url() . '/wp-comments-post.php' ?>" method="post"
                    class="space-y-2 lg:space-y-3 mt-5 flex flex-col">


                    <!--                <input type="text" name="author" placeholder="نام و نام خانوادگی" class="p-3 rounded-xl outline-0 w-full lg:w-2/4">-->
                    <!---->
                    <!--                <input type="text" name="email" placeholder="ایمیل" class="p-3 rounded-xl outline-0 w-full lg:w-2/4">-->

                    <textarea name="comment" id="comment" placeholder="توضیحات"
                        class="p-3 rounded-xl outline-0 w-full lg:w-2/4 h-[180px]  border-2" required></textarea>

                    <input name="submit" type="submit" id="submit"
                        class="cursor-pointer bg-[#35394C] text-white py-3 px-12 rounded-xl w-fit" value="ثبت نظر">
                    <input type="hidden" name="comment_post_ID" value="<?php echo $product->get_id() ?>"
                        id="comment_post_ID">
                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                    <?php
                    if (is_user_logged_in()): ?>
                        <input type="hidden" name="_wp_unfiltered_html_comment" id="_wp_unfiltered_html_comment_disabled"
                            value="<?php echo wp_create_nonce() ?>">
                    <?php endif;
                    ?>

                </form>

            </div>
        <?php else: ?>
            <p class=" bg-[#F2F5FF] text-mainBlue p-2 rounded-xl mt-2">امکان ارسال دیدگاه وجود ندارد.</p>
        <?php endif; ?>

    </div>




</div>