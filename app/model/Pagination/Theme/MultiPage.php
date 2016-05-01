<?php
namespace Pagination\Theme;

class MultiPage extends Theme
{

    /**
     *
     * {@inheritDoc}
     * @see \Pagination\Theme\Theme::getTheme()
     */
    public function getTheme(): string
    {
        if ($this->_pg->getCountPage() > 1) {
            $prevLink = $this->_pg->getPrevLink();
            $nextLink = $this->_pg->getNextLink();

            $pagination = <<<EOT
<nav>
    <ul class="pagination">
        <li class="{$this->_pg->getPrevDisabled()}">
            <a href="{$prevLink}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
EOT;
            foreach ($this->_pg->getPaginationArray() as $page) {
                $class = $page['number'] == $this->_pg->getCurrentPage() ? "active" : "";
                $pagination .= <<<EOT
        <li class="$class">
            <a href="{$page['link']}">{$page['number']}</a>
        </li>
EOT;
            }

            $pagination .= <<<EOT
        <li class="{$this->_pg->getNextDisabled()}">
            <a href="{$nextLink}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
EOT;

            return $pagination;
        }
        return "";
    }
}
