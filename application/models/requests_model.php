<?php

class Requests_model extends Common_model {

    public function __construct() {
        parent::__construct();
        $this->table_name = "requests";
    }

    public function add_new() {
        $this->load->library('form_validation');
        if ($this->form_validation->run('add-car') == FALSE) {
            $this->session->set_flashdata('message', ERROR_MESSAGE . ":" . validation_errors());
            return FALSE;
        }
        $insert_data = array(
            'make_id' => $this->input->post('make'),
            'model_id' => $this->input->post('model'),
            'price' => $this->input->post('price'),
            'status' => 1,
            'attribute_id' => 1,
            'attribute_id' => 1,
            'created_at' => $this->today_datetime
        );
        ///////////////////  saving image ///
        $imageData = $this->Cars_model->upload_image('image_url');
        if ($imageData) {
            $insert_data['image_url'] = base_url() . UPLOAD_PATH . $imageData['upload_data']['orig_name'];
        }
        /////////////////////////////////////////////
        $result = $this->Cars_model->save($insert_data);
        if ($result) {
            $this->session->set_flashdata('message', "Saved successfully.");
            return true;
        }
        $this->session->set_flashdata('message', ERROR_MESSAGE . ": Something went wrong");
        return false;
    }

}