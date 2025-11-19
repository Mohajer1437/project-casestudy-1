<?php

namespace IdealBoresh\Presentation\Comments;

use Walker_Comment;

class IdealCommentWalker extends Walker_Comment
{
    protected function html5_comment($comment, $depth, $args): void
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        $commentId = 'comment-' . $comment->comment_ID;
        $classes = implode(' ', get_comment_class('', $comment));

        echo '<' . $tag . ' id="' . esc_attr($commentId) . '" class="' . esc_attr($classes) . '">';
        echo '<article id="div-' . esc_attr($commentId) . '" class="comment-body">';
        echo '<footer class="comment-meta">';
        echo '<div class="comment-author vcard">';
        echo get_avatar($comment, 48);
        printf('<b class="fn">%s</b>', esc_html(get_comment_author($comment)));
        echo '</div>';
        echo '<div class="comment-metadata">';
        printf('<time datetime="%s">%s</time>', esc_attr(get_comment_time('c')), esc_html(get_comment_date('', $comment)));
        echo '</div>';
        echo '</footer>';

        echo '<div class="comment-content">';
        comment_text($comment);
        echo '</div>';

        comment_reply_link(array_merge($args, [
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="reply">',
            'after'     => '</div>',
        ]));

        echo '</article>';
        echo '</' . $tag . '>';
    }
}
