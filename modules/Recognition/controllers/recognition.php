<?php 
class Recognition extends Trongate{

    function index() {
        $data['view_module'] = 'recognition';
        $data['view_file'] = 'homepage';
        $this->template('public', $data);
    }

}
