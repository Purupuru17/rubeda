<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_mhs extends CI_Model {

    var $id = 'id_mhs';
    var $table = 'm_mhs';
    var $column_order = array(null,'nim','nama_mhs','angkatan','kelamin_mhs','status_mhs',null); //set column field database for datatable orderable
    var $column_search = array('nim','nama_mhs','nama_prodi','angkatan','kelamin_mhs','status_mhs','agama_mhs'); //set column field database for datatable searchable 
    var $order = array('nim' => 'asc'); // default order 

    function __construct() {
        parent::__construct();
    }
    //INSERT
    function insert($data) {
        $this->db->set($this->id, 'UUID()', FALSE);
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function insertPA($data) {
        $this->db->insert('tmp_pa', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }
    function insertBatch($data) {
        $this->db->trans_start();
        $this->db->insert_batch($this->table, $data);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    function insertTmp($id, $data, $pass) {
        $this->db->trans_start();
        //Insert User
        $this->db->insert('yk_user', $data);
        //Insert TMP
        $this->db->insert('tmp_mhs', array('mhs_id' => $id, 'user_id' => $data['id_user'], 'pass_mhs' => $pass));
        
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
    function updateBatch($data) {
        $this->db->trans_start();
        $this->db->update_batch($this->table, $data, $this->id);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    function updateTmp($user_id, $data, $tmp) {
        $this->db->trans_start();
        //update user
        $this->db->where('id_user', $user_id);
        $this->db->update('yk_user', $data);
        //update tmp
        $this->db->where('user_id', $user_id);
        $this->db->update('tmp_mhs', $tmp);

        $this->db->trans_complete();
        $this->db->trans_status();
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
    function deletePA($where) {
        $this->db->where($where);
        $this->db->delete('tmp_pa');
        return $this->db->affected_rows() > 0 ? true : false;
    }
    //EMPTY
    function empty() {
        $this->db->empty_table($this->table);
        return $this->db->affected_rows();
    }
    //GET
    function getAll($where = NULL, $like = '', $order = 'asc') {
        $this->db->from($this->table);
        if(!is_null($where)){
            $this->db->where($where);
        }
        if(!empty($like)){
            $this->db->group_start();
            $this->db->like('nim', $like, 'both');
            $this->db->or_like('nama_mhs', $like, 'both');  
            $this->db->group_end();
        }
        if(!is_null($order)){
            $this->db->order_by('nama_prodi asc, nim asc');
        }
        $get = $this->db->get();
        return [
            'rows' => $get->num_rows(),
            'data' => $get->result_array()
        ];
    }
    function getPA($where = NULL, $limit = null) {
        $this->db->select('m.*,d.nidn,d.nama_dosen');
        $this->db->from($this->table.' m');
        $this->db->join('tmp_pa p', 'p.mhs_id = m.id_mhs', 'left');
        $this->db->join('m_dosen d', 'p.dosen_id = d.id_dosen', 'left');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->order_by('nama_mhs', 'asc');
        if(!is_null($limit)){
            return $this->db->get()->row_array();
        }
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
    function getTmp($where) {
        $this->db->from('tmp_mhs m');
        $this->db->join('yk_user u', 'm.user_id = u.id_user', 'inner');
        
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    function isExist($where) {
        $this->db->from($this->table);
        $this->db->where($where);
        return $this->db->get()->num_rows();
    }
    function getEmpty() {
        $data['prodi_id'] = NULL;
        $data['nim'] = NULL;
        $data['nama_mhs'] = NULL;
        $data['angkatan'] = NULL;
        $data['status_mhs'] = NULL;
        $data['kelamin_mhs'] = NULL;
        $data['telepon_mhs'] = NULL;
        $data['alamat_mhs'] = NULL;
        $data['note_mhs'] = NULL;
        
        $data['update_mhs'] = NULL;
        $data['log_mhs'] = NULL;
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
    function count_all($where = NULL) {
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function get_datatables_query($where = NULL) {
        $this->db->from($this->table);
//        $this->db->join('m_prodi p', 'm.prodi_id = p.id_prodi', 'inner');
        
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
