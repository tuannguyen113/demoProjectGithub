<html>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <input type="text" name="name">
    <input type="text" name="email">
    <input type="submit" name="submit" value="submitpost">
</form><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
    <input type="text" name="tel">
    <input type="text" name="address">
    <input type="submit"name="submit" value="sunmitGet">
</form>
</html>