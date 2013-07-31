<?php

namespace NZZ\AdminMyTownBundle\Controller\Point;

use Admingenerated\NZZAdminMyTownBundle\BasePointController\ListController as BaseListController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ListController extends BaseListController
{
    public function indexAction()
    {

        $this->parseRequestForPager();

        $form = $this->getFilterForm();

        return $this->render('NZZAdminMyTownBundle:PointList:index.html.twig', $this->getAdditionalRenderParameters() + array(
                'Points' => $this->getPager(),
                'form'                      => $form->createView(),
                'sortColumn'                => $this->getSortColumn(),
                'sortOrder'                 => $this->getSortOrder(),
                'scopes'                    => $this->getScopes(),
            ));
    }

    protected function processFilters($query)
    {
        if ($this->getRequest()->getMethod() == "GET") {
            $filterProjectId = $this->getRequest()->query->get('projectId');
        }
        if (isset($filterProjectId) && null !== $filterProjectId) {
            $fl = $this->getFilters();
                $fl['project_id'] = $filterProjectId;
                $this->setFilters($fl);
        }

        $filterObject = $this->getFilters();

        $queryFilter = $this->get('admingenerator.queryfilter.propel');
        $queryFilter->setQuery($query);

        if (isset($filterObject['project_id']) && null !== $filterObject['project_id']) {
            $queryFilter->addIntegerFilter("project_id", $filterObject['project_id']);
        }

        if (isset($filterObject['id']) && null !== $filterObject['id']) {
            $queryFilter->addIntegerFilter("id", $filterObject['id']);
        }

        if (isset($filterObject['title']) && null !== $filterObject['title']) {
            $queryFilter->addVarcharFilter("title", $filterObject['title']);
        }

        if (isset($filterObject['description']) && null !== $filterObject['description']) {
            $queryFilter->addVarcharFilter("description", $filterObject['description']);
        }

        if (isset($filterObject['latitude']) && null !== $filterObject['latitude']) {
            $queryFilter->addFloatFilter("latitude", $filterObject['latitude']);
        }

        if (isset($filterObject['longitude']) && null !== $filterObject['longitude']) {
            $queryFilter->addFloatFilter("longitude", $filterObject['longitude']);
        }

        if (isset($filterObject['author_name']) && null !== $filterObject['author_name']) {
            $queryFilter->addVarcharFilter("author_name", $filterObject['author_name']);
        }

        if (isset($filterObject['author_location']) && null !== $filterObject['author_location']) {
            $queryFilter->addVarcharFilter("author_location", $filterObject['author_location']);
        }

        if (isset($filterObject['sentiment']) && null !== $filterObject['sentiment']) {
            $queryFilter->addIntegerFilter("sentiment", $filterObject['sentiment']);
        }

        if (isset($filterObject['is_published']) && null !== $filterObject['is_published']) {
            $queryFilter->addBooleanFilter("is_published", $filterObject['is_published']);
        }



    }
}
