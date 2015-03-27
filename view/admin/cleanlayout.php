<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
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

<div class="container-fluid">
    <div>
        <?php echo $content ?>
    </div>
</div>
</body>
</html>