#!/bin/bash

echo -e "🚀 SCRIPT INFORMATION\n\nScript ini dibuat oleh: Ahmad Haikal Rizal\nInstagram: @lelekuningcoy\nGitHub: github.com/ahr-ahr\n\nSabar bos..."

read -p "Masukkan jumlah Chrome yang ingin dibuka: " chromeCount

if [[ -z "$chromeCount" || "$chromeCount" -le 0 ]]; then
    echo "Anda tidak memasukkan jumlah yang valid! Script akan berhenti."
    exit 1
fi

chromedriver_path="/path/to/chromedriver"
$chromedriver_path --port=9515 --enable-unsafe-webgl --enable-unsafe-swiftshader &
sleep 3

# Menjalankan PHP script sesuai jumlah yang diminta
for ((i=1; i<=chromeCount; i++))
do
    php /path/to/index.php &
    sleep 1
done

exit 0
