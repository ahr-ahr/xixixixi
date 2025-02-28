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

        $extensionPath = "C:/xampp/htdocs/xixixixi/admkpobhocmdideidcndkfaeffadipkc";
        $randomUserAgent = $this->faker->userAgent;
        $proxyServer = "http://139.255.64.140:80";

        if (!file_exists($extensionPath)) {
            die("❌ ERROR: Folder ekstensi tidak ditemukan - $extensionPath\n");
        }
        if (!is_readable($extensionPath)) {
            die("❌ ERROR: Folder ekstensi tidak dapat dibaca - $extensionPath\n");
        }

        echo "✅ Folder ekstensi dapat diakses!\n";

        $options->addArguments([
            "--user-agent=$randomUserAgent",
            //"--proxy-server=$proxyServer",
            "--load-extension=$extensionPath",
            "--disable-popup-blocking",
            "--disable-notifications",
            "--ignore-certificate-errors",
            "--no-sandbox",
            "--disable-gpu",
            "--disable-dev-shm-usage"
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create('http://localhost:9515', $capabilities);

        echo "✅ Chrome Selenium sudah berjalan dengan ekstensi. Silakan periksa manual di browser!\n";

        sleep(5);
    }


    public function fillForm()
    {
        $url1 = 'https://accounts.google.com/signup/v2/webcreateaccount?flowName=GlifWebSignIn&flowEntry=SignUp';
        $url2 = 'https://api64.ipify.org?format=json';

        $this->driver->get($url1);

        $this->driver->executeScript("window.open('', '_blank');");

        $windows = $this->driver->getWindowHandles();
        $this->driver->switchTo()->window($windows[1]);

        $this->driver->get($url2);

        $ip = $this->driver->findElement(WebDriverBy::tagName('body'))->getText();
        echo "\nCurrent IP: " . $ip;

        $this->driver->switchTo()->window($windows[0]);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('firstName'))
        );

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        sleep(1);
        $this->driver->findElement(WebDriverBy::name('firstName'))->sendKeys($firstName);
        sleep(2.5);
        $this->driver->findElement(WebDriverBy::name('lastName'))->sendKeys($lastName);

        sleep(0.5);
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('day'))
        );

        $birthDate = $this->faker->dateTimeBetween('-50 years', '-18 years');
        $day = $birthDate->format('d');
        $month = $birthDate->format('F');
        $year = $birthDate->format('Y');

        $this->driver->findElement(WebDriverBy::id('day'))->sendKeys($day);

        $monthDropdown = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('month')));
        $monthDropdown->selectByVisibleText($month);

        sleep(1);

        $this->driver->findElement(WebDriverBy::id('year'))->sendKeys($year);

        sleep(1);

        $genderElement = $this->driver->findElement(WebDriverBy::id('gender'));
        if ($genderElement->isDisplayed()) {
            $genderDropdown = new WebDriverSelect($genderElement);
            $randomGender = rand(1, 2);
            $genderDropdown->selectByValue((string) $randomGender);
        } else {
            throw new Exception("Dropdown gender tidak ditemukan atau tidak dapat diakses.");
        }

        sleep(0.5);
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        $username = $firstName . $lastName . $year;

        try {
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))
            );

            $this->driver->findElement(WebDriverBy::xpath('//div[@jsname="CeL6Qc" and contains(text(), "Create your own Gmail address")]'))->click();

            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            sleep(1);
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys($username);

        } catch (NoSuchElementException $e) {
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            sleep(1);
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys($username);
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

        $specialChars = ['!', '?', '@', '#', '$', '%', '^', '&', '*'];
        $randomSymbol1 = $specialChars[array_rand($specialChars)];
        $randomSymbol2 = $specialChars[array_rand($specialChars)];

        $password = $firstName . $randomSymbol1 . $lastName . $randomSymbol2 . $year;

        sleep(2);
        $this->driver->findElement(WebDriverBy::name('Passwd'))->sendKeys($password);
        sleep(2);
        $this->driver->findElement(WebDriverBy::name('PasswdAgain'))->sendKeys($password);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        echo "\n" . $firstName;
        echo "\n" . $lastName;
        echo "\n" . $day;
        echo "\n" . $month;
        echo "\n" . $year;
        echo "\n" . $username;
        echo "\n" . $password;

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

            echo "\nVerifikasi berhasil!";
        } catch (Exception $e) {
            echo "\nTerjadi error: " . $e->getMessage();
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

$automation = new EdgeAutomation();
$automation->fillForm();
$automation->close();

?>