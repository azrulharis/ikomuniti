<?php
include('upload_class.php');
include('imageresizer.class.php');

	if(isset($_REQUEST['Action']) && $_REQUEST['Action'] == 'UploadNew')
	{
		$UF_obj = new Upload();
		$UF_obj -> File			=	$_FILES['Comic'];
		$UF_obj -> SavePath		=	'pictures/'; 	// PLACE where you want to save images.
		$UF_obj -> ThumbPath	=	'pictures/thumb/'; //if not specify will not create thumbnil
		$UF_obj -> NewName		=	$_FILES['Comic']['name'];
		
		//width and height of large image which will save in "pictures/" folder
		$UF_obj -> NewWidth		= 600;
		$UF_obj -> NewHeight	= 600;	
		////width and height of thumb image which will save in "pictures/thumb/" folder
		$UF_obj -> TWidth		= 100;
		$UF_obj -> THeight		= 100;

		/* 		
		*		if you want to name image something other then upload image name then use bellow formate
		* 		for example you upload two images then
		*
		* $UF_obj -> NewName	=	array('NewName1.jpg', 'NewName2.jpg');
		*/
		
		$UF_obj -> NameCase		=	'lower'; //default no change. upper for upper case
		$UF_obj -> OverWrite	=	true; //default = true. replace existing image
		
		//UploadFile() function upload and resize image.
		//function return error message if any.
		//error variable is in array form. so you can get more then one error/warning messages.
		// or you can also access error message by class object varialbe like $UF_obj -> Error
		$Error = $UF_obj -> UploadFile();
		print_r($Error);
		if(count($Error) > 0 and is_array($Error))
		{
			foreach($Error as $key=>$val)
			{
				echo $val . '<br>';
			}
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form action="" target="_self" method="post" enctype="multipart/form-data">
  <table border="0" cellpadding="4" cellspacing="0" width="100%">
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td> First Image: </td>
      <td><input type="file" name="Comic[]" id="Comic" />      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td> Second Image: </td>
      <td><input type="file" name="Comic[]" id="Comic" />      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="hidden" name="Action" value="UploadNew" />
          <input type="submit" name="submit" value="Upload" />      </td>
    </tr>
  </table>
</form>
</body>
</html>
