<?php

?>

<section id="login">

    <h2>Use as</h2>

    <div class="responseFromDb">
        <? if ($responseFromDb["error"]){ ?>
            <div class="error"><? echo $responseFromDb["error"] ?></div>
        <? } ?>

        <? if ($responseFromDb["succes"]){ ?>
            <div class="succes">
                Вы вошли на сайт, <a href="index.php?r=login">вернуться на главную</a>
            </div>
        <? } ?>
    </div>

    <form action="" method="post" enctype="multipart/form-data" name="myForm" target="_self">
        <input type="hidden" name="method_name" value="login">

        <input type="text" name="login" value="" placeholder="login"/><br><br>
        <input type="password" name="pass" value="" placeholder="password"/><br><br>

        <input name="submit" type="submit" value="register now"/>
    </form>
</section>
