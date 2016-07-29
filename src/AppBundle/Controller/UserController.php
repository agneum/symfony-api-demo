<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 */
class UserController extends BaseAPIController
{
    /**
     * @Route("/")
     * @Method("GET")
     * @Rest\View
     * @ApiDoc(
     *   description="Retrieve list of users",
     *   resource=true
     * )
     */
    public function fetchAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->view($users);
    }

    /**
     * @Route("/")
     * @Method("POST")
     * @Rest\View
     * @ApiDoc(
     *   description="Create a user",
     *   resource=true,
     *   parameters={
     *     {"name"="email", "dataType"="email", "required"=true, "description"="Email"},
     *     {"name"="firstname", "dataType"="string", "required"=true, "description"="User's firstname"},
     *     {"name"="lastname", "dataType"="string", "required"=true, "description"="User's lastname"},
     *     {"name"="isActive", "dataType"="boolean", "required"=true, "description"="Is active"},
     *     {"name"="group", "dataType"="integer", "required"=true, "description"="Group id"},
     *   }
     * )
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\UserType', new User(), array(
            'validation_groups' => ['creation']
        ));

        $form->submit($request->request->all());
        if ($form->isValid()) {
            $user = $form->getData();
            $this->get('app.class_manager')->save($user);

            return $user;
        }

        return $this->returnErrors($form->getErrors());
    }

    /**
     * @Route("/{id}/", requirements={"id":"\d+"})
     * @Method("GET")
     * @Rest\View
     * @ParamConverter("user", class="AppBundle:User")
     * @ApiDoc(
     *   description="Fetch info of a user",
     *   resource=true
     * )
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * @Route("/{id}/modify", requirements={"id":"\d+"})
     * @Method("PUT")
     * @ParamConverter("user", class="AppBundle:User")
     * @Rest\View
     * @ApiDoc(
     *   description="Modify a user",
     *   resource=true,
     *   parameters={
     *     {"name"="email", "dataType"="email", "required"=false, "description"="Email"},
     *     {"name"="firstname", "dataType"="string", "required"=false, "description"="User's firstname"},
     *     {"name"="lastname", "dataType"="string", "required"=false, "description"="User's lastname"},
     *     {"name"="isActive", "dataType"="string", "required"=false, "description"="Is active"},
     *     {"name"="group", "dataType"="integer", "required"=false, "description"="Group id"},
     *   }
     * )
     */
    public function modifyUserAction(User $user, Request $request)
    {
        $form = $this->createForm('AppBundle\Form\UserType', $user);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $this->get('app.class_manager')->save($user);

            return $user;
        }

        return $this->returnErrors($form->getErrors());
    }
}
