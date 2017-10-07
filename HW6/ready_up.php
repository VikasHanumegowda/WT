<html>
    <head>
        <title>
            Homework 6
        </title>
    </head>
    <body>
        <?php if(isset($_POST["Search"])): ?>
            Your text is <?php echo $_POST["STS"];?>
        <?php else: ?>
            <div style="width: 500px; height: auto; background: #C0C0C0;  margin-left: auto; margin-right: auto; padding-left: 2px; padding-right: 2px; border-style: solid; border-width: 1px; border-color: #808080;">
                <div  style="font-size: 40px;text-align: center;">Stock Search</div><hr style="color: #808080;">
                <form method=POST action=<?php echo $_SERVER["PHP_SELF"];?>>
                    <div >
                        <p style="font-size: 20px;display: inline-block;">Enter Stock Ticker Symbol:*</p>
                        <input style="display: inline-block; width: 50%;" type="text" name="STS"><br>
                        <input style="font-size: 20px; margin-left: 245px;margin-right: 10px;" type="submit" name ="Search" value="Search">
                        <input style="font-size: 20px;" type="button" value="Clear" name="Clear">
                    </div>
                </form>
                <p>* - <i>Mandatory fields.</i></p>
            </div>
        <?php endif; ?>


    </body>
</html>