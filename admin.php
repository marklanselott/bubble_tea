<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Панель адміністратора</title>
    <link rel="stylesheet" href="asset/base.css">
    <link rel="stylesheet" href="asset/forms.css">
</head>
<body>
    <div class="sidebar">
        <ul>
            <?php include 'components/view/section_list.php'; ?>
        </ul>
    </div>
    <div class="main">
        <?php include 'components/header.php'; ?>
        <div class="content"><?php include 'router.php'; ?></div>
    </div>
</body>
</html>
