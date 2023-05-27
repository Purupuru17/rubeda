<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_video extends CI_Model {
    
    var $id = 'id_video';
    var $table = 'm_video';
    var $column_order = array(null,'judul_video','judul_topik','privasi_video','usia_video','status_video','tag_video',null); //set column field database for datatable orderable
    var $column_search = array('judul_video','judul_topik','privasi_video','usia_video','status_video','tag_video'); //set column field database for datatable searchable 
    var $order = array('create_video' => 'desc'); // default order 
    
    //INSERT
    function insert($data) {
        $this->db->set($this->id, 'UUID()', FALSE);
        
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows() > 0 ? true : false;
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
    //GET
    function getAll($where = NULL, $order = 'asc') {
        $this->db->from($this->table.' v');
        $this->db->join('m_topik t', 'v.topik_id = t.id_topik', 'inner');
        if(!is_null($where)){
            $this->db->where($where);
        }
        $this->db->order_by('v.create_video', $order);
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
        $this->db->from($this->table.' v');
        $this->db->join('m_topik t', 'v.topik_id = t.id_topik', 'inner');
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
