<?php
	/** 
		file: image.class.php ����ΪImage
		ͼ�����࣬������ɶԸ������͵�ͼ��������š���ͼƬˮӡ�ͼ��õĲ�����
	*/
	class Image {
		/* ͼƬ�����·�� */
		private $path;   				

		/**
		 * ʵ��ͼ�����ʱ����ͼ���һ��·����Ĭ��ֵ�ǵ�ǰĿ¼
		 * @param	string	$path	����ָ������ͼƬ��·��
		 */
		function __construct($path="./"){
			$this->path = rtrim($path,"/")."/";
		}
		
		/**
		 * ��ָ����ͼ���������
		 * @param	string	$name	����Ҫ�����ͼƬ����
		 * @param	int	$width		���ź�Ŀ��
		 * @param	int	$height		���ź�ĸ߶�
		 * @param	string	$qz		����ͼƬ��ǰ׺
		 * @return	mixed			�����ź��ͼƬ����,ʧ�ܷ���false;
		 */
		function thumb($name, $width, $height,$qz="th_"){
			/* ��ȡͼƬ��ȡ��߶ȡ���������Ϣ */
			$imgInfo = $this->getInfo($name);                                 
			/* ��ȡ����ͼƬ����Դ  */
			$srcImg = $this->getImg($name, $imgInfo);                          
			/* ��ȡ��ͼƬ�ߴ� */
			$size = $this->getNewSize($name,$width, $height,$imgInfo);       
			/* ��ȡ�µ�ͼƬ��Դ */
			$newImg = $this->kidOfImage($srcImg, $size,$imgInfo);   
			/* ͨ�������˽�з�������������ͼ������������ͼ�����ƣ���"th_"Ϊǰ׺ */
			return $this->createNewImage($newImg, $qz.$name,$imgInfo);    
		}
		
		/** 
		* ΪͼƬ���ˮӡ
		* @param	string	$groundName	����ͼƬ������Ҫ��ˮӡ��ͼƬ����ֻ֧��GIF,JPG,PNG��ʽ 
		* @param	string	$waterName	ͼƬˮӡ������Ϊˮӡ��ͼƬ����ֻ֧��GIF,JPG,PNG��ʽ
		* @param	int	$waterPos		ˮӡλ�ã���10��״̬��0Ϊ���λ�ã� 
		* 								1Ϊ���˾���2Ϊ���˾��У�3Ϊ���˾��ң� 
		* 								4Ϊ�в�����5Ϊ�в����У�6Ϊ�в����ң� 
		*								7Ϊ�׶˾���8Ϊ�׶˾��У�9Ϊ�׶˾��ң� 
		* @param	string	$qz			��ˮӡ���ͼƬ���ļ�����ԭ�ļ���ǰ��������ǰ׺
		* @return	mixed				������ˮӡ���ͼƬ����,ʧ�ܷ���false
		*/ 
		function waterMark($groundName, $waterName, $waterPos=0, $qz="wa_"){
			/*��ȡˮӡͼƬ�ǵ�ǰ·��������ָ����·��*/
			$curpath = rtrim($this->path,"/")."/";
			$dir = dirname($waterName);
			if($dir == "."){
				$wpath = $curpath;
			}else{
				$wpath = $dir."/";
				$waterName = basename($waterName);
			}
			
			/*ˮӡͼƬ�ͱ���ͼƬ���붼Ҫ����*/
			if(file_exists($curpath.$groundName) && file_exists($wpath.$waterName)){
				$groundInfo = $this->getInfo($groundName);         		 //��ȡ������Ϣ
				$waterInfo = $this->getInfo($waterName, $dir);    		 //��ȡˮӡͼƬ��Ϣ
				/*���������ˮӡͼƬ��С���ͻᱻˮӡȫ����ס*/
				if(!$pos = $this->position($groundInfo, $waterInfo, $waterPos)){
					echo 'ˮӡ��Ӧ�ñȱ���ͼƬС��';
					return false;
				}

				$groundImg = $this->getImg($groundName, $groundInfo);    //��ȡ����ͼ����Դ
				$waterImg = $this->getImg($waterName, $waterInfo, $dir); //��ȡˮӡͼƬ��Դ	
				
				/* ����˽�з�����ˮӡͼ��ָ��λ�ø��Ƶ�����ͼƬ�� */
				$groundImg = $this->copyImage($groundImg, $waterImg, $pos, $waterInfo); 
				/* ͨ�������˽�з����������ˮͼƬ��������ͼƬ�����ƣ�Ĭ����"wa_"Ϊǰ׺ */
				return $this->createNewImage($groundImg, $qz.$groundName, $groundInfo);
				
			}else{
				echo 'ͼƬ��ˮӡͼƬ�����ڣ�';
				return false;
			}
		}
		
		/**
		* ��һ����ı���ͼƬ�м��ó�ָ�������ͼƬ
		* @param	string	$name	��Ҫ���еı���ͼƬ
		* @param	int	$x			����ͼƬ��߿�ʼ��λ��
		* @param	int	$y			����ͼƬ������ʼ��λ��
		* @param	int	$width		ͼƬ���õĿ��
		* @param	int	$height		ͼƬ���õĸ߶�
		* @param	string	$qz		��ͼƬ������ǰ׺
		* @return	mixed			�ü����ͼƬ����,ʧ�ܷ���false;
		*/
		function cut($name, $x, $y, $width, $height, $qz="cu_"){
			$imgInfo=$this->getInfo($name);                 //��ȡͼƬ��Ϣ
			/* �ü���λ�ò��ܳ�������ͼƬ��Χ */
			if( (($x+$width) > $imgInfo['width']) || (($y+$height) > $imgInfo['height'])){
				echo "�ü���λ�ó����˱���ͼƬ��Χ!";
				return false;
			}
			
			$back = $this->getImg($name, $imgInfo);         //��ȡͼƬ��Դ      
			/* ����һ�����Ա���ü���ͼƬ����Դ */
			$cutimg = imagecreatetruecolor($width, $height);
			/* ʹ��imagecopyresampled()������ͼƬ���вü� */
			imagecopyresampled($cutimg, $back, 0, 0, $x, $y, $width, $height, $width, $height);
			imagedestroy($back);
			/* ͨ�������˽�з������������ͼ��������ͼƬ�����ƣ�Ĭ����"cu_"Ϊǰ׺ */
			return $this->createNewImage($cutimg, $qz.$name,$imgInfo);    
		}

		/* �ڲ�ʹ�õ�˽�з���������ȷ��ˮӡͼƬ��λ�� */
		private function position($groundInfo, $waterInfo, $waterPos){
			/* ��Ҫ��ˮӡ��ͼƬ�ĳ��Ȼ��ȱ�ˮӡ��С���޷�����ˮӡ */
			if( ($groundInfo["width"]<$waterInfo["width"]) || ($groundInfo["height"]<$waterInfo["height"]) ) { 
				return false; 
			} 
			switch($waterPos) { 
				case 1:			//1Ϊ���˾��� 
					$posX = 0; 
					$posY = 0; 
					break; 
				case 2:			//2Ϊ���˾��� 
					$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
					$posY = 0; 
					break; 
				case 3:			//3Ϊ���˾��� 
					$posX = $groundInfo["width"] - $waterInfo["width"]; 
					$posY = 0; 
					break; 
				case 4:			//4Ϊ�в����� 
					$posX = 0; 
					$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
					break; 
				case 5:			//5Ϊ�в����� 
					$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
					$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
					break; 
				case 6:			//6Ϊ�в����� 
					$posX = $groundInfo["width"] - $waterInfo["width"]; 
					$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
					break; 
				case 7:			//7Ϊ�׶˾��� 
					$posX = 0; 
					$posY = $groundInfo["height"] - $waterInfo["height"]; 
					break; 
				case 8:			//8Ϊ�׶˾��� 
					$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
					$posY = $groundInfo["height"] - $waterInfo["height"]; 
					break; 
				case 9:			//9Ϊ�׶˾��� 
					$posX = $groundInfo["width"] - $waterInfo["width"]; 
					$posY = $groundInfo["height"] - $waterInfo["height"]; 
					break; 
				case 0:
				default:		//��� 
					$posX = rand(0,($groundInfo["width"] - $waterInfo["width"])); 
					$posY = rand(0,($groundInfo["height"] - $waterInfo["height"])); 
					break; 
			} 
			return array("posX"=>$posX, "posY"=>$posY);
		}

		
		/* �ڲ�ʹ�õ�˽�з��������ڻ�ȡͼƬ��������Ϣ����ȡ��߶Ⱥ����ͣ� */
		private function getInfo($name, $path=".") {
			$spath = $path=="." ? rtrim($this->path,"/")."/" : $path.'/';
			
			$data = getimagesize($spath.$name);
			$imgInfo["width"]	= $data[0];
			$imgInfo["height"]  = $data[1];
			$imgInfo["type"]	= $data[2];

			return $imgInfo;		
		}

		/*�ڲ�ʹ�õ�˽�з����� ���ڴ���֧�ָ���ͼƬ��ʽ��jpg,gif,png���֣���Դ  */
		private function getImg($name, $imgInfo, $path='.'){
			
			$spath = $path=="." ? rtrim($this->path,"/")."/" : $path.'/';
			$srcPic = $spath.$name;
			
			switch ($imgInfo["type"]) {
				case 1:					//gif
					$img = imagecreatefromgif($srcPic);
					break;
				case 2:					//jpg
					$img = imagecreatefromjpeg($srcPic);
					break;
				case 3:					//png
					$img = imagecreatefrompng($srcPic);
					break;
				default:
					return false;
					break;
			}
			return $img;
		}
		
		/* �ڲ�ʹ�õ�˽�з��������صȱ������ŵ�ͼƬ��Ⱥ͸߶ȣ����ԭͼ�����ź�Ļ�С���ֲ��� */
		private function getNewSize($name, $width, $height, $imgInfo){	
			$size["width"] = $imgInfo["width"];          //ԭͼƬ�Ŀ��
			$size["height"] = $imgInfo["height"];        //ԭͼƬ�ĸ߶�
			
			if($width < $imgInfo["width"]){
				$size["width"]=$width;             		 //���ŵĿ�������ԭͼС���������ÿ��
			}

			if($height < $imgInfo["height"]){
				$size["height"] = $height;            	 //���ŵĸ߶������ԭͼС���������ø߶�
			}
			/* �ȱ������ŵ��㷨 */
			if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]){
				$size["height"] = round($imgInfo["height"]*$size["width"]/$imgInfo["width"]);
			}else{
				$size["width"] = round($imgInfo["width"]*$size["height"]/$imgInfo["height"]);
			}
			
			return $size;
		}	
		
		/* �ڲ�ʹ�õ�˽�з��������ڱ���ͼ�񣬲�����ԭ��ͼƬ��ʽ */
		private function createNewImage($newImg, $newName, $imgInfo){
			$this->path = rtrim($this->path,"/")."/";
			switch ($imgInfo["type"]) {
		   		case 1:				//gif
					$result = imageGIF($newImg, $this->path.$newName);
					break;
				case 2:				//jpg
					$result = imageJPEG($newImg,$this->path.$newName);  
					break;
				case 3:				//png
					$result = imagePng($newImg, $this->path.$newName);  
					break;
			}
			imagedestroy($newImg);
			return $newName;
		}

		/* �ڲ�ʹ�õ�˽�з��������ڼ�ˮӡʱ����ͼ�� */
		private function copyImage($groundImg, $waterImg, $pos, $waterInfo){
			imagecopy($groundImg, $waterImg, $pos["posX"], $pos["posY"], 0, 0, $waterInfo["width"],$waterInfo["height"]);
			imagedestroy($waterImg);
			return $groundImg;
		}

		/* �ڲ�ʹ�õ�˽�з������������͸���ȵ�ͼƬ����ԭ�� */
		private function kidOfImage($srcImg, $size, $imgInfo){
			$newImg = imagecreatetruecolor($size["width"], $size["height"]);		
			$otsc = imagecolortransparent($srcImg);					
			if( $otsc >= 0 && $otsc < imagecolorstotal($srcImg)) {  		
		  		 $transparentcolor = imagecolorsforindex( $srcImg, $otsc ); 
		 		 $newtransparentcolor = imagecolorallocate(
			   		 $newImg,
			  		 $transparentcolor['red'],
			   	         $transparentcolor['green'],
			   		 $transparentcolor['blue']
		  		 );
		  		 imagefill( $newImg, 0, 0, $newtransparentcolor );
		  		 imagecolortransparent( $newImg, $newtransparentcolor );
			}
			imagecopyresized( $newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"] );
			imagedestroy($srcImg);
			return $newImg;
		}
	}

	
	
	