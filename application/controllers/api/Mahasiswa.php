<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');

        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('is_unique', '{field} sudah tersedia, Silahkan ganti.');
        $this->form_validation->set_message('regex_match', '{field} tidak dalam format yang benar.');
        $this->form_validation->set_message('valid_email', 'Harus berisi alamat {field} yang valid, Seperti example@gmail.com atau example@yahoo.com');
    }

    public function index_get()
    {

        $id = $this->get('id');

        if ($id === null) {
            if ($this->mahasiswa->get_data()) {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'OK'
                    ],
                    'results' => $this->mahasiswa->get_data()
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'Not found.'
                    ],
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            if ($this->mahasiswa->get_data($id)) {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'OK'
                    ],
                    'results' => $this->mahasiswa->get_data($id)
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'Not found.'
                    ],
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $this->form_validation->set_rules('nrp', 'NRP', 'required|is_unique[mahasiswa.nrp]|regex_match[/^[0-9]{8}$/]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[mahasiswa.email]');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => [
                    'code' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'Bad request.'
                ],
                'errors' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data_db = [
                'nrp' => htmlentities($this->post('nrp')),
                'nama' => htmlspecialchars($this->post('nama')),
                'email' => htmlspecialchars($this->post('email')),
                'jurusan' => htmlspecialchars($this->post('jurusan')),
            ];

            if ($this->mahasiswa->insert_data($data_db) > 0) {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_CREATED,
                        'message' => 'Created.'
                    ],
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => 'Internal server error.'
                    ],
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        if ($id <= 0) {
            $this->response([
                'status' => [
                    'code' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'Bad request.'
                ],
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $mahasiswa = $this->mahasiswa->get_data($id);

            if (!$mahasiswa) {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_BAD_REQUEST,
                        'message' => 'Bad request.'
                    ],
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $nrp = htmlspecialchars($this->put('nrp'));
                $email = htmlspecialchars($this->put('email'));
                $check_nrp = $this->db->query("SELECT * FROM mahasiswa WHERE nrp = '$nrp' AND id != '$id'");
                $check_email = $this->db->query("SELECT * FROM mahasiswa WHERE email = '$email' AND id != '$id'");

                $this->form_validation->set_data($this->put());
                if ($check_nrp->num_rows() > 0) {
                    $this->form_validation->set_rules('nrp', 'NRP', 'required|is_unique[mahasiswa.nrp]|regex_match[/^[0-9]{8}$/]');
                } else {
                    $this->form_validation->set_rules('nrp', 'NRP', 'required|regex_match[/^[0-9]{8}$/]');
                }
                $this->form_validation->set_rules('nama', 'Nama', 'required');
                if ($check_email->num_rows() > 0) {
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[mahasiswa.email]');
                } else {
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                }
                $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $this->response([
                        'status' => [
                            'code' => REST_Controller::HTTP_BAD_REQUEST,
                            'message' => 'Bad request.'
                        ],
                        'errors' => $this->form_validation->error_array()
                    ], REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $data_db = [
                        'nrp' => $nrp,
                        'nama' => htmlspecialchars($this->put('nama')),
                        'email' => $email,
                        'jurusan' => htmlspecialchars($this->put('jurusan')),
                    ];

                    if ($this->mahasiswa->update_data($data_db, $id)) {
                        $this->response([
                            'status' => [
                                'code' => REST_Controller::HTTP_OK,
                                'message' => 'Updated.'
                            ],
                            'results' => $id
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => [
                                'code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                                'message' => 'Internal server error.'
                            ],
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id <= 0) {
            $this->response([
                'status' => [
                    'code' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'Bad request.'
                ],
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->mahasiswa->delete_data($id) > 0) {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'Deleted.'
                    ],
                    'results' => $id
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => [
                        'code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => 'Internal server error.'
                    ],
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
