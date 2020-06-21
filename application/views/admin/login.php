<form action="/admin/news/index/1" method="post" style="display: flex; flex-direction: column; width: 300px;">
    <label>Login:</label>
    <input type="text" placeholder="login" name="login"><br>
    <label>Password:</label><input type="password" placeholder="password" name="password">
    <br>
    <input type="submit">
    <pre><?php
        if (isset($_SESSION['logged_in'])){
            echo $_SESSION['logged_in'] ;
            unset($_SESSION['logged_in']);
        }else {

        }?></pre>
</form>