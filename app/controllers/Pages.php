<?php

class Pages extends AbstractController {


    public function __construct() {

    }

    public function index() {

        $data = [
            'title' => 'Landing page',
        ];

        $this->render('index', $data);
    }

    public function about() {
        
        $data = [
            'title' => 'About page',
        ];
        $this->render('about', $data);
    }
}