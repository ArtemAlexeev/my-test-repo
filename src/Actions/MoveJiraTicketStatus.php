<?php

namespace Actions;

/**
 * Class MoveJiraTicketStatus
 *
 * @package Actions
 */
class MoveJiraTicketStatus
{
    /**
     * @return void
     */
    public function helloJira(): void
    {
        echo 'Hello, Jira! :)';
    }

    /**
     * @return string
     */
    public function getInProgressStatus(): string
    {
        return 'In Progress';
    }

    /**
     * @return string
     */
    public function getCodeReviewStatus(): string
    {
        return 'Code Review';
    }
}
