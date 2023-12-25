drop database electronacerb7;
create database electronacerb7;

--@block
CREATE TABLE clients (
    id INT NOT NULL,
    fullname VARCHAR(250) NOT NULL,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(250) NOT NULL UNIQUE,
    phonenumber INT UNIQUE,
    adresse VARCHAR(250),
    city VARCHAR(250),
    passw VARCHAR(220) NOT NULL,
    valide BOOLEAN ,
    PRIMARY KEY (id)
);

--@block
CREATE TABLE admins(
    id INT PRIMARY KEY NOT NULL ,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(250) NOT NULL,
    passw VARCHAR(250) NOT NULL
    
);
--@block
INSERT INTO admins ( username , email ,passw) VALUES
('admin1','admin1@email.com','admin1');
--@block
CREATE TABLE orders(
    order_id INT PRIMARY KEY,
    creation_date DATE,
    shipping_date DATE,
    delivery_date DATE,
    total_price DECIMAL(10, 2),
    bl BOOLEAN
);

--@block
CREATE TABLE Categories (
    catname VARCHAR(50) PRIMARY KEY,
    descrip TEXT,
    imgs VARCHAR(250),
    bl BOOLEAN 
);

--@block
INSERT INTO categories ( catname , descrip ,imgs, bl) VALUES
    ('Mouse','Gaming Mouse extra buttons, high sensitivity, Wireless ', 'img/catmouse.jpg' , 1),
    ('KeyBoards','Gaming Keyboards, Mechanical Keyboards','img/catkeyboards.jpg' ,1),
    ('Headsets','Gaming,Wireless,Noise-Canceling Headsets','img/casque.jpg' ,1),
    ('Coolers','CPU Coolers with RGB Lighting','img/catcooler.jpg',1),
    ('Computers','Gaming,laptops and pcs', 'img/catlaptop&pc.jpg',1),
    ('Monitors','Gaming, Ultra-Wide,4k, Curved Monitors','img/catmonitors.jpg',1),
    ('SSD','SATA,NVMe,External SSDs', 'img/catssd.jpg',1),
    ('RAM','DDR,RGB RAM', 'img/catram.jpg',1);


--@block
CREATE TABLE Products (
    reference INT PRIMARY KEY,
    imgs VARCHAR(250),
    productname VARCHAR(255) NOT NULL,
    barcode VARCHAR(10) NOT NULL,
    purchase_price DECIMAL(10, 2) NOT NULL,
    final_price DECIMAL(10, 2) NOT NULL,
    price_offer DECIMAL(10, 2),
    descrip TEXT,
    min_quantity INT NOT NULL,
    stock_quantity INT NOT NULL,
    category_name VARCHAR(50),
    FOREIGN KEY (category_name) REFERENCES Categories(catname) ON DELETE CASCADE,
    bl BOOLEAN
);




--@block
INSERT INTO Products ( imgs, productname, barcode, purchase_price, final_price, price_offer, descrip, min_quantity, stock_quantity, category_name, bl) VALUES 
 ('img/ram1.jpg', 'Ram 8gb',235467896, 300, 450, 435 , 'Ram 8gb', 2, 20, 'RAM',  true ),
    ('img/ram2.jpg', 'Ram',235454896, 350, 450, 393 , 'Ram gb', 2, 20, 'RAM', true),
    ('img/ram3.jpg', 'Ram ',231267896, 400, 550, 495 , 'Ram ', 2, 20, 'RAM', true),
    ('img/ram4.jpg', 'Ram',235461256, 400, 550, 535, 'Ram ', 2, 15, 'RAM', true),
    ('img/ram-ddr4-16gb-2x8gb-pc3000-rgb-cl16.jpg', 'Ram ddr4 16gb',334456478, 474, 625, 450,'Ram ddr4',2,30, 'RAM', true),
    ('img/emtec-disque-dur-ssd.jpg','emtec ssd',123986433, 500,700, 600,'EMTEC ssd',2,35,'SSD', true),
    ('img/emtec-power--ssd.jpg' ,'emtec power ssd', 3476546584 ,600,500, 450 ,'EMTEC POWER', 2, 2,'SSD', true),
    ('img/kingston-25-ssd.jpg','king stone ssd',123456789,500,700,NULL,'KING STONE',2,1,'SSD', true),
    ('img/cooler-master-masterliquid.jpg','cooler',354872873,1000,1500,1232,'liquid cooler',2,2,'Coolers', true),
    ('img/thermaltake-floe-dx-water.jpg','thermaltake',984756378,2000,3000,NULL,'water cooler',2,1,'Coolers', true),
    ('img/gaming-monitor.jpg',' Monitor',127374914,2000,4500,NULL,'Gaming monitor',2,5,'Monitors', true),
    ('img/monitor-24-msi.jpg',' Monitor',984538765,3000,6000,5242,'MCI MONITOR',2,3,'Monitors', true),
    ('img/samsung-24-curvo.jpg','Samsung Monitor',647647382,5000,7000,NULL,'Samsung Curvo Monitor',2,1,'Monitors', true),
    ('img/gaming-mouse-razer-trinity.jpg','trinity razer mouse ',253984678,500,700,699,'trinity razer gaming',2,3,'Mouse', true),
    ('img/gaming-viper-ultimate-razer-mouse.jpg','viper mouse',836476538,700,900,NULL,'ultimate viper',2,1,'Mouse', true),
    ('img/razer-mouse-mamba-elite.jpg','elite mouse',126387645,400,600,NULL,'mamba elite',2,3,'Mouse', true),
    ('img/pc1.jpg',' Skytech Desktop gaming',2537813654,8000,9500,7000,'Skytech Eclipse Gaming PC Desktop  NVIDIA RTX 4070Ti',2,1,'Computers', true),
    ('img/pc2.jpg','Desktop Skytech Archangel ',263517357,9000,11000,9500,'Skytech Archangel Gaming Pc NVIDIA RTX 4070 Ti, 1TB',2,3,'Computers', true),
    ('img/pc3.jpg','Laptop MSI ',263587357,12000,18000,NULL,'MSI 144 Hz IPS Intel Core i7 13th Gen',2,10,'Computers', true),
    ('img/pc4.jpg','Laptop Hasee ',263517357,9000,11000,9500,'Hasee Z8  Gaming Laptop 16G DDR4 RAM',2,1,'Computers', true),
    ('img/keyboard1.jpg','Keyboard Crosshair', 987356478,1000,2500,2000,'CORSAIR WIRELESSMechanical Gaming Keyboard RGB',2,4,'Keyboards', true),
    ('img/keyboard2.jpg','Keyboard Rosewill', 987356438,800,1500,NULL,'Rosewill NEON RGB Wired Mechanical Gaming Keyboard',2,4,'Keyboards' , true),
    ('img/keyboard3.jpg','Keyboard Neon Rosewill', 987356878,700,1900,NULL,'Rosewill NEON Wired Mechanical Gaming Keyboard',2,10,'Keyboards' , true),
    ('img/c1.jpg','White headset',2638465489,800,1000,NULL,'Wireless headset RGB',2,1,'Headsets', true),
    ('img/c2.jpg','Black headset',2648465489,900,1200,NULL,'Wireless headset RGB',2,5,'Headsets', true);