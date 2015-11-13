<?php

namespace Entity;

/**
 * Options
 *
 * @Table(name="options")
 * @Entity
 */
class Options
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="site_title", type="string", length=255, nullable=false)
     */
    private $siteTitle;

    /**
     * @var string
     *
     * @Column(name="admin_email", type="string", length=255, nullable=false)
     */
    private $adminEmail;

    /**
     * @var integer
     *
     * @Column(name="post_limit", type="integer", nullable=false)
     */
    private $postLimit = '10';

    /**
     * @var string
     *
     * @Column(name="date_format", type="string", length=20, nullable=false)
     */
    private $dateFormat = 'j.n.Y H:i';

    /**
     * @var string
     *
     * @Column(name="base_url", type="string", length=255, nullable=false)
     */
    private $baseUrl;

    /**
     * @var string
     *
     * @Column(name="request_uri", type="string", length=255, nullable=false)
     */
    private $requestUri;
    
    /**
     * @var string
     *
     * @Column(name="theme", type="string", length=50, nullable=false)
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
     * @return Options
     */
    public function setSiteTitle($siteTitle)
    {
        $this->siteTitle = $siteTitle;

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
     * Set postLimit
     *
     * @param integer $postLimit
     * @return Options
     */
    public function setPostLimit($postLimit)
    {
        $this->postLimit = $postLimit;

        return $this;
    }

    /**
     * Get postLimit
     *
     * @return integer 
     */
    public function getPostLimit()
    {
        return $this->postLimit;
    }

    /**
     * Set dateFormat
     *
     * @param string $dateFormat
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
     * @param string $requestUri
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
