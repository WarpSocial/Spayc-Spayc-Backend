<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

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
        'ios' => [
            'passphrase' => '123',
            'certificate_file'=>'Spayc_Push_Certificates.pem',
            'gateway' => 'ssl://gateway.sandbox.push.apple.com:2195'
        ],
        'windows' => [
            'channelName' => 'ioskiwitech'
        ]
    ];
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
            'alert' =>  !empty($data['message'])?$data['message']:null,
            'sound' => 'default',
            'badge'=>1,
            'user_id'=>!empty($data['requested_by'])?$data['requested_by']:null,
            'matrix_room_id'=>!empty($data['matrix_room_id'])?$data['matrix_room_id']:null,
            'notification_type'=>!empty($data['notification_type'])?$data['notification_type']:null,
            'user_image'=>!empty($data['user_image'])?$data['user_image']:null,
            'spayc_image'=>!empty($data['spayc_image'])?$data['spayc_image']:null,
            'date_time'=>!empty($data['time'])?$data['time']:null,
            'id'=>!empty($data['id'])?$data['id']:null
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