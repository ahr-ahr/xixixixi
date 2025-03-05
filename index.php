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
use Facebook\WebDriver\WebDriverWait;

class xixixixi
{
    private $driver;
    private $faker;
    private $port;

    public function __construct()
    {
        $options = getopt("", ["port:"]);
        $this->port = $options['port'] ?? 9515;
        $webdriverUrl = "http://localhost:" . $this->port;

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
            "--disable-blink-features=AutomationControlled",
            "--start-maximized",
            "--disable-infobars",
            "--disable-dev-shm-usage",
            //"--disable-extensions",
            "--disable-web-security",
            "--allow-running-insecure-content",
            "--disable-features=IsolateOrigins,site-per-process",
            "--window-size=1920,1080",
            "--disable-background-timer-throttling",
            "--disable-backgrounding-occluded-windows",
            "--disable-renderer-backgrounding",
            "--disable-client-side-phishing-detection"
        ]);


        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create($webdriverUrl, $capabilities);
        $this->driver->executeScript('Object.defineProperty(navigator, "webdriver", {get: () => undefined})');

        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;33m🚀 GOOGLE ACCOUNT AUTO-REGISTER BOT\e[0m\n";
        echo "\e[1;36m━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\e[0m\n";
        echo "\e[1;32m✅ Status: \e[1;37mBerjalan\e[0m\n";
        echo "\e[1;32m🌐 Proxy Server: \e[1;34m$proxyServer\e[0m\n";
        echo "\e[1;32m🔌 Ekstensi Aktif: \e[1;35mYa\e[0m\n";
        echo "\e[1;32m🔢 Port ChromeDriver: \e[1;34m$this->port\e[0m\n";
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
        //$url1 = 'https://accounts.google.com/signup';
        $url1 = 'https://workspace.google.com/intl/en-US/gmail/';
        $url1 = 'https://www.google.com';
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

        $searchBox = $this->driver->findElement(WebDriverBy::name('q'));
        $searchBox->sendKeys('Google Account Signup')->submit();
        sleep(rand(2, 4));

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath("//a[.//span[contains(text(), 'Sign in - Google Accounts')]]")
            )
        );

        $signupLink = $this->driver->findElement(
            WebDriverBy::xpath("//a[.//span[contains(text(), 'Sign in - Google Accounts')]]")
        );

        $this->driver->executeScript("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", [$signupLink]);
        sleep(rand(1, 2));

        $this->driver->executeScript("
    const event = new MouseEvent('mouseover', { bubbles: true });
    arguments[0].dispatchEvent(event);
", [$signupLink]);
        sleep(rand(1, 2));

        $signupLink->click();
        sleep(rand(2, 3));


        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath("//button[.//span[text()='Create account']] | //a[contains(@href, '/lifecycle/flows/signup')]")
            )
        );

        $buatAkunButton = null;

        try {
            $buatAkunButton = $this->driver->findElement(WebDriverBy::xpath("//button[.//span[text()='Create account']]"));
        } catch (NoSuchElementException $e) {
            try {
                $buatAkunButton = $this->driver->findElement(WebDriverBy::xpath("//a[contains(@href, '/lifecycle/flows/signup')]"));
            } catch (NoSuchElementException $e) {
                throw new Exception("Elemen 'Create account' tidak ditemukan!");
            }
        }

        $this->driver->executeScript("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", [$buatAkunButton]);
        sleep(rand(1, 2));

        $this->driver->executeScript("
    const event = new MouseEvent('mouseover', { bubbles: true });
    arguments[0].dispatchEvent(event);
", [$buatAkunButton]);
        sleep(rand(1, 2));

        $buatAkunButton->click();
        sleep(rand(2, 3));

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath("//li[.//span[text()='For my personal use']]")
            )
        );

        $personalUseOption = $this->driver->findElement(WebDriverBy::xpath("//li[.//span[text()='For my personal use']]"));

        $this->driver->executeScript("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", [$personalUseOption]);
        sleep(rand(1, 2));

        $this->driver->executeScript("
    const event = new MouseEvent('mouseover', { bubbles: true });
    arguments[0].dispatchEvent(event);
", [$personalUseOption]);
        sleep(rand(1, 2));

        $personalUseOption->click();
        sleep(rand(2, 3));



        //         $dropdown = $this->driver->executeScript("
// const dropdownButton = document.querySelector('gws-dropdown-button');
// if (dropdownButton) {
//     dropdownButton.scrollIntoView({ behavior: 'smooth', block: 'center' });

        //     const mouseOverEvent = new MouseEvent('mouseover', { bubbles: true });
//     dropdownButton.dispatchEvent(mouseOverEvent);

        //     setTimeout(() => {
//         dropdownButton.click();
//         console.log('Dropdown diklik!');
//     }, Math.random() * 500 + 500); // Delay antara 500-1000ms

        //     return true;
// } else {
//     console.log('❌ Dropdown tidak ditemukan!');
//     return false;
// }
// ");

        //         if ($dropdown) {
//             sleep(rand(1, 2));

        //             $personalUse = $this->driver->executeScript("
//     const personalUseButton = [...document.querySelectorAll('a')].find(a => a.innerText.includes('For my personal use'));
//     if (personalUseButton) {
//         personalUseButton.scrollIntoView({ behavior: 'smooth', block: 'center' });

        //         // Simulasi hover sebelum klik
//         const mouseOverEvent = new MouseEvent('mouseover', { bubbles: true });
//         personalUseButton.dispatchEvent(mouseOverEvent);

        //         // Delay acak sebelum klik
//         setTimeout(() => {
//             personalUseButton.click();
//             console.log('✅ Berhasil klik For my personal use!');
//         }, Math.random() * 700 + 300); // Delay antara 300-1000ms

        //         return true;
//     } else {
//         console.log('❌ Opsi For my personal use tidak ditemukan!');
//         return false;
//     }
// ");

        //             if (!$personalUse) {
//                 throw new Exception("Gagal menemukan atau mengklik opsi 'For my personal use'.");
//             }
//         } else {
//             throw new Exception("Gagal menemukan atau mengklik dropdown 'Create an account'.");
//         }

        $firstName = preg_replace('/[^A-Za-z]/', '', $this->faker->firstName);
        $lastName = preg_replace('/[^A-Za-z]/', '', $this->faker->lastName);

        $actions = new WebDriverActions($this->driver);

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('firstName'))
        );
        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('lastName'))
        );

        $firstNameField = $this->driver->findElement(WebDriverBy::name('firstName'));
        $lastNameField = $this->driver->findElement(WebDriverBy::name('lastName'));

        $firstNameField->click();
        $this->slowType($firstNameField, $firstName);
        sleep(rand(1, 2));

        $lastNameField->click();
        $this->slowType($lastNameField, $lastName);
        sleep(rand(1, 3));

        $nextButton = $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'));
        $actions->moveToElement($nextButton)->perform();
        sleep(rand(1, 2));
        $nextButton->click();

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('day'))
        );

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('month'))
        );

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('year'))
        );

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('gender'))
        );

        $birthDate = $this->faker->dateTimeBetween('-50 years', '-18 years');
        $day = $birthDate->format('d');
        $month = $birthDate->format('F');
        $year = $birthDate->format('Y');

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

        try {
            $this->driver->wait(20)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))
            );

            $this->driver->executeScript("document.querySelector('.zJKIV.lezCeb.kAVONc[jsname=\"ornU0b\"][data-value=\"custom\"]').click();");
            sleep(3);

            $this->driver->wait(20)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

        } catch (NoSuchElementException $e) {
            $this->driver->wait(20)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );
        }

        $attempt = 0;
        $maxAttempts = 3;

        while ($attempt < $maxAttempts) {
            sleep(1);

            $this->driver->wait(20)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            $usernameField = $this->driver->findElement(WebDriverBy::name('Username'));
            $usernameField->clear();

            sleep(3);

            $this->driver->wait(20)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );
            $usernameField = $this->driver->findElement(WebDriverBy::name('Username'));
            $username = "a" . $firstName . "h" . $lastName . "r";
            $this->slowType($usernameField, $username);

            usleep(rand(500000, 1500000));

            try {
                sleep(2);

                $errorElement = $this->driver->findElements(
                    WebDriverBy::xpath("//*[contains(text(), 'That username is taken. Try another.')]")
                );

                if (count($errorElement) > 0) {
                    echo "⚠️  Username '$username' sudah diambil, mencoba variasi lain...\n";
                    $attempt++;
                } else {
                    echo "✅ Username '$username' tersedia!\n";
                    break;
                }
            } catch (TimeoutException $e) {
                echo "✅ Username '$username' tersedia!\n";
                break;
            }
        }

        if ($attempt >= $maxAttempts) {
            throw new Exception("Gagal mendapatkan username yang tersedia setelah $maxAttempts percobaan.");
        }


        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        sleep(3);

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('div[jsname="ornU0b"]'))
        );

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Passwd'))
        );

        $this->driver->wait(20)->until(
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

        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        try {
            while (true) {
                try {
                    $this->driver->wait(10)->until(
                        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body'))
                    );
                    $errorElement = (new WebDriverWait($this->driver, 10))->until(
                        WebDriverExpectedCondition::presenceOfElementLocated(
                            WebDriverBy::xpath("//*[contains(text(), 'Sorry, we could not create your Google Account.')]")
                        )
                    );

                    if ($errorElement->isDisplayed()) {
                        echo "❌ ERROR: Pendaftaran gagal.\n";
                        $this->restartProgram();
                        return;
                    }
                } catch (TimeoutException $e) {
                    echo "✅ Tidak ada pesan error, lanjutkan proses.\n";
                }


                $this->driver->wait(20)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('phoneNumberId'))
                );

                $useSmsActivate = false;
                $use5Sim = true;
                $useSmsPool = false;
                $useSmsHub = false;

                $phoneNumber = '';
                $orderId = '';

                // SMS-Activate logic
                if ($useSmsActivate) {
                    $apiKey = '83eA2A1142980d5426fb50bb782b62f1';
                    $country = '6'; // Country code for Indonesia (or other country as needed)
                    $service = 'go'; // Service code for Google

                    $apiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=getNumber&service=$service&country=$country";
                    $response = file_get_contents($apiUrl);

                    if (strpos($response, 'ACCESS_NUMBER') === false) {
                        echo "Gagal mendapatkan nomor dari SMS-Activate. Mencoba lagi...\n";
                        continue;
                    }

                    $parts = explode(':', $response);
                    $orderId = $parts[1]; // Order ID
                    $phoneNumber = $parts[2]; // Phone number
                }

                // 5Sim logic
                if ($use5Sim && $phoneNumber == '') {
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

                // SMSPool logic
                if ($useSmsPool && $phoneNumber == '') {
                    $smsPoolToken = 'YOUR_SMSPOOL_BEARER_TOKEN';
                    $apiUrl = "https://api.smspool.net/purchase/sms";
                    $headers = [
                        "Authorization: Bearer $smsPoolToken",
                        "Content-Type: application/x-www-form-urlencoded"
                    ];

                    $postFields = [
                        'country' => '1', // Use country code (1 for USA, adjust accordingly)
                        'service' => '1', // Service ID for Google
                        'max_price' => '0.01',
                        'pricing_option' => '0',
                        'quantity' => '2',
                        'areacode' => '[]', // Optional: provide area codes
                        'exclude' => '0',
                        'create_token' => '0',
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $smsPoolResponse = json_decode($response, true);
                    if ($smsPoolResponse['success'] == 1) {
                        $phoneNumber = $smsPoolResponse['data'][0]['phone']; // Example: using the first phone number from response
                        $orderId = $smsPoolResponse['data'][0]['orderid']; // Order ID
                    } else {
                        echo "Gagal mendapatkan nomor dari SMSPool. Mencoba lagi...\n";
                        continue;
                    }
                }

                // SMSHub logic
                if ($useSmsHub && $phoneNumber == '') {
                    $apiKey = 'YOUR_SMSHUB_API_KEY';
                    $country = 'RU'; // Example country code for Russia, adjust as needed
                    $service = 'google'; // Service code for Googles
                    $operator = 'any'; // You can change this based on the operator, if necessary

                    $apiUrl = "https://smshub.org/stubs/handler_api.php?api_key=$apiKey&action=getNumber&service=$service&country=$country&operator=$operator";
                    $response = file_get_contents($apiUrl);

                    if (strpos($response, 'ACCESS_NUMBER') === false) {
                        echo "Gagal mendapatkan nomor dari SMSHub. Mencoba lagi...\n";
                        continue;
                    }

                    $parts = explode(':', $response);
                    $orderId = $parts[1]; // Order ID
                    $phoneNumber = $parts[2]; // Phone number
                }

                // Enter phone number in input
                $phoneNumberInput = $this->driver->findElement(WebDriverBy::id('phoneNumberId'));
                $phoneNumberInput->clear();
                $phoneNumberInput->click();
                $phoneNumberInput->sendKeys($phoneNumber);

                $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();
                sleep(5);

                // Check for number errors
                $errorElements = $this->driver->findElements(WebDriverBy::xpath("//*[contains(text(), 'This phone number has been used too many times') or contains(text(), 'This phone number cannot be used for verification.') or contains(text(), 'This phone number format is not recognized. Please check the country and number.') or contains(text), 'There was a problem verifying your phone number.')]"));
                if (count($errorElements) > 0) {
                    echo "⚠️  Nomor tidak valid. Mencoba nomor baru...\n";

                    // Cancel number in SMS-Activate
                    if ($useSmsActivate) {
                        $cancelApiUrl = "https://api.sms-activate.ae/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=8&id=$orderId";
                        file_get_contents($cancelApiUrl);
                        echo "🚨 ORDER DICANCEL 🚨\n";
                        echo "✅ Order dengan ID: $orderId berhasil dibatalkan di SMS-Activate.\n";
                        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                    }
                    // Ban number in 5Sim
                    elseif ($use5Sim) {
                        $banApiUrl = "https://5sim.net/v1/user/ban/$orderId";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $banApiUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_exec($ch);
                        curl_close($ch);
                        echo "✅ Order dengan ID: $orderId berhasil dibatalkan di 5Sim.\n";
                        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                    }
                    // Ban number in SMSPool
                    elseif ($useSmsPool) {
                        $banApiUrl = "https://api.smspool.net/ban/$orderId";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $banApiUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_exec($ch);
                        curl_close($ch);
                        echo "✅ Order dengan ID: $orderId berhasil dibatalkan di SMSPool.\n";
                        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                    } elseif ($useSmsHub) {
                        $banApiUrl = "https://smshub.org/stubs/handler_api.php?api_key=$apiKey&action=setStatus&status=8&id=$orderId";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_exec($ch);
                        curl_close($ch);
                        echo "✅ Order dengan ID: $orderId berhasil dibatalkan di SMSHub.\n";
                        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                    }
                    continue;
                }

                $this->driver->wait(15)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('code'))
                );

                // Check OTP
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
                } elseif ($use5Sim) {
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
                } elseif ($useSmsPool) {
                    $otpApiUrl = "https://api.smspool.net/otp/$orderId";
                    do {
                        sleep(5);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $otpApiUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $otpResponse = curl_exec($ch);
                        curl_close($ch);

                        $otpData = json_decode($otpResponse, true);
                        $otp = $otpData['code'] ?? null;
                    } while (!$otp);
                } elseif ($useSmsHub) {
                    $otpApiUrl = "https://smshub.org/stubs/handler_api.php?api_key=$apiKey&action=getStatus&id=$orderId";
                    do {
                        sleep(5);
                        $response = file_get_contents($otpApiUrl);
                        if (strpos($response, 'STATUS_OK') !== false) {
                            $otp = explode(':', $response)[1];
                        }
                    } while (!$otp);
                }

                $otpInput = $this->driver->findElement(WebDriverBy::id('code'));
                $otpInput->clear();
                $otpInput->sendKeys($otp);

                sleep(2);
                $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                echo "🎉 SUKSES: Verifikasi berhasil!\n";
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                break;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }


        $this->driver->wait(20)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id("recoverySkip"))
        )->click();
        sleep(2);

        $nextButton = $this->driver->executeScript("document.querySelector('button span.VfPpkd-vQzf8d').click();");
        sleep(2);

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

        sleep(10);

        $this->restartProgram();

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
        $txtFilePath = 'accounts.txt';
        $csvFilePath = 'accounts.csv';

        date_default_timezone_set('Asia/Jakarta');

        // Header untuk TXT jika belum ada
        if (!file_exists($txtFilePath)) {
            $header = "Timestamp | First Name | Last Name | Day | Month | Year | Username | Password\n";
            $header .= str_repeat('-', 100) . "\n";
            file_put_contents($txtFilePath, $header, LOCK_EX);
        }

        // Timestamp sekarang
        $timestamp = date('Y-m-d H:i:s');

        // Formatting untuk TXT
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

        // Simpan ke TXT
        file_put_contents($txtFilePath, $line, FILE_APPEND | LOCK_EX);

        // Simpan ke CSV
        $csvData = [
            $timestamp,
            $data[0] ?? 'N/A',
            $data[1] ?? 'N/A',
            $data[2] ?? 'N/A',
            $data[3] ?? 'N/A',
            $data[4] ?? 'N/A',
            $data[5] ?? 'N/A',
            $data[6] ?? 'N/A'
        ];

        $file = fopen($csvFilePath, 'a'); // Mode append
        if ($file) {
            fputcsv($file, $csvData); // Simpan dalam format CSV
            fclose($file);
        }
    }


    private function restartProgram()
    {
        $this->driver->quit();

        if (PHP_OS_FAMILY === 'Windows') {
            exec("start /B php " . __FILE__ . " --port=" . $this->port);
        } else {
            exec("php " . __FILE__ . " --port=" . $this->port . " > /dev/null 2>&1 &");
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