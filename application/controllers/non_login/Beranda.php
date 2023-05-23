<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends KZ_Controller {
    
    private $module = 'non_login/beranda';
    private $url_route = array('id', 'source', 'type'); 
    
    function index() {
        empty($this->sessionid) ? redirect('non_login/login') : null;
        
        $this->load->model(array('m_prodi'));
        $this->data['prodi'] = $this->m_prodi->getAll();
        $this->data['fakultas'] = $this->m_prodi->getAll(null,'asc','fakultas');
        
        $this->data['module'] = $this->module;
        $this->data['title'] = array('Beranda','');
        $this->data['breadcrumb'] = array( 
            array('title'=>'Beranda', 'url'=>'#')
        );
        $this->load_view('non_login/v_home', $this->data);
    }
    function err_404() {
        $this->data['breadcrumb'] = array( 
            array('title'=>'Halaman Tidak Ditemukan', 'url'=>'#')
        );
        $this->load_view('errors/html/error_404', $this->data);
    }
    function err_module() {
        $this->data['breadcrumb'] = array( 
            array('title'=>'Gagal Akses Module', 'url'=>'#')
        );
        $this->load_view('errors/html/error_module', $this->data);
    }
    function ajax() {
        $routing_module = $this->uri->uri_to_assoc(4, $this->url_route);
        if(is_null($routing_module['type'])){
            redirect('');
        }
        if($routing_module['type'] == 'chart') {
            if ($routing_module['source'] == 'akm') {
                $this->_chart_akm();
            }else if ($routing_module['source'] == 'kelas') {
                $this->_chart_kelas();
            }
        }
    }
    //function
    function _chart_akm() {
        $this->load->model(array('m_mhs','m_akm'));
        
        $fakultas = decode($this->input->post('fakultas'));
        $angkatan = $this->input->post('tahun');
        $uts = $this->input->post('uts');
        $uas = $this->input->post('uas');
        
        $where['a.semester_id'] = $this->smtid;
        $whr['status_mhs'] = 'AKTIF';
        if ($angkatan != '') {
            $where['m.angkatan'] = $angkatan;
            $whr['angkatan'] = $angkatan;
        }
        if ($uts != '') {
            $where['a.valid_uts'] = $uts;
        }
        if ($uas != '') {
            $where['a.valid_uas'] = $uas;
        }
        if ($fakultas != '') {
            $where['p.fakultas'] = $fakultas;
        }
        $rs = $this->m_akm->countAkm($where);
        $data = array();
        $total = 0; $all = 0;
        if($rs['rows'] > 0){
            foreach ($rs['data'] as $item) {
                $whr['prodi_id'] =  $item['prodi_id'];
                
                $row = array();
                $row['awal'] = (int) $this->m_mhs->count_all($whr);
                $row['akhir'] = (int) $item['akhir'];
                $row['prodi'] = '<b>'.round($row['akhir']/$row['awal']*100).'%</b> '.$item['nama_prodi'];
                
                $data[] = $row;
                $all += $row['awal'];
                $total += $row['akhir'];
            }
        }else{
            $data[] = array(array('awal' => 0, 'akhir' => 0, 'prodi' => ''));
        }
        jsonResponse(array('data' => $data, 'total' => $total, 'all' => $all, 'range' => 'Aktivitas Kuliah Mahasiswa (AKM) '.$this->smtname));
    }
    function _chart_kelas() {
        $this->load->model(array('m_kelas','m_akm','m_jurnal'));
        
        $prodi = decode($this->input->post('prodi'));
        $semester = $this->input->post('semester');
        
        $where['id_semester'] = $this->smtid;
        $where['n.semester_id'] = $where['a.semester_id'] = $this->smtid;
        $where['prodi_id'] = empty($prodi) ? null:$prodi;
        if ($semester != '') {
            $where['semester_kelas'] = $semester;
        }
        $rs = $this->m_kelas->chartRekap($where);
        $data = array();
        $total = 0;
        if($rs['rows'] > 0){
            foreach ($rs['data'] as $item) {
                $row = array();
                $row['qty'] = (int) $item['qty'];
                $row['grade'] = (int) $this->m_akm->countKuota(array('kelas_id' => $item['id_kelas'],'nilai_huruf <>' => null))['qty_mhs'];
                $row['meet'] = (int) $this->m_jurnal->count_all(array('kelas_id' => $item['id_kelas']));
                $row['name'] = $item['kode_matkul'].' - '.$item['nama_matkul'].
                        ' - '.$item['nama_kelas'].' ['.$item['nama_dosen'].']';
                
                $data[] = $row;
                $total ++;
            }
        }else{
            $data[] = array(array('qty' => 0, 'name' => ''));
        }
        jsonResponse(array('data' => $data, 'total' => $total, 'range' => 'Kelas Perkuliahan '.$this->smtname));
    }
}
