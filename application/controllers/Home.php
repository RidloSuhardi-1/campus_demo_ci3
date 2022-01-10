<?php

class Home extends CI_Controller
{
    public function index()
    {
        // page title
        $data['title'] = 'Beranda';

        // load view
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('home.php', $data);
        $this->load->view('templates/footer');
    }
}
