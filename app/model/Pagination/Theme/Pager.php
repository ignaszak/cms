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
        if ($this->pg->getCountPage() > 1) {
            return <<<EOT
<nav>
    <ul class="pager">
        <li class="{$this->pg->getPrevDisabled()}">
            <a href="{$this->pg->getPrevLink()}">Previous</a>
        </li>
        <li class="{$this->pg->getNextDisabled()}">
            <a href="{$this->pg->getNextLink()}">Next</a>
        </li>
    </ul>
</nav>
EOT;
        }
        return "";
    }
}
