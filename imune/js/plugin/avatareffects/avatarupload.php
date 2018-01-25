<?php
//If the POST has the image file and image name
if (isset($_POST['imagefile']) && isset($_POST['imagename']) && "" !== trim($_POST['imagefile']) && "" !== trim($_POST['imagename'])) {
	//If the image is not edited by Avatar Effects then it is only a image url and must be downloaded and saved
	if(filter_var($_POST['imagefile'], FILTER_VALIDATE_URL))
	{
		$imageUrl = $_POST['imagefile'];
		$imageName = $_POST['imagename'];
		$imageName = $imageName.".".pathinfo($imageUrl, PATHINFO_EXTENSION);//set extension for image file

		// Folder where the image will be saved
		$folder = "upload/";

		$ch = curl_init($imageUrl);
		$fp = fopen($folder.$imageName, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		echo $imageName;//Some return info to Ajax
	}
	else//The image was edited by Avatar Effects and is base64 format 
	{
		$imageData=$_POST['imagefile'];
		$imageName=$_POST['imagename'].".png";//Default extension for the image file is .png;

		// Remove the headers (data:,) part.
		$filteredData=substr($imageData, strpos($imageData, ",")+1);

		// Need to decode before saving since the data we received is already base64 encoded
		$unencodedData=base64_decode($filteredData);

		// Folder where the image will be saved
		$folder = "upload/";
	
		// Here you need to ensure that there is no another image with the same name.
		// You can use some unique id in your database (eg the id of a user) or create a 
		// folder with the username of the user who is uploading the image and leave the original filename.
			
		// Save the image
		$fp = fopen($folder.$imageName, "wb");
		fwrite( $fp, $unencodedData);
		fclose( $fp );
		echo $imageName;//Some return info to Ajax
	}
}
else
	echo "Not all parameters have been passed.";//Some return info to Ajax
?>







