<?php
class Boat_model extends CI_Model {

    public $normal_max = 8;
    public $library_max = 4;
    public $skipair_max = 4; //The boat has skipair can has max 4 skipair and rest of student who doesn't have skipair

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('boat')->result();
        if(count($result) == 1){
            return $result;
        } else {
            return null;
        }
    }

    public function getall()
    {
        $result = $this->db->get('boat')->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function getAllOceanBoat()
    {
        $this->db->select('boat.*, count(boat_has_student.id_boat) AS seat_occupied');
        $this->db->group_by('boat.id');
        $this->db->from('boat');
        $this->db->join('boat_has_student', 'boat_has_student.id_boat = boat.id', 'left'); 
        $result = $this->db->get()->result();
        if(count($result) > 0){
            foreach ($result as $key => $value) {
                if($this->is_boat_has_book($value->id)){
                    $value->has_book = true;
                    $value->books = $this->get_books_by_boat($value->id);
                } else {
                    $value->has_book = false;
                    $value->books = [];
                }

                $ski_data = $this->check_skipair_by_boat($value->id);
                if(count($ski_data) > 0){
                    $value->has_skipair = true;
                    $value->skipair_count = $this->skipair_max - $ski_data['count'];
                } else {
                    $value->has_skipair = false;
                    $value->skipair_count = 0;
                }

                $value->students = $this->get_student_by_boat($value->id);

                if($value->has_book){
                    $value->max_limit = $this->library_max;
                } else if($value->has_skipair && $value->skipair_count == $this->skipair_max){
                    $value->max_limit = $this->normal_max;
                } else {
                    $value->max_limit = $this->normal_max;
                }
            }
            return $result;
        } else {
            return null;
        }
    }

    public function insert($data)
    {
        $this->db->insert('boat', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function update($id, $data)
    {
        return $this->db->update('boat', $data, array('id' => $id));
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('boat');
    }

    public function check_boat_space($id_boat, $has_skipair)
    {
        $students_on_boat = $this->get_student_by_boat($id_boat);
        $students_on_boat_count = $students_on_boat == null ? 0 : count($students_on_boat);
        if($students_on_boat_count >= $this->normal_max)
            return false;
        //check boat has any book if Yes. Then boat can consider as Library boat and it can has max 4 student.
        if($this->is_boat_has_book($id_boat)){
            $max_limit = $this->library_max;
            if($students_on_boat_count < $max_limit){
                return true;
            } else {
                return false;
            }
        } else {
            $max_limit = $this->normal_max;
            if($has_skipair){
                $skipair_data = $this->check_skipair_by_boat($id_boat);
                $skipair_on_boat_count = 0;
                if(count($skipair_data) > 0) {
                    $skipair_on_boat_count = $this->skipair_max - $skipair_data['count'];
                }
                if($skipair_on_boat_count < $this->skipair_max){
                    return true;
                } else {
                    return false;
                }
            } else {
                if($students_on_boat_count < $max_limit){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function is_boat_has_book($id)
    {
        $this->db->where('id_boat', $id);
        $result = $this->db->get('boat_has_book')->result();
        if(count($result) > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_books_by_boat($id_boat)
    {
        $this->db->select('book.*, boat_has_book.*');
        $this->db->from('book');
        $this->db->join('boat_has_book', 'boat_has_book.id_book = book.id AND boat_has_book.id_boat = '.$id_boat); 
        $result = $this->db->get()->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function is_book_aready_on_boat($id_book, $id_boat)
    {
        $this->db->where('id_boat', $id_boat);
        $this->db->where('id_book', $id_book);
        $result = $this->db->get('boat_has_book')->result();
        if(count($result) > 0){
            return $result[0]->id;
        } else {
            return null;
        }
    }

    public function insert_book_to_boat($id_book, $id_boat)
    {
        $book_id = $this->is_book_aready_on_boat($id_book, $id_boat);
        if($book_id > 0){
            $insert_id = $book_id;
        } else {
            $this->db->insert('boat_has_book', array('id_book' => $id_book, 'id_boat' => $id_boat ));
            $insert_id = $this->db->insert_id();
        }
        return $insert_id;
    }

    public function is_student_on_boat($id_student, $id_boat)
    {
        $this->db->where('id_boat', $id_boat);
        $this->db->where('id_student', $id_student);
        $result = $this->db->get('boat_has_student')->result();
        if(count($result) > 0){
            return $result[0]->id;
        } else {
            return null;
        }
    }

    public function insert_student_on_boat($id_student, $id_boat, $has_skipair)
    {
        $boat_has_student = $this->is_student_on_boat($id_student, $id_boat);
        if( $boat_has_student != null){
            return $boat_has_student;
        } else {
            $this->db->insert('boat_has_student', array('id_student' => $id_student, 'id_boat' => $id_boat ));
            $insert_id = $this->db->insert_id();
            if($insert_id > 0 && $has_skipair){
                $ski_data = $this->check_skipair_by_boat($id_boat);
                if(count($ski_data) == 0){
                    $this->db->insert('boat_has_skipair', array('id_student_skipair1' => $id_student, 'id_boat' => $id_boat ));
                } else {
                    $this->insert_skipair_by_boat($id_boat, $id_student);
                }
            }
            return  $insert_id;
        }
    }

    public function get_student_by_boat($id_boat)
    {
        $this->db->select('student.first_name AS first_name, student.last_name AS last_name, student.has_skipair AS has_skipair, boat_has_student.*');
        $this->db->from('student');
        $this->db->join('boat_has_student', 'boat_has_student.id_student = student.id AND boat_has_student.id_boat = '.$id_boat);
        $result = $this->db->get()->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function get_skipair_by_boat($id_boat)
    {
        $this->db->where('id_boat', $id_boat);
        $result = $this->db->get('boat_has_skipair')->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function check_skipair_by_boat($id_boat)
    {
        $this->db->where('id_boat', $id_boat);
        $result = $this->db->get('boat_has_skipair')->result();
        if(count($result) > 0){
            $skipair_count = 0;
            $skipair_column = '';
            foreach ($result[0] as $key => $value) {
                if(strpos($key, 'id_student_skipair') !== false && $value == null){
                    if($skipair_count == 0)
                        $skipair_column = $key;
                    $skipair_count++;
                }
            }
            return array('count'=> $skipair_count, 'column' => $skipair_column);
        } else {
            return [];
        }
    }

    public function insert_skipair_by_boat($id_boat, $id_student)
    {
        $result = $this->check_skipair_by_boat($id_boat);
        if( count($result) > 0){
            $this->db->where('id_boat', $id_boat);
            $this->db->set($result['column'], $id_student);
            $result = $this->db->update('boat_has_skipair');
            return $result;
        } else {
            return null;
        }
        
    }

    public function get_skipair_by_boat_student($id_boat, $id_student)
    {
        $this->db->where('id_boat', $id_boat);
        $this->db->group_start();
        $this->db->or_where('id_student_skipair1', $id_student);
        $this->db->or_where('id_student_skipair2', $id_student);
        $this->db->or_where('id_student_skipair3', $id_student);
        $this->db->or_where('id_student_skipair4', $id_student);
        $this->db->group_end();
        $result = $this->db->get('boat_has_skipair')->result();
        if(count($result) > 0){
            return $result;
        } else {
            return null;
        }
    }

    public function update_skipair_on_boat($id_boat_has_skipair, $column)
    {
        $this->db->where('id', $id_boat_has_skipair);
        $this->db->set($column, null);
        $result = $this->db->update('boat_has_skipair');
        return $result;
    }

    public function student_on_boat_delete($id_student, $id_boat)
    {
        $this->db->where('id_student', $id_student);
        $this->db->where('id_boat', $id_boat);
        $this->db->delete('boat_has_student');
        $result = $this->get_skipair_by_boat_student($id_boat, $id_student);
        if($result){
            foreach($result[0] as $key => $value){
                if(strpos($key, 'id_student_skipair') !== false && $value == $id_student){
                    return $this->update_skipair_on_boat($result[0]->id, $key);
                }
            }
            return 1;
        } else {
            return 1;
        }
    }

}
?>