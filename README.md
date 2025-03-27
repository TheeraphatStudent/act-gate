# Event management

PHP event management system

# MVC Concept

User <-> View <-> Controller <-> Model

### Project structure

`# Controller`  
- Render content
- จัดการ Flow ที่ `MainController`
- Logic
- Request -> Response

`# Model`  
- เชื่อมต่อฐานข้อมูล
- Api key

`# View`  
- Content
- ทำงานตามแต่ละ View ต้องทำ เช่น MapView ใช้แสดง Map เท่านั้น

`# Component`
- ส่วนย่อยๆของ Content ที่ View ต้องเรียกใช้บ่อยๆ
- ถ้าเป็น Style สร้าง Component ได้ใน input.css ที่ layer components

`# Public`
- ส่วนที่ Client เข้าถึงได้โดยตรง เอาไว้เก็บ Image, Icon, Style

### การทำงาน
การ Route จะใช้ Parameter เป็รหลัก โดยจะ Query ที่ index.php

# Php syntax

`<?php ?>` To create php structure
```
<?php 
echo "Hello World";

?>
```

`?> <?php` To create chide php process inside parent
```
<?php 
echo "Hello World";

    ?> 
        echo "This is an child!"

    <?php
?>
```

# To rebuild tailwind css

```bash
npx tailwindcss -i .\public\style\input.css -o .\public\style\style.css --watch
```

delay watch for 3 second

```bash
npx tailwindcss -i .\public\style\input.css -o .\public\style\style.css --watch --poll 3000
```

# Basic docker

### to check file in directory

```bash
docker exec -it <container_name> ls -l /var/www/html/pages/php/submitted.php
```

### to run docker

```bash
docker compose up -d
```

### to stop docker container

```bash
docker compose down
```

# Deploy with sliplane

```
Webpage: http://206.189.91.219:3001
Phpadmin: http://206.189.91.219:8081
```

# Deply wirh ngrok

```
docker run --net=host -it -e NGROK_AUTHTOKEN=2rOqB5GAbOGqPqCf245sIl96WJp_3wQSDz2Lz9FvQ2Y4F6bc2 ngrok/ngrok:latest http 3000
```

# SVG Icon

`
https://www.svgrepo.com/svg/126764/pie-chart?edit=true
`

---

# Js word

### fetch

1. ใช้ fetch ดึงข้อมูล (GET Request)
```
fetch('https://api.example.com/data')
  .then(response => response.json()) // แปลงข้อมูลเป็น JSON
  .then(data => console.log(data)) // แสดงข้อมูลใน console
  .catch(error => console.error('Error:', error)); // จับ error
```

2. ใช้ fetch ส่งข้อมูล (POST Request)
```
fetch('https://api.example.com/data', {
  method: 'POST', // ใช้ HTTP method POST
  headers: {
    'Content-Type': 'application/json' // กำหนดประเภทข้อมูลที่ส่ง
  },
  body: JSON.stringify({ name: 'John', age: 30 }) // แปลง object เป็น JSON
})
  .then(response => response.json())
  .then(data => console.log('Success:', data))
  .catch(error => console.error('Error:', error));
```

3. ใช้ fetch ในรูปแบบ async/await
```
async function fetchData() {
  try {
    const response = await fetch('https://api.example.com/data');
    const data = await response.json();
    console.log(data);
  } catch (error) {
    console.error('Error:', error);
  }
}

fetchData();
```