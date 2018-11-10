<<<<<<< HEAD
﻿<?php
header("Content-type: text/html; charset=utf-8");
require_once('PublicMethod.php');

/**
 * 更换头像控制类
 * @author 伟
 */
Class ChangeAvatar extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->library('upload');
	}
	
	/*
	 * 进入更换头像页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 获取个人信息
			$obj = $this->Moa_user_model->get($_SESSION['user_id']);
			$data['username'] = $obj->username;
			$data['error'] = '';
			$this->load->view('view_change_avatar', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 获取最新头像（更换头像后，异步刷新左侧导航栏中的小头像）
	 */
	public function getLastedAvatar() {
		if (isset($_POST['old_avatar_name'])) {
			$sm_src_pic_name = $_POST['old_avatar_name'];
			$obj = $this->Moa_user_model->get($_SESSION['user_id']);
			if (('sm_' . $obj->avatar) != $sm_src_pic_name) {
				// 更新session的avatar
				$_SESSION['avatar'] = $obj->avatar;
				// 删除旧的sm小头像,默认的除外
				if (file_exists('upload/avatar/' . $sm_src_pic_name) && ($sm_src_pic_name != "sm_default.png")) {
					unlink('upload/avatar/' . $sm_src_pic_name);
				}
			}
			
			echo json_encode(array("status" => TRUE, "imgSrc" => $obj->avatar));
			return;
		}
	}
	
// 	public function uploadAvatar_OOP() {
// 		// 面向对象的头像裁剪上传  require 'Cropavatar.php';
// 		$crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file']);
// 		$response = array(
// 				'state'  => 200,
// 				'message' => $crop -> getMsg(),
// 				'result' => $crop -> getResult()
// 		);
// 		echo json_encode($response);
// 	}
	
	/**
	 * 头像裁剪上传与数据库记录
	 */
	public function uploadAvatar() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			if (isset($_POST['avatar_src']) && isset($_POST['avatar_data']) && isset($_FILES['avatar_file'])) {
				$post_src = $_POST['avatar_src'];
				$post_data = $_POST['avatar_data'];
				$files_file = $_FILES['avatar_file'];
						
				$src = NULL;
				$data = NULL;
				$file = NULL;
				$dst = NULL;
				$type = NULL;
				$extension = NULL;
				$msg = NULL;
				$src_pic_name = NULL;
				$avatar_pic_name = NULL;
				$path = 'upload/avatar/';
				
				/**** setSrc ****/
				if (!empty($post_src)) {
					$type = exif_imagetype($post_src);
				
					if ($type) {
						$src = $post_src;
						$type = $type;
						$extension = image_type_to_extension($type);
						/**** setDst ****/
						$avatar_pic_name = $uid . '_' . date('YmdHis') . '.png';
						$dst = $path . $avatar_pic_name;
						/**** setDst end ****/
					}
				}
				/**** setSrc end ****/
				
				/**** setData ****/
				if (!empty($post_data)) {
					$data = json_decode(stripslashes($post_data));
				}
				/**** setData end ****/
				
				/**** setFile ****/
				$errorCode = $files_file['error'];
				
				if ($errorCode === UPLOAD_ERR_OK) {
					$tmp_type = exif_imagetype($files_file['tmp_name']);
				
					if ($tmp_type) {
						$tmp_extension = image_type_to_extension($tmp_type);
						$src_pic_name = $uid . '_' . date('YmdHis') . '.src' . $tmp_extension;
						$tmp_src = $path . $src_pic_name;
				
						if ($tmp_type == IMAGETYPE_GIF || $tmp_type == IMAGETYPE_JPEG || $tmp_type == IMAGETYPE_PNG) {
				
							if (file_exists($tmp_src)) {
								unlink($tmp_src);
							}
				
							$tmp_result = move_uploaded_file($files_file['tmp_name'], $tmp_src);
				
							if ($tmp_result) {
								$src = $tmp_src;
								$type = $tmp_type;
								$extension = $tmp_extension;
								// setDst
								$avatar_pic_name = $uid . '_' . date('YmdHis') . '.png';
								$dst = $path . $avatar_pic_name;
								// setDst end
							} else {
								$msg = 'Failed to save file';
							}
						} else {
							$msg = 'Please upload image with the following types: JPG, PNG, GIF';
						}
					} else {
						$msg = 'Please upload image file';
					}
				} else {
					$msg = $this -> codeToMessage($errorCode);
				}
				/**** setFile end ****/
				
				/**** crop ****/
				if (!empty($src) && !empty($dst) && !empty($data)) {
					switch ($type) {
						case IMAGETYPE_GIF:
							$src_img = imagecreatefromgif($src);
							break;
				
						case IMAGETYPE_JPEG:
							$src_img = imagecreatefromjpeg($src);
							break;
				
						case IMAGETYPE_PNG:
							$src_img = imagecreatefrompng($src);
							break;
					}
				
					if (!$src_img) {
						$msg = "Failed to read the image file";
						
						// return
						$result = !empty($data) ? $dst : $src;
						$response = array(
								'state'  => 200,
								'message' => $msg,
								'result' => $result
						);
						echo json_encode($response);
						return;
					}
				
					$size = getimagesize($src);
					$size_w = $size[0]; // natural width
					$size_h = $size[1]; // natural height
				
					$src_img_w = $size_w;
					$src_img_h = $size_h;
				
					$degrees = $data -> rotate;
				
					// Rotate the source image
					if (is_numeric($degrees) && $degrees != 0) {
						// PHP's degrees is opposite to CSS's degrees
						$new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );
				
						imagedestroy($src_img);
						$src_img = $new_img;
				
						$deg = abs($degrees) % 180;
						$arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;
				
						$src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
						$src_img_h = $size_w * sin($arc) + $size_h * cos($arc);
				
						// Fix rotated image miss 1px issue when degrees < 0
						$src_img_w -= 1;
						$src_img_h -= 1;
					}
				
					$tmp_img_w = $data -> width;
					$tmp_img_h = $data -> height;
					$dst_img_w = 220;
					$dst_img_h = 220;
				
					$src_x = $data -> x;
					$src_y = $data -> y;
				
					if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
						$src_x = $src_w = $dst_x = $dst_w = 0;
					} else if ($src_x <= 0) {
						$dst_x = -$src_x;
						$src_x = 0;
						$src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
					} else if ($src_x <= $src_img_w) {
						$dst_x = 0;
						$src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
					}
				
					if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
						$src_y = $src_h = $dst_y = $dst_h = 0;
					} else if ($src_y <= 0) {
						$dst_y = -$src_y;
						$src_y = 0;
						$src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
					} else if ($src_y <= $src_img_h) {
						$dst_y = 0;
						$src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
					}
				
					// Scale to destination position and size
					$ratio = $tmp_img_w / $dst_img_w;
					$dst_x /= $ratio;
					$dst_y /= $ratio;
					$dst_w /= $ratio;
					$dst_h /= $ratio;
				
					$dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);
				
					// Add transparent background to destination image
					imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
					imagesavealpha($dst_img, true);
				
					$result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
				
					if ($result) {
						if (!imagepng($dst_img, $dst)) {
							$msg = "Failed to save the cropped image file";
						}
					} else {
						$msg = "Failed to crop the image file";
					}
				
					imagedestroy($src_img);
					imagedestroy($dst_img);
				}
				/**** crop end ****/
				
				/**** 头像文件名存入数据库 ****/
				// 首先删除原有头像文件，默认头像除外
				$old_avatar = $this->Moa_user_model->get($uid)->avatar;
				if ($old_avatar != 'default.png') {
					unlink('upload/avatar/' . $old_avatar);
				}
				// 更新数据库头像文件名
				$user_paras['avatar'] = $avatar_pic_name;
				$res = $this->Moa_user_model->update($uid, $user_paras);
				
				if ($res != FALSE && $res > 0) {
					$_SESSION['avatar'] = $avatar_pic_name;
					$msg = '更换成功，从此以新面目示人啦~';
					// 缩小为64*64的头像尺寸
					$this->imageScale($avatar_pic_name, 64);
				} else {
					$msg = '更换失败';
				}
				
				// 不论更换是否成功，都删除原文件
				if (file_exists('upload/avatar/' . $src_pic_name) && ($src_pic_name != "default.png")) {
					unlink('upload/avatar/' . $src_pic_name);
				}
				
				/**** return ****/
				$result = !empty($data) ? $dst : $src;
				$response = array(
						'state'  => 200,
						'message' => $msg,
						'result' => $result
				);
				echo json_encode($response);
				/**** return end ****/
			}
		}
	}
	
	/**
	 * 缩小头像尺寸为64*64
	 * @param $avatar_pic_name 220*220的头像文件名
	 * @param $size 目标头像尺寸
	 */
	private function imageScale($avatar_pic_name, $size) {
		$path = 'upload/avatar/';
		
		//因为PHP只能对资源进行操作，所以要对需要进行缩放的图片进行拷贝，创建为新的资源
		$tmp_src = $path . $avatar_pic_name;
		$src_img = imagecreatefrompng($tmp_src);
	
		//取得源图片的宽度和高度
		$size_src = getimagesize($tmp_src);
		$w = $size_src['0'];
		$h = $size_src['1'];
	
		//声明一个$w宽，$h高的真彩图片资源
		$dst_img = imagecreatetruecolor($size, $size);
			
		//关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $size, $size, $size_src['0'], $size_src['1']);
		// 加前缀sm_
		$tmp_dst = $path . 'sm_' . $avatar_pic_name;
		imagepng($dst_img, $tmp_dst);
	
		//销毁资源
		imagedestroy($dst_img);
	}
	
	/**
	 * 获取错误信息
	 * @param $code 错误代码
	 */
	private function codeToMessage($code) {
      	switch ($code) {
        	case UPLOAD_ERR_INI_SIZE:
          		$message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
          		break;

        	case UPLOAD_ERR_FORM_SIZE:
         		$message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
          		break;

        	case UPLOAD_ERR_PARTIAL:
          		$message = 'The uploaded file was only partially uploaded';
          		break;

	        case UPLOAD_ERR_NO_FILE:
	        	$message = 'No file was uploaded';
	        	break;
	
	        case UPLOAD_ERR_NO_TMP_DIR:
	        	$message = 'Missing a temporary folder';
	        	break;
	
	        case UPLOAD_ERR_CANT_WRITE:
	        	$message = 'Failed to write file to disk';
	        	break;
	
	        case UPLOAD_ERR_EXTENSION:
	        	$message = 'File upload stopped by extension';
	        	break;
	
	        default:
	          	$message = 'Unknown upload error';
	    }
	
	    return $message;
	}
	
	
=======
﻿<?php
header("Content-type: text/html; charset=utf-8");
require_once('PublicMethod.php');

/**
 * 更换头像控制类
 * @author 伟
 */
Class ChangeAvatar extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->library('upload');
	}
	
	/*
	 * 进入更换头像页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 获取个人信息
			$obj = $this->Moa_user_model->get($_SESSION['user_id']);
			$data['username'] = $obj->username;
			$data['error'] = '';
			$this->load->view('view_change_avatar', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 获取最新头像（更换头像后，异步刷新左侧导航栏中的小头像）
	 */
	public function getLastedAvatar() {
		if (isset($_POST['old_avatar_name'])) {
			$sm_src_pic_name = $_POST['old_avatar_name'];
			$obj = $this->Moa_user_model->get($_SESSION['user_id']);
			if (('sm_' . $obj->avatar) != $sm_src_pic_name) {
				// 更新session的avatar
				$_SESSION['avatar'] = $obj->avatar;
				// 删除旧的sm小头像,默认的除外
				if (file_exists('upload/avatar/' . $sm_src_pic_name) && ($sm_src_pic_name != "sm_default.png")) {
					unlink('upload/avatar/' . $sm_src_pic_name);
				}
			}
			
			echo json_encode(array("status" => TRUE, "imgSrc" => $obj->avatar));
			return;
		}
	}
	
// 	public function uploadAvatar_OOP() {
// 		// 面向对象的头像裁剪上传  require 'Cropavatar.php';
// 		$crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file']);
// 		$response = array(
// 				'state'  => 200,
// 				'message' => $crop -> getMsg(),
// 				'result' => $crop -> getResult()
// 		);
// 		echo json_encode($response);
// 	}
	
	/**
	 * 头像裁剪上传与数据库记录
	 */
	public function uploadAvatar() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			if (isset($_POST['avatar_src']) && isset($_POST['avatar_data']) && isset($_FILES['avatar_file'])) {
				$post_src = $_POST['avatar_src'];
				$post_data = $_POST['avatar_data'];
				$files_file = $_FILES['avatar_file'];
						
				$src = NULL;
				$data = NULL;
				$file = NULL;
				$dst = NULL;
				$type = NULL;
				$extension = NULL;
				$msg = NULL;
				$src_pic_name = NULL;
				$avatar_pic_name = NULL;
				$path = 'upload/avatar/';
				
				/**** setSrc ****/
				if (!empty($post_src)) {
					$type = exif_imagetype($post_src);
				
					if ($type) {
						$src = $post_src;
						$type = $type;
						$extension = image_type_to_extension($type);
						/**** setDst ****/
						$avatar_pic_name = $uid . '_' . date('YmdHis') . '.png';
						$dst = $path . $avatar_pic_name;
						/**** setDst end ****/
					}
				}
				/**** setSrc end ****/
				
				/**** setData ****/
				if (!empty($post_data)) {
					$data = json_decode(stripslashes($post_data));
				}
				/**** setData end ****/
				
				/**** setFile ****/
				$errorCode = $files_file['error'];
				
				if ($errorCode === UPLOAD_ERR_OK) {
					$tmp_type = exif_imagetype($files_file['tmp_name']);
				
					if ($tmp_type) {
						$tmp_extension = image_type_to_extension($tmp_type);
						$src_pic_name = $uid . '_' . date('YmdHis') . '.src' . $tmp_extension;
						$tmp_src = $path . $src_pic_name;
				
						if ($tmp_type == IMAGETYPE_GIF || $tmp_type == IMAGETYPE_JPEG || $tmp_type == IMAGETYPE_PNG) {
				
							if (file_exists($tmp_src)) {
								unlink($tmp_src);
							}
				
							$tmp_result = move_uploaded_file($files_file['tmp_name'], $tmp_src);
				
							if ($tmp_result) {
								$src = $tmp_src;
								$type = $tmp_type;
								$extension = $tmp_extension;
								// setDst
								$avatar_pic_name = $uid . '_' . date('YmdHis') . '.png';
								$dst = $path . $avatar_pic_name;
								// setDst end
							} else {
								$msg = 'Failed to save file';
							}
						} else {
							$msg = 'Please upload image with the following types: JPG, PNG, GIF';
						}
					} else {
						$msg = 'Please upload image file';
					}
				} else {
					$msg = $this -> codeToMessage($errorCode);
				}
				/**** setFile end ****/
				
				/**** crop ****/
				if (!empty($src) && !empty($dst) && !empty($data)) {
					switch ($type) {
						case IMAGETYPE_GIF:
							$src_img = imagecreatefromgif($src);
							break;
				
						case IMAGETYPE_JPEG:
							$src_img = imagecreatefromjpeg($src);
							break;
				
						case IMAGETYPE_PNG:
							$src_img = imagecreatefrompng($src);
							break;
					}
				
					if (!$src_img) {
						$msg = "Failed to read the image file";
						
						// return
						$result = !empty($data) ? $dst : $src;
						$response = array(
								'state'  => 200,
								'message' => $msg,
								'result' => $result
						);
						echo json_encode($response);
						return;
					}
				
					$size = getimagesize($src);
					$size_w = $size[0]; // natural width
					$size_h = $size[1]; // natural height
				
					$src_img_w = $size_w;
					$src_img_h = $size_h;
				
					$degrees = $data -> rotate;
				
					// Rotate the source image
					if (is_numeric($degrees) && $degrees != 0) {
						// PHP's degrees is opposite to CSS's degrees
						$new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );
				
						imagedestroy($src_img);
						$src_img = $new_img;
				
						$deg = abs($degrees) % 180;
						$arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;
				
						$src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
						$src_img_h = $size_w * sin($arc) + $size_h * cos($arc);
				
						// Fix rotated image miss 1px issue when degrees < 0
						$src_img_w -= 1;
						$src_img_h -= 1;
					}
				
					$tmp_img_w = $data -> width;
					$tmp_img_h = $data -> height;
					$dst_img_w = 220;
					$dst_img_h = 220;
				
					$src_x = $data -> x;
					$src_y = $data -> y;
				
					if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
						$src_x = $src_w = $dst_x = $dst_w = 0;
					} else if ($src_x <= 0) {
						$dst_x = -$src_x;
						$src_x = 0;
						$src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
					} else if ($src_x <= $src_img_w) {
						$dst_x = 0;
						$src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
					}
				
					if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
						$src_y = $src_h = $dst_y = $dst_h = 0;
					} else if ($src_y <= 0) {
						$dst_y = -$src_y;
						$src_y = 0;
						$src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
					} else if ($src_y <= $src_img_h) {
						$dst_y = 0;
						$src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
					}
				
					// Scale to destination position and size
					$ratio = $tmp_img_w / $dst_img_w;
					$dst_x /= $ratio;
					$dst_y /= $ratio;
					$dst_w /= $ratio;
					$dst_h /= $ratio;
				
					$dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);
				
					// Add transparent background to destination image
					imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
					imagesavealpha($dst_img, true);
				
					$result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
				
					if ($result) {
						if (!imagepng($dst_img, $dst)) {
							$msg = "Failed to save the cropped image file";
						}
					} else {
						$msg = "Failed to crop the image file";
					}
				
					imagedestroy($src_img);
					imagedestroy($dst_img);
				}
				/**** crop end ****/
				
				/**** 头像文件名存入数据库 ****/
				// 首先删除原有头像文件，默认头像除外
				$old_avatar = $this->Moa_user_model->get($uid)->avatar;
				if ($old_avatar != 'default.png') {
					unlink('upload/avatar/' . $old_avatar);
				}
				// 更新数据库头像文件名
				$user_paras['avatar'] = $avatar_pic_name;
				$res = $this->Moa_user_model->update($uid, $user_paras);
				
				if ($res != FALSE && $res > 0) {
					$_SESSION['avatar'] = $avatar_pic_name;
					$msg = '更换成功，从此以新面目示人啦~';
					// 缩小为64*64的头像尺寸
					$this->imageScale($avatar_pic_name, 64);
				} else {
					$msg = '更换失败';
				}
				
				// 不论更换是否成功，都删除原文件
				if (file_exists('upload/avatar/' . $src_pic_name) && ($src_pic_name != "default.png")) {
					unlink('upload/avatar/' . $src_pic_name);
				}
				
				/**** return ****/
				$result = !empty($data) ? $dst : $src;
				$response = array(
						'state'  => 200,
						'message' => $msg,
						'result' => $result
				);
				echo json_encode($response);
				/**** return end ****/
			}
		}
	}
	
	/**
	 * 缩小头像尺寸为64*64
	 * @param $avatar_pic_name 220*220的头像文件名
	 * @param $size 目标头像尺寸
	 */
	private function imageScale($avatar_pic_name, $size) {
		$path = 'upload/avatar/';
		
		//因为PHP只能对资源进行操作，所以要对需要进行缩放的图片进行拷贝，创建为新的资源
		$tmp_src = $path . $avatar_pic_name;
		$src_img = imagecreatefrompng($tmp_src);
	
		//取得源图片的宽度和高度
		$size_src = getimagesize($tmp_src);
		$w = $size_src['0'];
		$h = $size_src['1'];
	
		//声明一个$w宽，$h高的真彩图片资源
		$dst_img = imagecreatetruecolor($size, $size);
			
		//关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $size, $size, $size_src['0'], $size_src['1']);
		// 加前缀sm_
		$tmp_dst = $path . 'sm_' . $avatar_pic_name;
		imagepng($dst_img, $tmp_dst);
	
		//销毁资源
		imagedestroy($dst_img);
	}
	
	/**
	 * 获取错误信息
	 * @param $code 错误代码
	 */
	private function codeToMessage($code) {
      	switch ($code) {
        	case UPLOAD_ERR_INI_SIZE:
          		$message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
          		break;

        	case UPLOAD_ERR_FORM_SIZE:
         		$message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
          		break;

        	case UPLOAD_ERR_PARTIAL:
          		$message = 'The uploaded file was only partially uploaded';
          		break;

	        case UPLOAD_ERR_NO_FILE:
	        	$message = 'No file was uploaded';
	        	break;
	
	        case UPLOAD_ERR_NO_TMP_DIR:
	        	$message = 'Missing a temporary folder';
	        	break;
	
	        case UPLOAD_ERR_CANT_WRITE:
	        	$message = 'Failed to write file to disk';
	        	break;
	
	        case UPLOAD_ERR_EXTENSION:
	        	$message = 'File upload stopped by extension';
	        	break;
	
	        default:
	          	$message = 'Unknown upload error';
	    }
	
	    return $message;
	}
	
	
>>>>>>> abnormal
}