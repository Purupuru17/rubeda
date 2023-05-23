<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('notif')) {

    function notif($type, $title, $message) {
        $alert = '<div class="alert alert-' . $type . '">' .
                '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>' .
                '<strong>' . $title . ' ! </strong></br>' . $message . '<br />' .
                '</div>';

        return $alert;
    }
}
if (!function_exists('load_css')) {

    function load_css(array $array) {
        foreach ($array as $uri) {
            echo '<link rel="stylesheet" type="text/css" href="' . base_url('app/'.$uri) . '" />';
        }
    }

}
if (!function_exists('load_js')) {

    function load_js(array $array, $async = FALSE) {
        foreach ($array as $uri) {
            if(!$async){
                echo '<script type="text/javascript"  src="' . base_url('app/'.$uri) . '"></script>';
            }else{
                echo '<script async type="text/javascript"  src="' . base_url('app/'.$uri) . '"></script>';
            }
        }
    }

}
if (!function_exists('load_file')) {

    function load_file($src, $img = NULL) {
        $null_ava_img = !is_null($img) ? 'app/img/no-avatar.png' : 'app/img/no-img.jpg';
        if(empty($src)){
            return base_url($null_ava_img);
        }
        if(substr($src, 0, 3) != 'app'){
            $CI = &get_instance();
            $CI->load->library(array('s3'));
            $link = $CI->s3->url($src);
        }else{
            $link = is_file($src) ? base_url($src) : base_url($null_ava_img);
        }
        return $link;
    }

}
if (!function_exists('delete_file')) {

    function delete_file($src) {
        if(empty($src)){
            return false;
        }
        if(substr($src, 0, 3) != 'app'){
            $CI = &get_instance();
            $CI->load->library(array('s3'));
            $CI->s3->remove($src);
        }else{
            (is_file($src)) ? unlink($src) : '';
        }
    }
}
if (!function_exists('star')) {

    function star($value) {
        if ($value > 0) {
            for ($i = 1; $i <= $value; $i++) {
                echo '<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x orange"></i></span>';
            }
            for ($i = 1; $i <= 5 - $value; $i++) {
                echo '<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x orange"></i></span>';
            }
        }
    }
}
if (!function_exists('st_aktif')) {

    function st_aktif($value, $ya = null) {
        if(!is_null($ya)){
            return ($value == '1') ? '<span class="label label-success label-white">YA</span>' : '<span class="label label-danger label-white">TIDAK</span>';
        }
        return ($value == '1') ? '<span class="label label-success arrowed-in-right arrowed">AKTIF</span>' : '<span class="label label-danger arrowed-in-right arrowed">TIDAK AKTIF</span>';
    }
}
if (!function_exists('st_file')) {

    function st_file($src, $file = NULL) {
        $rs = '<i class="bigger-130 fa fa-times red"></i>';
        $down = '&nbsp; | &nbsp;<a class="bigger-120" href="'. load_file($src) .'" target="_blank"><i class="fa fa-download"></i></a>';
        
        if(empty($src)){
            return $rs;
        }
        if(substr($src, 0, 3) != 'app'){
            $rs = '<i class="bigger-120 fa fa-check-square-o green"></i>';
            $rs .= is_null($file) ? '' : $down;
        }else{
            if(is_file($src)){
                $rs = '<i class="bigger-120 fa fa-check green"></i>';
                $rs .= is_null($file) ? '' : $down;
            }
        }
        return $rs; 
    }
}
if (!function_exists('st_tagih')) {

    function st_tagih($value) {

        if ($value == '1') {
            $status = '<span class="label label-success arrowed-in-right arrowed">LUNAS</span>';
        } else if ($value == '0') {
            $status = '<span class="label label-danger arrowed-in-right arrowed">BELUM LUNAS</span>';
        } else {
            $status = '<span class="label label-default arrowed-in-right arrowed">PENDING</span>';
        }
        return $status;
    }
}
if (!function_exists('st_mhs')) {

    function st_mhs($value, $type = NULL) {
        $warning = array('LAINNYA','MUTASI','PROSES','SAKIT','PRAKTIKUM');
        $info = array('LULUS','IZIN','OFFLINE');
        $success = array('AKTIF','HADIR','ONLINE','SELESAI');
        $danger = array('DIKELUARKAN','WAFAT','PUTUS SEKOLAH','MENGUNDURKAN DIRI','HILANG','TIDAK AKTIF');
        
        if (in_array($value, $info)) {
            $status = '<span class="label label-info arrowed-in-right arrowed">'.$value.'</span>';
        } else if (in_array($value, $warning)) {
            $status = '<span class="label label-warning arrowed-in-right arrowed">'.$value.'</span>';
        } else if (in_array($value, $success)) {
            $status = '<span class="label label-success arrowed-in-right arrowed">'.$value.'</span>';
        } else if (in_array($value, $danger)) {
            $status = '<span class="label label-danger arrowed-in-right arrowed">'.$value.'</span>';
        } else {
            $status = '<span class="label label-default arrowed-in-right arrowed">'.$value.'</span>';
        }
        return !empty($type) ? '<span class="label label-'.$type.' label-white arrowed">'.$value.'</span>':$status;
    }

}
if (!function_exists('st_sinkron')) {

    function st_sinkron($value) {

        if ($value == '1') {
            $status = '<span><i class="ace-icon fa fa-check green bigger-110"></i></span>';
        } else if ($value == '2') {
            $status = '<span><i class="ace-icon fa fa-times red bigger-110"></i></span>';
        } else {
            $status = '<span><i class="ace-icon fa fa-question orange bigger-110"></i></span>';
        }
        return $status;
    }
}
if (!function_exists('st_nilai')) {

    function st_nilai($data) {
        $huruf = '-';
        $gpm = floatval($data['nilai_gpm']) * 0.4; //40
        $dpm = floatval($data['nilai_dpm']) * 0.4; //40
        $upt = floatval($data['nilai_upt'])* 0.2; //20
        $nilai = round($gpm + $dpm + $upt, 1);
        
        if($nilai > 3.75 && $nilai <= 4){
            $huruf = 'A';
        }else if($nilai > 3.5 && $nilai <= 3.75){
            $huruf = 'A-';
        }else if($nilai > 3.25 && $nilai <= 3.5){
            $huruf = 'AB';
        }else if($nilai > 3 && $nilai <= 3.25){
            $huruf = 'B+';
        }else if($nilai > 2.75 && $nilai <= 3){
            $huruf = 'B';
        }else if($nilai > 2.5 && $nilai <= 2.75){
            $huruf = 'B-';
        }else if($nilai > 2.25 && $nilai <= 2.5){
            $huruf = 'BC';
        }else if($nilai > 2 && $nilai <= 2.25){
            $huruf = 'C+';
        }else if($nilai > 1.75 && $nilai <= 2){
            $huruf = 'C';
        }else if($nilai > 1.5 && $nilai <= 1.75){
            $huruf = 'C-';
        }else if($nilai > 1.25 && $nilai <= 1.5){
            $huruf = 'CD';
        }else if($nilai > 1 && $nilai <= 1.25){
            $huruf = 'D+';
        }else if($nilai > 0 && $nilai <= 1){
            $huruf = 'D';
        }else if($nilai == 0){
            $huruf = 'E';
        }else{
            $huruf = '*';
        }
        
        if($gpm == 0 && $dpm == 0){
            return '-';
        }
        return $nilai.' ('.$huruf.')';
    }
}
if (!function_exists('load_array')) {

    function load_array($type) {
        $val = array();
        switch ($type) {
            case 'st_mhs':
                $val = array(
                    'AKTIF','LULUS','LAINNYA','MUTASI',
                    'DIKELUARKAN','WAFAT','PUTUS SEKOLAH','MENGUNDURKAN DIRI','HILANG','TIDAK AKTIF'
                );
                break;
            case 'st_akm':
                $val = array(
                    array('id' => 'A', 'txt' => 'AKTIF'),array('id' => 'N', 'txt' => 'NON-AKTIF'),
                    array('id' => 'C', 'txt' => 'CUTI'),array('id' => 'G', 'txt' => 'DOUBLE DEGREE'),
                    array('id' => 'M', 'txt' => 'KAMPUS MERDEKA')
                );
                break;
            case 'st_opsi':
                $val = array(
                    array('id' => '1', 'txt' => 'AKTIF'),array('id' => '0', 'txt' => 'TIDAK AKTIF')
                );
                break;
            case 'st_calon':
                $val = array(
                    'SEMINAR','UJIAN','YUDISIUM','WISUDA'
                );
                break;
            case 'tahun':
                $awal = intval(date('Y'));
                for($i = 2015; $i <= $awal + 1; $i++ ){
                    $val[] = $i;
                }
                break;
            case 'status':
                $val = array(
                    'PENDING','AKTIF', 'PROSES' ,'SELESAI', 'TIDAK AKTIF'
                );
                break;
            case 'nilai':
                $val = array(
                    array('huruf'=>'A','angka'=>4),array('huruf'=>'A-','angka'=>3.75),array('huruf'=>'AB','angka'=>3.5),
                    array('huruf'=>'B+','angka'=>3.25),array('huruf'=>'B','angka'=>3),array('huruf'=>'B-','angka'=>2.75),
                    array('huruf'=>'BC','angka'=>2.5),array('huruf'=>'C+','angka'=>2.25),array('huruf'=>'C','angka'=>2),
                    array('huruf'=>'C-','angka'=>1.75),array('huruf'=>'CD','angka'=>1.5),array('huruf'=>'D+','angka'=>1.25),
                    array('huruf'=>'D','angka'=>1),array('huruf'=>'E','angka'=>0)
                );
                break;
            case 'magang':
                $val = array(
//                    'Asistensi Mengajar','Magang I', 'Magang II','Magang III','PKL','KPM'
                    'REGULAR','KERJASAMA'
                );
                break;
            case 'tempat':
                $val = array(
//                    'Sekolah Negeri','Sekolah Swasta', 'Kelurahan' ,'Kampung', 'Perusahaan', 'Dinas', 'Usaha Rumahan'
                    'Kecamatan','Kelurahan','Kampung','Desa','Perusahaan', 'Dinas'
                );
                break;
        }
        return $val;
    }
}
if (!function_exists('encode')) {

    function encode($param, $url_safe = TRUE) {
        if(is_null($param) || $param == '' ){
            return '';
        }        
        $CI = &get_instance();
        $secret_key = $CI->config->item('encryption_key');
        $secret_iv = $CI->config->item('encrypt_iv');
        $encrypt_method = $CI->config->item('encrypt_method');
        // hash
        $key = hash('sha256', $secret_key);
        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        //do the encryption given text/string/number
        $result = openssl_encrypt($param, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($result);
        
        if ($url_safe) {
            $output = strtr($output, array('+' => '.', '=' => '-', '/' => '~'));
        }
        return $output;
    }
}
if (!function_exists('decode')) {

    function decode($param, $url_safe = TRUE) {
        $CI = &get_instance();
        $secret_key = $CI->config->item('encryption_key');
        $secret_iv = $CI->config->item('encrypt_iv');
        $encrypt_method = $CI->config->item('encrypt_method');
        
        if ($url_safe){
            $param = strtr($param, array('.' => '+', '-' => '=', '~' => '/'));
        }
        // hash
        $key = hash('sha256', $secret_key);
        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        //do the decryption given text/string/number
        $output = openssl_decrypt(base64_decode($param), $encrypt_method, $key, 0, $iv);

        return $output;
    }
}
if (!function_exists('ip_agent')) {

    function ip_agent() {
        $CI = &get_instance();
        $CI->load->library('user_agent');

        $agent = $CI->input->ip_address();
        if ($CI->agent->is_robot()) {
            $agent .= ' | Robot ' . $CI->agent->robot();
        } else if ($CI->agent->is_mobile()) {
            $agent .= ' | Mobile ' . $CI->agent->mobile();
        } else if ($CI->agent->is_browser()) {
            $agent .= ' | Desktop ';
        } else {
            $agent .= ' | '.$CI->agent->agent_string();
        }
        $agent .= ' - ' . $CI->agent->platform();
        $agent .= ' | ' . $CI->agent->browser() . ' ' . $CI->agent->version();

        return $agent;
    }
}
if (!function_exists('jsonResponse')) {

    function jsonResponse($output) {
        $CI = &get_instance();
        $debug = $CI->config->item('app.debug');
        $ajax_request = $CI->input->is_ajax_request();

        if ($debug == 0) {
            (!$ajax_request) ? exit('No direct script access allowed') : '';
        }
        $CI->output->set_status_header(200)->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
        exit();
    }
}
