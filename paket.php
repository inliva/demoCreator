<?php

$menu = '';
$i = 0;
$dizin = opendir('resim');

	while($dosya = readdir($dizin)) {
		//$indexno = explode('.', $dosya);
		if($dosya != '.' && $dosya != '..' && $dosya != '.DS_Store'){
			$indexno = $i == 0 ? '' : $i;
		   	$menu .= "<div class='thumb'><a href='index{$indexno}.html'><img src='resim/{$dosya}' width='60' height='60' /></a></div>";
		   	$i++;
	   }
	}
	
	$i = 0;
	$dizin = opendir('resim');
	while($dosya = readdir($dizin)) {

		$indexno = $i == 0 ? '' : $i;
		if($dosya != '.' && $dosya != '..' && $dosya != '.DS_Store'){
			
		$sablon =  "
			
			<!DOCTYPE html>
			<html>
			<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>demo</title>
			<style type='text/css'>
				body		{margin:0; padding:0;  background:url(resim/{$dosya}) no-repeat; !important; background-size:1920px; background-position:top center; height:1420px;}
				#wrap		{position:absolute; top:30px; right:10px; width:60px;}
				.thumb		{width:60px; height:60px; float:left; margin:5px 0 0 0; float:left;}
				.thumb img	{width:60px;height:60px;  margin:5px 0 0 0;}
				img {border: none} 
			</style>
			</head>
			<body>
				<div id='wrap'>
					{$menu}
				</div>
			</body>
			</html>


        ";
      
		 $i++;

		 $olustur = fopen('index'.$indexno.'.html', 'w');

		fwrite($olustur, $sablon);
		fclose($olustur);
	   }

	}


	   	$zipAdi = "indir.zip";
		$resimDosyasi = "resim";

		$zip = new ZipArchive; 
		if ($zip -> open($zipAdi, ZipArchive::CREATE) === TRUE) 
		{ 
		    $dir = preg_replace('/[\/]{2,}/', '/', $resimDosyasi."/"); 
		    
		    $dirs = array($dir); 
		    while (count($dirs)) 
		    { 
		        $dir = current($dirs); 
		        $zip -> addEmptyDir($dir); 
		        
		        $dh = opendir($dir); 
		        while($dosya = readdir($dh)) 
		        { 
		        	
		            if ($dosya != '.' && $dosya != '..' && $dosya != '.DS_Store') 
		            { 
		            	echo "erdi";
		                if (is_file($dosya)) 
		                    $zip -> addFile($dir.$dosya, $dir.$dosya); 
		                elseif (is_dir($dosya)) 
		                    $dirs[] = $dir.$dosya."/"; 
		            } 
		        } 
		        closedir($dh); 
		        array_shift($dirs); 
		    } 


		    
		    $zip -> close(); 
		    echo 'zip başarıyla oluşturuldu!'; 
		} 
		else 
		{ 
		    echo 'zip dosyası oluşturulurken hata oluştu'; 
		} 


  //       $resimAdi = $_FILES['file']['name'];
  //       $uzanti = explode('.', $resimAdi);

  //       $olustur = fopen('tmp/'.$uzanti[0].'.html', 'w');


  //       $menuSablon = "<div class='thumb'><a href='$uzanti[0].'.html'.'><img src='resim/$resimAdi' width='60' height='60' /></a></div>";

        

		// fwrite($olustur, $sablon);
		// fclose($olustur);