<!--500错误-->
{extend name="public/base" /}
{block name='content'}
{include file='public/content_header' /}
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 哎呀！页面出问题了。</h3>
            <p>
                当前页面出现了一点点问题。
                同时，您可以<br/>  <br/> <a class="btn btn-success BackButton">返回上一页</a> 或者 <a class="btn btn-primary" href="{{route('admin.index.index')}}">去首页</a>
            </p>
        </div>
    </div>
</section>
{/block}