<?php
	$error = "";
	$filename = "";
	$filesize = "";
	$fileloc = "";
	$fileElementName = 'blogpic';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
				
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
      //--------- BEGIN SECOND SCRIPT --------------------------------------------------------------------
      //save master image to temp folder, name it using a temp name
      //resize and save thumb image to 40x40px, name it using the same temp name as master
      
       //define a maxim size for the uploaded images
       define ("MAX_SIZE","1000"); 
       // define the width and height for the thumbnail
       // note that theese dimmensions are considered the maximum dimmension and are not fixed, 
       // because we have to keep the image ratio intact or it will be deformed
       //define ("WIDTH","110"); 
       //define ("HEIGHT","110"); 
	
        // this is the function that will create the thumbnail image from the uploaded image
       // the resize will be done considering the width and height defined, but without deforming the image
       function make_thumb($img_name,$filename,$new_w,$new_h)
       {
        //get image extension.
        $ext=getExtension($img_name);
        //creates the new image using the appropriate function from gd library
        if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
          $src_img=imagecreatefromjpeg($img_name);

          if(!strcmp("png",$ext))
          $src_img=imagecreatefrompng($img_name);

          //gets the dimmensions of the image
        $old_x=imageSX($src_img);
        $old_y=imageSY($src_img);

         // next we will calculate the new dimmensions for the thumbnail image
        // the next steps will be taken: 
        // 	1. calculate the ratio by dividing the old dimmensions with the new ones
        //	2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
        //		and the height will be calculated so the image ratio will not change
        //	3. otherwise we will use the height ratio for the image
        // as a result, only one of the dimmensions will be from the fixed ones
        $ratio1=$old_x/$new_w;
        $ratio2=$old_y/$new_h;
        if($ratio1>$ratio2)	{
          $thumb_w=$new_w;
          $thumb_h=$old_y/$ratio1;
        }
        else	{
          $thumb_h=$new_h;
          $thumb_w=$old_x/$ratio2;
        }

          // we create a new image with the new dimmensions
        $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

        // resize the big image to the new created one
        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

        // output the created image to the file. Now we will have the thumbnail into the file named by $filename
        if(!strcmp("png",$ext))
          imagepng($dst_img,$filename); 
        else
          imagejpeg($dst_img,$filename); 

          //destroys source and destination images. 
        imagedestroy($dst_img); 
        imagedestroy($src_img); 
       }
       
       // This function reads the extension of the file. 
       // It is used to determine if the file is an image by checking the extension. 
       function getExtension($str) {
               $i = strrpos($str,".");
               if (!$i) { return ""; }
               $l = strlen($str) - $i;
               $ext = substr($str,$i+1,$l);
               return $ext;
       }
       
        //reads the name of the file the user submitted for uploading
       $image=$_FILES[$fileElementName]['name'];
       
 	// if it is not empty
 	if ($image) 
 	{
 		// get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES[$fileElementName]['name']);
 		
 		// get the extension of the file in a lower case format
 	 	$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		// if it is not a known extension, we will suppose it is an error, print an error message 
 		//and will not upload the file, otherwise we continue
 		if (($extension != "jpg")  && ($extension != "jpeg") && ($extension != "png"))	
 		{
 			$error .= 'Unknown extension!';
 			$errors=1;
 		}
 		else
 		{
 			// get the size of the image in bytes
 			// $_FILES[\'image\'][\'tmp_name\'] is the temporary filename of the file in which 
			//the uploaded file was stored on the server
 			$size=getimagesize($_FILES[$fileElementName]['tmp_name']);
 			$sizekb=filesize($_FILES[$fileElementName]['tmp_name']);

 			//compare the size with the maxim size we defined and print error if bigger
 			if ($sizekb > MAX_SIZE*1024)
 			{
 				$error .= 'You have exceeded the size limit!';
 				$errors=1;
 			}
 			else {

              //we will give an unique name, for example the time in unix time format
            $image_name=time().'.'.$extension;
            //the new name will be containing the full path where will be stored (images folder)
            $newname="../../images/blog-pics/masters/".$image_name;
            $copied = copy($_FILES[$fileElementName]['tmp_name'], $newname);
            //we verify if the image has been uploaded, and print error instead
            if (!$copied) 
            {
              $error .= 'Copy unsuccessfull!';
              $errors=1;
            }
            else
            {
              // the new thumbnail image will be placed in images/thumbs/ folder
              $thumb_name='../../images/blog-pics/thumbs/thumb_'.$image_name;
              // call the function that will create the thumbnail. The function will get as parameters 
              //the image name, the thumbnail name and the width and height desired for the thumbnail
              $thumb=make_thumb($newname,$thumb_name,40,40);
              
              //also add the users pic
              $thumb_name='../../images/user-pics/thumbs/thumb_'.$image_name;
              $thumb=make_thumb($newname,$thumb_name,110,110);
              
            }}
        }
 			}
 			
      
      //--------- END SECOND SCRIPT --------------------------------------------------------------------

      //return variables to javascript
			$filename = $_FILES[$fileElementName]['name'];
			$filesize = round(($sizekb/1000), 0);
			$fileloc = $thumb_name;
			//for security reason, we force to remove all uploaded file
			@unlink($_FILES[$fileElementName]);
	}		
	$return_JSON = "";
	$return_JSON .= "{";
	$return_JSON .=				"error: '" . $error . "',\n";
	$return_JSON .=				"name: '" . $filename . "',\n";
	$return_JSON .=				"size: '" . $filesize . "',\n";
	$return_JSON .=				"loc: '" . $fileloc . "'\n";
	$return_JSON .= "}";
	echo $return_JSON;
?>