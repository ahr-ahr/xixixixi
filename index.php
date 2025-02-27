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

class EdgeAutomation
{
    private $driver;
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
        $options = new ChromeOptions();

        $extensionPath = "C:\\xampp\\htdocs\\xixixixi\\admkpobhocmdideidcndkfaeffadipkc";

        $randomUserAgent = $this->faker->userAgent;

        $proxyApiUrl = "http://127.0.0.1:10101/api/proxy?t=2&num=1&country=ID";

        $options->addArguments([
            "--user-agent=$randomUserAgent",
            '--user-data-dir="C:\\Users\\AHMAD~1\\AppData\\Local\\Microsoft\\Edge\\User Data"',
            //"--proxy-server=$proxyApiUrl", // Langsung gunakan API proxy
            '--profile-directory="Profile 1"',
            '--load-extension=' . $extensionPath,
            '--disable-popup-blocking',
            '--disable-notifications',
            "--ignore-certificate-errors",
            "--no-sandbox",
            "--disable-gpu",
            "--disable-dev-shm-usage",
            "--proxy-bypass-list=*"
        ]);

        $options->addExtensions(['C:\xampp\htdocs\xixixixi\3.1.0_0.crx']);
        $options->addEncodedExtensions(['C:\xampp\htdocs\xixixixi\3.1.0_0.crx']);

        $capabilities = DesiredCapabilities::microsoftEdge();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create('http://localhost:9515', $capabilities);
        echo "Current User-Agent: " . $randomUserAgent;
    }

    public function fillForm()
    {
        $url1 = 'https://accounts.google.com/signup';
        $url2 = 'https://api64.ipify.org?format=json';

        // Buka window pertama
        $this->driver->get($url1);

        // Buka window baru
        $this->driver->executeScript("window.open('', '_blank');");

        // Pindah ke window kedua
        $windows = $this->driver->getWindowHandles();
        $this->driver->switchTo()->window($windows[1]);

        // Buka URL kedua di window baru
        $this->driver->get($url2);

        // Ambil IP
        $ip = $this->driver->findElement(WebDriverBy::tagName('body'))->getText();
        echo "\nCurrent IP: " . $ip;

        // Kembali ke window pertama
        $this->driver->switchTo()->window($windows[0]);


        // Tunggu elemen input "First Name" muncul
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('firstName'))
        );

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        $this->driver->findElement(WebDriverBy::name('firstName'))->sendKeys($firstName);
        $this->driver->findElement(WebDriverBy::name('lastName'))->sendKeys($lastName);

        // Klik tombol "Next"
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        // Tunggu halaman berikutnya (Tanggal Lahir & Gender)
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('day'))
        );

        // Generate tanggal lahir acak antara 18 hingga 50 tahun yang lalu
        $birthDate = $this->faker->dateTimeBetween('-50 years', '-18 years');
        $day = $birthDate->format('d');
        $month = $birthDate->format('F'); // Format bulan (January, February, dst.)
        $year = $birthDate->format('Y');

        // Isi Tanggal Lahir (Hari)
        $this->driver->findElement(WebDriverBy::id('day'))->sendKeys($day);

        // Pilih Bulan dari Dropdown
        $monthDropdown = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('month')));
        $monthDropdown->selectByVisibleText($month); // Memilih bulan sesuai nama (contoh: "January")

        // Tunggu 1 detik untuk memastikan dropdown tahun tersedia
        sleep(1);

        // Pilih Tahun dari Dropdown
        $this->driver->findElement(WebDriverBy::id('year'))->sendKeys($year);

        // Tunggu 1 detik sebelum memilih gender (opsional)
        sleep(1);

        // Pilih Gender (Male)
        $genderElement = $this->driver->findElement(WebDriverBy::id('gender'));
        if ($genderElement->isDisplayed()) {
            $genderDropdown = new WebDriverSelect($genderElement);
            $genderDropdown->selectByValue('1'); // "1" biasanya untuk Male
        } else {
            throw new Exception("Dropdown gender tidak ditemukan atau tidak dapat diakses.");
        }

        // Klik tombol "Next"
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        // **Buat Username dari First Name + Last Name + Year**
        $username = $firstName . $lastName . $year;

        try {
            // Tunggu elemen pilihan alamat Gmail atau opsi buat sendiri muncul
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))
            );

            // Klik opsi "Create your own Gmail address"
            $this->driver->findElement(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))->click();

            // Tunggu input email muncul
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            // Isi alamat Gmail yang diinginkan
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys($username);

        } catch (NoSuchElementException $e) {
            // Jika opsi "Create your own Gmail address" tidak ditemukan, langsung isi username
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            // Isi Username langsung
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys($username);
        }

        // Tunggu tombol Next muncul setelah isi Username atau Email
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

        $specialChars = ['!', '?', '@', '#', '$', '%', '^', '&', '*'];
        $randomSymbol1 = $specialChars[array_rand($specialChars)];
        $randomSymbol2 = $specialChars[array_rand($specialChars)];

        $password = $firstName . $randomSymbol1 . $lastName . $randomSymbol2 . $year;

        $this->driver->findElement(WebDriverBy::name('Passwd'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::name('PasswdAgain'))->sendKeys($password);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('body'))
        );
        try {
            try {
                $errorElement = $this->driver->findElement(WebDriverBy::xpath("//*[contains(text(), 'Sorry, we could not create your Google Account')]"));
                if ($errorElement->isDisplayed()) {
                    echo "Akun gagal dibuat. Restarting...\n";
                    $this->restartProgram();
                    return;
                }
            } catch (NoSuchElementException $e) {
            }

            // Tunggu sampai input nomor telepon muncul
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('phoneNumberId'))
            );

            $token = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjA0NTQ5OTEsImlhdCI6MTcyODkxODk5MSwicmF5IjoiNmM3NjUyYzM1YjI0NjUzY2VhZGRiODdlMjU1MDgxY2QiLCJzdWIiOjI3NzMyMDl9.O0XspCzUhluZyT7nLEIBCfkju1Yf48lWMPy3c-QXGt5zHpN32zt5OsY-IiL26aJ6Rc2ozkPCnA71JEK0QDp086r88WOiCqeogr-ssfl2RVK3G0Rh0Cq42Cb6vbv2y0JOagOfTp8EowzB1k8IZpetg0xZZw3JhuErguDPcpeR-Jk5IwqXb9RmXaKCU8f236aPT8PWdvxdm5amPtHRIPh7l1_7dQhAnoYNFwb8mApeyqFWDS6wJc1u9ZNOogrQnoZa-JVj-BfmnkU96kP_QWFxcBJs9BAWHqt8xei7DX5wKK0qiZaE1SGoSZe6hE-WnfRQXrzR0pukDa64EHTuHcLn2w';
            $country = 'indonesia';
            $operator = 'virtual52';
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

            if (isset($data['phone'])) {
                $phoneNumber = $data['phone'];
            } else {
                die("Gagal mendapatkan nomor dari API 5sim");
            }

            $phoneNumberInput = $this->driver->findElement(WebDriverBy::id('phoneNumberId'));
            $phoneNumberInput->click();
            $phoneNumberInput->sendKeys($phoneNumber);

            $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

            $this->driver->wait(15)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('code'))
            );

            $orderId = $data['id'];
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

            $otpInput = $this->driver->findElement(WebDriverBy::id('code'));
            $otpInput->sendKeys($otp);

            $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

            echo "Verifikasi berhasil!";
        } catch (Exception $e) {
            echo "Terjadi error: " . $e->getMessage();
            $this->restartProgram();
        }

        sleep(30);

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
            // Tunggu iframe reCAPTCHA muncul
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('iframe[title="reCAPTCHA"]'))
            );

            // Temukan elemen iframe reCAPTCHA
            $captchaFrame = $this->driver->findElement(WebDriverBy::cssSelector('iframe[title="reCAPTCHA"]'));
            $this->driver->switchTo()->frame($captchaFrame);

            // Klik checkbox reCAPTCHA
            $this->driver->findElement(WebDriverBy::cssSelector('.recaptcha-checkbox'))->click();
            sleep(3);

            // Kembali ke konteks utama
            $this->driver->switchTo()->defaultContent();

            // Tunggu challenge muncul dan cari frame challenge
            sleep(5);
            $challengeFrame = $this->driver->findElement(WebDriverBy::cssSelector('iframe[title="recaptcha challenge"]'));
            $this->driver->switchTo()->frame($challengeFrame);

            // Cari dan klik tombol Buster
            $busterButton = $this->driver->findElement(WebDriverBy::cssSelector('button[aria-label="Solve this CAPTCHA"]'));
            $busterButton->click();

            // Tunggu proses selesai
            sleep(15);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function restartProgram()
    {
        // Tutup WebDriver
        $this->driver->quit();

        // Restart program (Windows)
        if (PHP_OS_FAMILY === 'Windows') {
            exec("start /B php " . __FILE__);
        } else {
            // Restart program (Linux/macOS)
            exec("php " . __FILE__ . " > /dev/null 2>&1 &");
        }

        exit();
    }

    public function close()
    {
        $this->driver->quit();
    }
}

// Jalankan otomatisasi dengan solver CAPTCHA Buster
$automation = new EdgeAutomation();
$automation->fillForm();
$automation->close();

?>