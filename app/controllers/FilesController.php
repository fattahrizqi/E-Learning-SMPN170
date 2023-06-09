<?php

use App\helpers\Flasher as Flasher;
Use App\helpers\Request as Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FilesController extends Controller{

    public function export()
    {
        $dir = 'repo/';
        $filename = $_POST["file"];
        $file_path = $dir . $filename;
        $ctype = "application/octet-stream";

        if(!empty($file_path) && file_exists($file_path)) {
            header("Pragma:public");
            header("Expired:0");
            header("Cache-Control:must-revalidate");
            header("Content-Control:public");
            header("Content-Description: File Transfer");
            header("Content-Type: $ctype");
            header("Content-Disposition:attachment; filename=\"".basename($file_path)."\"");
            header("Content-Transfer-Encoding:binary");
            header("Content-Length:".filesize($file_path));
            flush();
            readfile($file_path);
            exit();
        } else{
            Flasher::setFlash('error', 'File doesnt exist');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function import()
    {
        // HTTP method check
        Request::requestMethod();

        $fileName = $_FILES['import_file']['name'];

        $allowed_ext = ['xlsx', 'csv', 'xls'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

        if (in_array($file_ext, $allowed_ext)) {
            $inputFileNamePath = $_FILES['import_file']['tmp_name'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $param = [];
            $count = 0;
            foreach ($data as $row) {
                if ($count > 0) {
                    $name =  $row[0];
                    $position = $row[1];
                    $gender = $row[2];
                    $no_induk = $row[3];
                    $birth_place = $row[4];
                    $birth_date = $row[5];
                    $religion = $row[6];
                    $role = $row[7];

                    $param['name'] = $name;
                    $param['position'] = $position;
                    $param['gender'] = $gender;
                    $param['no_induk'] = $no_induk;
                    $param['birth_place'] = $birth_place;
                    $param['birth_date'] = $birth_date;
                    $param['religion'] = $religion;
                    $param['role'] = $role;

                    $existing_user = $this->model('User_model')->getUserByEmail($name);

                    if ($existing_user) {
                        Flasher::setFlash('error', 'An account with that email address already exists.');
                    } else {
                        if($param['name'] != null) {
                            $user_id = $this->model('User_model')->createUserByImport($param);
                            $createProfile = $this->model('User_model')->createProfileByImport($param);
                            if ($user_id && $createProfile) {
                                Flasher::setFlash('success', 'Account create successfull!');
                            } else {
                                Flasher::setFlash('error', 'There was an error creating your account.');
                            }
                        } else {
                            Flasher::setFlash('success', 'Import data success!');
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                        }
                    }
                } else {
                    $count = 1;
                }
            }
            Flasher::setFlash('success', 'Import data success!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        else {
            Flasher::setFlash('error', 'Invalid file');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}