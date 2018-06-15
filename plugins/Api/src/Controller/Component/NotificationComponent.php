<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Api\Utils\Utils;

class NotificationComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'andriod' => [
            'access_key' => 'AIzaSyDG3fYAj1uW7VB-wejaMJyJXiO5JagAsYI',
            'url' => 'https://android.googleapis.com/gcm/send'
        ],
        
        'windows' => [
            'channelName' => 'ioskiwitech'
        ]
    ];
    
    /**
     * initialize function to initialize the current component config with new more config param
     * 
     * @param array $config config related to the current component
     * @return void nothing
     */
    public function initialize(array $config) {
        parent::initialize($config);
        $iosconfig = Configure::read('IOSPUSH');
        $config = !empty($config)?$config:array();
        $this->_config = array_merge($this->_defaultConfig , $config);
        $this->_config['ios'] = $iosconfig;
    }
    // Sends Push notification for iOS users
    public function iosPush($data, $deviceToken) {
        $passPhrase = $this->getConfig('ios.passphrase');
        $geteWay = $this->getConfig('ios.gateway');
        $certificate = ROOT.DS.$this->getConfig('ios.certificate_file');
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert',$certificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passPhrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client($geteWay, $error, $errorString, 10, STREAM_CLIENT_CONNECT | STREAM_CLIENT_ASYNC_CONNECT, $ctx);

        if (!$fp) {
            \Cake\Log\Log::info("Failed to connect: $error $errorString" . PHP_EOL);
            return false;
        }

        // Create the payload body
        $body['aps'] = [
            'alert' => Utils::getVar('message',$data),
            'sound' => 'default',
            'badge'=>1,
            'user_id'=> Utils::getVar('requested_by',$data),
            'matrix_room_id'=> Utils::getVar('matrix_room_id',$data),
            'notification_type'=> Utils::getVar('notification_type',$data),
            'user_image'=> Utils::getVar('user_image',$data),
            'spayc_image'=> Utils::getVar('spayc_image',$data),
            'date_time'=> Utils::getVar('date_time',$data),
            'id'=> Utils::getVar('id',$data),
            'spayc_id'=> Utils::getVar('spayc_id',$data)
        ];

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        
        // Close the connection to the server
        fclose($fp);
        return $result;
    }

    // Sends Push notification for Android users
    public function android($data, $deviceToken) {

        $url = $this->getConfig('andriod.url');
        $accessKey = $this->getConfig('andriod.access_key');

        $message = [
            'message' => $data['message'],
            'slug' => $data['slug'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1
        ];

        $headers = [
            'Authorization: key=' . $accessKey,
            'Content-Type: application/json'
        ];

        $fields = [
            'registration_ids' => array($deviceToken),
            'data' => $message,
        ];
        $http = new Client(['headers' => $headers]);
        $httpResponse = $http->post(
                $url, json_encode($fields), [
            'type' => 'json',
            'ssl_verify_host' => false,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false,
            'ssl_verify_peer_name' => false
                ]
        );
        $response = json_decode($httpResponse->body, true);
        return $response;
    }

    // Sends Push's toast notification for Windows Phone 8 users
    public function WP($data, $uri) {
        $delay = 2;
        $msg = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<wp:Notification xmlns:wp=\"WPNotification\">" .
                "<wp:Toast>" .
                "<wp:Text1>" . htmlspecialchars($data['message']) . "</wp:Text1>" .
                "<wp:Text2>" . htmlspecialchars($data['slug']) . "</wp:Text2>" .
                "</wp:Toast>" .
                "</wp:Notification>";

        $headers = array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $http = new Client(['headers' => $headers]);
        $httpResponse = $http->post(
                $uri, $msg, [
            'ssl_verify_host' => false,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false,
            'ssl_verify_peer_name' => false
                ]
        );
        $response = json_decode($httpResponse->body, true);
        return $response;
    }

}

?>