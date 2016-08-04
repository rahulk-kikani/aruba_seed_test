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
class Book extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('book_model');
    }

    public function detail_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the book
        if ($id === NULL)
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No books were found'
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
        $user = $this->book_model->get($id);
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

        // If the id parameter doesn't exist create/insert book into database
        if ($id === NULL)
        {
            $name = $this->post('name');
            $url_on_amazon = $this->post('url_on_amazon');

            if($name == '' || $url_on_amazon == ''){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Invalid Data'
                ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
            } else {
                $data = array(
                    'name' => $name,
                    'url_on_amazon' => $url_on_amazon
                    );
                $new_book = $this->book_model->insert($data);
                if($new_book > 0 ){
                    $data['id'] = $new_book;
                    $this->set_response([
                        'status' => TRUE,
                        'data' => $data,
                        'message' => 'Book Detail Created.'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Operation Failed'
                    ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
                }
                
            }

        } else {

            //Update book info.
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

            if($this->post('url') != '')
                $data['url'] = $this->post('url');

            if(count($data) == 0){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Invalid Data'
                ], REST_Controller::HTTP_OK); // HTTP_OK (200) being the HTTP response code
            } else {
                $new_book = $this->book_model->update($id, $data);
                if($new_book){
                    $data['id'] = $id;
                    $this->set_response([
                        'status' => TRUE,
                        'data' => $data,
                        'message' => 'Book Detail Updated.'
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

        $this->book_model->delete($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the book'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }

    public function all_get()
    {
        $books = $this->book_model->getall();
        if (!empty($books))
        {
            $this->set_response($books, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
