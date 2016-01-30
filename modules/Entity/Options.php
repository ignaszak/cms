<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Options
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="site_title", type="string", length=255, nullable=false)
     */
    private $siteTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="site_description", type="string", length=255, nullable=true)
     */
    private $siteDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_email", type="string", length=255, nullable=false)
     */
    private $adminEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="view_limit", type="integer", nullable=false)
     */
    private $viewLimit = '10';

    /**
     * @var string
     *
     * @ORM\Column(name="date_format", type="string", length=20, nullable=false)
     */
    private $dateFormat = 'j.n.Y H:i';

    /**
     * @var string
     *
     * @ORM\Column(name="base_url", type="string", length=255, nullable=false)
     */
    private $baseUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="request_uri", type="string", length=255, nullable=false)
     */
    private $requestUri;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=50, nullable=false)
     */
    private $theme;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siteTitle
     *
     * @param string $siteTitle
     *
     * @return Options
     */
    public function setSiteTitle($siteTitle)
    {
        $this->siteTitle = $siteTitle;

        return $this;
    }

    /**
     * Get siteDescription
     *
     * @return string
     */
    public function getSiteDescription()
    {
        return $this->siteDescription;
    }

    /**
     * Set siteDescription
     *
     * @param string $siteDescription
     *
     * @return Options
     */
    public function setSiteDescription($siteDescription)
    {
        $this->siteDescription = $siteDescription;

        return $this;
    }

    /**
     * Get siteTitle
     *
     * @return string
     */
    public function getSiteTitle()
    {
        return $this->siteTitle;
    }

    /**
     * Set adminEmail
     *
     * @param string $adminEmail
     *
     * @return Options
     */
    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;

        return $this;
    }

    /**
     * Get adminEmail
     *
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->adminEmail;
    }

    /**
     * Set viewLimit
     *
     * @param integer $viewLimit
     *
     * @return Options
     */
    public function setViewLimit($viewLimit)
    {
        $this->viewLimit = $viewLimit;

        return $this;
    }

    /**
     * Get viewLimit
     *
     * @return integer
     */
    public function getViewLimit()
    {
        return $this->viewLimit;
    }

    /**
     * Set dateFormat
     *
     * @param string $dateFormat
     *
     * @return Options
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * Get dateFormat
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set baseUrl
     *
     * @param string $baseUrl
     *
     * @return Options
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Get baseUrl
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set requestUri
     *
     * @param string $requestUri
     *
     * @return Options
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;

        return $this;
    }

    /**
     * Get requestUri
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Options
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
