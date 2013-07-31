<?php

namespace NZZ\MyTownBundle\Model;

use NZZ\MyTownBundle\Model\ProjectDataQuery;
use PropelObjectCollection;
use NZZ\MyTownBundle\Model\ProjectData;

use NZZ\MyTownBundle\Model\om\BaseProject;

class Project extends BaseProject
{
    public function getProjectData()
    {
       return $projectData = ProjectDataQuery::create()
            ->joinWith('Project')
            ->findByProjectId($this->id);
    }

    public function setProjectData(PropelObjectCollection $projectDataCollection)
    {
        /** @var ProjectData $projectData*/
        foreach ($projectDataCollection as $projectData) {
            try {
                $projectData->save();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }
    }
}
