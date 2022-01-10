<?php

class Home extends CI_Controller
{
    public function index()
    {
        // page title
        $data['title'] = 'Beranda';

        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('home.php');
        $this->load->view('templates/footer');
    }
}
