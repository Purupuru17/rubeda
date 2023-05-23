<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Ifsnop\Mysqldump as IMysqldump;

class Ajax extends KZ_Controller {
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
    }
    function routing() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if ($routing_module['type'] == 'list') {
            //LIST
            if ($routing_module['source'] == 'notif') {
                $this->_notif_user();
            }
        } else if ($routing_module['type'] == 'action') {
            //LIST
            if ($routing_module['source'] == 'cron') {
                $this->_backup_db();
            }
        }
    }    
    function _notif_user() {
        $this->load->model(array('m_notif'));
        
        if(!empty($this->loggedin)){
            $id = $this->input->post('id');
            if($id != ''){
                $this->m_notif->update(decode($id), array('status_notif' => '1'));
                jsonResponse(array('data' => NULL, 'item' => 0 ,'status' => FALSE));
            }
            
            $unread = $this->m_notif->unRead($this->sessionid);
            $rs = $this->m_notif->getAll(array('n.send_id' => $this->sessionid), 10);
            
            if($rs['rows'] > 0){
                $data = array();
//                foreach ($rs['data'] as $item) {
//                    $row = array();
//                    $row['id'] = encode($item['id_notif']);
//                    $row['subject'] =  $item['subject_notif'];
//                    $row['msg'] = $item['msg_notif'];
//                    $row['time'] =  selisih_wkt($item['buat_notif']);
//                    $row['link'] = site_url($item['link_notif']);
//                    $row['status'] = ($item['status_notif'] == '0') ? 'un-read' : '';
//                    $data[] = $row;
//                }
                jsonResponse(array('data' => $data, 'item' => $unread ,'status' => TRUE));
            }else{
                jsonResponse(array('data' => NULL, 'item' => 0 ,'status' => FALSE));
            }
        }
    }
    function _backup_db() {
        $this->load->helper(array('download'));
        $is_cli = $this->input->is_cli_request();
        if(!$is_cli){
//            exit('404 not found');
        }
        $title = url_title($this->config->item('app.session').'db '. format_date(date('Y-m-d H:i:s'),2),'-',true);
        $file = "app/log/{$title}.sql";
        $table = array('m_mhs','yk_user_log','yk_site_log');
        
        $dumpSettings = array('exclude-tables' => $table);
        try {
            $dump = new IMysqldump\Mysqldump($this->db->dsn, $this->db->username, $this->db->password, $dumpSettings);
            $dump->start($file);
            force_download($file, NULL);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
