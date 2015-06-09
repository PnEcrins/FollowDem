<?php
/**
 * Mortar
 *
 * @copyright Copyright (c) 2009, Robert Hafner
 * @license http://www.mozilla.org/MPL/
 * @package             Library
 * @subpackage  Imap
 */

/**
 * This library is a wrapper around the Imap library functions included in php. This class in particular manages a
 * connection to the server (imap, pop, etc) and allows for the easy retrieval of stored messages.
 *
 * @package             Library
 * @subpackage  Imap
 */
class imap
{
        /**
         * When SSL isn't compiled into PHP we need to make some adjustments to prevent soul crushing annoyances.
         *
         * @var bool
         */
        static $sslEnable = true;

        /**
         * These are the flags that depend on ssl support being compiled into imap.
         *
         * @var array
         */
        static $sslFlags = array('ssl', 'validate-cert', 'novalidate-cert', 'tls', 'notls');

        /**
         * This is used to prevent the class from putting up conflicting tags. Both directions- key to value, value to key-
         * are checked, so if "novalidate-cert" is passed then "validate-cert" is removed, and vice-versa.
         *
         * @var array
         */
        static $exclusiveFlags = array('validate-cert' => 'novalidate-cert', 'tls' => 'notls');

        /**
         * This is the domain or server path the class is connecting to.
         *
         * @var string
         */
        protected $serverPath;

        /**
         * This is the name of the current mailbox the connection is using.
         *
         * @var string
         */
        protected $mailbox;

        /**
         * This is the username used to connect to the server.
         *
         * @var string
         */
        protected $username;

        /**
         * This is the password used to connect to the server.
         *
         * @var string
         */
        protected $password;

        /**
         * This is an array of flags that modify how the class connects to the server. Examples include "ssl" to enforce a
         * secure connection or "novalidate-cert" to allow for self-signed certificates.
         *
         * @link http://us.php.net/manual/en/function.imap-open.php
         * @var array
         */
        protected $flags = array();

        /**
         * This is the port used to connect to the server
         *
         * @var int
         */
        protected $port;

        /**
         * This is the set of options, represented by a bitmask, to be passed to the server during connection.
         *
         * @var int
         */
        protected $options = 0;

        /**
         * This is the resource connection to the server. It is required by a number of imap based functions to specify how
         * to connect.
         *
         * @var resource
         */
        protected $imapStream;

        /**
         * This is the name of the service currently being used. Imap is the default, although pop3 and nntp are also
         * options
         *
         * @var string
         */
        protected $service = 'imap';

        /**
         * This constructor takes the location and service thats trying to be connected to as its arguments.
         *
         * @param string $serverPath
         * @param null|int $port
         * @param null|string $service
         */
        public function __construct($serverPath, $port = 143, $service = 'imap')
        {
                $this->serverPath = $serverPath;

                $this->port = $port;

                switch ($port) {
                        case 143:
                                $this->setFlag('novalidate-cert');
                                break;

                        case 993:
                                $this->setFlag('ssl');
                                break;
                }

                $this->service = $service;
        }

        /**
         * This function sets the username and password used to connect to the server.
         *
         * @param string $username
         * @param string $password
         */
        public function setAuthentication($username, $password)
        {
                $this->username = $username;
                $this->password = $password;
        }

        /**
         * This function sets the mailbox to connect to.
         *
         * @param string $mailbox
         */
        public function setMailBox($mailbox = '')
        {
                $this->mailbox = $mailbox;
                if(isset($this->imapStream))
                {
                        $this->setImapStream();
                }
        }

        /**
         * This function sets or removes flag specifying connection behavior. In many cases the flag is just a one word
         * deal, so the value attribute is not required. However, if the value parameter is passed false it will clear that
         * flag.
         *
         * @param string $flag
         * @param null|string|bool $value
         */
        public function setFlag($flag, $value = null)
        {
                if(!self::$sslEnable && in_array($flag, self::$sslFlags))
                        return;

                if(isset(self::$exclusiveFlags[$flag]))
                {
                        $kill = $flag;
                }elseif($index = array_search($flag, self::$exclusiveFlags)){
                        $kill = $index;
                }

                if(isset($kill) && isset($this->flags[$kill]))
                        unset($this->flags[$kill]);

                if(isset($value) && $value !== true)
                {
                        if($value == false)
                        {
                                unset($this->flags[$flag]);
                        }else{
                                $this->flags[] = $flag . '=' . $value;
                        }
                }else{
                        $this->flags[] = $flag;
                }
        }

        /**
         * This funtion is used to set various options for connecting to the server.
         *
         * @param int $bitmask
         */
        public function setOptions($bitmask = 0)
        {
                if(!is_numeric($bitmask))
                        throw new ImapException();

                $this->options = $bitmask;
        }

        /**
         * This function gets the current saved imap resource and returns it.
         *
         * @return resource
         */
        public function getImapStream()
        {
                if(!isset($this->imapStream))
                        $this->setImapStream();

                return $this->imapStream;
        }

        /**
         * This function takes in all of the connection date (server, port, service, flags, mailbox) and creates the string
         * thats passed to the imap_open function.
         *
         * @return string
         */
        protected function getServerString()
        {
                $mailboxPath = '{' . $this->serverPath;

                if(isset($this->port))
                        $mailboxPath .= ':' . $this->port;

                if($this->service != 'imap')
                        $mailboxPath .= '/' . $this->service;

                foreach($this->flags as $flag)
                {
                        $mailboxPath .= '/' . $flag;
                }

                $mailboxPath .= '}';

                if(isset($this->mailbox))
                        $mailboxPath .= $this->mailbox;

                return $mailboxPath;
        }

        /**
         * This function creates or reopens an imapStream when called.
         *
         */
        protected function setImapStream()
        {
                if(isset($this->imapStream))
                {
                        if(!imap_reopen($this->imapStream, $this->mailbox, $this->options, 1))
                                throw new ImapException(imap_last_error());
                }else{
                        $imapStream = imap_open($this->getServerString(), $this->username, $this->password, $this->options, 1);

                        if($imapStream === false)
                                throw new ImapException(imap_last_error());

                        $this->imapStream = $imapStream;
                }
        }

        /**
         * This returns the number of messages that the current mailbox contains.
         *
         * @return int
         */
        public function numMessages()
        {
                return imap_num_msg($this->getImapStream());
        }

        /**
         * This function returns an array of ImapMessage object for emails that fit the criteria passed. The criteria string
         * should be formatted according to the imap search standard, which can be found on the php "imap_search" page or in
         * section 6.4.4 of RFC 2060
         *
         * @link http://us.php.net/imap_search
         * @link http://www.faqs.org/rfcs/rfc2060
         * @param string $criteria
         * @param null|int $limit
         * @return array An array of ImapMessage objects
         */
        public function search($criteria = 'ALL', $limit = null)
        {
                if($results = imap_search($this->getImapStream(), $criteria, SE_UID))
                {
                        if(isset($limit) && count($results) > $limit)
                                $results = array_slice($results, 0, $limit);

                        $stream = $this->getImapStream();
                        $messages = array();

                        foreach($results as $messageId)
                                $messages[] = new ImapMessage($messageId, $this);

                        return $messages;
                }else{
                        false;
                }
        }

        /**
         * This function returns the recently received emails as an array of ImapMessage objects.
         *
         * @param null|int $limit
         * @return array An array of ImapMessage objects for emails that were recently received by the server.
         */
        public function getRecentMessages($limit = null)
        {
                return $this->search('Recent', $limit);
        }

        /**
         * Returns the emails in the current mailbox as an array of ImapMessage objects.
         *
         * @param null|int $limit
         * @return array
         */
        public function getMessages($limit = null)
        {
                $numMessages = $this->numMessages();

                if(isset($limit) && is_numeric($limit) && $limit < $numMessages)
                        $numMessages = $limit;

                if($numMessages < 1)
                        return false;

                $stream = $this->getImapStream();
                $messages = array();
                for($i = 1; $i <= $numMessages; $i++)
                {
                        $uid = imap_uid($stream, $i);
                        $messages[] = new ImapMessage($uid, $this);
                }

                return $messages;
        }

        /**
         * This function removes all of the messages flagged for deletion from the mailbox.
         *
         * @return bool
         */
        public function expunge()
        {
                return imap_expunge($this->getImapStream());
        }
}

/**
 * This library is a wrapper around the Imap library functions included in php. This class represents a single email
 * message as retrieved from the Imap.
 *
 * @package             Library
 * @subpackage  Imap
 */
class ImapMessage
{
        /**
         * This is the connection/mailbox class that the email came from.
         *
         * @var Imap
         */
        protected $imapConnection;

        /**
         * This is the unique identifier for the message. This corresponds to the imap "uid", which we use instead of the
         * sequence number.
         *
         * @var int
         */
        protected $uid;

        /**
         * This is a reference to the Imap stream generated by 'imap_open'.
         *
         * @var resource
         */
        protected $imapStream;

        /**
         * This as an object which contains header information for the message.
         *
         * @var stdClass
         */
        protected $headers;

        /**
         * This is an object which contains various status messages and other information about the message.
         *
         * @var stdClass
         */
        protected $messageOverview;

        /**
         * This is an object which contains information about the structure of the message body.
         *
         * @var stdClass
         */
        protected $structure;

        /**
         * This is an array with the index being imap flags and the value being a boolean specifying whether that flag is
         * set or not.
         *
         * @var array
         */
        protected $status = array();

        /**
         * This is an array of the various imap flags that can be set.
         *
         * @var string
         */
        static protected $flagTypes = array('recent', 'flagged', 'answered', 'deleted', 'seen', 'draft');

        /**
         * This holds the plantext email message.
         *
         * @var string
         */
        protected $plaintextMessage;

        /**
         * This holds the html version of the email.
         *
         * @var string
         */
        protected $htmlMessage;

        /**
         * This is the date the email was sent.
         *
         * @var int
         */
        protected $date;

        /**
         * This is the subject of the email.
         *
         * @var string
         */
        protected $subject;

        /**
         * This is the size of the email.
         *
         * @var int
         */
        protected $size;

        /**
         * This is an array containing information about the address the email came from.
         *
         * @var string
         */
        protected $from;

        /**
         * This is an array of arrays that contain information about the addresses the email was cc'd to.
         *
         * @var array
         */
        protected $cc;

        /**
         * This is an array of arrays that contain information about the addresses that should receive replies to the email.
         *
         * @var array
         */
        protected $replyTo;

        /**
         * This is an array of ImapAttachments retrieved from the message.
         *
         * @var array
         */
        protected $attachments = array();

        /**
         * This value defines the encoding we want the email message to use.
         *
         * @var string
         */
        static public $charset = 'UTF-8//TRANSLIT';

        /**
         * This constructor takes in the uid for the message and the Imap class representing the mailbox the
         * message should be opened from. This constructor should generally not be called directly, but rather retrieved
         * through the apprioriate Imap functions.
         *
         * @param int $messageUniqueId
         * @param Imap $mailbox
         */
        public function __construct($messageUniqueId, Imap $mailbox)
        {
                $this->imapConnection = $mailbox;
                $this->uid = $messageUniqueId;
                $this->imapStream = $this->imapConnection->getImapStream();
                $this->loadMessage();
        }

        /**
         * This function is called when the message class is loaded. It loads general information about the message from the
         * imap server.
         *
         */
        protected function loadMessage()
        {

                /* First load the message overview information */

                $messageOverview = $this->getOverview();

                $this->subject = $messageOverview->subject;
                $this->date = strtotime($messageOverview->date);
                $this->size = $messageOverview->size;

                foreach(self::$flagTypes as $flag)
                        $this->status[$flag] = ($messageOverview->$flag == 1);



                /* Next load in all of the header information */

                $headers = $this->getHeaders();

                if(isset($headers->to))
                        $this->to = $this->processAddressObject($headers->to);

                if(isset($headers->cc))
                        $this->cc = $this->processAddressObject($headers->cc);

                $this->from = $this->processAddressObject($headers->from);
                $this->replyTo = isset($headers->reply_to) ? $this->processAddressObject($headers->reply_to) : $this->from;

                /* Finally load the structure itself */

                $structure = $this->getStructure();

                if(!isset($structure->parts))
                {
                        // not multipart
                        $this->processStructure($structure);
                }else{
                // multipart
                        foreach($structure->parts as $id => $part)
                                $this->processStructure($part, $id + 1);
                }
        }

        /**
         * This function returns an object containing information about the message. This output is similar to that over the
         * imap_fetch_overview function, only instead of an array of message overviews only a single result is returned. The
         * results are only retrieved from the server once unless passed true as a parameter.
         *
         * @param bool $forceReload
         * @return stdClass
         */
        public function getOverview($forceReload = false)
        {
                if($forceReload || !isset($this->messageOverview))
                {
                        // returns an array, and since we just want one message we can grab the only result
                        $results = imap_fetch_overview($this->imapStream, $this->uid, FT_UID);
                        $this->messageOverview = array_shift($results);
                }
                return $this->messageOverview;
        }

        /**
         * This function returns an object containing the headers of the message. This is done by taking the raw headers
         * and running them through the imap_rfc822_parse_headers function. The results are only retrieved from the server
         * once unless passed true as a parameter.
         *
         * @param bool $forceReload
         * @return stdClass
         */
        public function getHeaders($forceReload = false)
        {
                if($forceReload || !isset($this->headers))
                {
                        // raw headers (since imap_headerinfo doesn't use the unique id)
                        $rawHeaders = imap_fetchheader($this->imapStream, $this->uid, FT_UID);

                        // convert raw header string into a usable object
                        $headerObject = imap_rfc822_parse_headers($rawHeaders);

                        // to keep this object as close as possible to the original header object we add the udate property
                        $headerObject->udate = strtotime($headerObject->date);

                        $this->headers = $headerObject;
                }

                return $this->headers;
        }

        /**
         * This function returns an object containing the structure of the message body. This is the same object thats
         * returned by imap_fetchstructure. The results are only retrieved from the server once unless passed true as a
         * parameter.
         *
         * @return stdClass
         */
        public function getStructure($forceReload = false)
        {
                if($forceReload || !isset($this->structure))
                {
                        $this->structure = imap_fetchstructure($this->imapStream, $this->uid, FT_UID);
                }
                return $this->structure;
        }

        /**
         * This function returns the message body of the email. By default it returns the plaintext version. If a plaintext
         * version is requested but not present, the html version is stripped of tags and returned. If the opposite occurs,
         * the plaintext version is given some html formatting and returned. If neither are present the return value will be
         * false.
         *
         * @param bool $html Pass true to receive an html response.
         * @return string|bool Returns false if no body is present.
         */
        public function getMessageBody($html = false)
        {
                if($html)
                {
                        if(!isset($this->htmlMessage) && isset($this->plaintextMessage))
                        {
                                $output = nl2br($this->plaintextMessage);
                                return $output;

                        }elseif(isset($this->htmlMessage)){
                                return $this->htmlMessage;
                        }
                }else{
                        if(!isset($this->plaintextMessage) && isset($this->htmlMessage))
                        {
                                $output = strip_tags($this->htmlMessage);
                                return $output;
                        }elseif(isset($this->plaintextMessage)){
                                return $this->plaintextMessage;
                        }
                }
                return false;
        }

        /**
         * This function returns either an array of email addresses and names or, optionally, a string that can be used in
         * mail headers.
         *
         * @param string $type Should be 'to', 'cc', 'from', or 'reply-to'.
         * @param bool $asString
         * @return array|string|bool
         */
        public function getAddresses($type, $asString = false)
        {
                $addressTypes = array('to', 'cc', 'from', 'reply-to');

                if(!in_array($type, $addressTypes) || !isset($this->$type) || count($this->$type) < 1)
                        return false;


                if(!$asString)
                {
                        if($type == 'from')
                                return $this->from[0];

                        return $this->$type;
                }else{
                        $outputString = '';
                        foreach($this->$type as $address)
                        {
                                if(isset($set))
                                        $outputString .= ', ';
                                if(!isset($set))
                                        $set = true;

                                $outputString .= isset($address['name']) ?
                                                                  $address['name'] . ' <' . $address['address'] . '>'
                                                                : $address['address'];
                        }
                        return $outputString;
                }
        }

        /**
         * This function returns the date, as a timestamp, of when the email was sent.
         *
         * @return int
         */
        public function getDate()
        {
                return isset($this->date) ? $this->date : false;
        }

        /**
         * This returns the subject of the message.
         *
         * @return string
         */
        public function getSubject()
        {
                return $this->subject;
        }

        /**
         * This function marks a message for deletion. It is important to note that the message will not be deleted form the
         * mailbox until the Imap->expunge it run.
         *
         * @return bool
         */
        public function delete()
        {
                return imap_delete($this->imapStream, $this->uid, FT_UID);
        }

        /**
         * This function returns Imap this message came from.
         *
         * @return Imap
         */
        public function getImapBox()
        {
                return $this->imapConnection;
        }

        /**
         * This function takes in a structure and identifier and processes that part of the message. If that portion of the
         * message has its own subparts, those are recursively processed using this function.
         *
         * @param stdClass $structure
         * @param string $partIdentifier
         * @todoa process attachments.
         */
        protected function processStructure($structure, $partIdentifier = null)
        {
                $parameters = self::getParametersFromStructure($structure);
				//print_r($parameters);
                if(isset($parameters['name']) || isset($parameters['filename']))
                {
                        $attachment = new ImapAttachment($this, $structure, $partIdentifier);
                        $this->attachments[] = $attachment;
                }elseif($structure->type == 0 || $structure->type == 1){

                        $messageBody = isset($partIdentifier) ?
                                                          imap_fetchbody($this->imapStream, $this->uid, $partIdentifier, FT_UID)
                                                        : imap_body($this->imapStream, $this->uid, FT_UID);

                        $messageBody = self::decode($messageBody, $structure->encoding);

                        if(isset($parameters['charset']) && $parameters['charset'] !== self::$charset)
                                $messageBody = iconv($parameters['charset'], self::$charset, $messageBody);

                        if(strtolower($structure->subtype) == 'plain' || $structure->type == 1)
                        {
                                if(isset($this->plaintextMessage))
                                {
                                        $this->plaintextMessage .= PHP_EOL . PHP_EOL;
                                }else{
                                        $this->plaintextMessage = '';
                                }

                                $this->plaintextMessage .= trim($messageBody);
                        }else{

                                if(isset($this->htmlMessage))
                                {
                                        $this->htmlMessage .= '<br><br>';
                                }else{
                                        $this->htmlMessage = '';
                                }

                                $this->htmlMessage .= $messageBody;
                        }
                }

                if(isset($structure->parts)){  // multipart: iterate through each part

                        foreach ($structure->parts as $partIndex => $part)
                        {
                                $partId = $partIndex + 1;

                                if(isset($partIdentifier))
                                        $partId = $partIdentifier . '.' . $partId;

                                $this->processStructure($part, $partId);
                        }
                }
        }

        /**
         * This function takes in the message data and encoding type and returns the decoded data.
         *
         * @param string $data
         * @param int|string $encoding
         * @return string
         */
        static public function decode($data, $encoding)
        {
                if(!is_numeric($encoding))
                        $encoding = strtolower($encoding);

                switch($encoding)
                {
                        case 'quoted-printable':
                        case 4:
                                return quoted_printable_decode($data);

                        case 'base64':
                        case 3:
                                return base64_decode($data);

                        default:
                                return $data;
                }
        }

        /**
         * This function returns the body type that an imap integer maps to.
         *
         * @param int $id
         * @return string
         */
        static public function typeIdToString($id)
        {
                switch($id)
                {
                        case 0:
                                return 'text';

                        case 1:
                                return 'multipart';

                        case 2:
                                return 'message';

                        case 3:
                                return 'application';

                        case 4:
                                return 'audio';

                        case 5:
                                return 'image';

                        case 6:
                                return 'video';

                        default:
                        case 7:
                                return 'other';
                }
        }

        /**
         * Takes in a section structure and returns its parameters as an associative array.
         *
         * @param stdClass $structure
         * @return array
         */
        static function getParametersFromStructure($structure)
        {
                $parameters = array();
                if(isset($structure->parameters))
                        foreach($structure->parameters as $parameter)
                                $parameters[strtolower($parameter->attribute)] = $parameter->value;

                if(isset($structure->dparameters))
                        foreach($structure->dparameters as $parameter)
                                $parameters[strtolower($parameter->attribute)] = $parameter->value;

                return $parameters;
        }

        /**
         * This function takes in an array of the address objects generated by the message headers and turns them into an
         * associative array.
         *
         * @param array $addresses
         * @return array
         */
        protected function processAddressObject($addresses)
        {
                $outputAddresses = array();
                if(is_array($addresses))
                        foreach($addresses as $address)
                {
                        $currentAddress = array();
                        $currentAddress['address'] = $address->mailbox . '@' . $address->host;
                        if(isset($address->personal))
                                $currentAddress['name'] = $address->personal;
                        $outputAddresses[] = $currentAddress;
                }
                return $outputAddresses;
        }

        /**
         * This function returns the unique id that identifies the message on the server.
         *
         * @return int
         */
        public function getUid()
        {
                return $this->uid;
        }

        /**
         * This function returns the attachments a message contains. If a filename is passed then just that ImapAttachment
         * is returned, unless
         *
         * @param null|string $filename
         * @return array|bool|ImapAttachments
         */
        public function getAttachments($filename = null)
        {
                if(!isset($this->attachments) || count($this->attachments) < 1)
                        return false;

                if(!isset($filename))
                        return $this->attachments;

                $results = array();
                foreach($this->attachments as $attachment)
                {
                        if($attachment->getFileName() == $filename)
                                $results[] = $attachment;
                }

                switch (count($results)) {
                        case 0:
                                return false;

                        case 1:
                                return array_shift($results);

                        default:
                                return $results;
                                break;
                }
        }

        /**
         * This function checks to see if an imap flag is set on the email message.
         *
         * @param string $flag Recent, Flagged, Answered, Deleted, Seen, Draft
         * @return bool
         */
        public function checkFlag($flag = 'flagged')
        {
                return (isset($this->status[$flag]) && $this->status[$flag] == true);
        }

        /**
         * This function is used to enable or disable a flag on the imap message.
         *
         * @param string $flag Flagged, Answered, Deleted, Seen, Draft
         * @param bool $enable
         * @return bool
         */
        public function setFlag($flag, $enable = true)
        {
                if(!in_array($flag, self::$flagTypes) || $flag == 'recent')
                        throw new ImapException('Unable to set invalid flag "' . $flag . '"');

                $flag = '\\' . ucfirst($flag);

                if($enable)
                {
                        return imap_setflag_full($this->imapStream, $this->uid, $flag, ST_UID);
                }else{
                        return imap_clearflag_full($this->imapStream, $this->uid, $flag, ST_UID);
                }
        }

}


/**
 * This library is a wrapper around the Imap library functions included in php. This class wraps around an attachment
 * in a message, allowing developers to easily save or display attachments.
 *
 * @package             Library
 * @subpackage  Imap
 */
class ImapAttachment
{

        /**
         * This is the structure object for the piece of the message body that the attachment is located it.
         *
         * @var stdClass
         */
        protected $structure;

        /**
         * This is the unique identifier for the message this attachment belongs to.
         *
         * @var unknown_type
         */
        protected $messageId;

        /**
         * This is the ImapResource.
         *
         * @var resource
         */
        protected $imapStream;

        /**
         * This is the id pointing to the section of the message body that contains the attachment.
         *
         * @var unknown_type
         */
        protected $partId;

        /**
         * This is the attachments filename.
         *
         * @var unknown_type
         */
        protected $filename;

        /**
         * This is the size of the attachment.
         *
         * @var int
         */
        protected $size;

        /**
         * This stores the data of the attachment so it doesn't have to be retrieved from the server multiple times. It is
         * only populated if the getData() function is called and should not be directly used.
         *
         * @internal
         * @var unknown_type
         */
        protected $data;

        /**
         * This function takes in an ImapMessage, the structure object for the particular piece of the message body that the
         * attachment is located at, and the identifier for that body part. As a general rule you should not be creating
         * instances of this yourself, but rather should get them from an ImapMessage class.
         *
         * @param ImapMessage $message
         * @param stdClass $structure
         * @param string $partIdentifier
         */
        public function __construct(ImapMessage $message, $structure, $partIdentifier = null)
        {
                $this->messageId = $message->getUid();
                $this->imapStream = $message->getImapBox()->getImapStream();
                $this->structure = $structure;

                if(isset($partIdentifier))
                        $this->partId = $partIdentifier;

                $parameters = ImapMessage::getParametersFromStructure($structure);

                if(isset($parameters['filename']))
                {
                        $this->filename = $parameters['filename'];
                }elseif(isset($parameters['name'])){
                        $this->filename = $parameters['name'];
                }

                $this->size = $structure->bytes;

                $this->mimeType = ImapMessage::typeIdToString($structure->type);

                if(isset($structure->subtype))
                        $this->mimeType .= '/' . strtolower($structure->subtype);

                $this->encoding = $structure->encoding;
        }

        /**
         * This function returns the data of the attachment. Combined with getMimeType() it can be used to directly output
         * data to a browser.
         *
         * @return binary
         */
        public function getData()
        {
                if(!isset($this->data))
                {
                        $messageBody = isset($this->partId) ?
                                                          imap_fetchbody($this->imapStream, $this->messageId, $this->partId, FT_UID)
                                                        : imap_body($this->imapStream, $this->messageId, FT_UID);

                        $messageBody = ImapMessage::decode($messageBody, $this->encoding);
                        $this->data = $messageBody;
                }
                return $this->data;
        }

        /**
         * This returns the filename of the attachment, or false if one isn't given.
         *
         * @return string
         */
        public function getFileName()
        {
                return (isset($this->filename)) ? $this->filename : false;
        }

        /**
         * This function returns the mimetype of the attachment.
         *
         * @return string
         */
        public function getMimeType()
        {
                return $this->mimeType;
        }

        /**
         * This returns the size of the attachment.
         *
         * @return int
         */
        public function getSize()
        {
                return $this->size;
        }

        /**
         * This function saves the attachment to the passed directory, keeping the original name of the file.
         *
         * @param string $path
         */
        public function saveToDirectory($path)
        {
                $path = rtrim($path, '/') . '/';

                if(is_dir($path))
                        return $this->saveAs($path . $this->getFileName());

                return false;
        }

        /**
         * This function saves the attachment to the exact specified location.
         *
         * @param path $path
         */
        public function saveAs($path)
        {
                $dirname = dirname($path);
                if(file_exists($path))
                {
                        if(!is_writable($path))
                                return false;
                }elseif(!is_dir($dirname) || !is_writable($dirname)){
                        return false;
                }

                if(($filePointer = fopen($path, 'w')) == false)
                        return false;

                $results = fwrite($filePointer, $this->getData());
                fclose($filePointer);
                return is_numeric($results);
        }
}

/**
 * This is a specific exception for the Imap classes. It extends the CoreWarning class- if you want to use this library
 * outside of Mortar just have it extend your own exceptions, or the main Exception class itself.
 *
 */
class ImapException extends Exception  {}

/**
 * Rather than make the Imap class dependant on anything in Mortar we're going to put this dependency check here where
 * it can easily be taken out or replaced in other libraries.
 */
//Imap::$sslEnable = (bool) phpInfo::getExtensionProperty('imap', 'SSL Support');
?>
