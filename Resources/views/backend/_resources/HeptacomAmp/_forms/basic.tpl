<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{link file="backend/_resources/HeptacomAmp/css/bootstrap.min.css"}" />
    <link rel="stylesheet" href="{link file="backend/_resources/HeptacomAmp/css/bootstrap-theme.min.css"}" />
    <link rel="stylesheet" href="{link file="backend/_resources/HeptacomAmp/css/heptacom-dialog-box.css"}" />
    {block name="head"}{/block}
</head>
<body>
{block name="content/main"}
    <div class="heptacom-dialog-box">
        <div class="heptacom-dialog-box-header">
            {block name="content/main/header"}{/block}
        </div>
        <div class="heptacom-dialog-box-content">
            {block name="content/main/content"}{/block}
        </div>
        <div class="heptacom-dialog-box-footer">
            {block name="content/main/footer"}{/block}
        </div>
    </div>
{/block}
{block name="content/javascript"}
    <script type="text/javascript" src="{link file="backend/base/frame/postmessage-api.js"}"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/jquery-2.1.4.min.js"}"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/bootstrap.min.js"}"></script>
{/block}
<script type="text/javascript">
    $(function() {
        {block name="content/layout/javascript"}{/block}
    });
</script>
</body>
</html>