<?php


namespace App\Services;



use Symfony\Component\Config\Definition\Exception\Exception;

class Curl
{
    private $ch;
    private $http_header;
    private $method;
    private $debug;
    private $url;
    private $data;
    private $response_info;
    private $authorization_method;
    private $authorization_encode;

    public function __construct( $security_level = 'MEDIUM', $debug = 0 )
    {
        $this->reset($security_level, $debug);
    }

    public function setUrl( $url )
    {

        if ( empty( $url ) )
        {
            throw new Exception('Missing URL parameter on method setUrl');
        }

        $this->url = $url;
        curl_setopt( $this->ch, CURLOPT_URL, $url );
    }

    public function setMethod( $method )
    {
        error_log('Bridge Method: ' . $method);
        $this->method = $method;

        switch( $method ):
            case 'GET':
                curl_setopt( $this->ch, CURLOPT_POST, false );
                break;
            case 'PUT':
                curl_setopt( $this->ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
                break;
            case 'PATCH':
                curl_setopt( $this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH' );
                $this->setContentType('application/json');
                break;
            case 'POST':
            case 'XML_POST':
                curl_setopt( $this->ch, CURLOPT_POST, true );
                $this->setContentType('application/x-www-form-urlencoded');
                break;
            case 'SOAP':
                curl_setopt( $this->ch, CURLOPT_POST, true );
                $this->setContentType('text/xml');
                break;
            case 'XML':
                curl_setopt( $this->ch, CURLOPT_POST, true );
                $this->setContentType('application/xml');
                break;
            case 'JSON':
                curl_setopt( $this->ch, CURLOPT_POST, true );
                $this->setContentType('application/json');
                break;
            default:
                curl_setopt( $this->ch, CURLOPT_POST, false );
                break;
        endswitch;
    }

    public function setData( $data )
    {
        $this->data = $data;
        if ( in_array($this->method, array('POST', 'XML', 'XML_POST', 'JSON', 'PUT', 'PATCH', 'SOAP')) === true )
        {
            if ( getType($data) == 'array' )
            {
                $data = http_build_query($data);


            }
            curl_setopt( $this->ch, CURLOPT_POSTFIELDS, $data );

        }
        else
        {
            throw new Exception('Trying to set data on a non-POST request');
        }
    }

    public function setContentType( $type )
    {
        $new_header = array();

        foreach ( $this->http_header as $header )
        {
            if ( strpos($header, 'Content-type') !== false )
            {
                continue;
            }
            $new_header[] = $header;
        }

        $this->setHttpHeader($new_header);
        $this->addHttpHeader( 'Content-type: ' . $type );
    }

    public function returnRequest ( $request )
    {
        curl_setopt( $this->ch, CURLOPT_RETURNTRANSFER, $request );
    }

    public function setSecurityLevel( $level )
    {
        switch( $level ):
            case 'HIGH':
                curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, false );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYHOST, 2 );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYPEER, true );
                break;
            case 'LOW':
                curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYHOST, 2 );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYPEER, false );
                break;
            case 'MEDIUM':
            default:
                curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYHOST, 2 );
                curl_setopt( $this->ch, CURLOPT_SSL_VERIFYPEER, false );
                break;
        endswitch;
    }

    public function setSoapAction( $action )
    {
        $this->addHttpHeader( 'SOAPAction: "' . $action . '"' );
    }

    public function addRawHeader( $key, $value)
    {
        $this->addHttpHeader( $key . $value );
    }

    public function setAuthorizationToken( $token, $is_raw_auth = false )
    {
        if ( $is_raw_auth )
        {
            $this->addHttpHeader( "Auth: " . $token );
        }
        else
        {
            $this->addHttpHeader( "Authorization:" . $this->authorization_method . ' ' . (($this->authorization_encode === true) ? base64_encode($token) : $token) );
        }
    }

    public function setCredentials( $username, $password )
    {
        curl_setopt( $this->ch, CURLOPT_USERPWD, $username . ':' . $password );
        curl_setopt( $this->ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY );
    }

    public function setCredentialsMethod( $method )
    {
        curl_setopt( $this->ch, CURLOPT_HTTPAUTH, $method );
    }

    public function setDebug( $value = false )
    {
        $this->debug = $value;
    }

    public function execute()
    {
        if ( $this->debug == true )
        {
            error_log('---- CURL DEBUG DUMP START ----');
            error_log( 'Calling URL: ' . $this->url );
            error_log( 'Method: ' . $this->method );
            error_log( 'Data: ' . print_r($this->data, 1) );
            error_log( 'Headers: ' . print_r($this->http_header, 1) );
        }

        //Set the header
        if ( !empty($this->http_header) )
        {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->http_header);
        }

        $response = curl_exec( $this->ch );

        if ( $this->debug == true )
        {
            error_log( 'Got response: ' . $response );
        }

        if ( !empty( curl_errno( $this->ch ) ) )
        {
            $error = curl_strerror( curl_errno( $this->ch ) );

            if ( $this->debug == true )
            {
                error_log( 'Error detected: ' . $error );
            }

            curl_close( $this->ch );

            throw new Exception( 'Curl failed with message: '.$error );
        }

        if ( $this->debug == true )
        {
            error_log('---- CURL DEBUG DUMP END ----');
        }

        $this->response_info = curl_getinfo($this->ch);

        curl_close( $this->ch );
        return $response;
    }

    public function getResponseInfo()
    {
        return $this->response_info;
    }

    public function getResponseHttpCode()
    {
        return $this->response_info['http_code'];
    }

    private function addHttpHeader( $header )
    {
        $this->http_header[] = $header;
    }

    public function setHttpHeader( $header )
    {
        if ( 'string' == getType($header) )
        {
            $header = explode( '; ', $header );
        }
        $this->http_header = $header;
    }

    public function setAuthorizationMethod( $value )
    {
        $this->authorization_method = $value;
    }

    public function setAuthorizationEncoding( $value )
    {
        $value = ( 'false' == $value ) ? false : true;
        $this->authorization_encode = $value;
    }

    /**
     * Closes existing connections and resets the service for a new connection to occur
     *
     * @param string $security_level - The security level to adhere to
     * @param bool $debug - Whether to run on debug mode
     */
    public function reset( $security_level = 'MEDIUM', $debug = false )
    {
        try
        {
            //Try to close the old connection before resetting
            if ( !empty($this->ch) )
            {
                curl_close($this->ch);
            }
        }
        catch ( Exception $e )
        {
            //The connection wasn't open
        }

        //Create new resource
        $this->ch = curl_init();
        curl_setopt( $this->ch, CURLOPT_VERBOSE, false );

        //Set variable defaults
        $this->http_header = array();
        $this->method = 'GET';
        $this->debug = $debug;
        $this->authorization_method = 'Basic';
        $this->authorization_encode = true;

        //Set default options
        $this->setSecurityLevel( $security_level );
        $this->returnRequest( true );
    }

    /**
     * Sets a timeout in seconds. Accepts floats or integers
     *
     * @param float $value
     */
    public function setTimeout( $value )
    {
        curl_setopt( $this->ch, CURLOPT_TIMEOUT_MS, $value * 1000 );
    }
}