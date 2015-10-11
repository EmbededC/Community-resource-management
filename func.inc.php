<?php
	/** file: func.inc.php �������ļ� */

	include "fileupload.class.php";                            //�����ļ��ϴ���FileUpload�����ļ�
	include "image.class.php";                                 //����ͼƬ������Image���ڵ��ļ�
	
	/* ����һ������upload()����ͼƬ�ϴ� */
	function upload(){
		$path = "./uploads/";                                     //����ͼƬ�ϴ�·��
		
		$up = new FileUpload($path);                           //�����ļ��ϴ������
		
		if($up->upload('pic')) {                               //�ϴ�ͼƬ
			$filename = $up->getFileName();                    //��ȡ�ϴ����ͼƬ��
			
			$img = new Image($path);                           //����ͼ���������
			
			$img -> thumb($filename, 300, 300, "");            //���ϴ���ͼƬ����������300X300����
			$img -> thumb($filename, 80, 80, "icon_");         //����һ��80x80��ͼ�꣬ʹ��icon_��ǰ׺
			$img -> watermark($filename, "logo.gif", 5, "");   //Ϊ�ϴ���ͼƬ����ͼƬˮӡ
			
			return array(true, $filename);                     //����ɹ����سɹ�״̬��ͼƬ����
		} else {
			return array(false, $up->getErrorMsg());           //���ʧ�ܷ���ʧ��״̬�ʹ�����Ϣ
		}
	}
	/* ɾ���ϴ���ͼƬ */
	function delpic($picname){
		$path = "./uploads/"; 

		@unlink($path.$picname);                                //ɾ��ԭͼ
		@unlink($path.'icon_'.$picname);                        //ɾ��ͼ��
	}
	
		