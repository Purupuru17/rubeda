<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_do extends KZ_Controller {
    
    private $module = 'master/kelas';
    private $module_do = 'master/kelas_do';
    private $url_route = array('id', 'source', 'type');  
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_kelas','m_akm'));
    }
    function add() {
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/add');
        }
        $this->load->library(array('feeder'));
        //feeder
        $data['id_semester'] = $this->smtid;
        $data['id_prodi'] = decode($this->input->post('prodi'));
        $data['id_matkul'] = decode($this->input->post('matkul'));
        $data['nama_kelas_kuliah'] = $this->input->post('semester').strtoupper($this->input->post('nama'));
        $data['sks_tatap_muka'] = (int) $this->input->post('sks');
        $data['lingkup'] = $this->input->post('lingkup');
        $data['mode'] = $this->input->post('mode');
        $data['tanggal_mulai_efektif'] = empty($this->input->post('mulai')) ? null : $this->input->post('mulai');
        $data['tanggal_akhir_efektif'] = empty($this->input->post('selesai')) ? null : $this->input->post('selesai');
        //lokal
        $val['prodi_id'] = $data['id_prodi'];
        $val['id_semester'] = $data['id_semester'];
        $val['id_matkul'] = $data['id_matkul'];
        $val['kode_matkul'] = $this->input->post('kode');
        $val['nama_matkul'] = $this->input->post('namamk');
        $val['sks_matkul'] = $data['sks_tatap_muka'];
        $val['jenis_matkul'] = $this->input->post('jenis');
        $val['nama_kelas'] = $data['nama_kelas_kuliah'];
        $val['semester_kelas'] = $this->input->post('semester');
        $val['status_kelas'] = $this->input->post('status');
        $val['kuota_kelas'] = $this->input->post('kuota');
        $val['is_valid'] = '0';
        $val['jumlah_mhs'] = 0;
        $val['update_kelas'] = date('Y-m-d H:i:s');
        $val['log_kelas'] = $this->sessionname.' menambahkan kelas kuliah';
        //check
        $check = $this->m_kelas->getId(array('id_matkul' => $val['id_matkul'], 'id_semester' => $this->smtid, 'prodi_id' => $data['id_prodi'],
            'semester_kelas' => $val['semester_kelas'], 'nama_kelas' => $val['nama_kelas'], 'status_kelas' => '1'));
        if(!is_null($check)){
            $this->session->set_flashdata('notif', notif('warning', 'Peringatan', 'Data kelas kuliah ini sudah ada sebelumnya. Cek dahulu sebelum menambahkan kembali'));
            redirect($this->module.'/add');
        }
        //insert
        $rs = $this->feeder->post('InsertKelasKuliah', $data);
        if ($rs['status']) {
            //insert lokal
            $val['id_kelas'] = $rs['data']['id_kelas_kuliah'];
            $this->m_kelas->insert($val);
            
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil disimpan'));
            redirect($this->module.'/detail/'.encode($val['id_kelas']));
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal disimpan. '.$rs['msg']));
            redirect($this->module.'/add');
        }
    }
    function edit($id = NULL) {
        if(empty(decode($id))){
            redirect($this->module);
        }
        if(!$this->_validation($this->rules)){
            redirect($this->module.'/edit/'.$id);
        }
        $this->load->library(array('feeder'));
        //feeder
        $data['id_semester'] = $this->smtid;
        $data['id_prodi'] = decode($this->input->post('prodi'));
        $data['id_matkul'] = decode($this->input->post('matkul'));
        $data['nama_kelas_kuliah'] = $this->input->post('semester').strtoupper($this->input->post('nama'));
        $data['sks_tatap_muka'] = (int) $this->input->post('sks');
        $data['lingkup'] = $this->input->post('lingkup');
        $data['mode'] = $this->input->post('mode');
        $data['tanggal_mulai_efektif'] = empty($this->input->post('mulai')) ? null : $this->input->post('mulai');
        $data['tanggal_akhir_efektif'] = empty($this->input->post('selesai')) ? null : $this->input->post('selesai');
        //lokal
        $val['id_matkul'] = $data['id_matkul'];
        $val['kode_matkul'] = $this->input->post('kode');
        $val['nama_matkul'] = $this->input->post('namamk');
        $val['sks_matkul'] = $data['sks_tatap_muka'];
        $val['jenis_matkul'] = $this->input->post('jenis');
        $val['nama_kelas'] = $data['nama_kelas_kuliah'];
        $val['semester_kelas'] = $this->input->post('semester');
        $val['status_kelas'] = $this->input->post('status');
        $val['kuota_kelas'] = $this->input->post('kuota');
        $val['update_kelas'] = date('Y-m-d H:i:s');
        $val['log_kelas'] = $this->sessionname.' mengubah kelas kuliah';
        //update
        $rs = $this->feeder->update('UpdateKelasKuliah', array('id_kelas_kuliah' => decode($id)),$data);
        if ($rs['status']) {
            //update lokal
            $this->m_kelas->update(decode($id), $val);
            
            $this->session->set_flashdata('notif', notif('success', 'Informasi', 'Data berhasil diubah'));
            redirect($this->module);
        } else {
            $this->session->set_flashdata('notif', notif('danger', 'Peringatan', 'Data gagal diubah. '.$rs['msg']));
            redirect($this->module.'/edit/'.$id);
        }
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'action') {
            //ACTION
            if($routing_module['source'] == 'sinkron') {
                $this->_sinkron_kelas();
            }else if($routing_module['source'] == 'delete') {
                $this->_delete_krs();
            }else if($routing_module['source'] == 'change') {
                $this->_change_kelas();
            }else if($routing_module['source'] == 'add_dosen') {
                $this->_add_dosen();
            }else if($routing_module['source'] == 'delete_dosen') {
                $this->_delete_dosen();
            }
        }
    }
    //function
    function _sinkron_kelas() {
        if (!$this->_validation($this->rules_sinkron,'ajax')) {
            jsonResponse(array('status' => FALSE, 'msg' => validation_errors()));
        }
        $this->load->library(array('feeder'));
        
        $data['id_kelas_kuliah'] = decode($this->input->post('id'));
        $mode = $this->input->post('mode');
        $regid = array_filter(explode(",", $this->input->post('mhs')));
        
        $update['update_nilai'] = date('Y-m-d H:i:s');
        
        $success = array();
        $error = array();
        $kosong = array();
        if(empty($mode)){
            //Insert KRS
            foreach ($regid as $val) {
                
                $data['id_registrasi_mahasiswa'] = decode($val);
                $update['status_nilai'] = '0';

                $rs = $this->feeder->post('InsertPesertaKelasKuliah', $data);
                if($rs['status']){
                    $update['status_krs'] = '1';
                    $update['log_nilai'] = $this->sessionname.' sinkron KRS ke Feeder';
                    $success[] = $update;
                }else {
                    $update['status_krs'] = ($rs['code'] == 119) ? '1':'2';
                    $update['log_nilai'] = $rs['msg'];
                    $error[] = $update;
                }
                $this->m_akm->updateNilai(array('kelas_id' => $data['id_kelas_kuliah'], 'mhs_id' => decode($val)), $update);
            }
            jsonResponse(array('status' => true, 'msg' => count($success).' data KRS berhasil tersimpan<br>'.count($error).' data KRS gagal tersimpan'));
            
        }else{
            //Update KHS
            foreach ($regid as $val) {

                $khs = $this->m_akm->checkKrs(array('kelas_id' => $data['id_kelas_kuliah'], 'mhs_id' => decode($val)));
                if(empty($khs['nilai_huruf']) || $khs['status_krs'] != '1'){
                    $kosong[] = $update;
                }else{
                    $data['id_registrasi_mahasiswa'] = decode($val);
                    $rs = $this->feeder->update('UpdateNilaiPerkuliahanKelas', $data, 
                        array('nilai_angka' => '','nilai_huruf' => $khs['nilai_huruf'], 
                            'nilai_indeks' => strval(array_find($khs['nilai_huruf'], load_array('nilai')))
                    ));
                    if($rs['status']) {
                        $update['status_nilai'] = '1';
                        $update['log_nilai'] = $this->sessionname.' sinkron KHS ke Feeder';
                        $success[] = $update;
                    }else {
                        $update['status_nilai'] = '2';
                        $update['log_nilai'] = $rs['msg'];
                        $error[] = $update;
                    }
                    $this->m_akm->updateNilai(array('kelas_id' => $data['id_kelas_kuliah'], 'mhs_id' => decode($val)), $update);
                }
            }
            if(count($kosong) > 0){
                jsonResponse(array('status' => false, 'msg' => count($kosong).' Mahasiswa belum memiliki Nilai Perkuliahan atau KRS belum tersimpan'));
            }
            jsonResponse(array('status' => true, 'msg' => count($success).' data KHS berhasil tersimpan<br>'.count($error).' data KHS gagal tersimpan'));
        }
    }
    function _delete_krs() {
        if (!$this->_validation($this->rules_sinkron,'ajax')) {
            jsonResponse(array('status' => FALSE, 'msg' => validation_errors()));
        }
        $data['id_kelas_kuliah'] = decode($this->input->post('id'));
        $regid = array_filter(explode(",", $this->input->post('mhs')));
        
        $update['status_krs'] = '0';
        $update['status_nilai'] = '0';
        $update['update_nilai'] = date('Y-m-d H:i:s');
        $update['log_nilai'] = $this->sessionname.' hapus KRS dari Feeder';
        
        $this->load->library(array('feeder'));
        //Delete KRS
        $success = array();
        $error = array();
        foreach ($regid as $val) {
            $data['id_registrasi_mahasiswa'] = decode($val);
            
            $rs = $this->feeder->delete('DeletePesertaKelasKuliah', $data);
            if ($rs['status']) {
                $success[] = $update;
                $this->m_akm->updateNilai(array('kelas_id' => $data['id_kelas_kuliah'], 'mhs_id' => decode($val)), $update);
            }else {
                $error[] = $update;
            }
        }
        jsonResponse(array('status' => true, 'msg' => count($success).' data KRS berhasil terhapus<br>'.count($error).' data KRS gagal terhapus'));
           
    }
    function _change_kelas() {
        if (!$this->_validation($this->rules_sinkron,'ajax')) {
            jsonResponse(array('status' => FALSE, 'msg' => validation_errors()));
        }
        $id = decode($this->input->post('id'));
        $regid = array_filter(explode(",", $this->input->post('mhs')));
        
        $update['kelas_id'] = decode($this->input->post('kelas'));
        $update['status_krs'] = '0';
        $update['status_nilai'] = '0';
        $update['update_nilai'] = date('Y-m-d H:i:s');
        $update['log_nilai'] = $this->sessionname.' memindahkan kelas kuliah';
        
        $success = array();
        $error = array();
        foreach ($regid as $val) {
            $rs = $this->m_akm->updateNilai(array('kelas_id' => $id, 'mhs_id' => decode($val)), $update);
            if ($rs) {
                $success[] = $update;
            }else {
                $error[] = $update;
            }
        }
        jsonResponse(array('status' => true, 'msg' => count($success).' data KRS berhasil dipindah<br>'.count($error).' data KRS gagal dipindah'));
           
    }
    function _add_dosen() {
        if (!$this->_validation($this->rules_dosen,'ajax')) {
            jsonResponse(array('status' => FALSE, 'msg' => validation_errors()));
        }
        $post = explode('|', $this->input->post('dosen'));
        $tipe = $this->input->post('tipe');
        //feeder
        $data['id_registrasi_dosen'] = decode(element(2, $post));
        $data['id_kelas_kuliah'] = decode($this->input->post('kelas'));
        $data['sks_substansi_total'] = (int)$this->input->post('substansi');
        $data['rencana_minggu_pertemuan'] = (int)$this->input->post('rencana');
        $data['realisasi_minggu_pertemuan'] = (int)$this->input->post('realisasi');
        $data['id_jenis_evaluasi'] = $this->input->post('jenis');
        //lokal
        $val['id_dosen'] = decode(element(0, $post));
        $val['nama_dosen'] = element(1, $post);
        $val['is_valid'] = $tipe;
        $val['update_kelas'] = date('Y-m-d H:i:s');
        $val['log_kelas'] = $this->sessionname.' menambahkan dosen pengampu';
        
        $this->load->library(array('feeder'));
        
        if($tipe == '0'){
            //praktisi
            $update = $this->m_kelas->update($data['id_kelas_kuliah'], $val);
            if ($update) {
                jsonResponse(array('status' => true, 'msg' => 'Dosen Pengampu berhasil tersimpan'));
            }else {
                jsonResponse(array('status' => false, 'msg' => 'Dosen Pengampu gagal tersimpan'));
            }
        }else if($tipe == '1'){
             //dosen
            $rs = $this->feeder->post('InsertDosenPengajarKelasKuliah', $data);
            if ($rs['status']) {
                //update lokal
                $this->m_kelas->update($data['id_kelas_kuliah'], $val);
                jsonResponse(array('status' => true, 'msg' => 'Dosen Pengampu berhasil tersimpan'));
            }else {
                jsonResponse(array('status' => false, 'msg' => $rs['msg']));
            }
        }
    }
    function _delete_dosen() {
        $id = decode($this->input->post('id'));
        if (empty($id)) {
            jsonResponse(array('status' => FALSE, 'msg' => 'Kelas kuliah tidak ditemukan'));
        }
        $val['id_dosen'] = null;
        $val['nama_dosen'] = null;
        $val['is_valid'] = '0';
        $val['update_kelas'] = date('Y-m-d H:i:s');
        $val['log_kelas'] = $this->sessionname.' menghapus dosen pengampu';
        
        $kelas = $this->m_kelas->getId($id);
        if($kelas['is_valid'] == '0'){    //praktisi
            $update = $this->m_kelas->update($id, $val);
            if ($update) {
                jsonResponse(array('status' => true, 'msg' => 'Dosen Pengampu berhasil dihapus'));
            }else {
                jsonResponse(array('status' => false, 'msg' => 'Dosen Pengampu gagal dihapus'));
            }
        }else if($kelas['is_valid'] == '1'){    //dosen
            $this->load->library(array('feeder'));
            
            $get = $this->feeder->get('GetDosenPengajarKelasKuliah', array('filter' => "id_kelas_kuliah='{$id}' AND
                id_dosen='{$kelas['id_dosen']}' AND id_semester='{$this->smtid}'"));
            //aktivitas dosen
            if(count($get['data']) > 0){
                $rs = $this->feeder->delete('DeleteDosenPengajarKelasKuliah', array('id_aktivitas_mengajar' => $get['data'][0]['id_aktivitas_mengajar']));
                if ($rs['status']) {
                    //update lokal
                    $this->m_kelas->update($id, $val);
                    jsonResponse(array('status' => true, 'msg' => 'Dosen Pengampu berhasil dihapus'));
                }else {
                    jsonResponse(array('status' => false, 'msg' => $rs['msg']));
                }
            }
            jsonResponse(array('status' => false, 'msg' => 'Aktivitas mengajar dosen sudah terhapus sebelumnya. Sinkron kelas kuliah kembali'));
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
            'label' => 'Nama Kelas',
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
            'label' => 'Lingkup Kelas',
            'rules' => 'trim|xss_clean'
        ),array(
            'field' => 'mode',
            'label' => 'Mode Kelas',
            'rules' => 'trim|xss_clean'
        ),array(
            'field' => 'status',
            'label' => 'Status Kelas',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'kuota',
            'label' => 'Kuota Kelas',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[1]|less_than_equal_to[100]'
        )
    ); 
    private $rules_sinkron = array(
        array(
            'field' => 'id',
            'label' => 'Kelas Kuliah',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'mhs',
            'label' => 'Mahasiswa',
            'rules' => 'required|trim|xss_clean'
        )
    );
    private $rules_dosen = array(
        array(
            'field' => 'kelas',
            'label' => 'Kelas Kuliah',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'dosen',
            'label' => 'Dosen Pengampu',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'substansi',
            'label' => 'SKS Substansi',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[1]|less_than_equal_to[10]'
        ),array(
            'field' => 'rencana',
            'label' => 'Rencana',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[10]|less_than_equal_to[16]'
        ),array(
            'field' => 'realisasi',
            'label' => 'Realisasi',
            'rules' => 'required|trim|xss_clean|is_natural|greater_than_equal_to[10]|less_than_equal_to[16]'
        ),array(
            'field' => 'jenis',
            'label' => 'Jenis Evaluasi',
            'rules' => 'required|trim|xss_clean'
        ),array(
            'field' => 'tipe',
            'label' => 'Tipe Dosen',
            'rules' => 'required|trim|xss_clean'
        )
    );
}
