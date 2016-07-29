<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/groups")
 */
class GroupController extends BaseAPIController
{
    /**
     * @Route("/")
     * @Method("GET")
     * @Rest\View
     * @ApiDoc(
     *   description="Retrieve list of groups",
     *   resource=true
     * )
     */
    public function fetchAction()
    {
        $groups = $this->getDoctrine()->getRepository('AppBundle:Group')->findAll();

        return $groups;
    }


    /**
     * @Route("/")
     * @Method("POST")
     * @Rest\View
     * @ApiDoc(
     *   description="Create a group",
     *   resource=true,
     *   parameters={
     *     {"name"="name", "dataType"="string", "required"=true, "description"="Group name"},
     *   }
     * )
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\GroupType', new Group(), array(
            'validation_groups' => array('creation')
        ));

        $form->submit($request->request->all());
        if ($form->isValid()) {
            $group = $form->getData();
            $this->get('app.class_manager')->save($group);

            return $group;
        }

        return $this->returnErrors($form->getErrors());
    }

    /**
     * @Route("/{id}/modify", requirements={"id":"\d+"})
     * @Method("PUT")
     * @ParamConverter("group", class="AppBundle:Group")
     * @Rest\View
     * @ApiDoc(
     *   description="Modify a group",
     *   resource=true,
     *   parameters={
     *     {"name"="name", "dataType"="string", "required"=true, "description"="Name"},
     *   }
     * )
     */
    public function modifyUserAction(Group $group, Request $request)
    {
        $form = $this->createForm('AppBundle\Form\GroupType', $group);

        $form->submit($request->request->all(), false);
        if ($form->isValid()) {
            $this->get('app.class_manager')->save($group);

            return $group;
        }

        return $this->returnErrors($form->getErrors());
    }
}
