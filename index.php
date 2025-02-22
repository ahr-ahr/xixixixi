<?php

require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\Exception\NoSuchElementException;

class EdgeAutomation
{
    private $driver;

    public function __construct()
    {
        $options = new ChromeOptions();

        $options->addArguments([
            '--user-data-dir=C:\Users\AHMAD HAIKAL RIZAL\AppData\Local\Microsoft\Edge\User Data',
            '--profile-directory=Default',
            '--disable-popup-blocking',
            '--disable-notifications',
            '--load-extension=C:\xampp\htdocs\xixixixi\admkpobhocmdideidcndkfaeffadipkc'
        ]);
        //$options->addExtensions(['C:\xampp\htdocs\xixixixi\3.1.0_0.crx']);

        $capabilities = DesiredCapabilities::microsoftEdge();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create('http://localhost:9515', $capabilities);
    }

    public function fillForm()
    {
        $url = 'https://accounts.google.com/signup';
        $this->driver->get($url);

        // Tunggu elemen input "First Name" muncul
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('firstName'))
        );

        // Isi "First Name" dan "Last Name"
        $this->driver->findElement(WebDriverBy::name('firstName'))->sendKeys('China');
        $this->driver->findElement(WebDriverBy::name('lastName'))->sendKeys('Sipit');

        // Klik tombol "Next"
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        // Tunggu halaman berikutnya (Tanggal Lahir & Gender)
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('day'))
        );

        // Isi Tanggal Lahir (contoh: 15 Mei 2000)
        $this->driver->findElement(WebDriverBy::name('day'))->sendKeys('15');

        // Pilih Bulan (Mei = value "5")
        $monthDropdown = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('month')));
        $monthDropdown->selectByValue('5');

        // Isi Tahun
        $this->driver->findElement(WebDriverBy::name('year'))->sendKeys('2000');

        // Pilih Gender (Male)
        $genderDropdown = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('gender')));
        $genderDropdown->selectByValue('1'); // "1" biasanya untuk Male

        // Klik tombol "Next"
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

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
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys('chinasipit4289');

        } catch (NoSuchElementException $e) {
            // Jika opsi "Create your own Gmail address" tidak ditemukan, langsung isi username
            $this->driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Username'))
            );

            // Isi Username langsung
            $this->driver->findElement(WebDriverBy::name('Username'))->sendKeys('ahdadbahjdaj12');
        }

        // Tunggu tombol Next muncul setelah isi Username atau Email
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        // Klik tombol "Next"
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        // Tunggu halaman berikutnya (Password)
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('Passwd'))
        );

        // Isi Password dan Confirm Password
        $this->driver->findElement(WebDriverBy::name('Passwd'))->sendKeys('chinasipit');
        $this->driver->findElement(WebDriverBy::name('PasswdAgain'))->sendKeys('chinasipit');

        // Tunggu tombol Next muncul setelah isi Password
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('button[type="button"]'))
        );

        // Klik tombol "Next" setelah isi Password
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="button"]'))->click();

        // Tunggu CAPTCHA muncul
        sleep(5);

        // Coba selesaikan CAPTCHA dengan ekstensi Buster
        if ($this->solveCaptchaWithBuster()) {
            echo "CAPTCHA berhasil dipecahkan dengan Buster!\n";
        } else {
            echo "Gagal menyelesaikan CAPTCHA!\n";
            return;
        }

        echo "Form berhasil dikirim!\n";
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