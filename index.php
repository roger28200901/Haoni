<?php
include('connect.php');
$_SESSION['step'] = 0;
$_SESSION['reset'] = true;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/widgets.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/scripts.js"></script>
<script>
sessionStorage.clear();
</script>
    <title>河內塔</title>
</head>

<body>
    <div id="container-game" style="width:620px !important">
        <div class="row">
            <div class="layout">
                <h2>河內塔</h2>
                <fieldset id="rule">
                    <legend>遊戲規則</legend>
                    <div>有三根竿子，例如由右至左編號分別為1、2和3，竿子上面可串中空圓盤。<br/>於竿子1放入N個盤子開始，盤子由下至上變小。 一次只能移動一個盤子。<br/>大盤子不能再小盤子上面。<br/>目標將全部盤子移動到竿子3。
                    </div>
                </fieldset>
                <div class="game" style="margin-top:10px">
                    <form action="game.php" method="POST">
                        <div class="row">
                            <label for="nickname">暱稱</label>
                            <input type="text" id="nickname" name="nickname" required/>
                        </div>
                        <div class="row">
                            <label for="difficulty">難易度</label>
                            <select id="difficulty" name="difficulty">
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                            
                        </div>
                        <button type="submit" style="margin-left:113px">開始遊戲</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>