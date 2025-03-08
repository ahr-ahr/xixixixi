#!/bin/bash

echo -e "🚀 SCRIPT INFORMATION\n\nScript ini dibuat oleh: Ahmad Haikal Rizal\nInstagram: @lelekuningcoy\nGitHub: github.com/ahr-ahr\n\nSabar bos..."

# Meminta email recovery
read -p "Masukkan email recovery Anda: " recoveryEmail

if [[ -z "$recoveryEmail" ]]; then
    echo "Email recovery tidak boleh kosong! Script berhenti."
    exit 1
fi

echo "🚀 Masukkan jumlah Chrome yang ingin dibuka:"
read chromeCount

if [[ -z "$chromeCount" || "$chromeCount" -le 0 ]]; then
    echo "Jumlah tidak valid! Script berhenti."
    exit 1
fi

# Jalankan beberapa ChromeDriver di port berbeda
for ((i=0; i<chromeCount; i++)); do
    port=$((9515 + i))
    ./chromedriver --port=$port &
    sleep 1
done

# Jalankan script PHP dengan port berbeda
for ((i=0; i<chromeCount; i++)); do
    port=$((9515 + i))
    
    # ✅ Pastikan --email dikutip agar aman
    php /path/to/index.php --port=$port --email="$recoveryEmail" &
    sleep 1
done

wait
