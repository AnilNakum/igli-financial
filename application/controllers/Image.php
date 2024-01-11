<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Image extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();        
    }

    public function index()
    {
        $data['page_title'] = "Manage Images";
        $this->view('image', $data);
    }

    public function upload($input = 'img')
    {
        pr($input);die;
        $preview = $config = $errors = [];

        $inner_dir = 'form-temp-img/';
        if (empty($_FILES[$input])) {
            return [];
        }
        $value = $_FILES[$input]; 
        $fileName = $value['name']; // the file name
        $fileSize = $value['size']; // the file size
        $fileType = $value['type']; // the file type

        if (isset($fileName) && $fileName != "") {
            $DateTime = strtotime("now");
            $FileUpload = fileUpload($inner_dir, $input, $value['tmp_name']);

            if ($FileUpload['Status'] == 'error') {
                $response['message'] = $FileUpload['Message'];
                $errors[] = $response;
            } else {
                $Img = $FileUpload['URL'];

                $newFilePath = UPLOAD_DIR . $Img;
                $newFileUrl = IMAGE_DIR . $Img;

                $fileId = explode('.', basename($Img));
                $preview[] = $newFileUrl;
                $config[] = [
                    'key' => $newFilePath,
                    'caption' => $fileName,
                    'size' => $fileSize,
                    'file_name' => $Img,
                    'file_type' => $fileType,
                    'downloadUrl' => $newFileUrl, // the url to download the file
                ];
            }

        } else {
            $errors[] = $fileName;
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];

        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0] . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }
        echo json_encode($out);
    }

    public function delete($ID = 0)
    {

        $file_path = $this->input->post('key');
        $last = explode('/', $file_path);
        $pfolder = $last[count($last) - 3];
        $dir = $last[count($last) - 2];
        $last = $last[count($last) - 1];
        $name = explode('.', $last);
        $file_name = $dir . '/' . $last;
        if ($ID > 0) {

            if ($dir == 'customers') {
                $Products = $this->Common->get_info(TBL_PRODUCTS, $ID, 'id');
                if ($Products->images != '') {
                    $SubImages = json_decode($Products->images);
                    if (($key = array_search($file_name, $SubImages)) !== false) {
                        unset($SubImages[$key]);
                    }
                }
                $Images = [];
                foreach ($SubImages as $key => $v) {
                    array_push($Images, $v);
                }
                $I = json_encode($Images);
                $UpdateInfo = array(
                    'images' => $I,
                );
                $this->Common->update_info(TBL_PRODUCTS, $ID, $UpdateInfo, 'id');
            }

            if ($dir == 'product_media') {
                $file_name = $pfolder . '/' . $file_name;
                $Catalog = $this->Common->get_info(TBL_PRODUCT_CATLOG, $ID, 'id');
                if ($Catalog->images != '') {
                    $SubImages = json_decode($Catalog->images);
                    if (($key = array_search($file_name, $SubImages)) !== false) {
                        unset($SubImages[$key]);
                    }
                }
                $Images = [];
                foreach ($SubImages as $key => $v) {
                    array_push($Images, $v);
                }
                $I = json_encode($Images);
                $UpdateInfo = array(
                    'images' => $I,
                );
                $this->Common->update_info(TBL_PRODUCT_CATLOG, $ID, $UpdateInfo, 'id');
            }
        }

        if ($file_path != "" && file_exists($file_path)):
            unlink($file_path);
            if (file_exists(UPLOAD_DIR . $dir . '/' . $name[0] . '-150x150.' . $name[1])) {
                unlink(UPLOAD_DIR . $dir . '/' . $name[0] . '-150x150.' . $name[1]);
            }
            if (file_exists(UPLOAD_DIR . $dir . '/' . $name[0] . '-300x300.' . $name[1])) {
                unlink(UPLOAD_DIR . $dir . '/' . $name[0] . '-300x300.' . $name[1]);
            }
        endif;

        echo json_encode(['status' => 'ok']);
    }

    public function submit()
    {
        $inner_dir = 'anil/';
        $upload_path = UPLOAD_DIR . $inner_dir;

        if (!file_exists(UPLOAD_DIR)): mkdir(UPLOAD_DIR, 0777, true);
        endif;
        if (!file_exists($upload_path)): mkdir($upload_path, 0777, true);
        endif;

        for ($i = 0; $i < count($this->input->post('key')); $i++) {
            $temp = array(
                'key' => $this->input->post('key')[$i],
                'caption' => $this->input->post('caption')[$i],
                'file_name' => $this->input->post('file_name')[$i],
                'size' => $this->input->post('size')[$i],
                'file_type' => $this->input->post('file_type')[$i],
                'url' => $this->input->post('url')[$i],
            );
            $ImgArray[$i] = $temp;
            $url = $ImgArray[$i]['url'];
            $filename = substr($url, strrpos($url, '/') + 1);
            if (file_exists($ImgArray[$i]['key'])) {
                file_put_contents($upload_path . $filename, file_get_contents($url));
                unlink($this->input->post('key')[$i]);
                $name = explode('.', $filename);
                if (file_exists(UPLOAD_DIR . 'temp-img/' . $name[0] . '-150x150.' . $name[1])) {
                    $url = IMAGE_DIR . 'temp-img/' . $name[0] . '-150x150.' . $name[1];
                    file_put_contents($upload_path . $name[0] . '-150x150.' . $name[1], file_get_contents($url));
                    unlink(UPLOAD_DIR . 'temp-img/' . $name[0] . '-150x150.' . $name[1]);
                }
                if (file_exists(UPLOAD_DIR . 'temp-img/' . $name[0] . '-300x300.' . $name[1])) {
                    $url = IMAGE_DIR . 'temp-img/' . $name[0] . '-300x300.' . $name[1];
                    file_put_contents($upload_path . $name[0] . '-300x300.' . $name[1], file_get_contents($url));
                    unlink(UPLOAD_DIR . 'temp-img/' . $name[0] . '-300x300.' . $name[1]);
                }
            }
        }
        echo json_encode(['status' => 'ok']);
    }
}