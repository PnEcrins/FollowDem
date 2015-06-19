<?php
if(isset($_POST["btConnect"]))
{
	if(isset($_POST["idLogin"]) && isset($_POST["idPwd"]) && !empty($_POST["idLogin"]) && !empty($_POST["idPwd"]))
	{
		if(($_POST["idLogin"]) == "admin" && ($_POST["idPwd"]) == "admin")
		{
			header("Location: ./index.php");
		}
	}
}
?>