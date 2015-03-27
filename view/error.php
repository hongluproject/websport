<style type="text/css">
    .system_error {
        border: 1px solid #990000;
        padding: 10px 20px;
        margin: 10px;
        font: 13px/1.4em verdana;
        background: #fff;
    }

    code.source {
        white-space: pre;
        background: #fff;
        padding: 1em;
        display: block;
        margin: 1em 0;
        border: 1px solid #bedbeb;
    }

    .system_error .box {
        margin: 1em 0;
        background: #ebf2fa;
        padding: 10px;
        border: 1px solid #bedbeb;
    }

    .code.source em {
        background: #ffc;
    }
</style>

<div class="system_error">

    <h2 style="color: #990000">提示</h2><br/>
    <h4><?php echo $error; ?></h4>

    <?php if ($url !== false): ?>
    <p>正在跳转，不想等待请点击 <a href="<?php echo $url ? $url : 'javascript:history.back();'; ?>">返回</a>...</p>
    <?php endif; ?>
</div>