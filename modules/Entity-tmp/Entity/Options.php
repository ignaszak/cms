<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options")
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
     * @ORM\Column(name="admin_email", type="string", length=255, nullable=false)
     */
    private $adminEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="post_limit", type="integer", nullable=false)
     */
    private $postLimit = '10';

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


}

