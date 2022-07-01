<?php 

require_once 'inc/TwoFactorAuth/lib/TwoFactorAuth.php';
require_once 'inc/TwoFactorAuth/lib/TwoFactorAuthException.php';

require_once 'inc/TwoFactorAuth/lib/Providers/Qr/MyProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Qr/IQRCodeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Qr/BaseHTTPQRCodeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Qr/ImageChartsQRCodeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Qr/QRException.php';

require_once 'inc/TwoFactorAuth/lib/Providers/Rng/IRNGProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/RNGException.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/CSRNGProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/MCryptRNGProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/OpenSSLRNGProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/HashRNGProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Rng/RNGException.php';

require_once 'inc/TwoFactorAuth/lib/Providers/Time/ITimeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Time/LocalMachineTimeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Time/HttpTimeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Time/NTPTimeProvider.php';
require_once 'inc/TwoFactorAuth/lib/Providers/Time/TimeException.php';


?>