<?php
namespace Mail;

class MailTransport
{

    /**
     *
     * @var string
     */
    private $transportClassName;

    /**
     *
     * @param string $transport
     * @return (\Swift_MailTransport|this)
     */
    public function __construct(string $transport)
    {
        switch ($transport) {
            case 'smtp':
                // newInstance('smtp.example.org', 587, 'ssl')
                //  ->setUsername('username')
                //  ->setPassword('password')
                $this->transportClassName = '\Swift_SmtpTransport';
                break;
            case 'sendMail':
                // newInstance('/usr/sbin/exim -bs')
                $this->transportClassName = '\Swift_SendmailTransport';
                break;
            case 'mail':
                $this->transportClassName = '\Swift_MailTransport';
                break;
            default:
                $this->transportClassName = '\Swift_MailTransport';
        }
    }

    /**
     * Configures and sets new instance
     *
     * @param string $p1 SMTP server for 'smtp' or command for 'sendMail' or
     *                   NULL for 'mail'
     * @param int    $p2 port for 'smtp' or NULL for 'sendMail' and 'mail'
     * @param string $p3 ssl for 'smtp' or NULL for 'sendMail' and 'mail'
     */
    public function conf(
        string $serverOrCommand = "",
        int $port = null,
        string $ssl = ""
    ): \Swift_Transport {

        if ($serverOrCommand === "" && $port === null && $ssl === "") {
            return $this->transportClassName::newInstance();
        } elseif (!empty($serverOrCommand) && $port === null && $ssl === "") {
            return $this->transportClassName::newInstance($serverOrCommand);
        } else {
            return $this->transportClassName::newInstance(
                $serverOrCommand,
                $port,
                $ssl
            );
        }
    }
}
