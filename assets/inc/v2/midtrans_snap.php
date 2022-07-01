<?php

/**
 * MidtransSnap Gateway
 *
 * @link https://indonet.co.id Jason Wanardi
 */
class MidtransSnap extends NonmerchantGateway {

    /**
     * @var array An array of meta data for this gateway
     */
    private $meta;

    /**
     * @var array An array of acceptable payment data for this gateway
     */
    private $enabled_payments = array(
        "credit_card",
        "gopay",
        "permata_va",
        "bca_va",
        "bni_va",
        "bri_va",
        "echannel",
        "other_va",
        "danamon_online",
        "mandiri_clickpay",
        "cimb_clicks",
        "bca_klikbca",
        "bca_klikpay",
        "bri_epay",
        "xl_tunai",
        "indosat_dompetku",
        "kioson",
        "Indomaret",
        "alfamart",
        "akulaku"
    );

    const NOTIF_NONE = 0;
    const NOTIF_APPEND = 1;
    const NOTIF_OVERRIDE = 2;

    /**
     * Construct a new merchant gateway
     */
    public function __construct() {
////        // Load the MidtransSnap API
////        Loader::load(dirname(__FILE__) . DS . 'api' . DS . 'midtranssnap_api.php');
        // Load configuration required by this gateway
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');

        // Load components required by this gateway
        Loader::loadComponents($this, ['Input']);

        // Load the language required by this gateway
        Language::loadLang('midtrans_snap', null, dirname(__FILE__) . DS . 'language' . DS);
    }

    /**
     * Returns an array of all fields to de/serialize when getting from the database
     *
     * @return array An array of the field names to de/serialize when getting from the database
     */
    public function serializableFields() {
        return ['devmode', 'snapmode', 'paymode', 'notification_mode'];
    }

    /**
     * Returns an array serialized fields
     *
     * @return array An array of serialized fields
     */
    public function serializeFields($meta) {
        foreach ($this->serializableFields() as $field) {
            if (isset($meta[$field]))
                $meta[$field] = serialize($meta[$field]);
        }
        return $meta;
    }

    /**
     * Returns an array unserialized fields
     *
     * @return array An array of unserialized fields
     */
    public function unserializeFields($meta) {
        foreach ($this->serializableFields() as $field) {
            if (isset($meta[$field]))
                $meta[$field] = unserialize($meta[$field]);
        }
        return $meta;
    }

    /**
     * Sets the meta data for this particular gateway
     *
     * @param array $meta An array of meta data to set for this gateway
     */
    public function setMeta(array $meta = null) {
        $this->meta = $meta;
    }

    /**
     * Create and return the view content required to modify the settings of this gateway
     *
     * @param array $meta An array of meta (settings) data belonging to this gateway
     * @return string HTML content containing the fields to update the meta data for this gateway
     */
    public function getSettings(array $meta = null) {
        // Auto unserialize meta
        $meta = isset($meta) ? $this->unserializeFields($meta) : null;

        // Load the view into this object, so helpers can be automatically add to the view
        $this->view = new View('settings', 'default');
        $this->view->setDefaultView('components' . DS . 'gateways' . DS . 'nonmerchant' . DS . 'midtrans_snap' . DS);
        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html']);

        $this->view->set('meta', $meta);
        $this->view->set('enabled_payments', $this->enabled_payments);

        return $this->view->fetch();
    }

    /**
     * Performs migration of data from $current_version (the current installed version)
     * to the given file set version
     *
     * @param string $current_version The current installed version of this gateway
     */
    public function upgrade($current_version) {
////        if (version_compare($current_version, '1.1.0', '<')) {
////        }
    }

    /**
     * Validates the given meta (settings) data to be updated for this gateway
     *
     * @param array $meta An array of meta (settings) data to be updated for this gateway
     * @return array The meta data to be updated in the database for this gateway, or reset into the form on failure
     */
    public function editSettings($meta) {
////// For more information on writing validation rules, see the
////// docs at https://docs.blesta.com/display/dev/Error+Checking
////

        $rules = [
            'mid' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.mid.valid', true)
                ]
            ],
            'skey' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.skey.valid', true)
                ]
            ],
            'ckey' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.ckey.valid', true)
                ]
            ],
            'devmode' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.devmode.valid', true)
                ]
            ],
            'snapmode' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.snapmode.valid', true)
                ]
            ],
            'paymode' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.paymode.valid', true)
                ]
            ],
            'notification_mode' => [
                'valid' => [
                    'rule' => true,
                    'message' => Language::_('MidtransSnap.!error.notification_mode.valid', true)
                ]
            ]
        ];
        $this->Input->setRules($rules);

        // Set unset checkboxes
        $checkbox_fields = ['devmode', 'snapmode'];

        foreach ($checkbox_fields as $checkbox_field) {
            $meta[$checkbox_field] = isset($meta[$checkbox_field]) ? ($meta[$checkbox_field] == 1) : false;
        }

        $meta['notification_mode'] = intval($meta['notification_mode']);

        // Validate the given meta data to ensure it meets the requirements
        $this->Input->validates($meta);

        // Auto serialize meta back
        $meta = $this->serializeFields($meta);

        // Return the meta data, no changes required regardless of success or failure for this gateway
        return $meta;
    }

    /**
     * Returns an array of all fields to encrypt when storing in the database
     *
     * @return array An array of the field names to encrypt when storing in the database
     */
    public function encryptableFields() {
        return ['skey', 'ckey'];
    }

    /**
     * Sets the currency code to be used for all subsequent payments
     *
     * @param string $currency The ISO 4217 currency code to be used for subsequent payments
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * Returns all HTML markup required to render an authorization and capture payment form
     *
     * @param array $contact_info An array of contact info including:
     *  - id The contact ID
     *  - client_id The ID of the client this contact belongs to
     *  - user_id The user ID this contact belongs to (if any)
     *  - contact_type The type of contact
     *  - contact_type_id The ID of the contact type
     *  - first_name The first name on the contact
     *  - last_name The last name on the contact
     *  - title The title of the contact
     *  - company The company name of the contact
     *  - address1 The address 1 line of the contact
     *  - address2 The address 2 line of the contact
     *  - city The city of the contact
     *  - state An array of state info including:
     *      - code The 2 or 3-character state code
     *      - name The local name of the country
     *  - country An array of country info including:
     *      - alpha2 The 2-character country code
     *      - alpha3 The 3-cahracter country code
     *      - name The english name of the country
     *      - alt_name The local name of the country
     *  - zip The zip/postal code of the contact
     * @param float $amount The amount to charge this contact
     * @param array $invoice_amounts An array of invoices, each containing:
     *  - id The ID of the invoice being processed
     *  - amount The amount being processed for this invoice (which is included in $amount)
     * @param array $options An array of options including:
     *  - description The Description of the charge
     *  - return_url The URL to redirect users to after a successful payment
     *  - recur An array of recurring info including:
     *      - amount The amount to recur
     *      - term The term to recur
     *      - period The recurring period (day, week, month, year, onetime) used in conjunction
     *          with term in order to determine the next recurring payment
     * @return string HTML markup required to render an authorization and capture payment form
     */
    public function buildProcess(array $contact_info, $amount, array $invoice_amounts = null, array $options = null) {
        //Load API
        $snapApi = $this->getApi();

        $meta = $this->unserializeFields($this->meta);

        $post = $_POST;

        $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $return_url = $this->ifSet($options['return_url']);
        $clientId = $this->ifSet($contact_info['client_id']);
        $orderId = $clientId . "-" . time();

        $_pattern = '/.*\/client\/pay\/received\/(.*)\/.*/';
        preg_match($_pattern, $options['return_url'], $_matches);
        $notificationURL = Configure::get("Blesta.gw_callback_url") . Configure::get("Blesta.company_id") . "/{$_matches[1]}/" . $clientId;

        switch ($meta['notification_mode']) {
            case $this::NOTIF_OVERRIDE:
                $snapApi->overrideNotifUrl = $notificationURL;
                break;
            case $this::NOTIF_APPEND:
                $snapApi->appendNotifUrl = $notificationURL;
                break;
            default:
        }

        $transaction_details = array(
            'order_id' => $orderId,
            'gross_amount' => round($amount, 0) // no decimal allowed
        );

        $currency = $this->ifSet($this->currency);

        $customer_details = array(
            'first_name' => $this->ifSet($contact_info['first_name']),
            'last_name' => $this->ifSet($contact_info['last_name']),
            'email' => $this->ifSet($contact_info['email']),
        );

        $item_details = [];
        $amount_left = round($amount, 0);
        $inv = [];
        foreach ($invoice_amounts as $ia) {
            @$id = $ia['id'];
            @$amt = $ia['amount'];
            $amount_left -= $amt;
            $item_details[] = array(
                'id' => "inv_$id",
                'price' => $amt,
                'quantity' => 1,
                'name' => "Invoice #$id"
            );
            $inv[$id] = $amt;
        }
        
        $extra_data = array('cur' => $currency, 'cid' => $clientId, 'inv' => $inv);
        
        if ($amount_left > 0) {
            $item_details[] = array(
                'id' => "topup",
                'price' => $amount_left,
                'quantity' => 1,
                'name' => "Topup Rp. $amount_left",
            );
        }

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'custom_field1' => json_encode($extra_data,JSON_NUMERIC_CHECK),
            'callbacks' => [
                'finish' => $return_url,
                'unfinish' => $current_url,
                'error' => $return_url,
            ],
        ];

        foreach ($meta['paymode'] as $key => $val) {
            $enabled_payments[] = $key;
        }

        $transaction['enabled_payments'] = $enabled_payments;

        //TODO: add URL depending on config

        $execPay = isset($post['pay']);
        $snapToken = null;

        if ($execPay) {
            $snap = $snapApi->createTransaction($transaction);
            $snapToken = $snap->token;
            if (!$meta['snapmode']) {
                header("Location: {$snap->redirect_url}");
            }
//            echo "<pre>SM:", var_dump($meta), "</pre>";
//            echo "<pre>", var_dump($snap), "</pre>";
//            die;
        }

        $this->view = $this->makeView('process', 'default', str_replace(ROOTWEBDIR, '', dirname(__FILE__) . DS));

        // Load the helpers required for this view
        Loader::loadHelpers($this, ['Form', 'Html']);

        $this->view->set('execPay', $execPay);
        $this->view->set('snapToken', $snapToken);
        $this->view->set('snapMode', $meta['snapmode']);
        $this->view->set('devMode', $meta['devmode']);
        $this->view->set('ckey', $meta['ckey']);
        $this->view->set('current_url', $current_url);
        $this->view->set('return_url', $return_url);

        // Get a list of key/value hidden fields to set for the payment form
////        $fields = $this->getProcessFields($contact_info, $amount, $invoice_amounts, $options);
////        $this->view->set('post_to', $api->getPaymentUrl());
////        $this->view->set('fields', $fields);

        return $this->view->fetch();
    }

    /**
     * Validates the incoming POST/GET response from the gateway to ensure it is
     * legitimate and can be trusted.
     *
     * @param array $get The GET data for this request
     * @param array $post The POST data for this request
     * @return array An array of transaction data, sets any errors using Input if the data fails to validate
     *  - client_id The ID of the client that attempted the payment
     *  - amount The amount of the payment
     *  - currency The currency of the payment
     *  - invoices An array of invoices and the amount the payment should be applied to (if any) including:
     *      - id The ID of the invoice to apply to
     *      - amount The amount to apply to the invoice
     *  - status The status of the transaction (approved, declined, void, pending, reconciled, refunded, returned)
     *  - reference_id The reference ID for gateway-only use with this transaction (optional)
     *  - transaction_id The ID returned by the gateway to identify this transaction
     *  - parent_transaction_id The ID returned by the gateway to identify this
     *      transaction's original transaction (in the case of refunds)
     */
    public function validate(array $get, array $post) {
////// For more information on writing validation rules, see the
////// docs at https://docs.blesta.com/display/dev/Error+Checking
////
////    There is often a hash validation and/or additional API calls that happen in this function as
////    its primary purpose is to validate the authenticity of a webhook callback from the payment processor
        //Load API
        $snapApi = $this->getApi();

        $meta = $this->unserializeFields($this->meta);

        $notification = $snapApi->getTransactionFromNotification();

        $transaction_status = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;
        $amount = $notification->gross_amount;
        $transaction_id = $notification->transaction_id;

        $custom_field1 = $notification->custom_field1;

        $extra_data = json_decode($custom_field1,true);

        $client_id = $extra_data['cid'];
        $inv = $extra_data['inv'];
        $currency = $extra_data['cur'];
        
        $invoices = [];
        foreach($inv as $key=>$val) {
            $invoices[] = ['id'=>$key, 'amount'=>$val];
        }

        switch ($transaction_status) {
            case 'settlement':
                $status = "approved";
                $success = true;
                break;
            case 'deny':
            case 'cancel':
                $status = "declined";
                $success = false;
                break;
            case 'capture':
                if ($fraud !== 'challange') {
                    $status = "approved";
                    $success = true;
                    break;
                }
            case 'pending':
            default:
                $status = "pending";
                $success = false;
                break;
        }

        $body = file_get_contents('php://input');
        $this->log($this->ifSet($_SERVER['REQUEST_URI']), json_encode(json_decode($body), JSON_PRETTY_PRINT), "input", true);

        $uri = $snapApi->getBaseUrl() . "{$notification->transaction_id}/status";
        $this->log($uri, json_encode($notification, JSON_PRETTY_PRINT), "output", $success);

        $result = array(
            'client_id' => $client_id,
            'amount' => $amount,
            'currency' => $currency,
            'invoices' => $invoices,
            'status' => $status,
            'transaction_id' => $transaction_id,
            'reference_id' => null,
            'parent_transaction_id' => null
        );

        return $result;
    }

    /**
     * Returns data regarding a success transaction. This method is invoked when
     * a client returns from the non-merchant gateway's web site back to Blesta.
     *
     * @param array $get The GET data for this request
     * @param array $post The POST data for this request
     * @return array An array of transaction data, may set errors using Input if the data appears invalid
     *  - client_id The ID of the client that attempted the payment
     *  - amount The amount of the payment
     *  - currency The currency of the payment
     *  - invoices An array of invoices and the amount the payment should be applied to (if any) including:
     *      - id The ID of the invoice to apply to
     *      - amount The amount to apply to the invoice
     *  - status The status of the transaction (approved, declined, void, pending, reconciled, refunded, returned)
     *  - transaction_id The ID returned by the gateway to identify this transaction
     *  - parent_transaction_id The ID returned by the gateway to identify this transaction's original transaction
     */
    public function success(array $get, array $post) {
////        Format data from $get and $post
////
////        $params = [
////            'client_id' => $this->ifSet($post['client_id']),
////            'amount' => $this->ifSet($post['total']),
////            'currency' => $this->ifSet($post['currency_code']),
////            'invoices' => unserialize(base64_decode($this->ifSet($post['invoices']))),
////            'status' => 'approved',
////            'transaction_id' => $this->ifSet($post['order_number']),
////            'parent_transaction_id' => null
////        ];
        if (!isset($get['order_id'])) {
            return;
        }
        $snapApi = $this->getApi();

        $meta = $this->unserializeFields($this->meta);

        $notification = $snapApi->getTransactionStatus($get['order_id']);

        $transaction_status = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;
        $amount = $notification->gross_amount;
        $transaction_id = $notification->transaction_id;

        $custom_field1 = $notification->custom_field1;

        $extra_data = json_decode($custom_field1,true);
        
//        echo "<pre>", json_encode($extra_data, JSON_NUMERIC_CHECK);die;

        $client_id = $extra_data['cid'];
        $inv = $extra_data['inv'];
        $currency = $extra_data['cur'];
        
        $invoices = [];
        foreach($inv as $key=>$val) {
            $invoices[] = ['id'=>$key, 'amount'=>$val];
        }

        switch ($transaction_status) {
            case 'settlement':
                $status = "approved";
                $success = true;
                break;
            case 'deny':
            case 'cancel':
                $status = "declined";
                $success = false;
                break;
            case 'capture':
                if ($fraud !== 'challange') {
                    $status = "approved";
                    $success = true;
                    break;
                }
            case 'pending':
            default:
                $status = "pending";
                $success = false;
                break;
        }

        $result = array(
            'client_id' => $client_id,
            'amount' => $amount,
            'currency' => $currency,
            'invoices' => $invoices,
            'status' => $status,
            'transaction_id' => $transaction_id,
            'reference_id' => null,
            'parent_transaction_id' => null
        );

        return $result;
    }

    /**
     * Refund a payment
     *
     * @param string $reference_id The reference ID for the previously submitted transaction
     * @param string $transaction_id The transaction ID for the previously submitted transaction
     * @param float $amount The amount to refund this transaction
     * @param string $notes Notes about the refund that may be sent to the client by the gateway
     * @return array An array of transaction data including:
     *  - status The status of the transaction (approved, declined, void, pending, reconciled, refunded, returned)
     *  - reference_id The reference ID for gateway-only use with this transaction (optional)
     *  - transaction_id The ID returned by the remote gateway to identify this transaction
     *  - message The message to be displayed in the interface in addition to the standard
     *      message for this transaction status (optional)
     */
    public function refund($reference_id, $transaction_id, $amount, $notes = null) {
        $this->Input->setErrors($this->getCommonError('unsupported'));
////        $params = [/* Format params for the refund request */];
////
////        // Attempt a refund
////        $api = $this->getApi();
////        $refund_response = $api->refund($params);
////
////        // Log data sent
////        $this->log('refund', json_encode($params), 'input', true);
////
////        // Log the response
////        $errors = $refund_response->errors();
////        $success = $refund_response->status() == '200' && empty($errors);
////        $this->log('refund', $refund_response->raw(), 'output', $success);
////
////        // Output errors
////        if (!$success) {
////            $this->Input->setErrors(['api' => $errors]);
////            return;
////        }
////
////        return [
////            'status' => 'refunded',
////            'transaction_id' => $transaction_id
////        ];
    }

    /**
     * Void a payment or authorization.
     *
     * @param string $reference_id The reference ID for the previously submitted transaction
     * @param string $transaction_id The transaction ID for the previously submitted transaction
     * @param string $notes Notes about the void that may be sent to the client by the gateway
     * @return array An array of transaction data including:
     *  - status The status of the transaction (approved, declined, void, pending, reconciled, refunded, returned)
     *  - reference_id The reference ID for gateway-only use with this transaction (optional)
     *  - transaction_id The ID returned by the remote gateway to identify this transaction
     *  - message The message to be displayed in the interface in addition to the standard
     *      message for this transaction status (optional)
     */
    public function void($reference_id, $transaction_id, $notes = null) {
        $this->Input->setErrors($this->getCommonError('unsupported'));
////
////        // Load the API
////        $api = $this->getApi();
////
////        $params = [/* Format params for the void request */];
////
////        // Log data sent
////        $this->log('void', json_encode($params), 'input', true);
////
////        // Get the payment details
////        $void_response = $api->void();
////        $errors = $void_response->errors();
////        $success = $void_response->status() == '200' && empty($errors);
////
////        // Log the API response
////        $this->log('void', $refund->raw(), 'output', $success);
////
////
////        return [
////            'status' => 'void',
////            'transaction_id' => $this->ifSet($transaction_id)
////        ];
    }

    /**
     * Loads the given API if not already loaded
     */
    private function getApi() {
        Loader::load(dirname(__FILE__) . DS . 'apis' . DS . 'midtrans_snap_api.php');
        return new MidtransSnapApi(
                $this->meta['mid'],
                $this->meta['skey'],
                $this->meta['ckey'],
                $this->meta['devmode']
        );
    }

}
