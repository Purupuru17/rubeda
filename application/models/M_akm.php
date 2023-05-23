<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_akm extends CI_Model {
    
    var $table = 'rf_akm';
    var $column_order = array(null,'nama_mhs','nama_prodi','status_akm','valid_akm','valid_uts','valid_uas',null); //set column field database for datatable orderable
    var $column_search = array('nim','nama_mhs','nama_prodi','angkatan','status_akm','valid_akm','valid_uts','valid_uas'); //set column field database for datatable searchable 
    var $order = array('update_akm' => 'desc'); // default order 
    
    //INSERT
    function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function insertKrs($data) {
        $this->db->set('id_nilai', 'UUID()', FALSE);
        $this->db->insert('rf_nilai', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function insertBatch($data) {
        $this->db->trans_start();
        $this->db->insert_batch('rf_nilai', $data);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    //UPDATE
    function update($id, $data) {
        if(is_array($id)){
            $this->db->where($id);
        }else{
            $this->db->where($this->id, $id);
        }
        $this->db->update($this->table, $data);
        
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function updateNilai($where, $data) {
        $this->db->where($where);
        $this->db->update('rf_nilai', $data);
        
        return $this->db->affected_rows() > 0 ? true : false;
    }
    //DELETE
    function delete($id) {
        if(is_array($id)){
            $this->db->where($id);
        }else{
            $this->db->where($this->id, $id);
        }
        $this->db->delete($this->table);
        
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function deleteKrs($where) {
        $this->db->where($where);
        $this->db->delete('rf_nilai');
        
        return $this->db->affected_rows();
    }
    //GET
    function getAll($where = NULL, $order = 'asc') {
        $this->db->from($this->table .' a');
        $this->db->join('m_mhs m', 'a.mhs_id = m.id_mhs', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->order_by('a.update_akm', $order);
        
        $get = $this->db->get();
        return [
            'rows' => $get->num_rows(),
            'data' => $get->result_array()
        ];
    }
    function getNilai($where = NULL, $order = 'asc', $limit = NULL) {
        $this->db->from('rf_nilai n');
        $this->db->join('m_mhs m', 'n.mhs_id = m.id_mhs', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        if(!is_null($limit)){
            $this->db->limit($limit);
            $this->db->order_by('n.kelas_id', $order);
        }else{
            $this->db->order_by('m.nim', $order);
        }
        $get = $this->db->get();
        return [
            'rows' => $get->num_rows(),
            'data' => $get->result_array()
        ];
    }
    function getKhs($where = NULL, $order = 'asc', $limit = NULL) {
        $this->db->from('rf_nilai n');
        $this->db->join('m_kelas k', 'n.kelas_id = k.id_kelas', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        if(!is_null($limit)){
            $this->db->limit($limit);
        }
        $this->db->order_by('k.kode_matkul', $order);
        $get = $this->db->get();
        return [
            'rows' => $get->num_rows(),
            'data' => $get->result_array()
        ];
    }
    function getId($id) {
        $this->db->from($this->table);
        if(is_array($id)){
            $this->db->where($id);
        }else{
            $this->db->where($this->id, $id);
        }
        return $this->db->get()->row_array();
    }
    function checkKrs($where = NULL) {
        $this->db->from('rf_nilai');
        if(!is_null($where)){
            $this->db->where($where);
        }
        return $this->db->get()->row_array();
    }
    function countKrs($where = NULL) {
        $this->db->select('COUNT(n.kelas_id) as qty_mk, SUM(k.sks_matkul) as qty_sks');
        $this->db->from('rf_nilai n');
        $this->db->join('m_kelas k', 'n.kelas_id = k.id_kelas', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->group_by('mhs_id');
        return $this->db->get()->row_array();
    }
    function countKuota($where = NULL) {
        $this->db->select('COUNT(mhs_id) as qty_mhs');
        $this->db->from('rf_nilai');
        if(!is_null($where)){
            $this->db->where($where);
        }
        return $this->db->get()->row_array();
    }
    function countAkm($where = null) {
        $this->db->select('COUNT(a.mhs_id) AS akhir, m.prodi_id, m.nama_prodi');
        $this->db->from('m_mhs m');
        $this->db->join('rf_akm a', 'm.id_mhs = a.mhs_id', 'inner');
        $this->db->join('m_prodi p', 'm.prodi_id = p.id_prodi', 'inner');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->group_by('m.prodi_id');
        $this->db->order_by('akhir asc');
        
        $get = $this->db->get();
        return [
            'rows' => $get->num_rows(),
            'data' => $get->result_array()
        ];
    }
    function getEmpty() {
        $data['mhs_id'] = NULL;
        $data['status_akm'] = NULL;
        $data['valid_akm'] = NULL;
        $data['valid_uts'] = NULL;
        $data['valid_uas'] = NULL;
        $data['biaya_akm'] = NULL;
        $data['sks_akm'] = NULL;
        $data['sks_total'] = NULL;
        $data['ips_akm'] = NULL;
        $data['ipk_total'] = NULL;
        
        $data['update_akm'] = NULL;
        $data['log_akm'] = NULL;
        return $data;
    }
    function get_datatables($where = NULL) {
        $this->get_datatables_query($where);
        if ($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function count_filtered($where = NULL) {
        $this->get_datatables_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function get_datatables_query($where = NULL) {
        $this->db->from($this->table .' a');
        $this->db->join('m_mhs m', 'a.mhs_id = m.id_mhs', 'left');
        $this->db->join('tmp_pa p', 'p.mhs_id = m.id_mhs', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $i = 0;
        foreach ($this->column_search as $item) { // looping awal
            if ($_POST['search']['value']) { // jika datatable mengirimkan pencarian dengan metode POST
                if ($i === 0) { // looping awal
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}
