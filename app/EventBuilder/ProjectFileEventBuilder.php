<?php

namespace Kanboard\EventBuilder;

use Kanboard\Event\ProjectFileEvent;
use Kanboard\Event\GenericEvent;

/**
 * Class ProjectFileEventBuilder
 *
 * @package Kanboard\EventBuilder
 * @author  Frederic Guillot
 */
class ProjectFileEventBuilder extends BaseEventBuilder
{
    protected $fileId = 0;

    /**
     * Set fileId
     *
     * @param  int $fileId
     * @return $this
     */
    public function withFileId($fileId)
    {
        $this->fileId = $fileId;
        return $this;
    }

    /**
     * Build event data
     *
     * @access public
     * @return GenericEvent|null
     */
    public function build()
    {
        $file = $this->projectFileModel->getById($this->fileId);

        if (empty($file)) {
            $this->logger->debug(__METHOD__.': File not found');
            return null;
        }

        return new ProjectFileEvent(array(
            'file' => $file,
            'project' => $this->projectModel->getById($file['project_id']),
        ));
    }
}
