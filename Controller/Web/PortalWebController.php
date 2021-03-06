<?php

namespace OswisOrg\OswisCoreBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PortalWebController extends AbstractController
{
    /**
     * Temporary Portal placement route.
     *
     * @return Response
     */
    final public function portal(): Response
    {
        return $this->render('@OswisOrgOswisCore/web/pages/portal.html.twig');
    }
}
