<?php
namespace Pagination;

class Pager extends Theme
{

    /**
     *
     * @return string
     */
    public function getTheme(): string
    {
        if ($this->_pg->getCountPage() > 1) {

            return <<<EOT
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
        }
        return "";
    }
}
