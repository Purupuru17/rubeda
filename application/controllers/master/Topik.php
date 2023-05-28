<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topik extends KZ_Controller {
    
    private $module = 'master/topik';
    private $module_do = 'master/topik_do';    
    private $url_route = array('id', 'source', 'type');
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_topik'));
    }
    function index() {
        $this->data['title'] = array('Topik','List Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> '')
        );
        $this->data['module'] = $this->module;
        $this->load_view('master/topik/v_index', $this->data);
    }
    function add() {
        $this->data['edit'] = $this->m_topik->getEmpty();
        
        $this->data['action'] = $this->module_do.'/add';
        $this->data['title'] = array('Topik','Tambah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/topik/v_form', $this->data);
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $this->data['edit'] = $this->m_topik->getId(decode($id));
        
        $this->data['action'] = $this->module_do.'/edit/'.$id;
        $this->data['title'] = array('Topik','Ubah Data');
        $this->data['breadcrumb'] = array( 
            array('title'=>$this->uri->segment(1), 'url'=>'#'),
            array('title'=>$this->uri->segment(2), 'url'=> site_url($this->module)),
            array('title'=>$this->data['title'][1], 'url'=>'')
        );
        $this->load_view('master/topik/v_form', $this->data);
    }
    function delete($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        $check = $this->db->get_where('m_video', array('topik_id' => decode($id)))->row_array();
        if(!is_null($check)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data gagal dihapus. 
                Data ini digunakan oleh data lainnya'));
            redirect($this->module);
        }
        $data = $this->m_topik->getId(decode($id));
        //delete
        $result = $this->m_topik->delete(decode($id));
        if ($result) {
            delete_file($data['img_topik']);
            
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil dihapus'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal dihapus'));
            redirect($this->module);
        }
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'table') {
            //TABLE
            if($routing_module['source'] == 'data') {
                $this->_table_data();
            }
        }
    }
    //function
    function _table_data() {
        $list = $this->m_topik->getAll();
        $data = array();
        $no = 1;
        foreach ($list['data'] as $items) {
            $row = array();
            
            $aksi = '<div class="action-buttons">
                    <a href="'. site_url($this->module .'/edit/'. encode($items['id_topik'])) .'" 
                        class="tooltip-warning btn btn-white btn-warning btn-sm btn-round" data-rel="tooltip" title="Ubah Data">
                        <span class="orange"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                    </a>
                    <a href="#" name="'. encode($items['id_topik']) .'" itemprop="'. $items['judul_topik'] .'" id="delete-btn" 
                        class="tooltip-error btn btn-white btn-danger btn-mini btn-round" data-rel="tooltip" title="Hapus Data">
                        <span class="red"><i class="ace-icon fa fa-trash-o"></i></span>
                    </a>
                </div>';
            $row[] = ctk($no);
            $row[] = '<a class="bolder" href="'.site_url('topik/'.encode($items['id_topik'])).'" target="_blank">'
                    .ctk($items['judul_topik']).'</a>';
            $row[] = ctk($items['parent_topik']);
            $row[] = '<img class="img-thumbnail img-circle lazyload blur-up" width="80" src="'.load_file($items['img_topik']).'" />';
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }
        jsonResponse(array("data" => $data));
    }
}
