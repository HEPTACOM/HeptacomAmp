{namespace name="frontend/detail/comment"}

{* Review title *}
{block name='frontend_detail_comment_post_title'}
    <a href="{url sArticle=$sArticle.articleID title=$sArticle.articleName controller='detail'}" id="product--publish-comment" class="btn is--primary is--large">
        {s name="DetailCommentHeaderWriteReview"}{/s}
    </a>
{/block}
