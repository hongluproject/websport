<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>呼朋后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>

    <script src="/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.autocomplete.min.js" type="text/javascript"></script>
    <script src="/assets/js/admin.js" type="text/javascript"></script>
    <script src="/assets/js/ajaxfileupload.js" type="text/javascript"></script>

    <script type="text/javascript">
        var data = <?php echo $data instanceof \Model\Core ? json_encode($data->to_array()) : '{}'; ?>;
        var validate = <?php echo $validate ? preg_replace('/":"\\\\(.*?)\\\\\/"/i', '":$1/', json_encode($validate)) : '{}'; ?>;
    </script>

</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/admin">Hoopeng平台</a>

            <div class="nav-collapse">

                <?php if ($user && $nav): ?>
                <ul class="nav">
                    <?php foreach ($nav as $_i => $item): ?>
                    <li class="<?php echo $path[0] == $_i ? 'active' : ''; ?>">
                        <a href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <p class="navbar-text pull-right">
                    <?php if ($user): ?>
                    使用 <a href="#"><?php echo  $user->data['username']; ?></a> 登陆，<a href="/admin/session/logout">注销</a>
                    <?php else: ?>
                    <a href="/admin/session/login">登陆</a>
                    <?php endif; ?>
                </p>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <?php if ($sidebar): ?>
        <div class="span2">
            <?php echo $sidebar ?>
        </div>
        <?php endif; ?>
        <div class="<?php echo $sidebar ? 'span10' : 'span12'; ?>">
            <?php echo $content ?>
        </div>
    </div>

    <hr>
    <footer>
        <p style="text-align: center">&copy; 2014 Hoopeng</p>
    </footer>
</div>
</body>
</html>