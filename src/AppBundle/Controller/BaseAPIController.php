<?php


namespace AppBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

class BaseAPIController extends FOSRestController
{
    protected function returnErrors($errors)
    {
        return array(
            'success' => false,
            'errors' => $errors,
        );
    }

}