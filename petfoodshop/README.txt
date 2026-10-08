PETFOOD SHOP - PHP + MySQL

คุณสมบัติ:
1. สมัครสมาชิก + password_hash/password_verify
2. 2 บทบาท user/admin
3. CRUD สินค้าอาหารสัตว์เลี้ยง
4. ข้อมูลสินค้ามี owner_id
5. user แก้/ลบได้เฉพาะสินค้าของตนเอง
6. admin แก้/ลบสินค้าทุกคนได้
7. Admin Dashboard แสดงจำนวนผู้ใช้/สินค้า
8. อัปโหลดรูปสินค้า
9. Prepared Statements ป้องกัน SQL Injection
10. Session logout ล้าง session และ cookie

วิธีติดตั้ง XAMPP:
1. แตกโฟลเดอร์ petfood_shop ไปไว้ใน C:\xampp\htdocs\
2. เปิด Apache และ MySQL
3. เข้า phpMyAdmin
4. Import ไฟล์ database.sql
5. แก้ config/database.php ให้ตรงกับ MySQL ของเครื่อง
6. เปิด http://localhost/petfood_shop/

สร้างบัญชี:
- สมัครสมาชิกอย่างน้อย 2 คนผ่าน register.php
- เข้า phpMyAdmin > SQL แล้วกำหนด 1 คนเป็น admin:
  UPDATE users SET role='admin' WHERE username='admin';

ตัวอย่าง:
ผู้ใช้คนที่ 1 username = admin
ผู้ใช้คนที่ 2 username = user1

ทดสอบสิทธิ์:
A) login เป็น user1 -> เพิ่มสินค้า -> แก้/ลบสินค้าของตัวเองได้
B) login เป็น user2 -> ไม่สามารถแก้/ลบสินค้าของ user1 ได้
C) login เป็น admin -> จัดการสินค้าได้ทุกคน และเข้า admin.php ได้

หมายเหตุ:
สร้างโฟลเดอร์ uploads ให้ PHP เขียนไฟล์ได้ หรือระบบจะสร้างให้อัตโนมัติเมื่ออัปโหลดครั้งแรก
