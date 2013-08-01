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
        /**  @var PropelObjectCollection $currentProjectDataCollection **/
        $currentProjectDataCollection = ProjectDataQuery::create()->findByprojectId($this->id);
        $toDelete = $currentProjectDataCollection->diff($projectDataCollection);
        foreach($toDelete as $obToDelete) {
            $obToDelete->delete();
        }
        /** @var ProjectData $projectData*/
            foreach ($projectDataCollection as $projectData) {
                if ($projectData->isNew() || $projectData->isModified()) {
                    try {
                            $projectData->setprojectId($this->id);
                            $projectData->save();
                        } catch (\Exception $e) {
                            var_dump($e->getMessage());
                            die;
                    }
                } else {
                }
            }
    }
}
