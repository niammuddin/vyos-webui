# vyos-webui

ini adalah project yang dibuat dengan PHP, javascript, HTML, CSS dan sedikit python.

digunakan untuk menampilkan konfigurasi dan monitoring pada system VyOS

## STEP 1
konfigurasi awal dengan edit file functions.php
- YOUR_IP_ADDRESS
- YOUR_API_KEY

## STEP 2
jika ingin menampilkan informasi route dan live traffic pada dashboard silahkan edit file index.php
- IP_ROUTE_API_URL
- BANDWIDTH_API_URL
- INTERFACES_API_URL

lalu copy file /scripts/monitor.py ke system vyos pada direktory /config/scripts/monitor.py

lalu buat service pada system vyos:

nano /etc/systemd/system/monitor_vyos.service

isi dengan script berikut ini

```
[Unit]
Description=Traffic Monitor Service
After=network.target

[Service]
ExecStart=/usr/bin/python3 /config/scripts/monitor.py
WorkingDirectory=/config/scripts
Restart=always

[Install]
WantedBy=multi-user.target
```

aktifkan
``````
sudo systemctl enable monitor_vyos
sudo systemctl start monitor_vyos
sudo systemctl status monitor_vyos
``````

## STEP 3
informasi user dan password untuk login ke web-ui edit pada file login.php
- Define username and password
- default admin/admin


follow me:
- https://www.facebook.com/niammuddin
- https://subnet.net.id
