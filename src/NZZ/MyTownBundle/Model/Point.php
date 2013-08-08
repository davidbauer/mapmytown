<?php

namespace NZZ\MyTownBundle\Model;

use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectQuery;
use NZZ\MyTownBundle\Model\om\BasePoint;

class Point extends BasePoint
{
    public function getProjectSlug()
    {
        /** @var Project $project */
        $project = ProjectQuery::create()->findOneById($this->project_id);

        return $project->getSlug();
    }

    public function getCreationDate($format = null)
    {
        return parent::getCreationDate('Y-m-d H:m:i');
    }

}
