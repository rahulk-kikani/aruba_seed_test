<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is student controller which handle all the actions related to student account.
 *
 * @version         v1
 * @category        Controller
 * @author          Rahul Kikani
 */
class Boat extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('boat_model');
        $this->load->model('student_model');
    }

    public function detail_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users
        if ($id === NULL)
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

        // Find and return a single record for a particular user.
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the student table, using the id as id_student for retreival.
        $user = NULL;
        $user = $this->boat_model->get($id);
        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function detail_post()
    {
        $id = $this->post('id');

        // If the id parameter doesn't exist create/insert student profile into database
        if ($id === NULL)
        {
            

            $name = $this->post('name');
            $price = $this->post('price');
            $color = $this->post('color');

            if($name == '' || $price == '' || $color == ''){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Invalid Data'
                ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
            } else {
                $data = array(
                    'name' => $name,
                    'price' => $price,
                    'color' => $color,
                    );
                $new_boat = $this->boat_model->insert($data);
                if($new_boat > 0 ){
                    $data['id'] = $new_boat;
                    $this->set_response([
                        'status' => TRUE,
                        'data' => $data,
                        'message' => 'Boat Record Created.'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Operation Failed'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                }
                
            }

        } else {

            //Update student profile info.
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $data = [];
            if($this->post('name') != '')
                $data['name'] = $this->post('name');

            if($this->post('price') != '')
                $data['price'] = $this->post('price');

            if($this->post('color') != '')
                $data['color'] = $this->post('color');

            if(count($data) == 0){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Invalid Data'
                ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
            } else {
                $new_boat = $this->boat_model->update($id, $data);
                if($new_boat){
                    $data['id'] = $id;
                    $this->set_response([
                        'status' => TRUE,
                        'data' => $data,
                        'message' => 'Student Profile Updated.'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Operation Failed'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                }
            }
        }
    }

    public function detail_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $this->boat_model->delete($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the student profile'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }

    public function all_get()
    {
        $boats = $this->boat_model->getall();
        if (!empty($boats))
        {
            $this->set_response($boats, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    //ocean_boat mean boat has at least one student.
    public function ocean_boat_get()
    {
        $boats = $this->boat_model->getAllOceanBoat();
        if (!empty($boats))
        {
            $this->set_response($boats, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function book_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users
        if ($id === NULL)
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

        // Find and return a single record for a particular user.
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the student table, using the id as id_student for retreival.
        $book = NULL;
        $book = $this->boat_model->get_books_by_boat($id);

        if (!empty($book))
        {
            $this->set_response([
                'status' => TRUE,
                'data' => $book
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Book data on boat could not be found'
            ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
        }
    }

    public function book_post()
    {
        $id_boat = (int) $this->post('id_boat');
        $id_book = (int) $this->post('id_book');

        // Validate the id.
        if ($id_boat <= 0 || $id_book <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $boat_book_id = $this->boat_model->insert_book_to_boat($id_book, $id_boat);
        if($boat_book_id > 0){
            $message = [
                'id' => $boat_book_id,
                'id_boat' => $id_boat,
                'id_book' => $id_book,
                'message' => 'Book Added to boat'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // HTTP_OK (202) being the HTTP response code
        } else {
            $message = [
                'id_boat' => $id_boat,
                'id_book' => $id_book,
                'message' => 'Operation Fail'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // HTTP_OK (202) being the HTTP response code
        }
    }

    public function student_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users
        if ($id === NULL)
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

        // Find and return a single record for a particular user.
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the student table, using the id as id_student for retreival.
        $book = NULL;
        $book = $this->boat_model->get_student_by_boat($id);

        if (!empty($book))
        {
            $this->set_response($book, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No student on boat'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function skipair_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users
        if ($id === NULL)
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

        // Find and return a single record for a particular user.
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the student table, using the id as id_student for retreival.
        $book = NULL;
        $book = $this->boat_model->get_skipair_by_boat($id);

        if (!empty($book))
        {
            $this->set_response($book, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No skipair on boat'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function student_on_boat_post()
    {
        $id_boat = (int) $this->post('id_boat');
        $id_student = (int) $this->post('id_student');

        // Validate the id.
        if ($id_boat <= 0 || $id_student <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $has_skipair = $this->student_model->student_has_skipair($id_student);
        $boat_space = $this->boat_model->check_boat_space($id_boat, $has_skipair);
        if($boat_space){
            $boat_has_student = $this->boat_model->insert_student_on_boat($id_student, $id_boat, $has_skipair);
            $message = [
                'status' => true,
                'id' => $boat_has_student,
                'id_boat' => $id_boat,
                'id_student' => $id_student,
                'message' => 'Student Added to boat'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        } else {
            $message = [
                'status' => false,
                'id_boat' => $id_boat,
                'id_student' => $id_student,
                'message' => 'Boat is full'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        }
    }

    public function relocate_student_post()
    {
        $id_boat = (int) $this->post('id_boat');
        $id_boat_dest = (int) $this->post('id_boat_dest');
        $id_student = (int) $this->post('id_student');

        // Validate the id.
        if ($id_boat <= 0 || $id_boat_dest <= 0 || $id_student <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $has_skipair = $this->student_model->student_has_skipair($id_student);
        $boat_space = $this->boat_model->check_boat_space($id_boat_dest, $has_skipair);
        if($boat_space){
            //delete user from old boat
            $this->boat_model->student_on_boat_delete($id_student, $id_boat);

            //add user to new boat
            $boat_has_student = $this->boat_model->insert_student_on_boat($id_student, $id_boat_dest, $has_skipair);
            $message = [
                'status' => true,
                'id' => $boat_has_student,
                'id_boat' => $id_boat,
                'id_student' => $id_student,
                'message' => 'Student Added to boat'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        } else {
            $message = [
                'status' => false,
                'id_boat' => $id_boat,
                'id_student' => $id_student,
                'message' => 'Boat is full'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        }
    }

    public function student_on_boat_delete()
    {
        $id_boat = (int) $this->get('id_boat');
        $id_student = (int) $this->get('id_student');

        // Validate the id.
        if ($id_boat <= 0 || $id_student <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $this->boat_model->student_on_boat_delete($id_student, $id_boat);
        $message = [
            'id_boat' => $id_boat,
            'id_student' => $id_student,
            'message' => 'Deleted the student profile'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }
}
