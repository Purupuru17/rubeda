<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends KZ_Controller {
    
    private $module = 'video';
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function index($url = null) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_index', $this->data);
    }
    function upload() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/video/h_upload', $this->data);
    }
    function riwayat() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/video/h_riwayat', $this->data);
    }
    function topik($url = null) {
        if(!empty($url)){
            $this->_detail($url);
        }
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik', $this->data);
    }
    function _detail($url) {
        $this->data['module'] = $this->module;
        $this->load_home('home/video/h_topik_detail', $this->data);
    }
}
