<?php
namespace Pagination\Theme;

class PagerAlign extends Theme
{

    /**
     *
     * {@inheritDoc}
     * @see \Pagination\Theme\Theme::getTheme()
     */
    public function getTheme(): string
    {
        if ($this->_pg->getCountPage() > 1) {

            return <<<EOT
<nav>
    <ul class="pager">
        <li class="previous {$this->_pg->getNextDisabled()}">
            <a href="{$this->_pg->getLinkWhitoutPage()}{$this->_pg->getNextLink()}">
                <span aria-hidden=\"true\">&larr;</span> Older
            </a>
        </li>
        <li class="next {$this->_pg->getPrevDisabled()}">
            <a href="{$this->_pg->getLinkWhitoutPage()}{$this->_pg->getPrevLink()}">
                Newer <span aria-hidden=\"true\">&rarr;</span>
            </a>
        </li>
    </ul>
</nav>
EOT;
        }
        return "";
    }
}
