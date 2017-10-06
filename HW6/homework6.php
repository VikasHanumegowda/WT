<html>
    <head>
        <title>
            Homework 6
        </title>
    </head>
    <body>
        <?php if(isset($_POST["Search"])): ?>
        <?php else: ?>
            <div style="width: 500px; height: auto; background: #C0C0C0;  margin-left: auto; margin-right: auto; padding-left: 2px; padding-right: 2px;">
                <div class="center" style="font-size: 40px;text-align: center;">Stock Search</div><hr>
                <div style="font-size: 20px;">Enter Stock Ticker Symbol:*</div>
            </div>
        <?php endif; ?>


    </body>
</html>