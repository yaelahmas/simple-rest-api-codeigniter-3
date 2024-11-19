<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa_model extends CI_Model
{
    public function get_data($id = null)
    {
        if ($id === null) {
            return $this->db->get('mahasiswa')->result_array();
        } else {
            return $this->db->get_where('mahasiswa', ['id' => $id])->result_array();
        }
    }

    public function insert_data($data_db)
    {
        return $this->db->insert('mahasiswa', $data_db);
    }

    public function update_data($data_db, $id)
    {
        return $this->db->update('mahasiswa', $data_db, ['id' => $id]);
    }

    public function delete_data($id)
    {
        $this->db->delete('mahasiswa', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
