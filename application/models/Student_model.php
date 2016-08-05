<?php
class Student_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('student')->result();
        if(count($result) == 1){
            return $result;
        } else {
            return null;
        }
    }

    public function getall()
    {
        $result = $this->db->get('student')->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function insert($data)
    {
        $this->db->insert('student', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function update($id, $data)
    {
        return $this->db->update('student', $data, array('id' => $id));
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('student');
    }

    public function student_has_skipair($id)
    {
        $this->db->where('id', $id);
        $this->db->where('has_skipair', 1);
        $result = $this->db->get('student')->result();
        if(count($result) == 1){
            return true;
        } else {
            return false;
        }
    }
}
?>