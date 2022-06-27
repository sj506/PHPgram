<!DOCTYPE html>
<html lang="en">
<?php include_once 'application/views/template/head.php'; ?>
<body class="h-full container-center">
    <div>
        <?php if (isset($_GET['email'])) {
            print '로그인을 할 수 없습니다';
        } ?>
        <h1>로그인</h1>
        <form action="signin" method="post">
            <div><input type="email" name="email" placeholder="email" 
            value = "<?= getParam('email') ?>"
            autofocus required></div>
            <div><input type="password" name="pw" placeholder="password" required></div>
            <div>
                <input type="submit" value="로그인">
            </div>
        </form>
        <div>
            <a href="signup">회원가입</a>
        </div>
    </div>
</body>
</html>