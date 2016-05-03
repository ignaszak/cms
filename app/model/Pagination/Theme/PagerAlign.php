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
        if ($this->pg->getCountPage() > 1) {
            return <<<EOT
<nav>
    <ul class="pager">
        <li class="previous {$this->pg->getNextDisabled()}">
            <a href="{$this->pg->getNextLink()}">
                <span aria-hidden=\"true\">&larr;</span> Older
            </a>
        </li>
        <li class="next {$this->pg->getPrevDisabled()}">
            <a href="{$this->pg->getPrevLink()}">
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
