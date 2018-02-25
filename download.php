<?php

session_start();

?>

<html>
<head> <title> Download Email </title> </head>

<body>


<a href="<?php echo $_SESSION['file']; ?>" download><button type="button"> Download </button>

</a>
</body>
</html>