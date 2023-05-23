<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends KZ_Controller {
    
    private $module = 'channel';
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function index($url = null) {
        if(!empty($url)){
            $this->_detail($url);
        }
        $this->data['module'] = $this->module;
        $this->load_home('home/channel/h_index', $this->data);
    }
    function subscribe() {
        $this->data['module'] = $this->module;
        
        $this->load_home('home/channel/h_subscribe', $this->data);
    }
    function _detail($url) {
        $this->data['module'] = $this->module;
        $this->load_home('home/channel/h_detail', $this->data);
    }
}
