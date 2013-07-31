<?php

namespace NZZ\AdminMyTownBundle\Controller\Point;

use Admingenerated\NZZAdminMyTownBundle\BasePointController\ListController as BaseListController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ListController extends BaseListController
{
    public function filtersAction()
    {
        if ($this->get('request')->get('reset')) {
            $this->setFilters(array());

            return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Point_list"));
        }

        if ($this->getRequest()->getMethod() == "POST") {
            $form = $this->getFilterForm();
            $form->bind($this->get('request'));

            if ($form->isValid()) {
                $filters = $form->getViewData();
            }
        }

        if ($this->getRequest()->getMethod() == "GET") {
            $filters = $this->getRequest()->query->all();
        }

        $filters['project_id'] = 2;
        if (isset($filters)) {
            $this->setFilters($filters);
        }

        return new RedirectResponse($this->generateUrl("NZZ_AdminMyTownBundle_Point_list"));
    }

}
