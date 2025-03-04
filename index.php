<?php

require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Faker\Factory as Faker;
use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\Exception\TimeoutException;

class xixixixi
{
    private $driver;
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
        $options = new ChromeOptions();

        $extensionPath = "C:/xampp/htdocs/xixixixi/admkpobhocmdideidcndkfaeffadipkc";
        $randomUserAgent = $this->faker->userAgent;

        $useApiProxy = false;  // Gunakan proxy dari API
        $useAuthSocks = false; // Gunakan SOCKS5 dengan user:pass
        $useNoAuthSocks = false; // Gunakan SOCKS5 tanpa user:pass
        $useAuthHttp = false; // Gunakan HTTP Proxy dengan user:pass
        $useNoAuthHttp = false; // Gunakan Http tanpa autentikasi
        $useAuthHttps = false; // Gunakan HTTPS Proxy dengan user:pass
        $useNoAuthHttps = false; // Gunakan HTTPS Proxy tanpa autentikasi
        $proxyServer = "";

        if ($useApiProxy) {
            $apiUrl = "http://127.0.0.1:2007/api/proxy?t=2&num=1&country=ID";

            $response = file_get_contents($apiUrl);
            if ($response === false) {
                die("❌ ERROR: Gagal menghubungi API.");
            }

            $data = json_decode($response, true);
            if (!is_array($data)) {
                die("❌ ERROR: Respon API bukan JSON yang valid.");
            }

            if ($data['error']) {
                die("❌ ERROR: " . $data['message']);
            }

            if (!isset($data['data']) || empty($data['data'])) {
                die("❌ ERROR: Tidak ada proxy yang tersedia.");
            }

            $proxyServer = "http://" . $data['data'][0];
        } elseif ($useAuthSocks) {
            $proxyServer = "socks5://user:pass@ip:port";
        } elseif ($useNoAuthSocks) {
            $proxyServer = "socks5://127.0.0.1:10000";
        } elseif ($useAuthHttp) {
            $proxyServer = "http://user:pass@ip:port";
        } elseif ($useNoAuthHttp) {
            $proxyServer = "http://ip:port";
        } elseif ($useAuthHttps) {
            $proxyServer = "https://user:pass@ip:port";
        } elseif ($useNoAuthHttps) {
            $proxyServer = "https://ip:port";
        }

        $options->addArguments([
            "--user-agent=$randomUserAgent",
            "--proxy-server=$proxyServer",
            "--load-extension=$extensionPath",
            "--disable-popup-blocking",
            "--disable-notifications",
            "--ignore-certificate-errors",
            "--no-sandbox",
            "--disable-gpu",
            "--disable-dev-shm-usage",
            '--disable-blink-features=AutomationControlled',
            '--start-maximized',
            '--disable-infobars',
            '--disable-dev-shm-usage'
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $this->driver = RemoteWebDriver::create('http://localhost:9515', $capabilities);

        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;33m🚀 GOOGLE ACCOUNT AUTO-REGISTER BOT\e[0m\n";
        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;32m✅ Status: \e[1;37mBerjalan\e[0m\n";
        echo "\e[1;32m🌐 Proxy Server: \e[1;34m$proxyServer\e[0m\n";
        echo "\e[1;32m🔌 Ekstensi Aktif: \e[1;35mYa\e[0m\n";
        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;33m📜 Deskripsi:\e[0m\n";
        echo "\e[1;37m  Program ini merupakan bot otomatis untuk mendaftarkan akun Google.\n";
        echo "  Menggunakan Selenium Chrome Driver dengan konfigurasi proxy dan ekstensi.\e[0m\n";
        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;33m👨‍💻 Author: \e[1;37mAhmad Haikal Rizal\e[0m\n";
        echo "\e[1;32m📌 GitHub: \e[1;34mgithub.com/ahr-ahr\e[0m\n";
        echo "\e[1;32m📷 Instagram: \e[1;35m@lelekuningcoy\e[0m\n";
        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";


        sleep(rand(2, 5));
    }

    private function slowType($element, $text)
    {
        foreach (str_split($text) as $char) {
            $element->sendKeys($char);
            usleep(rand(100000, 300000));
        }
    }

    public function fillForm()
    {
        //$url1 = 'https://accounts.google.com/signup/v2/webcreateaccount?flowName=GlifWebSignIn&flowEntry=SignUp';
        $url1 = 'https://accounts.google.com/signup';
        $url3 = 'https://httpbin.org/user-agent';
        $url4 = 'https://ipapi.co/json/';

        $this->driver->get($url1);
        $this->driver->executeScript("window.open('', '_blank');");

        $windows = $this->driver->getWindowHandles();
        $this->driver->switchTo()->window($windows[1]);

        try {
            $this->driver->get($url3);
            $userAgentJson = $this->driver->findElement(WebDriverBy::tagName('body'))->getText();
            $userAgentData = json_decode($userAgentJson, true);
            $userAgent = $userAgentData['user-agent'] ?? 'Tidak dapat mengambil User-Agent';

            $this->driver->get($url4);
            $locationJson = $this->driver->findElement(WebDriverBy::tagName('body'))->getText();
            $locationData = json_decode($locationJson, true);
            sleep(3);

            if (!is_array($locationData)) {
                throw new Exception("Gagal mengambil data lokasi.");
            }

            $ip = $locationData['ip'] ?? 'Unknown';
            $network = $locationData['network'] ?? 'Unknown';
            $version = $locationData['version'] ?? 'Unknown';
            $city = $locationData['city'] ?? 'Unknown';
            $region = $locationData['region'] ?? 'Unknown';
            $region_code = $locationData['region_code'] ?? 'Unknown';
            $country = $locationData['country_name'] ?? 'Unknown';
            $country_code = $locationData['country_code'] ?? 'Unknown';
            $country_code_iso3 = $locationData['country_code_iso3'] ?? 'Unknown';
            $country_capital = $locationData['country_capital'] ?? 'Unknown';
            $country_tld = $locationData['country_tld'] ?? 'Unknown';
            $continent_code = $locationData['continent_code'] ?? 'Unknown';
            $in_eu = $locationData['in_eu'] ? 'Yes' : 'No';
            $postal = $locationData['postal'] ?? 'Unknown';
            $latitude = $locationData['latitude'] ?? 'Unknown';
            $longitude = $locationData['longitude'] ?? 'Unknown';
            $timezone = $locationData['timezone'] ?? 'Unknown';
            $utc_offset = $locationData['utc_offset'] ?? 'Unknown';
            $country_calling_code = $locationData['country_calling_code'] ?? 'Unknown';
            $currency = $locationData['currency'] ?? 'Unknown';
            $currency_name = $locationData['currency_name'] ?? 'Unknown';
            $languages = $locationData['languages'] ?? 'Unknown';
            $country_area = $locationData['country_area'] ?? 'Unknown';
            $country_population = $locationData['country_population'] ?? 'Unknown';
            $asn = $locationData['asn'] ?? 'Unknown';
            $org = $locationData['org'] ?? 'Unknown';

            echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo " 🌍 IP Information & User Agent\n";
            echo " - IP Address       : $ip \n";
            echo " - Network          : $network \n";
            echo " - IP Version       : $version \n";
            echo " - User-Agent: $userAgent \n";
            echo "\n📍 Location\n";
            echo " - City            : $city \n";
            echo " - Region          : $region ($region_code) \n";
            echo " - Country         : $country ($country_code / $country_code_iso3) \n";
            echo " - Country TLD      : $country_tld \n";
            echo " - Capital         : $country_capital \n";
            echo " - Continent Code  : $continent_code \n";
            echo " - In EU?          : $in_eu \n";
            echo " - Postal Code     : $postal \n";
            echo " - Latitude        : $latitude \n";
            echo " - Longitude       : $longitude \n";
            echo "\n🕒 Time & Currency\n";
            echo " - Timezone        : $timezone \n";
            echo " - UTC Offset      : $utc_offset \n";
            echo " - Currency        : $currency ($currency_name) \n";
            echo " - Calling Code    : $country_calling_code \n";
            echo "\n🌐 Additional Info\n";
            echo " - Languages       : $languages \n";
            echo " - Country Area    : $country_area km² \n";
            echo " - Population      : $country_population \n";
            echo " - ISP/Org         : $org \n";
            echo " - ASN             : $asn \n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

        } catch (Exception $e) {
            echo "\n❌ Error: " . $e->getMessage() . "\n";
        }

        $this->driver->close();
        $this->driver->switchTo()->window($windows[0]);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('firstName'))
        );

        $firstName = preg_replace('/[^A-Za-z]/', '', $this->faker->firstName);
        $lastName = preg_replace('/[^A-Za-z]/', '', $this->faker->lastName);

        $actions = new WebDriverActions($this->driver);
        $firstNameField = $this->driver->findElement(WebDriverBy::name('firstName'));
        $lastNameField = $this->driver->findElement(WebDriverBy::name('lastName'));

        $actions->moveToElement($firstNameField)->perform();
        sleep(rand(1, 2));
        $this->slowType($firstNameField, $firstName);

        $actions->moveToElement($lastNameField)->perform();
        sleep(rand(1, 3));
        $this->slowType($lastNameField, $lastName);

        sleep(rand(1, 3));

        $nextButton = $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'));
        $actions->moveToElement($nextButton)->perform();
        sleep(rand(1, 2));
        $nextButton->click();

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('day'))
        );

        $birthDate = $this->faker->dateTimeBetween('-50 years', '-18 years');
        $day = $birthDate->format('d');
        $month = $birthDate->format('F');
        $year = $birthDate->format('Y');

        sleep(2);

        $this->slowType($this->driver->findElement(WebDriverBy::id('day')), $day);

        $monthElement = $this->driver->findElement(WebDriverBy::id('month'));

        if ($monthElement->isDisplayed()) {
            $action = new WebDriverActions($this->driver);
            $action->moveToElement($monthElement)->perform();

            usleep(rand(500000, 1500000));

            $monthElement->click();

            usleep(rand(500000, 1000000));

            $monthDropdown = new WebDriverSelect($monthElement);
            $monthDropdown->selectByVisibleText($month);

            usleep(rand(500000, 1000000));
        } else {
            throw new Exception("Dropdown bulan tidak ditemukan atau tidak dapat diakses.");
        }


        sleep(1);

        $this->slowType($this->driver->findElement(WebDriverBy::id('year')), $year);

        sleep(1);

        $genderElement = $this->driver->findElement(WebDriverBy::id('gender'));

        if ($genderElement->isDisplayed()) {
            $action = new WebDriverActions($this->driver);
            $action->moveToElement($genderElement)->perform();

            usleep(rand(500000, 1500000));

            $genderDropdown = new WebDriverSelect($genderElement);
            $randomGender = rand(1, 2);

            $genderElement->click();

            usleep(rand(500000, 1500000));

            $genderDropdown->selectByValue((string) $randomGender);

            usleep(rand(500000, 1000000));
        } else {
            throw new Exception("Dropdown gender tidak ditemukan atau tidak dapat diakses.");
        }


        sleep(1);

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $username = $firstName . $lastName . $year;
        $maxAttempts = 2;
        $attempt = 0;

        try {
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))
            );

            $this->driver->executeScript("document.querySelector('.zJKIV.lezCeb.kAVONc[jsname=\"ornU0b\"][data-value=\"custom\"]').click();");
            sleep(3);

            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

        } catch (NoSuchElementException $e) {
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );
        }

        $attempt = 0;
        $maxAttempts = 5;

        while ($attempt < $maxAttempts) {
            sleep(1);

            $usernameField = $this->driver->findElement(WebDriverBy::name('Username'));
            $usernameField->clear();
            $this->slowType($usernameField, $username);

            usleep(rand(500000, 1500000));

            try {
                $this->driver->wait(5)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(
                        WebDriverBy::xpath('//div[@class="Ekjuhf Jj6Lae"]')
                    )
                );

                echo "⚠️  Username '$username' sudah diambil, mencoba variasi lain...\n";

                $username .= rand(10, 99);
                $attempt++;
            } catch (TimeoutException $e) {
                echo "✅ Username tersedia: $username\n";
                break;
            }
        }

        if ($attempt >= $maxAttempts) {
            throw new Exception("Gagal mendapatkan username yang tersedia setelah $maxAttempts percobaan.");
        }

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Passwd'))
        );

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('PasswdAgain'))
        );

        sleep(1);

        $checkboxContainer = $this->driver->findElement(WebDriverBy::cssSelector('div[jsname="ornU0b"]'));
        $checkboxContainer->click();

        $specialChars = ['!', '?', '@', '#', '$', '%', '^', '&', '*'];
        $randomSymbol1 = $specialChars[array_rand($specialChars)];
        $randomSymbol2 = $specialChars[array_rand($specialChars)];

        $password = $firstName . $randomSymbol1 . $lastName . $randomSymbol2 . $year;

        sleep(rand(1, 3));
        $this->slowType($this->driver->findElement(WebDriverBy::name('Passwd')), $password);
        sleep(rand(1, 3));
        $this->slowType($this->driver->findElement(WebDriverBy::name('PasswdAgain')), $password);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body'))
        );

        // try {
        //     try {
        //         $errorElement = $this->driver->findElement(WebDriverBy::xpath("//*[contains(text(), 'Sorry, we could not create your Google Account')]"));
        //         if ($errorElement->isDisplayed()) {
        //             $this->restartProgram();
        //             return;
        //         }
        //     } catch (NoSuchElementException $e) {
        //     }

        //     $this->driver->wait(10)->until(
        //         WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('phoneNumberId'))
        //     );

        //     $useSmsActivate = false; // Ganti true jika ingin menggunakan SMS-Activate
        //     $phoneNumber = '';
        //     $orderId = '';

        //     if ($useSmsActivate) {
        //         // SMS-Activate API
        //         $apiKey = '83eA2A1142980d5426fb50bb782b62f1';
        //         $country = '6'; // Indonesia
        //         $service = 'go'; // Google

        //         $apiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=getNumber&service=$service&country=$country";
        //         $response = file_get_contents($apiUrl);

        //         if (strpos($response, 'ACCESS_NUMBER') === false) {
        //             die("Gagal mendapatkan nomor dari SMS-Activate");
        //         }

        //         $parts = explode(':', $response);
        //         $orderId = $parts[1]; // ID order
        //         $phoneNumber = $parts[2]; // Nomor HP
        //     } else {
        //         // 5Sim API
        //         $token = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjA0NTQ5OTEsImlhdCI6MTcyODkxODk5MSwicmF5IjoiNmM3NjUyYzM1YjI0NjUzY2VhZGRiODdlMjU1MDgxY2QiLCJzdWIiOjI3NzMyMDl9.O0XspCzUhluZyT7nLEIBCfkju1Yf48lWMPy3c-QXGt5zHpN32zt5OsY-IiL26aJ6Rc2ozkPCnA71JEK0QDp086r88WOiCqeogr-ssfl2RVK3G0Rh0Cq42Cb6vbv2y0JOagOfTp8EowzB1k8IZpetg0xZZw3JhuErguDPcpeR-Jk5IwqXb9RmXaKCU8f236aPT8PWdvxdm5amPtHRIPh7l1_7dQhAnoYNFwb8mApeyqFWDS6wJc1u9ZNOogrQnoZa-JVj-BfmnkU96kP_QWFxcBJs9BAWHqt8xei7DX5wKK0qiZaE1SGoSZe6hE-WnfRQXrzR0pukDa64EHTuHcLn2w';
        //         $country = 'indonesia';
        //         $operator = 'any';
        //         $product = 'google';

        //         $apiUrl = "https://5sim.net/v1/user/buy/activation/$country/$operator/$product";
        //         $headers = [
        //             "Authorization: Bearer $token",
        //             "Accept: application/json"
        //         ];

        //         $ch = curl_init();
        //         curl_setopt($ch, CURLOPT_URL, $apiUrl);
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         $response = curl_exec($ch);
        //         curl_close($ch);

        //         $data = json_decode($response, true);
        //         if (!isset($data['phone'])) {
        //             die("Gagal mendapatkan nomor dari API 5Sim");
        //         }

        //         $phoneNumber = $data['phone'];
        //         $orderId = $data['id'];
        //     }

        //     $phoneNumberInput = $this->driver->findElement(WebDriverBy::id('phoneNumberId'));
        //     $phoneNumberInput->click();
        //     $phoneNumberInput->sendKeys($phoneNumber);

        //     $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        //     sleep(5);

        //     // Cek error
        //     $errorElements = $this->driver->findElements(WebDriverBy::xpath("//*[contains(text(), 'This phone number has been used too many times') or contains(text(), 'This phone number cannot be used for verification.') or contains(text(), 'This phone number format is not recognized. Please check the country and number.')]"));
        //     if (count($errorElements) > 0) {
        //         echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        //         echo "⚠️  NOMOR TIDAK VALID ⚠️\n";
        //         echo "🚫 Nomor sudah terlalu sering digunakan atau tidak dapat digunakan untuk verifikasi.\n";
        //         echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";


        //         if ($useSmsActivate) {
        //             // Batalkan nomor di SMS-Activate
        //             $cancelApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=8&id=$orderId";
        //             file_get_contents($cancelApiUrl);
        //             echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        //             echo "🚨 ORDER DICANCEL 🚨\n";
        //             echo "✅ Order dengan ID: $orderId berhasil dibatalkan di SMS-Activate.\n";
        //             echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

        //         } else {
        //             // Ban nomor di 5Sim
        //             $banApiUrl = "https://5sim.net/v1/user/ban/$orderId";
        //             $ch = curl_init();
        //             curl_setopt($ch, CURLOPT_URL, $banApiUrl);
        //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //             curl_exec($ch);
        //             curl_close($ch);
        //             echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        //             echo "🚨 ORDER DIBANNED 🚨\n";
        //             echo "✅ Order dengan ID: $orderId berhasil dibanned di 5Sim.\n";
        //             echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        //         }

        //         $this->restartProgram();
        //         return;
        //     }

        //     $this->driver->wait(15)->until(
        //         WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('code'))
        //     );

        //     // Cek OTP
        //     $otp = null;
        //     if ($useSmsActivate) {
        //         // Cek OTP dari SMS-Activate
        //         $otpApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=getStatus&id=$orderId";
        //         do {
        //             sleep(5);
        //             $response = file_get_contents($otpApiUrl);
        //             if (strpos($response, 'STATUS_OK') !== false) {
        //                 $otp = explode(':', $response)[1];
        //             }
        //         } while (!$otp);
        //     } else {
        //         // Cek OTP dari 5Sim
        //         $otpApiUrl = "https://5sim.net/v1/user/check/$orderId";
        //         do {
        //             sleep(5);
        //             $ch = curl_init();
        //             curl_setopt($ch, CURLOPT_URL, $otpApiUrl);
        //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //             $otpResponse = curl_exec($ch);
        //             curl_close($ch);

        //             $otpData = json_decode($otpResponse, true);
        //             $otp = $otpData['sms'][0]['code'] ?? null;
        //         } while (!$otp);
        //     }

        //     $otpInput = $this->driver->findElement(WebDriverBy::id('code'));
        //     $otpInput->sendKeys($otp);

        //     $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        //     if ($useSmsActivate) {
        //         // Konfirmasi OTP di SMS-Activate
        //         $finishApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=6&id=$orderId";
        //         file_get_contents($finishApiUrl);
        //     }

        //     echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        //     echo "🎉 SUKSES: Verifikasi berhasil!\n";
        //     echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        // } catch (Exception $e) {
        //     echo "\nTerjadi error: " . $e->getMessage();
        //     $this->restartProgram();
        // }

        try {
            while (true) { // Looping untuk mendapatkan nomor baru jika gagal
                try {
                    $errorElement = $this->driver->findElement(WebDriverBy::xpath("//*[contains(text(), 'Sorry, we could not create your Google Account')]"));
                    if ($errorElement->isDisplayed()) {
                        continue; // Ambil nomor baru tanpa restart program
                    }
                } catch (NoSuchElementException $e) {
                }

                $this->driver->wait(10)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('phoneNumberId'))
                );

                $useSmsActivate = false; // Ganti true jika ingin menggunakan SMS-Activate
                $phoneNumber = '';
                $orderId = '';

                if ($useSmsActivate) {
                    // SMS-Activate API
                    $apiKey = '83eA2A1142980d5426fb50bb782b62f1';
                    $country = '6'; // Indonesia
                    $service = 'go'; // Google

                    $apiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=getNumber&service=$service&country=$country";
                    $response = file_get_contents($apiUrl);

                    if (strpos($response, 'ACCESS_NUMBER') === false) {
                        echo "Gagal mendapatkan nomor dari SMS-Activate. Mencoba lagi...\n";
                        continue; // Coba dapatkan nomor baru
                    }

                    $parts = explode(':', $response);
                    $orderId = $parts[1]; // ID order
                    $phoneNumber = $parts[2]; // Nomor HP
                } else {
                    // 5Sim API
                    $token = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjA0NTQ5OTEsImlhdCI6MTcyODkxODk5MSwicmF5IjoiNmM3NjUyYzM1YjI0NjUzY2VhZGRiODdlMjU1MDgxY2QiLCJzdWIiOjI3NzMyMDl9.O0XspCzUhluZyT7nLEIBCfkju1Yf48lWMPy3c-QXGt5zHpN32zt5OsY-IiL26aJ6Rc2ozkPCnA71JEK0QDp086r88WOiCqeogr-ssfl2RVK3G0Rh0Cq42Cb6vbv2y0JOagOfTp8EowzB1k8IZpetg0xZZw3JhuErguDPcpeR-Jk5IwqXb9RmXaKCU8f236aPT8PWdvxdm5amPtHRIPh7l1_7dQhAnoYNFwb8mApeyqFWDS6wJc1u9ZNOogrQnoZa-JVj-BfmnkU96kP_QWFxcBJs9BAWHqt8xei7DX5wKK0qiZaE1SGoSZe6hE-WnfRQXrzR0pukDa64EHTuHcLn2w';
                    $country = 'indonesia';
                    $operator = 'any';
                    $product = 'google';

                    $apiUrl = "https://5sim.net/v1/user/buy/activation/$country/$operator/$product";
                    $headers = [
                        "Authorization: Bearer $token",
                        "Accept: application/json"
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $data = json_decode($response, true);
                    if (!isset($data['phone'])) {
                        echo "Gagal mendapatkan nomor dari 5Sim. Mencoba lagi...\n";
                        continue; // Coba dapatkan nomor baru
                    }

                    $phoneNumber = $data['phone'];
                    $orderId = $data['id'];
                }

                // Masukkan nomor ke input
                $phoneNumberInput = $this->driver->findElement(WebDriverBy::id('phoneNumberId'));
                $phoneNumberInput->clear();
                $phoneNumberInput->click();
                $phoneNumberInput->sendKeys($phoneNumber);

                $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();
                sleep(5);

                // Cek error penggunaan nomor
                $errorElements = $this->driver->findElements(WebDriverBy::xpath("//*[contains(text(), 'This phone number has been used too many times') or contains(text(), 'This phone number cannot be used for verification.') or contains(text(), 'This phone number format is not recognized. Please check the country and number.')]"));
                if (count($errorElements) > 0) {
                    echo "⚠️  Nomor tidak valid. Mencoba nomor baru...\n";

                    if ($useSmsActivate) {
                        // Batalkan nomor di SMS-Activate
                        $cancelApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=8&id=$orderId";
                        file_get_contents($cancelApiUrl);
                    } else {
                        // Ban nomor di 5Sim
                        $banApiUrl = "https://5sim.net/v1/user/ban/$orderId";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $banApiUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_exec($ch);
                        curl_close($ch);
                    }

                    continue; // Coba dapatkan nomor baru tanpa restart
                }

                $this->driver->wait(15)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('code'))
                );

                // Cek OTP
                $otp = null;
                if ($useSmsActivate) {
                    $otpApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=getStatus&id=$orderId";
                    do {
                        sleep(5);
                        $response = file_get_contents($otpApiUrl);
                        if (strpos($response, 'STATUS_OK') !== false) {
                            $otp = explode(':', $response)[1];
                        }
                    } while (!$otp);
                } else {
                    $otpApiUrl = "https://5sim.net/v1/user/check/$orderId";
                    do {
                        sleep(5);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $otpApiUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $otpResponse = curl_exec($ch);
                        curl_close($ch);

                        $otpData = json_decode($otpResponse, true);
                        $otp = $otpData['sms'][0]['code'] ?? null;
                    } while (!$otp);
                }

                $otpInput = $this->driver->findElement(WebDriverBy::id('code'));
                $otpInput->sendKeys($otp);

                $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

                if ($useSmsActivate) {
                    $finishApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=6&id=$orderId";
                    file_get_contents($finishApiUrl);
                }

                echo "🎉 SUKSES: Verifikasi berhasil!\n";
                break; // Keluar dari loop jika sukses
            }
        } catch (Exception $e) {
            echo "\nTerjadi error: " . $e->getMessage();
        }


        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id("recoverySkip"))
        )->click();
        sleep(3);

        $nextButton = $this->driver->executeScript("document.querySelector('button span.VfPpkd-vQzf8d').click();");
        sleep(3);

        $this->driver->executeScript("
    document.querySelectorAll('button span.VfPpkd-vQzf8d').forEach(el => {
        if (el.innerText.trim() === 'I agree') {
            el.click();
        }
    });
");

        $data = [
            $firstName,
            $lastName,
            $day,
            $month,
            $year,
            $username . "@gmail.com",
            $password
        ];

        $this->saveToTxt($data);

        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🎉 SUKSES: Akun berhasil dibuat!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

        sleep(60);

        // // Coba selesaikan CAPTCHA dengan ekstensi Buster
        // if ($this->solveCaptchaWithBuster()) {
        //     echo "CAPTCHA berhasil dipecahkan dengan Buster!\n";
        // } else {
        //     echo "Gagal menyelesaikan CAPTCHA!\n";
        //     return;
        // }

        // echo "Form berhasil dikirim!\n";
    }

    private function solveCaptchaWithBuster()
    {
        try {
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('iframe[title="reCAPTCHA"]'))
            );

            $captchaFrame = $this->driver->findElement(WebDriverBy::cssSelector('iframe[title="reCAPTCHA"]'));
            $this->driver->switchTo()->frame($captchaFrame);

            $this->driver->findElement(WebDriverBy::cssSelector('.recaptcha-checkbox'))->click();
            sleep(3);

            $this->driver->switchTo()->defaultContent();

            sleep(5);
            $challengeFrame = $this->driver->findElement(WebDriverBy::cssSelector('iframe[title="recaptcha challenge"]'));
            $this->driver->switchTo()->frame($challengeFrame);

            $busterButton = $this->driver->findElement(WebDriverBy::cssSelector('button[aria-label="Solve this CAPTCHA"]'));
            $busterButton->click();

            sleep(15);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function saveToTxt($data)
    {
        $filePath = 'accounts.txt';

        date_default_timezone_set('Asia/Jakarta');

        if (!file_exists($filePath)) {
            $header = "Timestamp | First Name | Last Name | Day | Month | Year | Username | Password\n";
            $header .= str_repeat('-', 100) . "\n";
            file_put_contents($filePath, $header, LOCK_EX);
        }

        $timestamp = date('Y-m-d H:i:s');

        $username = isset($data[5]) ? str_pad($data[5], 40, ' ', STR_PAD_RIGHT) : 'N/A';
        $password = isset($data[6]) ? str_pad($data[6], 40, ' ', STR_PAD_RIGHT) : 'N/A';

        $line = sprintf(
            "%s | %s | %s | %s | %s | %s | %s | %s\n",
            $timestamp,
            $data[0] ?? 'N/A',
            $data[1] ?? 'N/A',
            $data[2] ?? 'N/A',
            $data[3] ?? 'N/A',
            $data[4] ?? 'N/A',
            trim($username),
            trim($password)
        );

        file_put_contents($filePath, $line, FILE_APPEND | LOCK_EX);
    }

    private function restartProgram()
    {
        $this->driver->quit();

        if (PHP_OS_FAMILY === 'Windows') {
            exec("start /B php " . __FILE__);
        } else {
            exec("php " . __FILE__ . " > /dev/null 2>&1 &");
        }

        exit();
    }

    public function close()
    {
        $this->driver->quit();
    }
}

$automation = new xixixixi();
$automation->fillForm();
$automation->close();

?>