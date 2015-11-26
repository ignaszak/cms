<?php

namespace Pagination;

class Pager extends PaginationTheme
{

    public function getTheme()
    {
        if ($this->_pg->getCountSite() > 1) {

            $pagination = <<<EOT
<nav>
    <ul class="pager">
        <li class="{$this->_pg->getPrevDisabled()}">
            <a href="{$this->_pg->getLinkWhitoutPage()}{$this->_pg->getPrevLink()}">Previous</a>
        </li>
        <li class="{$this->_pg->getNextDisabled()}">
            <a href="{$this->_pg->getLinkWhitoutPage()}{$this->_pg->getNextLink()}">Next</a>
        </li>
    </ul>
</nav>
EOT;

            return $pagination;
        }
    }

}
