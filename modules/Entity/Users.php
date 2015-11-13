<?php

namespace Entity;

/**
 * Users
 *
 * @Table(name="users")
 * @Entity
 */
class Users
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
     * @Column(name="login", type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @Column(name="reg_date", type="datetime", nullable=false)
     */
    private $reg_date;

    /**
     * @var \DateTime
     *
     * @Column(name="log_date", type="datetime", nullable=false)
     */
    private $log_date;

    /**
     * @var string
     *
     * @Column(name="role", type="string", nullable=false)
     */
    private $role;



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
     * Set login
     *
     * @param string $login
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set reg_date
     *
     * @param \DateTime $reg_date
     * @return Users
     */
    public function setRegDate($reg_date)
    {
        $this->reg_date = $reg_date;

        return $this;
    }

    /**
     * Get reg_date
     *
     * @return \DateTime 
     */
    public function getRegDate($format = "")
    {
        return $this->reg_date->format( (empty($format) ? \Conf\Conf::instance()->getDateFormat() : $format));
    }

    /**
     * Set log_date
     *
     * @param \DateTime $log_date
     * @return Users
     */
    public function setLogDate($log_date)
    {
        $this->log_date = $log_date;

        return $this;
    }

    /**
     * Get log_date
     *
     * @return \DateTime 
     */
    public function getLogDate($format = "")
    {
        return $this->log_date->format( (empty($format) ? \Conf\Conf::instance()->getOptions()->getDateFormat() : $format));
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}
