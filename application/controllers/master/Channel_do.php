<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Channel_do extends KZ_Controller {
    
    private $module = 'master/channel';
    private $module_do = 'master/channel_do';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_creator'));
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/edit/'.$id);
        }
        $data['id_prodi'] = decode($this->input->post('prodi'));
        $data['id_matkul'] = decode($this->input->post('matkul'));
        $data['nama_channel_kuliah'] = $this->input->post('semester').strtoupper($this->input->post('nama'));
        $data['sks_tatap_muka'] = (int) $this->input->post('sks');
        $data['lingkup'] = $this->input->post('lingkup');
        $data['mode'] = $this->input->post('mode');
        
        $data['update_channel'] = date('Y-m-d H:i:s');
        $data['log_channel'] = $this->sessionname.' mengubah channel kuliah';
        
        $result = $this->m_creator->update(decode($id), $data);
        if ($result) {
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil diubah'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal diubah'));
            redirect($this->module.'/edit/'.$id);
        }
    }
    private $rules = array(
        array(
            'field' => 'prodi',
            'label' => 'Program Studi',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'matkul',
            'label' => 'Mata Kuliah',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'sks',
            'label' => 'Bobot SKS',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[1]|less_than_equal_to[10]'
        ),array(
            'field' => 'semester',
            'label' => 'Semester',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'jenis',
            'label' => 'Jenis Mata Kuliah',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'nama',
            'label' => 'Nama Channel',
            'rules' => 'trim|xss_clean|max_length[5]'
        ),array(
            'field' => 'mulai',
            'label' => 'Tanggal Mulai',
            'rules' => 'trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'selesai',
            'label' => 'Tanggal Selesai',
            'rules' => 'trim|xss_clean|min_length[5]'
        ),array(
            'field' => 'lingkup',
            'label' => 'Lingkup Channel',
            'rules' => 'trim|xss_clean'
        ),array(
            'field' => 'mode',
            'label' => 'Mode Channel',
            'rules' => 'trim|xss_clean'
        ),array(
            'field' => 'status',
            'label' => 'Status Channel',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'kuota',
            'label' => 'Kuota Channel',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[1]|less_than_equal_to[100]'
        )
    ); 
}
