<?php

namespace Pagination;

class MultiPage extends PaginationTheme
{

    public function getTheme()
    {
        if ($this->_pg->getCountSite() > 1) {

            $prevLink = $this->_pg->getPrevLink();
            $nextLink = $this->_pg->getNextLink();
            $link = $this->_pg->getLinkWhitoutPage();

            $pagination = <<<EOT
<nav>
    <ul class="pagination">
        <li class="{$this->_pg->getPrevDisabled()}">
            <a href="$link$prevLink" aria-label="Previous">
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
            <a href="$link$nextLink" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
EOT;

            return $pagination;
        }
    }

}
